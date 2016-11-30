<?php defined('BASEPATH') OR exit('No direct script access allowed');?>


<div class="row">
    <div class="col-md-12 col-lg-12">
        <h1>Edit Location</h1>

        <?php if (isset($_SESSION['ln_message'])) : ?>
            <div class="alert alert-success"><?=$_SESSION['ln_message'];?>
            </div>
        <?php endif; ?>

        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

        <?= $this->form_builder->open_form(array('action' => ''));
        echo $this->form_builder->build_form_horizontal(
            array(
                array('id'=>'id',
                    'type'=>'hidden',
                    'value'=>$i['id']

                ),
                array(
                    'id' => 'name',
                    'value'=>$i['name'],
                    'readonly' => 'readonly',
                ),
                array(
                    'id' => 'area_of_accountability',
                    'type'=>'dropdown',
                    'options' => $aoa,
                    'class'=>"chosen-select",
                    'value'=>$i['area_of_accountability'],

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


    $('input[name=submit]').after('<a style="margin-left:10px" class="btn btn-primary" href="/location">Back</a>');
</script>