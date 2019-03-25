<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/themes/default/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/themes/default/css/dataTables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/themes/default/css/additions.css" rel="stylesheet">

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

<!-- Navigation -->
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header page-scroll">
            <!--button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button-->
            <a class="navbar-brand page-scroll" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>/assets/images/Black-UTS-logo.png" height="10px"></a>
        </div>


        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<div id="intro">

    <div class="container">

        <!--<div class="row">-->
        <div class="row">
            <div class="col-md-12 col-lg-8">

                <p class="lead">A health and safety inspection hazard, assigned to you via <a href="<?php echo base_url(); ?>">UTS Inspection Action Tracker</a> requires your attention. It has passed the target completion date of <mark><?=$TaskDueDate?></mark>.</p>
                <p><strong>A summary of the hazard follows:</strong></p>

				<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=2 style='border-collapse:collapse;border:none'>
                    <tr><td width=15 style='border:none'></td><td width=160 valign=top style='border:solid windowtext 1.0pt;padding:2px'>Reference number: </td>   <td class="text-left">&nbsp<mark><?=$InspectionID?>-<?=$HazardID?></mark>&nbsp</td></tr>
                     <tr><td width=15 style='border:none'></td><td width=160 valign=top style='border:solid windowtext 1.0pt;padding:2px'>Date the hazard was noticed:</td> <td class="text-left">&nbsp<mark><?=$DateIdentified?></mark>&nbsp</td></tr>
                     <tr><td width=15 style='border:none'></td><td width=160 valign=top style='border:solid windowtext 1.0pt;padding:2px'>Hazard identified by:</td>        <td class="text-left">&nbsp<mark><?=$InspectorName?></mark>&nbsp</td></tr>
                     <tr><td width=15 style='border:none'></td><td width=160 valign=top style='border:solid windowtext 1.0pt;padding:2px'>Description of the hazard:</td>   <td class="text-left">&nbsp<mark><?=$Issue?> - NO</mark>&nbsp</td></tr>
                     <tr><td width=15 style='border:none'></td><td width=160 valign=top style='border:solid windowtext 1.0pt;padding:2px'>Proposed action to fix this hazard is:</td><td class="text-left">&nbsp<mark><?=$ProposedAction?></mark>&nbsp</td></tr>
                </table>
				<p>&nbsp</p>

                <p>
                Please log into <a href="<?php echo base_url(); ?>">Inspection Action Tracker</a> using your UTS email and Action Tracker password (not your UTS password) and:
                <ul>
                    <li>Note Action Status as "Closed"  <strong>OR</strong></li>
                    <li>Amend the "Completion Date" to date you expect this action will be completed.</li>
                </ul>
                </p>
                <p class="text-primary strong">
                You may also amend the reviewed action if necessary.</p>
                <p>

                Note: Please do not reply to this message. Replies to this message are routed to an unmonitored mailbox. If you have questions please email <a href="mailto:safetyandwellbeing@uts.edu.au?subject=Action Tracker">safetyandwellbeing@uts.edu.au</a>.
                </p>
</div>



        </div>		    <!--</div>-->
        <hr/>

        <footer>
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    Copyright &copy; <a target="_blank" href="http://www.uts.edu.au">uts.edu.au</a>
                </div>
            </div>

        </footer>

    </div> <!-- /container -->
</div>
</body></html>
