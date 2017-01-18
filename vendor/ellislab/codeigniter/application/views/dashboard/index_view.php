<?php defined('BASEPATH') OR exit('No direct script access allowed');?>


<h3>Dashboard</h3>

<div style="clear:both"></div>
<br/>



<h4 style="float:left" >Outstanding Tasks</h4>
<table class="table table-striped table-bordered table-hover" style="border: 2px solid #ddd" cellspacing="0" width="100%">
    <thead>

    <tr>
        <th>&nbsp;</th>
        <th>Task ID </th>
        <th>Status</th>
        <th>Action Register</th>
        <th>Audit</th>
        <th>Days Overdue</th>
        <th>Due Date</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach($dataSet as $i):?>
        <tr>
            <td>
                <a class="btn btn-primary" href="Dashboard/request/<?=$i['task_id']?>">Edit</a>
            </td>
            <td><?=$i['task_id']?></td>

            <td><?=$i['status']?></td>
            <td><?=$i['action_register']?></td>
            <td><?=$i['audit']?></td>
            <td><?=$i['diff']?></td>
            <td><?=$i['completion_date']?></td>

            </td>

          </tr>

    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th>&nbsp;</th>
        <th>Task ID </th>
        <th>Status</th>
        <th>Action Register</th>
        <th>Audit</th>
        <th>Days Overdue</th>
        <th>Due Date</th>
    </tr>
    </tfoot>
</table>
<br/>
    <br/>


<script type="text/javascript">

     $(document).ready(function() {

            $('.table').DataTable({
                "order": [[5, "desc"],[6, "asc"]],
                "paging":   false,
                "searching": false,
                columnDefs: [{
                    targets: [6],
                    render:  $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY'),
                } ],
                "createdRow": function( row, data, dataIndex ) {
                    if ( data[5] > 10 ) {
                        $(row).addClass( 'urgent' );
                    }
                    else if(data[5] > 5){
                        $(row).addClass( 'caution' );
                    }
                    else{
                        $(row).addClass( 'new' );
                    }
                }

            });

        });


</script>

<style type="text/css">
    .table-striped > tbody > tr.urgent{background-color: #ff9ca5;
    }
    .table-striped > tbody > tr.caution{background-color: #ffdba3;
    }
    .table-striped > tbody > tr.new{background-color: #f4ffa0;
    }
    </style>

