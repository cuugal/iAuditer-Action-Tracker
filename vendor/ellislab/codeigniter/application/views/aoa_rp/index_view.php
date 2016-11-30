<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<h3>Responsible Person/s - Area of Accountability</h3>
<?php if (isset($_SESSION['ar_message'])) : ?>
    <div class="alert alert-success"><?=$_SESSION['ar_message'];?>
    </div>
<?php endif; ?>

<div style="float:left"><a href="Aoa_rp/newAoa" class="btn btn-primary">New</a></div>
<div style="clear:both"></div>
<br/>

<table class="table table-striped table-bordered table-hover" style="border: 2px solid #ddd" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>&nbsp;</th>
        <th>Responsible Person</th>
        <th>Area of Accountability</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($dataSet as $i): ?>

        <tr>
            <!--<td><a href="Aoa_rp/editAR/<?=$i['id']?>">View/Edit</a></td>-->
            <td><a
                    class="btn btn-primary" data-toggle="confirmation"
                    data-btn-ok-label="Delete" data-btn-ok-icon="glyphicon glyphicon-share-alt"
                    data-btn-ok-class="btn-success"
                    data-btn-cancel-label="Cancel" data-btn-cancel-icon="glyphicon glyphicon-ban-circle"
                    data-btn-cancel-class="btn-danger"
                    data-title="Warning" data-content="This will remove this Responsible Person from this Area"
                    href="Aoa_rp/remove/<?=$i['aoa_rp_id']?>">Delete</a></td>
            <td><?=$i['first_name']." ".$i['last_name']?></td>
            <td><?=$i['name']?></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th>&nbsp;</th>

        <th>Name</th>
        <th>Accountable Person</th>
    </tr>
    </tfoot>
</table>

<script type="text/javascript">

    $(document).ready(function() {

        $('.table').DataTable({
            "order": [[2, "desc"]],
            "columnDefs": [
                { "width": "10%", "targets": 0 }
            ]

        });

    });

    $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]',
        // other options
    });
</script>
