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
            <th>Username</th>
            <th>Email</th>
            <th>Last Login</th>
            <th>Faculty/Unit</th>
            <th>iAuditor Name</th>
            <th>Group</th>
        </tr>
        </thead>
        <tbody>
<?php foreach ($dataSet as $i): ?>

<tr>
    <td><a href="User/edit/<?=$i['user_id']?>">View/Edit</a></td>
    <td><?=$i['first_name']?></td>
    <td><?=$i['last_name']?></td>
    <td><?=$i['username']?></td>
    <td><?=$i['email']?></td>
    <td><?=date("Y-m-d H:i:s", $i['last_login'])?></td>
    <td><?=$i['faculty_unit']?></td>
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
            <th>Username</th>
            <th>Email</th>
            <th>Last Login</th>
            <th>Faculty/Unit</th>
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

</script>
