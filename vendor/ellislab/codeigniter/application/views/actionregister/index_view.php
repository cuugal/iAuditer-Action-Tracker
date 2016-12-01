<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<br/>

<?php foreach ($dataSet as $data): ?>

<table class="table table-striped table-bordered table-hover" style="border: 2px solid #ddd" cellspacing="0" width="100%">
    <thead>
    <tr class="arheader">
        <th colspan="3">Area of Accountability:</th>
        <th colspan="2"><?=$data[0]['area_of_accountability']?></th>
        <th colspan="2">Faculty/Unit:</th>
        <th colspan="2"><?=$data[0]['location']?></th>
        <th colspan="2">Accountable Person:</th>
        <th colspan="3"><?=$data[0]['accountable']?></th>
    </tr>
    <tr class="arheader">
        <th colspan="3">Responsible Person/s:</th>
        <th colspan="11"><?=$data[0]['responsible'];?></th>

    </tr>
    <tr>
        <th>&nbsp;</th>
        <th>Date Identified</th>
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

    <?php foreach($data as $i):?>
        <tr>
            <td><a class="btn btn-primary" href="ActionRegister/request/<?=$i['key']?>">View</a></td>
            <td><?=$i['created_at']?></td>
            <td><?=$i['inspector_name']?></td>
            <td><?=$i['location']?></td>
            <td><?=$i['source']?></td>
            <td><?=$i['type_of_hazard']?></td>
            <td><?=$i['issue']?></td>
            <td><?=$i['proposed_action']?></td>
            <td><?=$i['initial_risk']?></td>
            <td><?=$i['action_required']?></td>
            <td><?=$i['reviewed_action']?></td>
            <td><?=$i['residual_risk']?></td>
            <td><?=$i['action_status']?></td>
            <td><?=$i['completion_date']?></td>
          </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th>&nbsp;</th>
        <th>Date Identified</th>
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
<br/>
    <br/>
<?php endforeach; ?>

<script type="text/javascript">



    $(document).ready(function() {

            $('.table').DataTable({
                "order": [[1, "desc"]],
                "paging":   false,
                "searching": false

            });

        });

</script>

