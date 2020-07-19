@if (Session::get('json'))
@else
<!DOCTYPE html>
<html>
	<head>
		<title>Psarnetwork-Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="{{ URL::asset('backend/melon/assets/css/login.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('backend/melon/assets/css/responsive.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('backend/melon/assets/css/plugins.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('backend/melon/assets/css/icons.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('backend/melon/bootstrap/css/bootstrap.min.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('backend/melon/assets/css/main.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('backend/melon/assets/css/fontawesome/font-awesome.min.css') }}">
		<!--[if IE 7]><link rel="stylesheet" href="{{ URL::asset('backend/melon/assets/css/fontawesome/font-awesome-ie7.min.css') }}"><![endif]-->
		<!--[if IE 8]><link href="{{ URL::asset('backend/melon/assets/css/ie8.css') }}" rel="stylesheet" type="text/css"/><![endif]-->
		<link href="{{ URL::asset('//fonts.googleapis.com/css?family=Open+Sans:400,600,700') }}" rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="{{ URL::asset('backend/melon/assets/js/libs/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('backend/melon/bootstrap/js/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('backend/melon/assets/js/libs/lodash.compat.min.js') }}"></script>
		<!--[if lt IE 9]><script src="{{ URL::asset('backend/melon/assets/js/libs/html5shiv.js') }}"></script><![endif]-->
		<script type="text/javascript" src="{{ URL::asset('backend/melon/plugins/uniform/jquery.uniform.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('backend/melon/plugins/validation/jquery.validate.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('backend/melon/plugins/nprogress/nprogress.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('backend/melon/assets/js/login.js') }}"></script>
		<script>$(document).ready(function(){Login.init()});</script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body class="login">		
		<div class="box">
		  <div class="content">
		  		<table class="table table-hover">
				  	<tr>
				  		<td><a href="#">Email: {{$user->email}}</a></td>
				  	</tr>
				  	<tr>
				  		<td><a href="#">Name: {{$user->u_name}}</a></td>
				  	</tr>
				  	<tr>
				  		<td style="text-align:center"><a href="logout"><i class="icon-key"></i> Log Out</a></td>
				  	</tr>
				</table>
		  </div>
		  <div class="inner-box">
		    <div class="content"> <i class="icon-remove close hide-default"></i> <a href="#" class="forgot-password-link">Forgot Password?</a>
		      <form class="form-vertical forgot-password-form hide-default" action="login.html" method="post">
		        <div class="form-group">
		          <div class="input-icon"> <i class="icon-envelope"></i>
		            <input type="text" name="email" class="form-control" placeholder="Enter email address" data-rule-required="true" data-rule-email="true" data-msg-required="Please enter your email."/>
		          </div>
		        </div>
		        <button type="submit" class="submit btn btn-default btn-block"> Reset your Password </button>
		      </form>
		      <div class="forgot-password-done hide-default"> <i class="icon-ok success-icon"></i> <span>Great. We have sent you an email.</span> </div>
		    </div>
		  </div>
		</div>
	</body>
</html>
@endif