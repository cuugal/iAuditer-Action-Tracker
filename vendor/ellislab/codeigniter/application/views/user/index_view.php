<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

    <h3>Users</h3>

    <div style="float:left"><a href="User/register" class="btn btn-primary">Register New User</a></div>
<div style="clear:both"></div>
<br/>

    <table class="table table-striped table-bordered table-hover" style="border: 2px solid #ddd" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>&nbsp;</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Last Login</th>
            <th>Areas where Accountable</th>
            <th>Areas where Responsible</th>
            <th>iAuditor Name</th>
            <th>Group</th>
        </tr>
        </thead>
        <tbody>

<?php foreach($dataSet as $i): ?>

    <tr>
        <td style="width:130px"><a class="btn btn-primary" style="float:left" href="User/edit/<?=$i['user_id']?>">Edit</a>


            <a
                class="btn btn-primary <?php if($i['user_id'] == $this->ion_auth->get_user_id()): ?>disabled <?php endif;?>"
                data-toggle="confirmation"
                data-btn-ok-label="Delete" data-btn-ok-icon="glyphicon glyphicon-share-alt"
                data-btn-ok-class="btn-success"
                data-btn-cancel-label="Cancel" data-btn-cancel-icon="glyphicon glyphicon-ban-circle"
                data-btn-cancel-class="btn-danger"
                data-title="Warning" data-content="This will delete this User"
                href="User/delete_user/<?=$i['user_id']?>">Delete</a></td>

        </td>

        <td><?=$i['first_name']?></td>
        <td><?=$i['last_name']?></td>
        <td><?=$i['email']?></td>
        <td><?= isset($i['last_login']) ? date("Y-m-d H:i:s", $i['last_login']) : ''; ?></td>
        <td><?=$i['aoa']?></td>
        <td><?=$i['rp']?></td>
        <td><?=$i['iAuditor_Name']?></td>
        <td><?=$i['description']?></td>
    </tr>
    <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <th>&nbsp;</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Last Login</th>
            <th>Areas where Accountable</th>
            <th>Areas where Responsible</th>
            <th>iAuditor Name</th>
            <th>Group</th>
        </tr>
        </tfoot>
    </table>

<script type="text/javascript">

    $(document).ready(function() {

        $('.table').DataTable({
            "order": [[1, "desc"]],


        });

    });

    $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]',
        // other options
    });

</script>
