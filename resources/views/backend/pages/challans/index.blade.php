
@extends('backend.layouts.master')

@section('title')
Request Book List - Admin Panel
@endsection

@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Challan</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{route('challans.index')}}">Book Challan</a></li>
                    <li><span>Challan</span></li>
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
                    <div class="mt-1">
                        <h4 class="header-title float-left">Challan</h4>
                        <!-- Buttons for filtering challans -->
                        @if (Auth::guard('admin')->user()->role === 'dlc')
                            <div class="btn-group float-right" role="group">
                                <a href="{{ route('challans.index', ['filter' => 'alc']) }}" class="btn btn-primary">ALC Challan</a>
                                <a href="{{ route('challans.index', ['filter' => 'okcl']) }}" class="btn btn-primary">OKCL Challan</a>
                            </div>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>Challan Number</th>
                                    <th>Requested By</th>
                                    <th>Book Title</th>
                                    <th>Quantity</th>
                                    <th>Challan Date</th>
                                    <th>Remarks</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($challans as $challan)
                                    <tr>
                                        <td>{{ $challan->challan_number }}</td>
                                        <td>{{ $challan->bookRequest->requested_By->name }}</td>
                                        <td>{{ $challan->bookRequest->book->title }}</td>
                                        <td>{{ $challan->bookRequest->quantity }}</td>
                                        <td>{{ $challan->challan_date }}</td>
                                        <td>{{ $challan->remarks }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody> 
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>
</div>
@endsection