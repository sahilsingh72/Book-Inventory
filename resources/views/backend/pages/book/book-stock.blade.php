
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
                    <li><a href="{{ route('admin.book.stock') }}">Book-Stock</a></li>
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
                    @if(Auth::guard('admin')->user()->role === 'alc')
                        <h4 class="header-title float-left">ALC-Book Inventory</h4>
                    @else
                        <h4 class="header-title float-left">DLC-Book Inventory</h4>
                    @endif
                    <p class="float-right mb-2">
                        {{-- @if(Auth::guard('admin')->user()->role === 'okcl')
                            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createBookModal">Add New Book</button>
                        @endif --}}
                    </p>
                    <div class="clearfix"></div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="data-tables">
                       
                    </div>
                </div>

            </div>
        </div>
        <!-- data table end -->
    </div>
</div>


@endsection