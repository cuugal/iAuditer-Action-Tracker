<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="row">
    <div class="col-md-12 col-lg-8">
    <h1>Register</h1>

	<p>When you submit this form with a valid UTS email you will be sent an Activation Email. </br>Click on the link in this email to activate your account.</p>

        <?php if (isset($_SESSION['register_message'])) : ?>
            <div class="alert alert-success"><?=$_SESSION['register_message'];?>
            </div>
        <?php endif; ?>

        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>


    <?= $this->form_builder->open_form(array('action' => ''));
    echo $this->form_builder->build_form_horizontal(
    array(
        array(
            'id' => 'first_name'
        ),
        array(
            'id' => 'last_name'
        ),

        array(
            'id' => 'iAuditor_Name',
            'help' => 'The user\'s name as it appears in the iAuditor system.  Used for matching to inspector name in audits' ,

        ),

        array(
            'id' => 'email'
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
            'type' => 'submit'
        )
    )
    );

    ?>
    </div>
</div>

