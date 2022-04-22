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
    		<form action="{{ url('/signup') }}" method="POST">
    			@csrf
    			<div class="col-md-12">
    				<div class="form-group  {{ ($errors->has('name')) ? 'has-error' : '' }}">
    					<label>Fullname</label>
    					<input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="john doe">
    					@if ($errors->has('name'))
	                        <strong class="help-block">{{ $errors->first('name') }}</strong>
	                    @endif
    				</div>
    			</div>

    			<div class="col-md-12">
    				<div class="form-group  {{ ($errors->has('email')) ? 'has-error' : '' }}">
    					<label>Email</label>
    					<input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="me@mail.com">
    					@if ($errors->has('email'))
	                        <strong class="help-block">{{ $errors->first('email') }}</strong>
	                    @endif
    				</div>
    			</div>

    			<div class="col-md-12">
    				<div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
    					<label>Password</label>
    					<input type="password" name="password" class="form-control" placeholder="xxxxxxx">
    					@if ($errors->has('password'))
	                        <strong class="help-block">{{ $errors->first('password') }}</strong>
	                    @endif
    				</div>
    			</div>

    			<div class="col-md-12">
    				<div class="form-group {{ ($errors->has('confirm_password')) ? 'has-error' : '' }}">
    					<label>Confirm Password</label>
    					<input type="password" name="confirm_password" class="form-control" placeholder="xxxxxxx">
    					@if ($errors->has('confirm_password'))
	                        <strong class="help-block">{{ $errors->first('confirm_password') }}</strong>
	                    @endif
    				</div>
    			</div>

    			<div class="col-md-12">
    				<div class="form-group">
    					<button class="btn btn btn-danger btn-block">Signup</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
</div>
</div>
@endsection
