<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

    <h3>Inspection List</h3>

    <table id="example" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>&nbsp;</th>
            <th>Inspection Type</th>
            <th>Date of Inspection</th>
            <th>Area of Accountability</th>
            <th>Location</th>
            <th>Inspector Name</th>

            <th>Last Updated</th>
            <th>Actions Outstanding</th>
            <th>Actions In Progress</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
        <tr>
            <th>&nbsp;</th>
            <th>Inspection Type</th>
            <th>Date of Inspection</th>
            <th>Area of Accountability</th>
            <th>Location</th>
            <th>Inspector Name</th>

            <th>Last Updated</th>
            <th>Actions Outstanding </th>
            <th>Actions In Progress</th>
        </tr>
        </tfoot>
    </table>

<script type="text/javascript">
    var dataSet = <?=$dataSet?>;

    $(document).ready(function() {


        var table = $('#example').DataTable( {
            "data": dataSet,
            "columns": [
                { "data": "audit_id",
                    "render": function ( data, type, full, meta ) {
                        return '<a class="btn btn-primary" href="inspection/request/'+data+'" >View</a>';
                    }
                },
               { "data": "inspection_type"},
                { "data": "created_at"},
                { "data": "area_of_accountability", "width":"20%"},
                { "data": "location"},
                { "data": "inspector_name"},
                { "data": "modified_at"},
                { "data": "number_of_outstanding_actions"},
                { "data": "number_of_actions_in_progress"},


            ],
            columnDefs: [ {
                targets: [2,6],
                render:  $.fn.dataTable.render.moment( 'DD/MM/YYYY'),
            } ],

            "order": [[ 6, "desc" ]]


        } );
        //console.log(table.table());
        yadcf.init(table, [{
            column_number: 3,
            filter_type: "multi_select",
            select_type: 'chosen'
        }]);


    } );

</script>