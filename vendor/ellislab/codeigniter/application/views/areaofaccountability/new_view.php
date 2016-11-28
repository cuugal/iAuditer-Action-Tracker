<?php defined('BASEPATH') OR exit('No direct script access allowed');?>


    <div class="row">
    <div class="col-md-12 col-lg-12">
    <h1>New Area of Accountability</h1>

<?php if (isset($_SESSION['aa_message'])) : ?>
    <div class="alert alert-success"><?=$_SESSION['aa_message'];?>
    </div>
<?php endif; ?>

<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

<?= $this->form_builder->open_form(array('action' => ''));
echo $this->form_builder->build_form_horizontal(
    array(
        array(
            'id' => 'name',
            ),
        array(
            'id' => 'accountable_person',
            'type'=>'dropdown',
            'options' => $users,
            'class'=>"chosen-select"

        ),
        array(
            'id' => 'submit',
            'type' => 'submit',
            'label'=>'Save'

        )
    )
);
echo $this->form_builder->close_form();?>
    </div>
    </div>

<script type="text/javascript">
    $(".chosen-select").chosen();
</script>