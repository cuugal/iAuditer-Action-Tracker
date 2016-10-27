<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
<?php
    $d = new DateTime('2011-01-01T15:03:01.012345Z');

?>

<table id="example" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>Template ID</th>
        <th>Audit ID</th>
        <th>Modified At</th>

    </tr>
    </thead>
    <tbody>

    </tbody>
    <tfoot>
    <tr>
        <th>Template ID</th>
        <th>Audit ID</th>
        <th>Modified At</th>

    </tr>
    </tfoot>
</table>
</div>
<script type="text/javascript">

    $(document).ready(function() {



        $('#example').DataTable( {
            "ajax": {
                "url": "/import/getdata",
                "dataSrc": ""
            },
            "columns": [
                { "data": "template_id" },
                { "data": "audit_id" },
                { "data": "modified_at"},

            ],

        } );
    } );
    console.log("Date"+Date("2014-12-01T12:00:00Z"));
</script>