<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<br/>

<?php foreach ($dataSet as $data): ?>


<table class="table table-striped table-bordered table-hover" style="border: 2px solid #ddd" cellspacing="0" width="100%">
    <thead>
    <tr class="arheader">
        <th colspan="3">Area of Accountability:</th>
        <th colspan="2"><?=$data[0]['area_of_accountability']?></th>
        <th colspan="2">Org Unit:</th>
        <th colspan="2"><?=$data[0]['OrgUnit']?></th>
        <th colspan="2">Accountable Person:</th>
        <th colspan="2"><?=$data[0]['accountable']?></th>
    </tr>
    <tr class="arheader">
        <th colspan="3">Responsible Person/s:</th>
        <th colspan="10"><?=$data[0]['responsible'];?></th>

    </tr>
    <tr>
        <th>&nbsp;</th>
        <th>Inspection Id</th>
        <th>Hazard Id</th>
        <th>Date Identified</th>
        <th>Source</th>
        <th>Inspector</th>
        <th>Location</th>

        <th>Type of Hazard</th>
        <th>Issue</th>
        <th>Proposed Action</th>
        <th>Reviewed Action</th>
        <th>Residual Risk</th>
        <th>Action Status</th>

    </tr>
    </thead>
    <tbody>

    <?php foreach($data as $i):?>
        <tr>
            <td><a class="btn btn-primary" href="ActionRegister/request/<?=$i['key']?>">View</a></td>
            <th><?=$i['au_id']?></th>
            <th><?=$i['ar_id']?></th>
            <td><?=$i['created_at']?></td>
            <td><?=$i['source']?></td>
            <td><?=$i['inspector_name']?></td>
            <td><?=$i['location']?></td>

            <td><?=$i['type_of_hazard']?></td>
            <td><?=$i['issue']?><b> - No</b></td>
            <td><?=$i['proposed_action']?></td>
            <td><?=$i['reviewed_action']?></td>
            <td><?=$i['residual_risk']?></td>
            <td><?=$i['action_status']?>

                <?php if($i['action_status'] == 'In Progress' && isset($i['completion_date'])):

            ?> - Due to complete on: <?= $i['completion_date'];?>
            <?php endif;?>
                <?php if($i['action_status'] == 'Closed' && isset($i['action_closed_date'])):

                    ?> on: <?= $i['action_closed_date'];?>
                <?php endif;?>
                    </td>

          </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th>&nbsp;</th>
        <th>Inspection Id</th>
        <th>Hazard Id</th>
        <th>Date Identified</th>
        <th>Source</th>
        <th>Inspector</th>
        <th>Location</th>

        <th>Type of Hazard</th>
        <th>Issue</th>
        <th>Proposed Action</th>
        <th>Reviewed Action</th>
        <th>Residual Risk</th>
        <th>Action Status</th>

    </tr>
    </tfoot>
</table>
<br/>
    <br/>
<?php endforeach; ?>

<script type="text/javascript">



    $(document).ready(function() {

            $('.table').DataTable({
                "order": [[3, "desc"]],
                "paging":   false,
                "searching": false

            });

        });

</script>

