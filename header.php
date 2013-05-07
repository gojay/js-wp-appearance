<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Widget</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Le styles -->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css"/>
	<style type="text/css">
		body { padding-top: 60px; padding-bottom: 40px; }
	</style>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-responsive.css"/>
	<link rel="stylesheet" type="text/css" href="assets/js/jquery-ui/css/smoothness/jquery-ui-1.8.21.custom.css"/>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Le fav and touch icons -->
	<link rel="shortcut icon" href="http://twitter.github.com/bootstrap/assets/images/favicon.ico">
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="http://twitter.github.com/bootstrap/assets/images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="http://twitter.github.com/bootstrap/assets/images/apple-touch-icon-114x114.png">

	
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/jquery-ui/jquery-ui-1.8.18.custom.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery.equalHeight.js"></script>
	<script type="text/javascript" src="assets/js/widgets.js"></script>
	<script>
		$(document).ready(function(){
			// $('.ui-widget-content').equalHeight();
			Widgets.init({
				debug   : true,
				ajaxurl : 'includes/ajax.php'
			});
		})
	</script>

</head>
<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="#">Project name</a>
				<!-- <div class="nav-collapse">
					<ul class="nav">
						<li class="active"><a href="#">Home</a></li>
						<li><a href="#about">About</a></li>
						<li><a href="#contact">Contact</a></li>
					</ul>
					<p class="navbar-text pull-right">Logged in as <a href="#">username</a></p>
				</div> -->
			</div>
		</div>
	</div>
	<div class="container-fluid">