<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<h3>UTS Health and Safety Inspection - Action Report</h3>

<div class="row">
    <div class="col-lg-12">
        <div class="panel-body with-table">
<table class="action_register table table-bordered">
    <tr class="arheader">
        <td class="text-right quarter">Inspection Type:</td><td class="text-left"><?=$audit['inspection_type'];?></td>
        <td class="text-right">Last Updated:</td><td class="text-left"><?=$audit['modified_at'];?></td>
    </tr>

    <tr class="arheader">
        <td class="text-right quarter">Date of Inspection:</td><td class="text-left quarter"><?=$audit['created_at'];?></td>
        <td class="text-right quarter">Actions Outstanding:</td><td class="text-left quarter"><?=$audit['number_of_outstanding_actions']?></td>
    </tr>
    <tr class="arheader">
        <td class="text-right">Area of Accountability:</td><td class="text-left"><?=$audit['area_of_accountability'];?></td>
        <td class="text-right">Actions in Progress:</td><td class="text-left"><?=$audit['number_of_actions_in_progress']?></td>
    </tr>
    <tr class="arheader">
        <td class="text-right">Location:</td><td colspan="3" class="text-left"><?=$audit['location'];?></td>
    </tr>
    <tr class="arheader">
        <td class="text-right">Inspector Name:</td><td colspan="3" class="text-left"><?=$audit['inspector_name'];?></td>
    </tr>

</table>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-lg-12">
        <div id="previous_panel" class="panel">

            <div class="panel-body with-table">
                <table class="table datatables table-striped table-bordered" id="table1">
                    <thead>
                    <tr>
                        <th style="display:none"></th>
                        <th>Inspection ID <br/>- Hazard ID</th>
                        <th>Issue</th>
                        <th>Inspection Notes</th>
                        <th>Image</th>
                        <th>Type Of Hazard</th>
                        <th>Proposed Action</th>
                        <th>Reviewed Action</th>
                        <th>Priority</th>
                        <th>Action Status</th>


                    </tr>
                    </thead>

                    <tbody>

                    <?php foreach($inspections as $row):?>
                        <tr>
                            <td style="display:none"><?=$row['key']?></td>
                            <td width="120px"><?=$row['au_id']?> - <?=$row['ar_id']?></td>
                            <td><?=$row['issue']?> </td>
                            <td><?=$row['notes']?> </td>
                            <td>
                                <?php if($row['image'] != ''):
                                $img = base64_encode(file_get_contents(APPPATH.'../tmp/'.$row['image']));
                                ?>
                                    <img height="75px" src="data:image/png;base64,<?=$img;?>" alt="<?=$row['image'];?>"></td>
                                <?php endif;?>
                            <td><?=$row['type_of_hazard']?> </td>
                            <td><?=$row['proposed_action']?> </td>
                            <td><?=$row['reviewed_action']?> </td>
                            <td class="priority"><?=$row['residual_risk']?></td>
                            <td><?=$row['action_status']?>

                                <?php if(($row['action_status'] == 'In Progress' || $row['action_status'] == 'In Progress') && isset($row['completion_date'])):

                                    ?> - Due to complete on: <b><?=date("d/m/Y", strtotime($row['completion_date']))?></b>
                                <?php endif;?>
                                <?php if($row['action_status'] == 'Closed' && isset($row['action_closed_date'])):
                                    ?> on: <b><?= date("d/m/Y", strtotime($row['action_closed_date']));?></b>
                                <?php endif;?>
                            </td>





                        </tr>

                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {


//        var table = $('#table1').DataTable( {
////            columnDefs: [ {
////                targets: [3,7],
////                render:  $.fn.dataTable.render.moment('DD/MM/YYYY'),
////            } ],
//            dom: 'Bfrtip',
//            buttons: [
//                {
//                    extend: 'print',
//                    filename:'UTS | Action Report',
//                    title:'UTS | Action Report',
//                },
//                {
//                    extend: 'csv',
//                    filename:'UTS | Action Report',
//                    title:'UTS | Action Report',
//                },
//                {
//                    extend: 'pdf',
//
//                    filename:'UTS | Action Report',
//                    title:'UTS | Action Report',
//                    orientation:'landscape'
//                },
//            ],
//            "order": [[ 7, "desc" ]]
//
//
//        } );


        $('.container').addClass('max');
    } );

