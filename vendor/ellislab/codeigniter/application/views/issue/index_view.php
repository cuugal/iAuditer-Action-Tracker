<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<h3>Issues</h3>
<h6>Issues are loaded from audits</h6>

<br/>

<table class="table table-striped table-bordered table-hover" style="border: 2px solid #ddd" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>&nbsp;</th>

        <th>Issue</th>
        <th>Proposed Action</th>

    </tr>
    </thead>
    <tbody>
    <?php foreach ($dataSet as $i): ?>

        <tr>
            <td><a class="btn btn-primary" href="Issue/editIssue/<?=$i['issue_id']?>">View/Edit</a></td>
            <td><?=$i['issue']?></td>
            <td><?=$i['proposed_action']?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th>&nbsp;</th>
        <th>Issue</th>
        <th>Proposed Action</th>
    </tr>
    </tfoot>
</table>

<script type="text/javascript">

    $(document).ready(function() {

        $('.table').DataTable({
            "order": [[1, "desc"]],
            "columnDefs": [
                { "width": "10%", "targets": 0 }
            ]

        });

    });

</script>
