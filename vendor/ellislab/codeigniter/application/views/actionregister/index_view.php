<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<br/>

<?php foreach ($dataSet as $data): ?>


<table class="action_register table table-striped table-bordered table-hover" style="border: 2px solid #ddd" cellspacing="0" width="100%">
    <thead>
    <tr class="arheader">
        <th colspan="2">Area of Accountability:</th>
        <th colspan="1"><?=$data[0]['area_of_accountability']?></th>
        <th colspan="1">Org Unit:</th>
        <th colspan="1"><?=$data[0]['OrgUnit']?></th>
        <th colspan="2">Accountable Person:</th>
        <th colspan="1"><?=$data[0]['accountable']?></th>
    </tr>
    <tr class="arheader">
        <th colspan="2">Responsible Person/s:</th>
        <th colspan="6"><?=$data[0]['responsible'];?></th>

    </tr>
    <tr>
        <th>&nbsp;</th>
        <th>Inspection ID <br/>- Hazard ID</th>
        <th>Location</th>
        <th>Issue</th>
        <th>Proposed Action</th>
        <th>Reviewed Action</th>
        <th>Priority</th>
        <th>Action Status</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach($data as $i):?>
        <tr>
            <td width="130px">
                <input type="hidden" class="data" id="data<?=$i['au_id']?>-<?=$i['ar_id']?>" value='<?=json_encode($i);?>'/>
                <a class="btn btn-primary" href="ActionRegister/request/<?=$i['key']?>">Edit</a>
                <a class="btn btn-primary moretoggle" id="btn<?=$i['au_id']?>-<?=$i['ar_id']?>" >More</a>
            </td>
            <td width="120px"><?=$i['au_id']?> - <?=$i['ar_id']?></td>

            <td><?=$i['location']?></td>
            <td><?=$i['issue']?><b> - No</b></td>
            <td><?=$i['proposed_action']?></td>
            <td><?=$i['reviewed_action']?></td>
            <td class="priority"><?=$i['residual_risk']?></td>
            <td><?=$i['action_status']?>

                <?php if(($i['action_status'] == 'In Progress' || $i['action_status'] == 'In Progress') && isset($i['completion_date'])):

            ?> - Due to complete on: <b><?=date("d/m/Y", strtotime($i['completion_date']))?></b>
            <?php endif;?>
                <?php if($i['action_status'] == 'Closed' && isset($i['action_closed_date'])):
                    ?> on: <b><?= date("d/m/Y", strtotime($i['action_closed_date']));?></b>
                <?php endif;?>
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
        <th>Proposed Action</th>
        <th>Reviewed Action</th>
        <th>Priority</th>
        <th>Action Status</th>

    </tr>
    </tfoot>
</table>
<br/>
    <br/>
<?php endforeach; ?>

<script type="text/javascript">

    /* Formatting function for row details - modify as you need */
    function format ( d ) {
        // `d` is the original data object for the row
        return '<table class="table table-bordered" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
            '<tr>'+
            '<td class="text-right strong">Date:</td>'+
            '<td class="text-left">'+d.created_at+'</td>'+
            '</tr>'+
            '<tr>'+
            '<td class="text-right strong">Source:</td>'+
            '<td class="text-left">'+d.source+'</td>'+
            '</tr>'+
            '<tr>'+
            '<td class="text-right strong">Inspector:</td>'+
            '<td class="text-left">'+d.inspector_name+'</td>'+
            '</tr>'+
            '<tr>'+
            '<td class="text-right strong">Type of Hazard:</td>'+
            '<td class="text-left">'+d.type_of_hazard+'</td>'+
            '</tr>'+
            '<tr>'+
            '<td class="text-right strong">Issue:</td>'+
            '<td class="text-left">'+d.issue+'</td>'+
            '</tr>'+
            '<tr>'+
            '<td class="text-right strong">Proposed Action:</td>'+
            '<td class="text-left">'+d.proposed_action+'</td>'+
            '</tr>'+

        '</table>';

    }


     $(document).ready(function() {

            $('.table').DataTable({
                "order": [[1, "desc"]],
                "paging":   false,
                "searching": false,
                columnDefs: [ {
                    targets: [3,4],
                    render: $.fn.dataTable.render.ellipsis( 90, true )
                } ],
                "createdRow": function( row, data, dataIndex ) {
                    if (data[6] == 'High') {
                        $(row).addClass('high');
                    }
                    else if (data[6] == 'Medium') {
                        $(row).addClass('medium');
                    }
                    else if (data[6] == 'Low') {
                        $(row).addClass('low');
                    }
                },
            });

        });


    // Add event listener for opening and closing details
    $('tbody').on('click', 'td a.moretoggle', function () {

        var tr = $(this).closest('tr');

        var table = $(this).closest('.table').DataTable();
        var row = table.row( tr );

        var d1 = jQuery.parseJSON($(this).closest('tr').find('.data').val());
        //console.log(d1);
        //row.data(d1);

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
            $(this).text("More");
        }
        else {
            // Open this row
            row.child( format(d1) ).show("slow");
            tr.addClass('shown');
            $(this).text("Hide");
        }
    } );

    $(function () {
        $('[data-toggle="tooltip"]').tooltip({container: 'body'})
    })

</script>

<style type="text/css">
    .action_register > tbody > tr.high td.priority{
        background-color: #ff9000;
        /*
    border-style: solid;
        border-color: #ff9000;
        border-width: 2px;
        */
    }
    .action_register > tbody > tr.medium td.priority{

        background-color: #f5d328;
        /*
        border-style: solid;
        border-color: #f5d328;
        border-width: 2px;
        */
    }
    .action_register > tbody > tr.low td.priority{
        background-color: #70bf41;

        /*border-style: solid;
        border-color: #70bf41;
        border-width: 2px;
        */
    }
    </script>

