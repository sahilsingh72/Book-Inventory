
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
                    <li><a href="{{ route('admin.book.index') }}">book distribution</a></li>
                    <li><span></span></li>
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
                    <h4 class="header-title float-left">Book Distribution</h4>
                    <div class="clearfix"></div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="data-tables">
                        <form action="/distribute-books" method="POST">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                            <!-- Student Details -->
                            <div class="mb-3">
                                <label for="studentName" class="form-label">Student Name</label>
                                <input type="text" class="form-control" id="studentName" name="student_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="studentClass" class="form-label">Class</label>
                                <select class="form-select" id="studentClass" name="student_class" required>
                                    <option value="" disabled selected>Select Class</option>
                                    <option value="1">Class 1</option>
                                    <option value="2">Class 2</option>
                                    <option value="3">Class 3</option>
                                    <!-- Add more classes as needed -->
                                </select>
                            </div>
                
                            <!-- Book Details -->
                            <div class="mb-3">
                                <label for="bookName" class="form-label">Book Name</label>
                                <select class="form-select" id="bookName" name="book_id" required>
                                    <option value="" disabled selected>Select Book</option>
                                    {{-- @foreach($books as $book)
                                        <option value="{{ $book->id }}">{{ $book->title }} (Available: {{ $book->quantity }})</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                            </div>
                
                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Distribute Book</button>
                            </div>
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>
</div>


@endsection

@section('scripts')
@endsection