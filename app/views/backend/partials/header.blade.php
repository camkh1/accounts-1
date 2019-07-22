<!DOCTYPE html>
<html>
	<head>
		<title>@yield('title')</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		{{HTML::style('backend/melon/bootstrap/css/bootstrap.min.css')}}
            <!--[if lt IE 9]>
				{{HTML::style('backend/melon/plugins/jquery-ui/jquery.ui.1.10.2.ie.css')}}
            <![endif]-->
		{{HTML::style('backend/melon/assets/css/main.css')}}
		{{HTML::style('backend/melon/assets/css/plugins.css')}}
		{{HTML::style('backend/melon/assets/css/responsive.css')}}
		{{HTML::style('backend/melon/assets/css/icons.css')}}
		{{HTML::style('backend/melon/assets/css/fontawesome/font-awesome.min.css')}}
		{{HTML::script('backend/melon/assets/js/libs/jquery.min.js')}}
            <!--[if IE 7]>
            	{{HTML::style('backend/melon/assets/css/fontawesome/font-awesome-ie7.min.css')}}
            <![endif]-->
            <!--[if IE 8]>
				{{HTML::style('backend/melon/assets/css/ie8.css')}}
            <![endif]-->  
		<script type="text/javascript">
		      var _gaq = _gaq || [];
		      _gaq.push(['_setAccount', 'UA-46527722-1']);
		      _gaq.push(['_trackPageview']);

		      (function() {
		        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		      })();
		    </script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
<body>