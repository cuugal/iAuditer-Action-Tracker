<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<h3>Area of Accountability</h3>

<div style="float:left"><a href="AreaOfAccountability/newAoa" class="btn btn-primary">New</a></div>
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
            <td><a class="btn btn-primary" href="AreaOfAccountability/editAoa/<?=$i['aoa_id']?>">View/Edit</a></td>

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
