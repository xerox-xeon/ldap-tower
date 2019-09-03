<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>重置密码</title>
	<link rel="stylesheet" href="{{ url('/asset/register/css/bootstrap.min.css') }}" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="{{ url('/asset/register/css/my-login.css') }}">
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center align-items-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="{{ url('/asset/register/img/devops.png') }}" alt="devops">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">重置密码</h4>
							<form method="POST" class="my-login-validation" novalidate="" action="{{url('account/reset')}}">
								@if ($errors)
									<div class="alert alert-danger">
										<ul>
											@foreach ($errors as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
								<input type="hidden" name="verifyCode" value="{{ @$request_params['verifyCode'] }}">
								<div class="form-group">
									<label for="name">邮箱地址</label>
									<input id="name" type="text" class="form-control" name="email"  autofocus value="{{ @$request_params['email'] }}" readonly>
									<div class="invalid-feedback">
										邮箱地址不能为空！
									</div>
								</div>
								<div class="form-group">
									<label for="new-password">新密码</label>
									<input id="new-password" type="password" class="form-control" name="password" required autofocus data-eye>
									<div class="invalid-feedback">
										Password is required
									</div>
									<div class="form-text text-muted">
										请确保您的密码强大且易于记忆！
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block" @if($errors) disabled @endif>
										重置密码
									</button>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
						Copyright &copy;  {{ date('Y') }} &mdash; {{ env('LDAP_USER_DOMAIN') }}
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="{{ url('/asset/register/js/jquery-3.3.1.slim.min.js') }}" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="{{ url('/asset/register/css/bootstrap.min.css') }}" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="{{ url('/asset/register/js/my-login.js') }}"></script>
</body>
</html>