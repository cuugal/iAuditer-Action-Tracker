<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

    <h3>Inspection List</h3>
    <?php
    $d = new DateTime('2011-01-01T15:03:01.012345Z');
    //echo '<b>'.print_r($dataSet).'</b>';
    ?>

    <table id="example" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>&nbsp;</th>
            <th>Inspection Type</th>
            <th>Date of Inspection</th>
            <th>Area of Accountability</th>
            <th>Location</th>
            <th>Inspector Name</th>
            <th>Residual Risk (H,M,L)</th>
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
            <th>Residual Risk (H,M,L)</th>
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
                        return '<a href="inspection/request/'+data+'" target="_blank">View</a>';
                    }
                },
               { "data": "inspection_type"},
                { "data": "created_at"},
                { "data": "area_of_accountability"},
                { "data": "location"},
                { "data": "inspector_name"},
                { "data": "risk_overview"},
                { "data": "modified_at"},
                { "data": "number_of_outstanding_actions"},
                { "data": "number_of_actions_in_progress"},

            ],

            "order": [[ 7, "desc" ]]

        } );
        yadcf.init(table, [{
            column_number: 3,
            filter_type: "multi_select",
            select_type: 'chosen'
        }]);


    } );

</script>