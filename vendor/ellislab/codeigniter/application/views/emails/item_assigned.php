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
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand page-scroll" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>/assets/images/Black-UTS-logo.png" height="30px"></a>
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

                <p class="lead">A health and safety inspection hazard, assigned to you via <a href="<?php echo base_url(); ?>">UTS iAuditor Action Tracker</a> has been assigned to you. </p>
                <p class="text-primary strong">
                    A summary of the hazard follows:

                <table class="table">
                    <tr><td class="text-right strong">Reference number: </td>           <td class="text-left"><mark><?=$InspectionID?></mark></td></tr>
                    <tr><td class="text-right strong">Inspection type:</td>             <td class="text-left"><mark><?=$InspectionType?></td></mark></tr>
                    <tr><td class="text-right strong">Date of inspection:</td>          <td class="text-left"><mark><?=$DateIdentified?></td></mark></tr>
                    <tr><td class="text-right strong">Area of Accountability:</td>      <td class="text-left"><mark><?=$AoA?></td></mark></tr>
                    <tr><td class="text-right strong">Specific Location:</td>           <td class="text-left"><mark><?=$Location?>.</td></mark></tr>

                    <tr><td class="text-right strong">Actions identified:</td>           <td class="text-left"><mark><?=$Deficiencies?></td></mark></tr>

                </table>


                </p>
                <p>
                    Please log into <a href="<?php echo base_url(); ?>">iAuditor Action Tracker</a> using your UTS email and Action Tracker password (not your UTS password) and:
                <ul>
                    <li>Nominate an appropriate corrective action to reduce the level of risk presented by the hazard</li>
                    <li>Assign a priority</li>
                    <li>Close the action when action is completed</li>
                </ul>
                </p>


                    Note: Please do not reply to this message. Replies to this message are routed to an unmonitored mailbox. If you have questions please email <a href="mailto:safetyandwellbeing@uts.edu.au?subject=Action Tracker">safetyandwellbeing@uts.edu.au</a> or call us on <strong>(02) 9514 1342</strong>.
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
