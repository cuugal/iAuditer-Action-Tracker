<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $title; ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
	<?php
	/** -- Copy from here -- */
	if(!empty($meta))
	foreach($meta as $name=>$content){
		echo "\n\t\t";
		?><meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" /><?php
			 }
	echo "\n";

	if(!empty($canonical))
	{
		echo "\n\t\t";
		?><link rel="canonical" href="<?php echo $canonical?>" /><?php

	}
	echo "\n\t";

	foreach($css as $file){
	 	echo "\n\t\t";
		?><link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" /><?php
	} echo "\n\t";

	foreach($js as $file){
			echo "\n\t\t";
			?><script src="<?php echo $file; ?>"></script><?php
	} echo "\n\t";

	/** -- to here -- */
?>

        <!--- Loaded manually -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/themes/default/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/themes/default/css/dataTables.bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/themes/default/css/jquery.dataTables.yadcf.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/themes/default/css/chosen.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/themes/default/css/chosen.bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/themes/default/css/bootstrap-datepicker3.css"/>


        <script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/default/js/jquery-2.2.3.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/default/js/jquery.dataTables.js"></script>
       <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/default/js/bootstrap.js"></script>-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/default/js/datatables.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/default/js/dataTables.foundation.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/default/js/dataTables.bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/default/js/jquery.dataTables.yadcf.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/default/js/chosen.jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/default/js/bootstrap-datepicker.js"></script>

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/default/js/pdfobject.min.js"></script>

        <link href="<?php echo base_url(); ?>assets/themes/default/css/scrolling-nav.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/themes/default/css/additions.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->




</head>

  <body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

 <?php $this->load->view('themes/menu'); ?>

  <section id="intro" class="intro-section">

    <div class="container">
    <?php if($this->load->get_section('text_header') != '') { ?>
    	<h1><?php echo $this->load->get_section('text_header');?></h1>
    <?php }?>

    <!--<div class="row">-->
	    <?php echo $output;?>
		<?php echo $this->load->get_section('sidebar'); ?>
    <!--</div>-->
      <hr/>

      <footer>
      	<div class="row">
	        <div class="span6 b10">
				Copyright &copy; <a target="_blank" href="http://www.uts.edu.au">uts.edu.au</a>
	        </div>
        </div>
          <script type="text/javascript">
            //Auto scroll to any error messages
              $(document).ready(function (){
                  if ($(".alert").length) {
                      $('html, body').animate({
                          scrollTop: ($(".alert").first().offset().top)-61
                      },500);
                  }

              });
          </script>
      </footer>

    </div> <!-- /container -->
      </section>
</body></html>
