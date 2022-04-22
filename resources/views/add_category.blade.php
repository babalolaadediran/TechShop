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
    		<form action="{{ url('/category/add') }}" method="POST" enctype="multipart/form-data">
    			@csrf
    			<div class="col-md-12">
    				<div class="form-group  {{ ($errors->has('name')) ? 'has-error' : '' }}">
    					<label>Category name</label>
    					<input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="">
    					@if ($errors->has('name'))
	                        <strong class="help-block">{{ $errors->first('name') }}</strong>
	                    @endif
    				</div>
    			</div>

                <div class="col-md-12">
                    <div class="form-group {{ ($errors->has('description')) ? 'has-error' : '' }}">
                        <label>Category Description</label>
                        <textarea name="description" class="form-control"></textarea>
                        @if ($errors->has('description'))
                            <strong class="help-block">{{ $errors->first('description') }}</strong>
                        @endif
                    </div>
                </div>

    			<div class="col-md-12">
    				<div class="form-group">
    					<button class="btn btn-success btn-block">Add</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
</div>
</div>
@endsection
