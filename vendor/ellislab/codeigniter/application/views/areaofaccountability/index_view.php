<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<h3>Area of Accountability</h3>

<div style="float:left"><a href="AreaOfAccountability/assignAoa" class="btn btn-primary">Assign</a></div>
<div style="float:left;padding-left:10px"><a href="AreaOfAccountability/newAoa" class="btn btn-primary">New Area of Accountability</a></div>
<div style="clear:both"></div>
<br/>

<table class="table table-striped table-bordered table-hover" style="border: 2px solid #ddd" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>&nbsp;</th>

        <th>Area of Accountability Name</th>
        <th>Accountable Person</th>

    </tr>
    </thead>
    <tbody>
    <?php foreach ($dataSet as $i): ?>

        <tr>
            <td><a class="btn btn-primary" href="AreaOfAccountability/editAssignAoa/<?=$i['aoa_id']?>">Edit</a></td>

            <td><?=$i['name']?></td>
            <td><?=$i['first_name']." ".$i['last_name']?></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th>&nbsp;</th>

        <th>Area of Accountability Name</th>
        <th>Accountable Person</th>
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
