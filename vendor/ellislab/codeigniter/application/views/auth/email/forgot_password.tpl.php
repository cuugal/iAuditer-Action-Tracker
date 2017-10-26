<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="keywords" content=""/>
	<meta name="description" content=""/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/themes/default/css/bootstrap.css"
		  rel="stylesheet">
	<link rel="stylesheet" type="text/css"
		  href="<?php echo base_url(); ?>assets/themes/default/css/dataTables.bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/themes/default/css/additions.css"
		  rel="stylesheet">

</head>

<body id="page-top">
<div class="container" class="col-md-8 col-lg-8">
	<!-- Navigation -->
	<nav class="navbar ">
		<div class="container">
			<div class="navbar-header page-scroll">

				<a class="navbar-brand page-scroll" href="<?php echo base_url(); ?>"><img
						src="<?php echo base_url(); ?>/assets/images/Black-UTS-logo.png" height="50px"></a>
			</div>


			<!-- /.navbar-collapse -->
		</div>
		<!-- /.container -->
	</nav>

	<div id="intro">


		<!--<div class="row">-->
		<div class="col-md-12">

			<h1><?php echo sprintf(lang('email_forgot_password_heading'), $identity);?></h1>
			<p class="lead">


				You have requested a password reset,
				<?php echo sprintf(lang('email_forgot_password_subheading'), anchor('auth/reset_password/'. $forgotten_password_code, lang('email_forgot_password_link')));?>
				<br/>	<br/>





		</div>


		<hr/>

		<footer>
			<div class="row">
				<div class="col-md-12 col-lg-8">
					Copyright &copy; <a target="_blank" href="http://www.uts.edu.au">UTS</a>
				</div>
			</div>

		</footer>

	</div> <!-- /container -->
</div>

</body>
</html>
