<?php defined('BASEPATH') OR exit('No direct script access allowed');?>


<div class="row">
    <div class="col-md-12 col-lg-12">
        <h1>Edit Issue</h1>

        <?php if (isset($_SESSION['is_message'])) : ?>
            <div class="alert alert-success"><?=$_SESSION['is_message'];?>
            </div>
        <?php endif; ?>

        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

        <?= $this->form_builder->open_form(array('action' => ''));
        echo $this->form_builder->build_form_horizontal(
            array(
                array('id'=>'id',
                    'type'=>'hidden',
                    'value'=>$issue['id']

                ),
                array(
                    'id' => 'issue',
                    'value'=>$issue['issue'],
                    'readonly' => 'readonly',

                ),
                array(
                    'id' => 'proposed_action',
                    'type'=>'dropdown',
                    'options' => $actions,
                    'class'=>"chosen-select",
                    'value'=>$issue['proposed_action'],

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



<script type="text/javascript">
    $(".chosen-select").chosen();


    $('input[name=submit]').after('<a style="margin-left:10px" class="btn btn-primary" href="/Issue">Back</a>');


    $(document).ready(function() {

        $('.table').DataTable({
            "order": [[1, "desc"]],
            "columnDefs": [
                { "width": "10%", "targets": 0 }
            ]

        });

    });
</script>