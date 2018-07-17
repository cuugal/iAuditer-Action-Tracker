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
				<p>&nbsp</p>
                <p class="lead">A health and safety inspection, completed using <a href="<?php echo base_url(); ?>">UTS iAuditor Action Tracker</a> has been assigned to you.</p>
                <p><strong>A summary of the inspection follows:</strong></p>

                <!--table class="table"-->
				<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=2 style='border-collapse:collapse;border:none; width:100%'>
                    <tr><td width=15 style='border:none'></td><td width=160 valign=top style='border:solid windowtext 1.0pt;padding:2px'>Reference number: </td>		<td>&nbsp<mark><?=$InspectionID?></mark>&nbsp</td></tr>
                    <tr><td width=15 style='border:none'></td><td width=160 valign=top style='border:solid windowtext 1.0pt;padding:2px'>Inspection type:</td>          <td>&nbsp<mark><?=$InspectionType?></td></mark>&nbsp</tr>
                    <tr><td width=15 style='border:none'></td><td width=160 valign=top style='border:solid windowtext 1.0pt;padding:2px'>Date of inspection:</td>       <td>&nbsp<mark><?=$DateIdentified?></td></mark>&nbsp</tr>
                    <tr><td width=15 style='border:none'></td><td width=160 valign=top style='border:solid windowtext 1.0pt;padding:2px'>Area of accountability:</td>   <td>&nbsp<mark><?=$AoA?></td></mark>&nbsp</tr>
                    <tr><td width=15 style='border:none'></td><td width=160 valign=top style='border:solid windowtext 1.0pt;padding:2px'>Specific location:</td>        <td>&nbsp<mark><?=$Location?></td></mark>&nbsp</tr>
                    <tr><td width=15 style='border:none'></td><td width=160 valign=top style='border:solid windowtext 1.0pt;padding:2px'>Actions identified:</td>       <td>&nbsp<mark><?=$Deficiencies?></td></mark>&nbsp</tr>
                    <tr><td width=15 style='border:none'></td><td width=160 valign=top style='border:solid windowtext 1.0pt;padding:2px'>Inspector Name:</td>       <td>&nbsp<mark><?=$InspectorName?></td></mark>&nbsp</tr>
                    <tr><td width=15 style='border:none'></td><td width=160 valign=top style='border:solid windowtext 1.0pt;padding:2px'>Accountable Person:</td>       <td>&nbsp<mark><?=$Accountable?></td></mark>&nbsp</tr>
                </table>
				<p>&nbsp</p>

                <table class=MsoTableGrid border=1 cellspacing=0 cellpadding=2 style='border-collapse:collapse;border:none; width:100%'>
                    <tr>
                        <th width=15 style='border:none'></th>
                        <th style="padding:2px">Hazard ID </th><th style="padding:2px">Issue </th><th style="padding:2px"> Inspection Notes </th><th style="padding:2px"> Image </th>
                        <th style="padding:2px"> Type of Hazard </th><th style="padding:2px"> Proposed Action</th></tr>
                    <?php foreach($inspections as $item): ?>
                    <tr>
                        <td width=15 style='border:none'></td>
                        <td style="padding:2px"><?=$item['ar_id'];?></td>
                        <td style="padding:2px"><?=$item['issue'];?></td>
                        <td style="padding:2px"><?=$item['notes'];?></td>
                        <td style="padding:2px"> <?php if($item['image'] != ''):
                            $img = base64_encode(file_get_contents(APPPATH.'../tmp/'.$item['image']));
                            ?>
                            <img height="75px" src="data:image/png;base64,<?=$img;?>" alt="<?=$item['image'];?>"></td>
                        <td style="padding:2px"><?=$item['type_of_hazard']?> </td>
                        <td style="padding:2px"><?=$item['proposed_action']?> </td>
                        <?php endif;?></td>
                    </tr>
                    <?php endforeach;?>
                </table>
                <p>
                    Please log into <a href="<?php echo base_url(); ?>">iAuditor Action Tracker</a> using your UTS email and Action Tracker password (not your UTS password) and:
                </p>

                <ul>
                    <li>Nominate any appropriate corrective actions to reduce the level of risk presented by any hazards identified</li>
                    <li>Assign a priority</li>
                    <li>Close the actions when actions are completed</li>
                </ul>

				<p>Note: Please do not reply to this message. Replies to this message are routed to an unmonitored mailbox. If you have questions please email <a href="mailto:safetyandwellbeing@uts.edu.au?subject=Action Tracker">safetyandwellbeing@uts.edu.au</a>.</p>

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
