<?php defined('BASEPATH') OR exit('No direct script access allowed');?>


<div class="row">
    <div class="col-md-12 col-lg-8">
        <h1>Edit User</h1>
        <?php if (isset($_SESSION['edit_message'])) : ?>
        <div class="alert alert-success"><?=$_SESSION['edit_message'];?>
        </div>
        <?php endif; ?>

        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

        <?= $this->form_builder->open_form(array('action' => ''));
        echo $this->form_builder->build_form_horizontal(
            array(
                array(
                    'id' => 'id',
                    'value' => $dataSet['user_id'],
                    'type' => 'hidden'
                ),
                array(
                    'id' => 'first_name',
                    'value' => $dataSet['first_name'],
                ),
                array(
                    'id' => 'last_name',
                    'value' => $dataSet['last_name'],
                ),
                array(
                    'id' => 'username',
                    'value' => $dataSet['username'],
                ),
                array(
                    'id' => 'email',
                    'value' => $dataSet['email'],
                ),

                array(
                    'id' => 'submit',
                    'type' => 'submit',
                    'label'=>'Save'

                )
            )
        );
        echo $this->form_builder->close_form();
        ?>
    </div>
    </div>

<div class="row">
    <div class="col-md-12 col-lg-8">

    <h3>Change Password</h3>
<?= $this->form_builder->open_form(array('action' => 'user/changepassword'));
    echo $this->form_builder->build_form_horizontal(
        array(
            array(
                'id' => 'id',
                'value' => $dataSet['user_id'],
                'type' => 'hidden'
            ),
            array(
            'id' => 'password',
            'type' => 'password',
            ),
            array(
            'id' => 'confirm_password',
            'type' => 'password',

            ),
            array(
                'id' => 'submit',
                'type' => 'submit',
                'label'=>'Change Password'

            )
        ));
echo $this->form_builder->close_form();
?>
</div>
</div>

