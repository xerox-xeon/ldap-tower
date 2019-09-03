<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>用户登录 - {{ env('APP_NAME') }}</title>
	<link rel="stylesheet" href="{{ url('/asset/register/css/bootstrap.min.css') }}" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="{{ url('/asset/register/css/my-login.css') }}">
</head>

<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="{{ url('/asset/register/img/devops.png') }}" alt="logo">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">修改密码@if ($login_success)成功@endif</h4>
							<form method="POST" class="my-login-validation" novalidate="" action="{{url('account/changepassword')}}">
								@if ($errors)
									<div class="alert alert-danger">
										<ul>
											@foreach ($errors as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
									@if ($login_success)
										<div class="alert alert-success">
											<h6><b>你可以登录如下平台：</b></h6>
											<ol>
												@foreach ($login_success as $key => $url)
													<li><a href='{{ $url }}' target="_blank">{{ $url }}</a></li>
												@endforeach
											</ol>
										</div>
									@endif
								<div class="form-group">
									<label for="name">英文帐号</label>
									<input id="name" type="text" class="form-control" name="name" required autofocus value="{{ @$request_params['name'] }}">
									<div class="invalid-feedback">
										英文帐号不能为空！
									</div>
								</div>

								<div class="form-group">
									<label for="password">原密码
									</label>
									<input id="password" type="password" class="form-control" name="password" required data-eye>
								    <div class="invalid-feedback">
										原密码不能为空！
							    	</div>
								</div>

								<div class="form-group">
										<label for="password">新密码
										</label>
										<input id="password" type="password" class="form-control" name="newPassword" required data-eye>
										<div class="invalid-feedback">
											新密码不能为空！
										</div>
									</div>
								<div class="form-group">
									<div class="custom-checkbox custom-control">


									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										确 定
									</button>
								</div>
								<div class="mt-4 text-center">
									Already have an account? <a href="{{ url('/account/') }}">登录</a>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
						Copyright &copy; {{ date('Y') }} &mdash; {{ env('LDAP_USER_DOMAIN') }}
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="{{ url('/asset/register/js/jquery-3.3.1.slim.min.js') }}" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="{{ url('/asset/register/js/popper.min.js') }}" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="{{ url('/asset/register/css/bootstrap.min.css') }}" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="{{ url('/asset/register/js/my-login.js') }}"></script>
</body>
</html>
