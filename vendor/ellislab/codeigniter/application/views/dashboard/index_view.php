<?php defined('BASEPATH') OR exit('No direct script access allowed');?>




<h4 style="float:left" >Outstanding Tasks</h4>
<table class="table table-striped outstanding table-bordered table-hover" style="border: 2px solid #ddd" cellspacing="0" width="100%">
    <thead>

    <tr>
        <th>&nbsp;</th>
        <th>Inspection ID <br/>- Hazard ID</th>
        <th>Location</th>
        <th>Issue</th>
        <th>Due Date</th>
        <th>Days Overdue</th>
        <th>Residual Risk</th>
        <th>Action Status</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach($outstanding as $i):?>
        <tr>
            <td>
                <a class="btn btn-primary" href="ActionRegister/request/<?=$i['item_id'].$i['audit']?>">Open</a>
            </td>
            <td width="120px"><?=$i['au_id']?> - <?=$i['ar_id']?></td>
            <td><?=$i['location']?></td>
            <td><?=$i['issue']?><b> - No</b></td>


            <td><?=$i['completion_date']?></td>
            <td class="diff"><?=$i['diff']?></td>
            <td><?=$i['residual_risk']?></td>
            <td><?=$i['action_status']?>

                <?php if(($i['action_status'] == 'In Progress' || $i['action_status'] == 'In Progress') && isset($i['completion_date'])):

                    ?> - Due to complete on: <b><?=date("d/m/Y", strtotime($i['completion_date']))?></b>
                <?php endif;?>
                <?php if($i['action_status'] == 'Closed' && isset($i['action_closed_date'])):
                    ?> on: <b><?= date("d/m/Y", strtotime($i['action_closed_date']));?></b>
                <?php endif;?>
            </td>

            </td>

          </tr>

    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th>&nbsp;</th>
        <th>Inspection ID <br/>- Hazard ID</th>
        <th>Location</th>
        <th>Issue</th>
        <th>Due Date</th>
        <th>Days Overdue</th>
        <th>Residual Risk</th>
        <th>Action Status</th>
    </tr>
    </tfoot>
</table>
<br/>
    <br/>



<h4 style="float:left" >Completed Tasks</h4>
<table class="table table-striped table-bordered table-hover" style="border: 2px solid #ddd" cellspacing="0" width="100%">
    <thead>

    <tr>
        <th>&nbsp;</th>
        <th>Inspection ID <br/>- Hazard ID</th>
        <th>Location</th>
        <th>Issue</th>
        <th>Due Date</th>
        <th>Days Overdue</th>
        <th>Residual Risk</th>
        <th>Action Status</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach($completed as $i):?>
        <tr>
            <td>
                <a class="btn btn-primary" href="ActionRegister/request/<?=$i['item_id'].$i['audit']?>">Open</a>
            </td>
            <td width="120px"><?=$i['au_id']?> - <?=$i['ar_id']?></td>
            <td><?=$i['location']?></td>
            <td><?=$i['issue']?><b> - No</b></td>


            <td><?=$i['completion_date']?></td>
            <td><?=$i['diff']?></td>
            <td><?=$i['residual_risk']?></td>
            <td><?=$i['action_status']?>

                <?php if(($i['action_status'] == 'In Progress' || $i['action_status'] == 'In Progress') && isset($i['completion_date'])):

                    ?> - Due to complete on: <b><?=date("d/m/Y", strtotime($i['completion_date']))?></b>
                <?php endif;?>
                <?php if($i['action_status'] == 'Closed' && isset($i['action_closed_date'])):
                    ?> on: <b><?= date("d/m/Y", strtotime($i['action_closed_date']));?></b>
                <?php endif;?>
            </td>

            </td>

        </tr>

    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th>&nbsp;</th>
        <th>Inspection ID <br/>- Hazard ID</th>
        <th>Location</th>
        <th>Issue</th>
        <th>Due Date</th>
        <th>Days Overdue</th>
        <th>Residual Risk</th>
        <th>Action Status</th>
    </tr>
    </tfoot>
</table>
<br/>
<br/>


<script type="text/javascript">

    $(document).ready(function() {

        $('.table').DataTable({
            "order": [[4, "asc"],[5, "desc"]],
            "paging":   false,
            "searching": false,
            columnDefs: [{
                targets: [4],
                render:  $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY'),
            } ],
            "createdRow": function( row, data, dataIndex ) {
                if ( data[5] > 7 ) {
                    $(row).addClass( 'overdue' );
                }
            }

        });

    });


    //Hit Crontasks URL
    console.log($.ajax('<?php echo site_url('Tools/cronTasks'); ?>'));


</script>

<style type="text/css">

    .outstanding > tbody > tr.overdue >td.diff{
        font-weight:bold;
        background-color: #fcf8e3;
        padding: 0.2em;
    }
</style>
