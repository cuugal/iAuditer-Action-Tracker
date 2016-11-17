<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="row">
    <div class="col-md-12 col-lg-8">
    <h1>Register</h1>
    <?php
    echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;
    ?>

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
            'id' => 'username'
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
