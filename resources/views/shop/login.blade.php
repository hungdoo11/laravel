@extends('layout.app')
@section('content')
<div class="inner-header">
	<div class="container">
		<div class="pull-left">
			<h6 class="inner-title">Đăng nhập</h6>
		</div>
		<div class="pull-right">
			<div class="beta-breadcrumb">
				<a href="index.html">Home</a> / <span>Đăng nhập</span>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<div class="container">
	<div id="content">
		<form action="{{ route('postlogin') }}" method="post" class="beta-form-checkout">
			@csrf
			@if(Session::has('flag'))
			<div class="alert alert-{{ Session::get('flag') }}">{{ Session::get('message') }}</div>
			@endif
			@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-6">
					<h4>Đăng nhập</h4>
					<div class="space20"> </div>

					<div class="form-block">
						<label for="email">Email address*</label>
						<input type="email" id="email" name="email" required>
					</div>
					<div class="form-block">
						<label for="password">Password*</label>
						<input type="password" id="password" name="password" required>
					</div>
					<div class="form-block">
						<button type="submit" class="btn btn-primary">Login</button>

						<a href="{{route('getInputEmail')}}">Quên mật khẩu ?</a>
					</div>
				</div>
				<div class="col-sm-3"></div>
			</div>
		</form>
	</div> <!-- #content -->
</div> <!-- .container -->
@endsection