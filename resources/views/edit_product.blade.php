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
    		<form action="{{ url('/products/edit/'.$getProductDeatils->id) }}" method="POST" enctype="multipart/form-data">
    			@csrf
                <div class="col-md-12">
                    <img src="{{ asset($getProductDeatils->image) }}" style="width: 400px;height: 200px;">
                </div>
                <div class="col-md-12">
                    <div class="form-group  {{ ($errors->has('image')) ? 'has-error' : '' }}">
                        <label>Product Image</label>
                        <input type="file" name="image" class="form-control">
                        @if ($errors->has('image'))
                            <strong class="help-block">{{ $errors->first('image') }}</strong>
                        @endif
                    </div>
                </div>

    			<div class="col-md-12">
    				<div class="form-group  {{ ($errors->has('name')) ? 'has-error' : '' }}">
    					<label>Product name</label>
    					<input type="text" name="name" value="{{ $getProductDeatils->name }}" class="form-control" placeholder="">
    					@if ($errors->has('name'))
	                        <strong class="help-block">{{ $errors->first('name') }}</strong>
	                    @endif
    				</div>
    			</div>

                <div class="col-md-12">
                    <div class="form-group {{ ($errors->has('description')) ? 'has-error' : '' }}">
                        <label>Product Description</label>
                        <textarea name="description" class="form-control">{{ $getProductDeatils->description }}</textarea>
                        @if ($errors->has('description'))
                            <strong class="help-block">{{ $errors->first('description') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group  {{ ($errors->has('unit')) ? 'has-error' : '' }}">
                        <label>Product Available Unit</label>
                        <input type="number" min="0" name="unit" value="{{ $getProductDeatils->unit }}" class="form-control" required>
                        @if ($errors->has('unit'))
                            <strong class="help-block">{{ $errors->first('unit') }}</strong>
                        @endif
                    </div>
                </div>

    			<div class="col-md-12">
                    <div class="form-group  {{ ($errors->has('price')) ? 'has-error' : '' }}">
                        <label>Product Price</label>
                        <input type="number" min="0" name="price" value="{{ $getProductDeatils->price }}" class="form-control" required>
                        @if ($errors->has('price'))
                            <strong class="help-block">{{ $errors->first('price') }}</strong>
                        @endif
                    </div>
                </div>

    			<div class="col-md-12">
    				<div class="form-group">
    					<button class="btn btn-info btn-block">Update</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
</div>
</div>
@endsection
