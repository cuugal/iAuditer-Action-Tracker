<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<br/>
<span style="float:right">
<strong style="display:inline-block">Filter:</strong>
<select id="multi-table-filter">
    <option>All</option>
    <option>Open/In Progress Only</option>
</select>
    </span>
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
            <!--th>Inspection ID <br/>- Hazard ID</th-->
            <th>Date</th>
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
                    <input type="hidden" class="data" id="data<?=$i['au_id']?>-<?=$i['ar_id']?>" value='<?=json_encode($i,JSON_HEX_APOS);?>'/>
                    <div style="display:none"><?=json_encode($i, JSON_HEX_APOS);?></div>
                    <a class="btn btn-primary" href="ActionRegister/request/<?=$i['key']?>">Edit</a>
                    <a class="btn btn-primary moretoggle" id="btn<?=$i['au_id']?>-<?=$i['ar_id']?>" >More</a>
                </td>
                <!--td width="120px"><?=$i['au_id']?> - <?=$i['ar_id']?></td-->
<!--                <td>--><?//= date("d/m/Y", strtotime($i['created_at']));?><!--</td>-->
                <td><?= $i['created_at'];?></td>
                <td><?=$i['location']?></td>
                <td><?=$i['issue']?>
                    <?php if (strpos($i['audit_id'], 'audit') !== false):?><b> - No</b><?php endif;?></td>

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
            <!--th>Inspection ID <br/>- Hazard ID</th-->
            <th>Date</th>
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

    function format ( d ) {
        // `d` is the original data object for the row
        return '<table class="table table-bordered" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
            '<tr>'+
            '<td class="text-right strong">Inspection ID - Hazard ID:</td>'+
            '<td class="text-left">'+d.au_id+' - '+d.ar_id+'</td>'+
            '</tr>'+
            '<tr>'+
            '<td class="text-right strong">Date:</td>'+
            '<td class="text-left">'+ moment( d.created_at).format('DD/MM/YYYY')+'</td>'+
            '</tr>'+
            '<tr>'+
            '<td class="text-right strong">Name:</td>'+
            '<td class="text-left">'+d.name+'</td>'+
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
            '<td class="text-left">'+d.issue+'<b> - No</b></td>'+
            '</tr>'+
            '<tr>'+
            '<td class="text-right strong">Proposed Action:</td>'+
            '<td class="text-left">'+d.proposed_action+'</td>'+
            '</tr>'+
            '<tr>'+
            '<td class="text-right strong">Inspection Notes:</td>'+
            '<td class="text-left">'+d.notes+'</td>'+
            '</tr>'+

            '</table>';

    }


    $(document).ready(function() {

        var api = $('.action_register').DataTable({
            "order": [[1, "desc"]],
            "paging":   false,

            columnDefs: [
                {
                    targets: [3,4],
                    render: $.fn.dataTable.render.ellipsis( 90, true ),
                },
                {
                    targets:[1],
                    render:  $.fn.dataTable.render.moment('DD/MM/YYYY'),
                }
                ],
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
                else if (data[6] == 'N/A') {
                    $(row).addClass('na');
                }
            },


        });




        $("#multi-table-filter").chosen({
            "disable_search": true
        });

        $('#multi-table-filter').on('change', function(event, params) {
            if(this.value == 'All') {
                $.fn.dataTable.tables({api: true}).columns(7).search('').draw();
            }
            else{
                $.fn.dataTable.tables( { api: true } ).columns(7).search('\\b'+'(Open|In Progress)'+'\\b',true,false,false).draw();
            }
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
    }
    .action_register > tbody > tr.medium td.priority{
        background-color: #f5d328;
    }
    .action_register > tbody > tr.low td.priority{
        background-color: #70bf41;
    }
    .action_register > tbody > tr.na td.priority {
        background-color: #2A86B0
    }
    .dataTables_filter{
        display:none;
    }
</style>

