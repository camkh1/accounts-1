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
			<script type="text/javascript">
					var _gaq = _gaq || [];
						gaq.push(['_setAccount', 'UA-46527722-1']);
						_gaq.push(['_trackPageview']);

					(function() {
							var ga = document.createElement('script');
							ga.type = 'text/javascript';
							ga.async = true;
							ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
							var s = document.getElementsByTagName('script')[0];
							s.parentNode.insertBefore(ga, s);
					})();

			</script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
<body class="login">
<div class="logo"> <img src="assets/img/logo.png" alt="logo"/> <strong>ME</strong>LON </div>
<div class="box">
  <div class="content">
    <form class="form-vertical login-form" action="index.html" method="post">
      <h3 class="form-title">Sign In to your Account</h3>
      <div class="alert fade in alert-danger" style="display: none;"> <i class="icon-remove close" data-dismiss="alert"></i> Enter any username and password. </div>
      <div class="form-group">
        <div class="input-icon"> <i class="icon-user"></i>
          <input type="text" name="username" class="form-control" placeholder="Username" autofocus data-rule-required="true" data-msg-required="Please enter your username."/>
        </div>
      </div>
      <div class="form-group">
        <div class="input-icon"> <i class="icon-lock"></i>
          <input type="password" name="password" class="form-control" placeholder="Password" data-rule-required="true" data-msg-required="Please enter your password."/>
        </div>
      </div>
      <div class="form-actions">
        <label class="checkbox pull-left">
          <input type="checkbox" class="uniform" name="remember">
          Remember me</label>
        <button type="submit" class="submit btn btn-primary pull-right"> Sign In <i class="icon-angle-right"></i> </button>
      </div>
    </form>
    <form class="form-vertical register-form" action="index.html" method="post" style="display: none;">
      <h3 class="form-title">Sign Up for Free</h3>
      <div class="form-group">
        <div class="input-icon"> <i class="icon-user"></i>
          <input type="text" name="username" class="form-control" placeholder="Username" autofocus data-rule-required="true"/>
        </div>
      </div>
      <div class="form-group">
        <div class="input-icon"> <i class="icon-lock"></i>
          <input type="password" name="password" class="form-control" placeholder="Password" id="register_password" data-rule-required="true"/>
        </div>
      </div>
      <div class="form-group">
        <div class="input-icon"> <i class="icon-ok"></i>
          <input type="password" name="password_confirm" class="form-control" placeholder="Confirm Password" data-rule-required="true" data-rule-equalTo="#register_password"/>
        </div>
      </div>
      <div class="form-group">
        <div class="input-icon"> <i class="icon-envelope"></i>
          <input type="text" name="Email" class="form-control" placeholder="Email address" data-rule-required="true" data-rule-email="true"/>
        </div>
      </div>
      <div class="form-group spacing-top">
        <label class="checkbox">
          <input type="checkbox" class="uniform" name="remember" data-rule-required="true" data-msg-required="Please accept ToS first.">
          I agree to the <a href="javascript:void(0);">Terms of Service</a></label>
        <label for="remember" class="has-error help-block" generated="true" style="display:none;"></label>
      </div>
      <div class="form-actions">
        <button type="button" class="back btn btn-default pull-left"> <i class="icon-angle-left"></i> Back</i> </button>
        <button type="submit" class="submit btn btn-primary pull-right"> Sign Up <i class="icon-angle-right"></i> </button>
      </div>
    </form>
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
<div class="single-sign-on"> <span>or</span>
  <button class="btn btn-facebook btn-block"> <i class="icon-facebook"></i> Sign in with Facebook </button>
  <button class="btn btn-twitter btn-block"> <i class="icon-twitter"></i> Sign in with Twitter </button>
  <button class="btn btn-google-plus btn-block"> <i class="icon-google-plus"></i> Sign in with Google </button>
</div>
<div class="footer"> <a href="#" class="sign-up">Don't have an account yet? <strong>Sign Up</strong></a> </div>
<script type="text/javascript">if(location.host=="envato.stammtec.de"||location.host=="themes.stammtec.de"){var _paq=_paq||[];_paq.push(["trackPageView"]);_paq.push(["enableLinkTracking"]);(function(){var a=(("https:"==document.location.protocol)?"https":"http")+"://analytics.stammtec.de/";_paq.push(["setTrackerUrl",a+"piwik.php"]);_paq.push(["setSiteId","17"]);var e=document,c=e.createElement("script"),b=e.getElementsByTagName("script")[0];c.type="text/javascript";c.defer=true;c.async=true;c.src=a+"piwik.js";b.parentNode.insertBefore(c,b)})()};</script>
		</body>

</html>
