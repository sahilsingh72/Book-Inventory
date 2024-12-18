<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BookRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\Admin;
use App\Models\BookStock;
use Illuminate\Http\Request;
use App\Models\Challan;   
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request as HttpRequest; // Alias for the HTTP Request

class BookRequestController extends Controller
{
    public function index(Request $request)
    {   
        $user = Auth::user(); // Get the currently logged-in user
        $role = $user->role;  // Check the role of the logged-in user
        
        $status = $request->query('status', 'pending'); // Default is 'pending'


        if($role === 'okcl') {
            // okcl role: show requests coming from DLC to okcl
            $bookRequests = BookRequest::select('book_requests.*','admins.name','books.title')
            ->leftJoin('admins', 'book_requests.requested_by', '=', 'admins.id')
            ->leftJoin('books', 'book_requests.book_id', '=', 'books.id')
            ->where('book_requests.requested_from', $user->id)
            // ->where('book_requests.status', '=' , 'pending')
            ->where('book_requests.status', $status)
            ->orderBy('book_requests.created_at', 'desc')
            ->get();
            
        } 
        elseif($role ==='dlc'){
            // DLC role: show requests coming from ALC to DLC
            $bookRequests = BookRequest::select('book_requests.*', 'admins.name', 'books.title')
            ->leftJoin('admins', 'book_requests.requested_by', '=', 'admins.id')
            ->leftJoin('books', 'book_requests.book_id', '=', 'books.id')
            ->where('book_requests.requested_from', $user->id) // DLC is the recipient
            ->where('book_requests.status',  $status)
            ->orderBy('book_requests.created_at', 'desc')
            ->get();
        }
        else {
        // If neither role, return an empty collection or handle accordingly
        $bookRequests = collect();
        }
              
        // Pass the $bookRequests variable to the view
        return view('backend.pages.book-requests.index', compact('bookRequests'));
    }

    // Show the form to create a new book request
    public function create() {
        $books = Book::all(); // Get all available books
        return view('backend.pages.book-requests.create', compact('books'));
    }

    // Store a new book request
    public function store(HttpRequest $request) 
    {
        // dd($request->all());
        $user = Auth::user();
        $requestfrom = $this->getRequestedFrom();
        try{
            // Validate incoming data
            $request->validate([
                'book_id.*' => 'required|exists:books,id', // Each book_id must exist in the books table
                'quantity.*' => 'required|integer|min:1', // Each quantity must be an integer greater than 0
            ]);

            $book_ids = $request->input('book_id'); // Array of book IDs
            $quantities = $request->input('quantity'); // Array of quantities

            foreach ($book_ids as $index => $book_id) {
                if (isset($quantities[$index])) {
                    $check_book_status = BookRequest::where('requested_by',Auth::id())
                    ->where('book_id',$book_id)
                    ->where('status',"pending");
                    if($check_book_status->count() > 0){
                        $book = $check_book_status->first();
                        $bookRequest =  BookRequest::find($book->id);  
                        $bookRequest->quantity = $book->quantity + $quantities[$index];
                        $bookRequest->update();
                    }else{

                    
                    $bookRequest = new BookRequest(); // Use the Request model
                    $bookRequest->requested_by = Auth::id(); // ID of the logged-in admin (ALC or DLC)
                    $bookRequest->requested_from = $requestfrom; // Logic to find out if requesting from DLC or OKCL
                    $bookRequest->book_id = $book_id;
                    $bookRequest->quantity = $quantities[$index];
                    $bookRequest->status = 'pending';
                    $bookRequest->save();
                }
                }
            }

            return redirect()->route('book-requests.view')->with('success', 'Book request created successfully.');
        }
        catch (\Exception $e) {
            Log::error('Failed to save book request: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create book request.');
        }
    }

    private function getRequestedFrom()
    {
        $user = Auth::user(); 

        if ($user->role == 'alc') {
            // If the user is an ALC, request should go to their DLC
            $dlc = Admin::where('id', $user->assign_under)->where('role', 'dlc')->first(); 
            if ($dlc) {
                return $dlc->id;
            } else {
                Log::error("No DLC found for ALC with ID: {$user->id}");
                return null;
            }
        }

        if ($user->role == 'dlc') {
            // If the user is a DLC, request should go to OKCL
            $okcl = Admin::where('role', 'okcl')->first();
            if ($okcl) {
                return $okcl->id;
            } else {
                Log::error("No OKCL admin found for DLC with ID: {$user->id}");
                return null;
            }
        }

        // Log an error for unrecognized roles
        Log::error("Unrecognized role for user ID: {$user->id} with role: {$user->role}");
        return null;
    }

