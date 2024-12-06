
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
                    <a href="{{route('book-requests.view')}}"><button type="button" class="btn btn-primary mb-5"  style="float:right; margin-right:15px">View Request Book List</button></a>
                    <h4 class="header-title float-left">Create Book Request</h4>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        <form action="{{ route('book-requests.store') }}" method="POST" class="form-inline">
                            @csrf
                            <div id="book-request-container">
                                <div class="form-row mb-2">
                                    <div class="form-group mr-2">
                                        <label for="book_id" class="mr-2">Select Book:</label>
                                        <select name="book_id[]" id="book_id" class="form-control "style="width:400px" required>
                                            @foreach($books as $book)
                                                <option value="{{ $book->id }}">{{ $book->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                
                                    <div class="form-group mr-2" style="margin-left:50px">
                                        <label for="quantity" class="mr-2">Quantity:</label>
                                        <input type="number" name="quantity[]" id="quantity" style="width:350px" class="form-control" required>
                                    </div>

                                    <button type="button" class="btn btn-success add-more">+</button>
                                </div>
                            </div>
                            {{-- <div class="form-row justify-content-start mt-5" style="margin-left:100px">                     --}}
                                <button type="submit" style="margin-left:890px" class="btn btn-primary mt-2">Request Book</button>
                            {{-- </div> --}}
                        </form>   
                    </div>
                </div>
            </div>
            <!-- data table end -->
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('book-request-container');

        // Add more rows
        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('add-more')) {
                e.preventDefault();
                const newRow = `
                <div class="form-row mb-2" style="">
                    <div class="form-group mr-2">
                        <label for="book_id" class="mr-2">Select Book:</label>
                        <select name="book_id[]" class="form-control" style="width:400px" required>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}">{{ $book->title }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="form-group mr-2" style="margin-left:50px">
                        <label for="quantity" class="mr-2">Quantity:</label>
                        <input type="number" name="quantity[]" style="width:350px" class="form-control" required>
                    </div>

                    <button type="button" class="btn btn-danger remove-row">-</button>
                </div>
                `;
                container.insertAdjacentHTML('beforeend', newRow);
            }

            // Remove row
            if (e.target && e.target.classList.contains('remove-row')) {
                e.preventDefault();
                e.target.closest('.form-row').remove();
            }
        });
    });
</script>
@endsection
