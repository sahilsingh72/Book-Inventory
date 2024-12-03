
@extends('backend.layouts.master')

@section('title')
Book Request Create- Admin Panel
@endsection

@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Book</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('book-requests.create') }}">Request</a></li>
                    <li><span>Create Request</span></li>
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
                    @if ((auth::guard('admin')->user()->role === 'dlc') || (auth::guard('admin')->user()->role === 'alc'))
                        <a href="{{route('book-requests.view')}}"><button type="button" class="btn btn-primary mb-5"  style="float:right">View Request Book List</button></a>
                    @endif
                    <h4 class="header-title float-left">Create Book Request</h4>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        <form action="{{ route('book-requests.store') }}" method="POST" class="form-inline">
                            @csrf
                            <div class="form-group mr-2">
                                <label for="book_id" class="mr-2">Select Book:</label>
                                <select name="book_id" id="book_id" class="form-control" required>
                                    @foreach($books as $book)
                                        <option value="{{ $book->id }}">{{ $book->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="form-group mr-2">
                                <label for="quantity" class="mr-2">Quantity:</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" required>
                            </div>
                        
                            <button type="submit" class="btn btn-primary">Request Book</button>
                        </form>
                        
                    </div>
                </div>
            </div>
            <!-- data table end -->
        </div>
    </div>
</div>
@endsection
