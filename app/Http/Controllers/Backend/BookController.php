<?php

namespace App\Http\Controllers\Backend;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BookStock;

class BookController extends Controller
{
    // Show the list of books
    public function index(Request $request)
    {
        $books = Book::orderBy('created_at', 'desc')->get();
        // $books = Book::all();
        return view('backend.pages.book.index', compact('books'));
    }

    // Store a new book
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:255|unique:books',
            'published_date' => 'required|date',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        Book::create($request->all());

        return redirect()->route('admin.book.index')->with('success', 'Book added successfully.');
    }


    // Show the form for editing the specified book
    public function show($id)
    {
        
        $book = Book::find($id);
       return response()->json($book);
    }

    public function edit($id)
    {
        $book = Book::find($id);
       return response()->json($book);
    }

    public function update(Request $request,Book $book)
    {
       $update = Book::find($request->id);
                $update->title = $request->title;
                $update->author = $request->author;
                $update->isbn = $request->isbn;
                $update->published_date = $request->published_date;
                $update->quantity = $request->  quantity;
                $update->description = $request->description;
                $update->update();

        //$book->update($request->all());
        return redirect()->route('admin.book.index')->with('success', 'Book updated successfully');
    }

    // Remove the specified book
    public function destroy($id)
    {
        //dd($id);
        $book = Book::findOrFail($id);
        $book->delete();

       return redirect()->back()->with('success', 'Book deleted successfully');
    }

    public function showStock() {
        $stocks = BookStock::all(); 
        return view('backend.pages.book.book-stock', compact('stocks'));
        }

    // public function bookStock(){
    //     return view('backend.pages.book.book-stock');
    // }

}
