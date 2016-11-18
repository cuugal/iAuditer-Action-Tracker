<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<h3>Action Register</h3>

<table id="example" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>&nbsp;</th>
        <th>Date Identified</td>
        <th>Inspector</th>
        <th>Location</th>
        <th>Source</th>
        <th>Type of Hazard</th>
        <th>Issue</th>
        <th>Proposed Action</th>
        <th>Initial Risk</th>
        <th>Action Required</th>
        <th>Reviewed Action</th>
        <th>Residual Risk</th>
        <th>Action Status</th>
        <th>Date Closed</th>
    </tr>
    </thead>
    <tbody>

    </tbody>
    <tfoot>
    <tr>
        <th>&nbsp;</th>
        <th>Date Identified</td>
        <th>Inspector</th>
        <th>Location</th>
        <th>Source</th>
        <th>Type of Hazard</th>
        <th>Issue</th>
        <th>Proposed Action</th>
        <th>Initial Risk</th>
        <th>Action Required</th>
        <th>Reviewed Action</th>
        <th>Residual Risk</th>
        <th>Action Status</th>
        <th>Date Closed</th>
    </tr>
    </tfoot>
</table>


<script type="text/javascript">
    var dataSet = <?=$dataSet?>;
    $(document).ready(function() {


        var table = $('#example').DataTable( {
            "data": dataSet,
            "columns": [
                { "data": "key",
                    "render": function ( data, type, full, meta ) {
                        return '<a href="actionregister/request/'+data+'">View</a>';
                    }
                },

                { "data": "created_at"},
                { "data": "inspector_name"},
                { "data": "location"},
                { "data": "source"},
                { "data": "type_of_hazard"},
                {"data": "issue",
                    "render":function ( data, type, row ) {
                        return data.length > 50 ?
                        data.substr( 0, 50 ) +'…' :
                            data;
                    }
                },
                { "data": "proposed_action"},
                { "data": "initial_risk"},
                { "data": "action_required"},
                { "data": "reviewed_action"},
                { "data": "residual_risk"},
                { "data": "action_status"},
                { "data": "completion_date"},

            ],

            "order": [[ 1, "desc" ]]

        } );
        /*
        yadcf.init(table, [{
            column_number: 1,
            filter_type: "multi_select",
            select_type: 'chosen'
        }]);
*/

    } );

</script>