</script>
<style type="text/css">
    .max{
        width:100%;
    }
    .stacked_btn{
        margin-top: 8px;
    }
    #table1_info{
        display:none;
    }
    div.dt-buttons {

        position: relative;
        float: left;
    }
    .dataTables_wrapper .dt-buttons > .dt-button:first-child {

        -webkit-border-radius: 3px 0 0 3px;
        -webkit-background-clip: padding-box;
        -moz-border-radius: 3px 0 0 3px;
        -moz-background-clip: padding;
        border-radius: 3px 0 0 3px;
        background-clip: padding-box;

    }
    .dataTables_wrapper .dt-buttons .dt-button {

        background: #fff;
        background-clip: border-box;
        border: 1px solid #ebebeb;
        margin: 0;

        -webkit-border-radius: 0px;
        -webkit-background-clip: padding-box;
        -moz-border-radius: 0px;
        -moz-background-clip: padding;
        border-radius: 0px;
        background-clip: padding-box;

    }
    button.dt-button, div.dt-button, a.dt-button {

        position: relative;
        display: inline-block;
        box-sizing: border-box;
        margin-right: 0.333em;
        padding: 0.5em 1em;
        border: 1px solid #999;
        border-radius: 2px;
        cursor: pointer;

        color: black;
        white-space: nowrap;
        overflow: hidden;
        background-color: #e9e9e9;
        background-image: -webkit-linear-gradient(top, white 0%, #e9e9e9 100%);
        background-image: -moz-linear-gradient(top, white 0%, #e9e9e9 100%);
        background-image: -ms-linear-gradient(top, white 0%, #e9e9e9 100%);
        background-image: -o-linear-gradient(top, white 0%, #e9e9e9 100%);
        background-image: linear-gradient(top, white 0%, #e9e9e9 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, StartColorStr='white', EndColorStr='#e9e9e9');
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        text-decoration: none;
        outline: none;
    }
    .quarter{
        width:25%;
    }



    /******** CSS Used ********/
    /*! CSS Used from: http://localhost:1024/assets/themes/default/css/bootstrap.css */
    footer{display:block;}
    a{background-color:transparent;}
    a:active,a:hover{outline:0;}
    img{border:0;}
    hr{height:0;-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;}
    table{border-spacing:0;border-collapse:collapse;}
    td,th{padding:0;}
    @media print{
        *,*:before,*:after{color:#000!important;text-shadow:none!important;background:transparent!important;-webkit-box-shadow:none!important;box-shadow:none!important;}
        a,a:visited{text-decoration:underline;}
        a[href]:after{content:" (" attr(href) ")";}
        thead{display:table-header-group;}
        tr,img{page-break-inside:avoid;}
        img{max-width:100%!important;}
        p,h3{orphans:3;widows:3;}
        h3{page-break-after:avoid;}
        .table{border-collapse:collapse!important;}
        .table td,.table th{background-color:#fff!important;}
        .table-bordered th,.table-bordered td{border:1px solid #ddd!important;}
    }
    *{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
    *:before,*:after{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
    a{color:#337ab7;text-decoration:none;}
    a:hover,a:focus{color:#23527c;text-decoration:underline;}
    a:focus{outline:thin dotted;outline:5px auto -webkit-focus-ring-color;outline-offset:-2px;}
    img{vertical-align:middle;}
    hr{margin-top:20px;margin-bottom:20px;border:0;border-top:1px solid #eee;}
    h3{font-family:inherit;color:inherit;}
    h3{margin-top:20px;margin-bottom:10px;margin-left:25px;}
    p{margin:0 0 10px;}
    .text-left{text-align:left;}
    .text-right{text-align:right;}
    .container{padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;}
    @media (min-width: 768px){
        .container{width:750px;}
    }
    @media (min-width: 992px){
        .container{width:970px;}
    }
    @media (min-width: 1200px){
        .container{width:1170px;}
    }
    .row{margin-right:-15px;margin-left:-15px;}
    .col-lg-12{position:relative;min-height:1px;padding-right:15px;padding-left:15px;}
    @media (min-width: 1200px){
        .col-lg-12{float:left;}
        .col-lg-12{width:100%;}
    }
    table{background-color:transparent;font-size:small;}
    th{text-align:left;}
    .table{width:100%;max-width:100%;margin-bottom:20px;}
    .table > thead > tr > th,.table > tbody > tr > td{padding:8px;vertical-align:top;border-top:1px solid #ddd;}
    .table > thead > tr > th{vertical-align:bottom;border-bottom:2px solid #ddd;}
    .table > thead:first-child > tr:first-child > th{border-top:0;}
    .table-bordered{border:1px solid #ddd;}
    .table-bordered > thead > tr > th,.table-bordered > tbody > tr > td{border:3px solid #fff}
    .table-bordered > thead > tr > th{border-bottom-width:2px;
        background-color: rgba(0, 104, 203, 0.59);
    color:#fff}
    .table-striped > tbody > tr:nth-of-type(odd){background-color:rgba(191, 211, 244, 0.29);}
    .panel{margin-bottom:20px;background-color:#fff;border:1px solid transparent;border-radius:4px;-webkit-box-shadow:0 1px 1px rgba(0, 0, 0, .05);box-shadow:0 1px 1px rgba(0, 0, 0, .05);}
    .panel-body{padding:15px;}
    .container:before,.container:after,.row:before,.row:after,.panel-body:before,.panel-body:after{display:table;content:" ";}
    .container:after,.row:after,.panel-body:after{clear:both;}
    /*! CSS Used from: http://localhost:1024/assets/themes/default/css/additions.css */

    .arheader{background-color: rgba(191, 211, 244, 0.29);}
    /*! CSS Used from: Embedded */
    .max{width:100%;}
    .quarter{width:25%;}
    html{
        font-family: Arial;
        font-size: small;
    }
</style>