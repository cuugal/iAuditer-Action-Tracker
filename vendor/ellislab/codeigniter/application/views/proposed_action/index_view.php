<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<h3>Proposed Actions</h3>

<div style="float:left"><a href="ProposedAction/newAction" class="btn btn-primary">New</a></div>
<div style="clear:both"></div>
<br/>

<table class="table table-striped table-bordered table-hover" style="border: 2px solid #ddd" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>&nbsp;</th>

        <th>Proposed Action</th>


    </tr>
    </thead>
    <tbody>
    <?php foreach ($dataSet as $i): ?>

        <tr>
            <td><a class="btn btn-primary" href="ProposedAction/editAction/<?=$i['id']?>">View/Edit</a></td>
            <td><?=$i['proposed_action']?></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th>&nbsp;</th>

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
