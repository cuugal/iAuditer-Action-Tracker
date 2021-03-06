<?php defined('BASEPATH') OR exit('No direct script access allowed');?>




<h4 style="float:left" >Outstanding Tasks</h4>
<table class="dashboard table table-striped outstanding table-bordered table-hover" style="border: 2px solid #ddd" cellspacing="0" width="100%">
    <thead>

    <tr>
        <th>&nbsp;</th>
        <th>Inspection ID <br/>- Hazard ID</th>
        <th>AoA</th>
        <th>Location</th>
        <th>Issue</th>
        <th>Due Date</th>
        <th>Days Overdue</th>
        <th>Priority</th>
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
            <td><?=$i['area_of_accountability']?></td>
            <td><?=$i['location']?></td>
            <td><?=$i['issue']?>
                <?php if (strpos($i['audit_id'], 'audit') !== false):?><b> - No</b><?php endif;?></td>



            <td><?=$i['completion_date']?></td>
            <td class="diff"><?=$i['diff']?></td>
            <td class="priority"><?=$i['residual_risk']?></td>
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
        <th>AoA</th>
        <th>Location</th>
        <th>Issue</th>
        <th>Due Date</th>
        <th>Days Overdue</th>
        <th>Priority</th>
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
        <th>AoA</th>
        <th>Location</th>
        <th>Issue</th>
        <th>Due Date</th>
        <th>Days Overdue</th>
        <th>Priority</th>
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
            <td><?=$i['area_of_accountability']?></td>
            <td><?=$i['location']?></td>
            <td><?=$i['issue']?><?php if (strpos($i['audit_id'], 'audit') !== false):?><b> - No</b><?php endif;?></td>


            <td><?=$i['completion_date']?></td>
            <td><?=$i['diff']?></td>
            <td class="priority"><?=$i['residual_risk']?></td>
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
        <th>AoA</th>
        <th>Location</th>
        <th>Issue</th>
        <th>Due Date</th>
        <th>Days Overdue</th>
        <th>Priority</th>
        <th>Action Status</th>
    </tr>
    </tfoot>
</table>
<br/>
<br/>


<script type="text/javascript">

    $(document).ready(function() {

        $('.table').DataTable({
            "order": [[5, "asc"],[6, "desc"]],
            "paging":   false,
            "searching": false,
            columnDefs: [{
                //targets: [5],
                //render:  $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY'),
            } ],
            "createdRow": function( row, data, dataIndex ) {
                if ( data[6] > 7 ) {
                    $(row).addClass( 'overdue' );
                }
                if (data[7] == 'High') {
                    $(row).addClass('high');
                }
                else if (data[7] == 'Medium') {
                    $(row).addClass('medium');
                }
                else if (data[7] == 'Low') {
                    $(row).addClass('low');
                }
                else if (data[7] == 'N/A') {
                    $(row).addClass('na');
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
    .dashboard > tbody > tr.high td.priority{
        background-color: #ff9000;

    }
    .dashboard > tbody > tr.medium td.priority{

        background-color: #f5d328;

    }
    .dashboard > tbody > tr.low td.priority{
        background-color: #70bf41;

    }
    .action_register > tbody > tr.na td.priority {
        background-color: #2A86B0
    }
</style>

