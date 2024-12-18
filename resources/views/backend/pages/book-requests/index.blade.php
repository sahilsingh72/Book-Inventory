
@extends('backend.layouts.master')

@section('title')
Book request - Admin Panel
@endsection

@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Book</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('book-requests.index') }}">Request Arrived</a></li>
                    <li><span>Request book list</span></li>
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
                    <div>
                        <h4 style="float:left">Book Requests</h4>
                        <a href="{{ route('book-requests.index', ['status' =>  'approved']) }}"><button type="button" class="btn btn-success mb-4"  style="float:right">approved History</button></a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        <div class="data-tables">
                            <table id="dataTable" class="table text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>Book Title</th>
                                        <th>Requested By</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    @foreach($bookRequests as $request)
                                        <tr>
                                            <td>{{ $request->title }}</td>
                                            {{-- <td>{{ $request->requestedby->name }}</td> --}}
                                            <td>{{ optional($request->requestedby)->name ?? 'Unknown' }}</td> 
                                            <td>{{ $request->quantity }}</td>
                                            <td>{{ ucfirst($request->status) }}</td>
                                            <td>
                                                @if($request->status === 'pending')
                                                    <button type="button" 
                                                            class="btn btn-success" 
                                                            onclick="openApproveModal({{ $request->id }}, '{{ $request->title }}', {{ $request->quantity }}, {{ $request->book->quantity }})">
                                                        Approve
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-danger"
                                                            onclick="openDeclineModal({{ $request->id }}, '{{ $request->title }}')">
                                                        Decline
                                                    </button>
                                                @else
                                                    <span>{{ ucfirst($request->status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>
</div>

<!-- Approval Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('book-requests.approve', ':id') }}" method="POST" id="approveForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Approve Book Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Book Title:</strong> <span id="modalBookTitle"></span></p>
                    <div class="form-group">
                        <label for="modalQuantity">Quantity</label>
                        <input type="number" class="form-control" id="modalQuantity" name="quantity" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="modalRemarks">Remarks</label>
                        <textarea class="form-control" id="modalRemarks" name="remarks" rows="3" placeholder="Enter remarks for declining"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Approve</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Decline Modal -->
<div class="modal fade" id="declineModal" tabindex="-1" role="dialog" aria-labelledby="declineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('book-requests.decline', ':id') }}" method="POST" id="declineForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="declineModalLabel">Decline Book Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Book Title:</strong> <span id="declineModalBookTitle"></span></p>

                    <div class="form-group">
                        <label for="declineRemarks">Remarks</label>
                        <textarea class="form-control" id="declineRemarks" name="remarks" rows="3" placeholder="Enter remarks for declining"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Decline</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Insufficient Stock Modal -->
<div class="modal fade" id="insufficientStockModal" tabindex="-1" role="dialog" aria-labelledby="insufficientStockModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insufficientStockModalLabel">Insufficient Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="insufficientStockMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


<script>
    function openApproveModal(id, title, requestedQuantity, availableStock) {
        if (requestedQuantity > availableStock) {
            // Set message and show the "Insufficient Stock" modal
            document.getElementById('insufficientStockMessage').textContent = 
                `Requested quantity (${requestedQuantity}) exceeds available stock (${availableStock}). Please update the request.`;
            $('#insufficientStockModal').modal('show');
            return;
        }

        // Set modal data
        document.getElementById('modalBookTitle').textContent = title;
        document.getElementById('modalQuantity').value = requestedQuantity;
        document.getElementById('modalRemarks').value = '';

        // Update form action
        const form = document.getElementById('approveForm');
        form.action = form.action.replace(':id', id);

        // Show modal
        $('#approveModal').modal('show');
    }
</script>
<script>
    function openDeclineModal(id, title) {
        // Set modal data
        document.getElementById('declineModalBookTitle').textContent = title;
        document.getElementById('modalRemarks').value = '';

        // Update form action
        const form = document.getElementById('declineForm');
        form.action = form.action.replace(':id', id);

        // Show modal
        $('#declineModal').modal('show');
    }
</script>
@endsection