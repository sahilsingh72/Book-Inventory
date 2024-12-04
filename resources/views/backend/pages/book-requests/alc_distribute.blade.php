
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