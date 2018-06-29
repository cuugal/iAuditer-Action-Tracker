<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<h3>Management Report</h3>


<div class="row">
    <div class="col-lg-8">

        <form class="form-horizontal col-sm-12" autocomplete="on" method="post" accept-charset="utf-8">
            <div class="form-group">

                <label class="col-lg-2 control-label" for="start">Start Date</label>

                <div class="col-lg-3">
                    <input type="text" value="<?=date("d/m/Y", strtotime($start));?>" class="form-control" id="start" name="start" data-provide="datepicker" data-date-format="dd/mm/yyyy"/>
                </div>

                <label class="col-lg-2 control-label" for="end">End Date</label>

                <div class="col-lg-3">
                    <input type="text" value="<?=date("d/m/Y", strtotime($end));?>" class="form-control" id="end" name="end" data-provide="datepicker" data-date-format="dd/mm/yyyy"/>
                </div>
                <a href="#" id="reset" class="btn btn-primary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">


        <div class="panel-body with-table">
            <table class="table datatables table-striped table-bordered" id="table1">
                <thead>
                <tr>
                    <th>OrgUnit</th>
                    <th>Locations Inspected</th>
                    <th>Inspections Done</th>
                    <th>Outstanding Actions</th>

                </tr>
                </thead>

                <tbody>
                <?php foreach ($data as $row): ?>

                    <tr>
                        <td><?= $row['OrgUnit'] ?></td>
                        <td><?= $row['Inspections']?></td>
                        <td><?= $row['OutstandingActions'];?></td>
                        <td><?= $row['TotalActions'];?></td>

                    </tr>

                <?php endforeach; ?>
                </tbody>

            </table>

        </div>

    </div>
</div>

<script type="text/javascript">

    $("#start").change(function(){
        url = '<?php echo site_url('Reports/index');?>';
        start = $.trim($("#start").val());
        end = $.trim($("#end").val());
        window.location.href = url+'/'+moment(start, 'DD/MM/YYYY').format('YYYY-MM-DD')+'/'+moment(end, 'DD/MM/YYYY').format('YYYY-MM-DD');
    });

    $("#end").change(function(){
        url = '<?php echo site_url('Reports/index');?>';
        start = $.trim($("#start").val());
        end = $.trim($("#end").val());
        window.location.href = url+'/'+moment(start, 'DD/MM/YYYY').format('YYYY-MM-DD')+'/'+moment(end, 'DD/MM/YYYY').format('YYYY-MM-DD');
    });

    $("#reset").click(function(){
        url = '<?php echo site_url('Reports');?>';
        window.location.href = url;
    });


</script>

<style type="text/css">
    #table1_info{
        display:none;
    }
</style>

