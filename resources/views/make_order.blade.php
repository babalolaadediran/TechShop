@extends('layouts/default_layout')
@section('content')
<div class="section">
<div class="container" style="margin-left:500px;">

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
    	<div class="col-md-6 offset-4">
    		<form action="{{ url('/make/order/'.$product->id) }}" method="POST">
    			@csrf
                <div class="col-md-12">
                    <img src="{{ asset($product->image) }}" style="width: 500px;height: 200px;">
                </div>

                <div class="col-md-12">
                    <h3 align="center">{{  $product->name }}</h3>
                    <p><strong>Descritpion:</strong> {{ $product->description }}</p>
                    <p><strong>Available Unit:</strong> {{ $product->unit }}</p>
                    <p><strong>Price:</strong> {{ $product->price }}</p>
                </div>

    			<div class="col-md-12">
    				<div class="form-group  {{ ($errors->has('quantity')) ? 'has-error' : '' }}">
    					<label>Quantity</label>
    					<input type="number" min="1" name="quantity" value="{{ old('quantity') }}" class="form-control" required>
    					@if ($errors->has('quantity'))
	                        <strong class="help-block">{{ $errors->first('quantity') }}</strong>
	                    @endif
    				</div>
    			</div>
                <div class="col-md-12">
                    <div class="form-group {{ ($errors->has('address')) ? 'has-error' : '' }}">
                        <label>Delivery Address</label>
                        <textarea name="address" class="form-control"></textarea>
                        @if ($errors->has('address'))
                            <strong class="help-block">{{ $errors->first('address') }}</strong>
                        @endif
                    </div>
                </div>

    			<div class="col-md-12">
    				<div class="form-group">
    					<button class="btn btn-success btn-block">Make Order</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
</div>
</div>
@endsection
