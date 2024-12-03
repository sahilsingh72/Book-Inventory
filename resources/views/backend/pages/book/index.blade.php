
@extends('backend.layouts.master')

@section('title')
Book - Admin Panel
@endsection

@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Book</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.book.index') }}">View Book</a></li>
                    <li><span>book list</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">  

                <div class="card-body">
                    <h4 class="header-title float-left">Book Inventory</h4>
                    <p class="float-right mb-2">
                        @if(Auth::guard('admin')->user()->role === 'okcl')
                            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createBookModal">Add New Book</button>
                        @endif
                    </p>
                    <div class="clearfix"></div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="data-tables">
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>S.No</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>ISBN</th>
                                    <th>Published Date</th>
                                    <th>Quantity</th>
                                    @if (auth::guard('admin')->user()->role === 'okcl')
                                        <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($books as $key=>$book)
                                    <tr>
                                        @if (auth::guard('admin')->user()->role === 'okcl')
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $book->title }}</td>
                                            <td>{{ $book->author }}</td>
                                            <td>{{ $book->isbn }}</td>
                                            <td>{{ $book->published_date }}</td>
                                            <td>{{ $book->quantity }}</td>
                                            @if (auth::guard('admin')->user()->role === 'okcl')
                                                <td>   
                                                    <button type="button" class="btn btn-info btn-sm"  onclick="view({{ $book->id }})">
                                                        View
                                                    </button>
                                                    <button type="button" class="btn btn-warning btn-sm"  onclick="editBookModal({{ $book->id }})">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm"  onclick="deleteBookModal({{ $book->id }})" >
                                                        Delete
                                                    </button>   
                                                </td>
                                            @endif
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Create Book Modal -->
                    <div class="modal fade" id="createBookModal" tabindex="-1" role="dialog" aria-labelledby="createBookModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createBookModalLabel">Add New Book</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="createBookForm" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="author">Author</label>
                                            <input type="text" class="form-control" id="author" name="author" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="isbn">ISBN</label>
                                            <input type="text" class="form-control" id="isbn" name="isbn" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="published_date">Published Date</label>
                                            <input type="date" class="form-control" id="published_date" name="published_date" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add Book</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Book Modal -->
                    <div class="modal fade" id="editBookModal" tabindex="-1" role="dialog" aria-labelledby="editBookModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editBookModalLabel">Edit Book</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="editBookForm" method="POST" action="">
                                    @csrf
                                
                                    <div class="modal-body">
                                        <input type="hidden" id="editBookId" name="id">
                                        <div class="form-group">
                                            <label for="editTitle">Title</label>
                                            <input type="text" class="form-control" id="editTitle" name="title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="editAuthor">Author</label>
                                            <input type="text" class="form-control" id="editAuthor" name="author" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="editIsbn">ISBN</label>
                                            <input type="text" class="form-control" id="editIsbn" name="isbn" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="editPublishedDate">Published Date</label>
                                            <input type="date" class="form-control" id="editPublishedDate" name="published_date" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="editQuantity">Quantity</label>
                                            <input type="number" class="form-control" id="editQuantity" name="quantity" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="editDescription">Description</label>
                                            <textarea class="form-control" id="editDescription" name="description"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update Book</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- View Book Modal -->
                    <div class="modal fade" id="viewBookModal" tabindex="-1" role="dialog" aria-labelledby="viewBookModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewBookModalLabel">View Book Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Book details will be populated here by AJAX -->
                                    
                                    <table class="table table-bordered">
                                     
                                          <tr>
                                            <th scope="col">Title</th>
                                            <td id="Title">Mark</td>
                                          </tr>
                                          <tr>
                                            <th scope="col">Author</th>
                                            <td id="Author">Otto</td>
                                            </tr>
                                            <tr>
                                            <th scope="col">ISBN</th>
                                            <td id="ISBN">Otto</td>
                                            </tr>
                                            <tr>
                                            <th scope="col">Published Date</th>
                                            <td id="Publisheddate">@mdo</td>
                                            </tr>
                                            <tr>
                                            <th scope="col">Quantity</th>
                                            <td id="Quantity">@mdo</td>
                                            </tr>
                                            <tr>
                                            <th scope="col">Description</th> 
                                            <td id="Description">@mdo</td>
                                            </tr>
                                        
                                      </table>
                                    </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteBookModal" tabindex="-1" role="dialog" aria-labelledby="deleteBookModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteBookModalLabel">Delete Book</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="deleteBookForm" method="get" action="">
                                    @csrf
                                
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this book?</p>
                                        <input type="hidden" id="deleteBookId" name="id">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- data table end -->
    </div>
</div>


@endsection

@section('scripts')

    <script>
    function editBookModal(id){
      
        $('#editBookModal').modal('show')
    
                  $.ajax({
                url: '/admin/book/edit/' + id,
                method: 'GET',
                success: function(data) {

                   console.log(data);
                    
                    $('#editBookId').val(data.id);
                    $('#editTitle').val(data.title);
                    $('#editAuthor').val(data.author);
                    $('#editIsbn').val(data.isbn);
                    $('#editPublishedDate').val(data.published_date);
                    $('#editQuantity').val(data.quantity);
                    $('#editDescription').val(data.description);
                    $('#editBookForm').attr('action', '/admin/book/update');
                }
            });



        
    }

    function view(id){
        $('#viewBookModal').modal('show')
        $.ajax({
                url: 'book/show/' + id,
                method: 'GET',
                success: function(data) {
                    $('#Title').html(data.title);
                    $('#Author').html(data.author);
                    $('#ISBN').html(data.isbn);
                    $('#Publisheddate').html(data.published_date);
                    $('#Quantity').html(data.quantity);
                    $('#Description').html(data.description);
                }
            });
    }


    function deleteBookModal(id){
        $('#deleteBookModal').modal('show')
        $('#deleteBookForm').attr('action', 'book/delete/' + id);
    }
</script>
@endsection