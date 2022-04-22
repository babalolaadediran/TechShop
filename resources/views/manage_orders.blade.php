@extends('layouts/default_layout')
@section('content')
<div class="section">
<div class="container" style="margin-left:150px;">

    <div class="row">
    	<div class="col-md-12">
    		@if(Session::has('success'))
                <div id="alert-msg">
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>{{ session('success') }}</strong>
                    </div>
                </div>
            @endif

    		@if(Session::has('error'))
                <div id="alert-msg">
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>{{ session('error') }}</strong>
                    </div>
                </div>
            @endif
    	</div>
    	<div class="col-md-12">
    			<table class="table table-striped table-bordered">
    				<tr>
    					<th>Date</th>
    					<th>Product Name</th>
    					<th>Quantity</th>
    					<th>Address</th>
    					<th>Delivery Status</th>
    					<th>Amount</th>
                        <th>Action</th>
    				</tr>
    				@foreach($orders as $list)
        				<tr>
        					<td>{{ \Carbon\Carbon::parse($list->created_at)->format('d,M-Y H:i:s a')  }}</td>
        					<td>{{ $list->name }}</td>
        					<td>{{ $list->quantity }}</td>
        					<td>{{ ucwords($list->address) }}</td>
        					<td>
        						@if($list->is_delivered == '0')
        							<span class="badge badge-warning">Pending</span>
        						@else
        							<span class="badge badge-success">Delivered</span>
        						@endif
        					</td>
        					<td>#{{ number_format($list->amount) }}</td>
                            <td>
                                @if($list->is_delivered == '0')
                                    <form method="POST" action="{{ url('/manage/orders/update/'.$list->id) }}">
                                        @csrf
                                        <button class="btn btn-success btn-sm">Update as Delivered.</button>
                                    </form>
                                @else
                                    <i class="badge badge-success">Delivered</i>
                                @endif
                            </td>
        				</tr>
    				@endforeach
    			</table>
    	</div>
    	<div class="col-md-6 offset-5">
    		<div align="center">
    			{{ $orders->links() }}
    		</div>
    	</div>
    </div>
</div>
</div>
@endsection