    // Logic to approve or decline a book request
    public function updateStatus($id, $status) {
        $bookRequest = BookRequest::find($id);

        if (!$bookRequest) {
            return redirect()->back()->with('error', 'Book request not found.');
        }

        $bookRequest->status = $status;
        $bookRequest->save();

        return redirect()->back()->with('success', 'Book request ' . $status . ' successfully.');
    }

    // Other methods as required (index, show, etc.)
    public function request_view(Request $request){
        $user = Auth::id();
        $status = $request->get('status', 'pending'); // Get status from query parameter

        // Fetch book requests where the requested_by or requested_from is the authenticated user
        $bookRequests = BookRequest::select('book_requests.*','admins.name','books.title')
            ->leftJoin('admins', 'book_requests.requested_from', '=', 'admins.id')
            ->leftJoin('books', 'book_requests.book_id', '=', 'books.id')
            ->where('book_requests.requested_by', $user);
            // ->orderBy('book_requests.created_at', 'desc')
            // ->get();
        if (!empty($status)) {
            $bookRequests->where('book_requests.status', $status);
        }

    $bookRequests = $bookRequests->orderBy('book_requests.created_at', 'asc')->get();

        
        return view('backend.pages.book-requests.request_book_list', compact('bookRequests'));
    }
    public function updateStatusapprove(Request $request, $id){

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the book request 
        $bookRequests = BookRequest::find($id);
        if (!$bookRequests) {
            return redirect()->back()->with('error', 'Book request not found.');
        }   
        // Fetch the book details from the books table
        $book = $bookRequests->book;
        if (!$book) {
            return redirect()->back()->with('error', 'Book not found.');
        }

        // Check if sufficient books are available in OKCL stock
        if ($book->quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Not enough books available.');
        }
        
        // Approve the book request and update quantity
        $bookRequests->status ='Approved';
        $bookRequests->quantity = $request->quantity;
        $bookRequests->update();

        // Update book quantities
        $book->quantity -= $bookRequests->quantity;
        $book->save();
        // Update or add stock to the DLC/ALC (requesting entity)
        $entityId = $bookRequests->requested_by; // Assuming `requested_by` holds the DLC/ALC ID
        $existingStock = BookStock::where('entity_id', $entityId)
                                ->where('isbn', $book->isbn)
                                ->first();

        if ($existingStock) {
            // Update quantity if the stock already exists
            $existingStock->quantity += $request->quantity;
            $existingStock->save();
        } else {
            // Add a new stock entry for the requesting entity
            BookStock::create([
                'entity_id' => $entityId,
                'title' => $book->title,
                'author' => $book->author,
                'isbn' => $book->isbn,
                'published_date' => $book->published_date,
                'quantity' => $request->quantity,
                'description' => $book->description,
            ]);
        }


        // Generate Challan after approval
            $this->generateChallan($bookRequests);

            return redirect()->back()->with('success', 'Request approved and challan generated successfully.');
        }

    public function updateStatusdecline($id){
        $bookRequests = BookRequest::find($id);
        $bookRequests->status ='Declined';
        $bookRequests->update();
        return redirect()->back()->with('success', 'Request Declined!.');
        }

    // public function showStocks() {
    //     $stocks = BookStock::all(); 
    //     // $stocks = BookStock::where('entity_id', auth::id())->get(); 
    
    //     return view('backend.pages.book.book-stock', compact('stocks'));
    // }


    public function alcDistribution(){
        return view('backend.pages.book-requests.alc_distribute');
    }

    public function generateChallan($bookRequests)
    {
        
    
        // Generate a unique challan number
        $challanNumber = 'CHLN-' . strtoupper(uniqid());
    
        // Create a new challan record
        $challan = new Challan();
        $challan->book_request_id = $bookRequests->id;
        $challan->challan_number = $challanNumber;
        $challan->challan_date = now();
        $challan->remarks = 'Challan generated for approved book request.';
        $challan->save();
        
        return redirect()->back()->with('success', 'Challan generated successfully with number: ' . $challanNumber);
    }
    
        
}
