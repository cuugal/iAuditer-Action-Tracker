<?php defined('BASEPATH') OR exit('No direct script access allowed');?>


<div class="row">
    <div class="col-md-12 col-lg-12">
        <h1>Edit Proposed Action</h1>

        <?php if (isset($_SESSION['pa_message'])) : ?>
            <div class="alert alert-success"><?=$_SESSION['pa_message'];?>
            </div>
        <?php endif; ?>

        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

        <?= $this->form_builder->open_form(array('action' => ''));
        echo $this->form_builder->build_form_horizontal(
            array(
                array('id'=>'id',
                    'type'=>'hidden',
                    'value'=>$pa['id']

                ),
                array(
                    'id' => 'proposed_action',
                    'value'=>$pa['proposed_action'],

                ),

                array(
                    'id' => 'submit',
                    'type' => 'submit',
                    'label'=>'Save'

                ),

            )
        );
        echo $this->form_builder->close_form();?>
    </div>
</div>
<h3>Issues linked to this proposed action</h3>
<table class="table table-striped table-bordered table-hover" style="border: 2px solid #ddd" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>&nbsp;</th>

        <th>Issue</th>


    </tr>
    </thead>
    <tbody>
    <?php foreach ($issues as $i): ?>

        <tr>
            <td><a class="btn btn-primary" href="Issues/editIssue/<?=$i['id']?>">View/Edit</a></td>
            <td><?=$i['proposed_action']?></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th>&nbsp;</th>

        <th>Issue</th>
    </tr>
    </tfoot>
</table>


<script type="text/javascript">
    $(".chosen-select").chosen();


    $('input[name=submit]').after('<a style="margin-left:10px" class="btn btn-primary" href="<?php echo site_url('ProposedAction'); ?>">Back</a>');


    $(document).ready(function() {

        $('.table').DataTable({
            "order": [[1, "desc"]],
            "columnDefs": [
                { "width": "10%", "targets": 0 }
            ]

        });

    });
</script>