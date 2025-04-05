@extends ('layout.app')
@section('content')
<div class="inner-header">
	<div class="container">
		<div class="pull-left">
			<h6 class="inner-title">Đăng kí</h6>
		</div>
		<div class="pull-right">
			<div class="beta-breadcrumb">
				<a href="index.html">Home</a> / <span>Đăng kí</span>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<div class="container">
	<div id="content">

		<form action="{{ route('postsignin') }}" method="post" class="beta-form-checkout">
			@csrf
			<div class="row">
				<div class="col-sm-3"></div>
				@if (count($errors)>0)
				<div class="alert alert-danger">
					@foreach($errors->all() as $err)
					{{ $err }}
					@endforeach
				</div>
				@endif
				@if(Session::has('success'))
				<div class="alert alert-success">{{ Session::get('success') }}</div>
				@endif
				<div class="col-sm-6">
					<h4>Đăng kí</h4>
					<div class="space20">&nbsp;</div>


					<div class="form-block">
						<label for="email">Email address*</label>
						<input name="email" type="email" id="email" required>
					</div>

					<div class="form-block">
						<label for="your_last_name">Fullname*</label>
						<input name="fullname" type="text" id="your_last_name" required>
					</div>

					<div class="form-block">
						<label for="address">Address*</label>
						<input name="address" type="text" id="address" placeholder="Street Address" required>
					</div>

					<div class="form-block">
						<label for="phone">Phone*</label>
						<input name="phone" type="text" id="phone" required>
					</div>
					<div class="form-block">
						<label for="password">Password*</label>
						<input name="password" type="password" id="password" required>
					</div>
					<div class="form-block">
						<label for="repassword">Re password*</label>
						<input name="repassword" type="password" id="repassword" required>
					</div>
					<div class="form-block">
						<button type="submit" class="btn btn-primary">Register</button>
					</div>
				</div>
				<div class="col-sm-3"></div>
			</div>
		</form>
	</div> <!-- #content -->
</div> <!-- .container -->
@endsection