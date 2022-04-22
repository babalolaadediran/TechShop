@extends('layouts/dashboard')
@section('content')
<div class="container">
    <div class="jumbotron">
        <h2 align="center">My Orders</h2>
    </div>

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
    		<div class="table-responsive">
    			<table class="table table-striped table-bordered">
    				<tr>
    					<th>Date</th>
    					<th>Product Name</th>
    					<th>Quantity</th>
    					<th>Address</th>
    					<th>Delivery Status</th>
    					<th>Amount</th>
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
	    				</tr>
    				@endforeach
    			</table>
    		</div>
    	</div>
    	<div class="col-md-6 offset-5">
    		<div align="center">
    			{{ $orders->links() }}
    		</div>
    	</div>
    </div>
</div>
@endsection