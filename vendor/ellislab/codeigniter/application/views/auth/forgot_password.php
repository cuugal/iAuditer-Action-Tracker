<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">

        <h1>Forgot Password</h1>
        <h4>Please enter in your email address to receive a password reset link.</h4>
        <?php
        echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;
        ?>
        <div id="infoMessage"><?php echo $message; ?></div>
        <?php echo form_open("auth/forgot_password", "class='form-horizontal col-sm-12'"); ?>

        <div class="form-group">
            <div class="col-sm-3 control-label">
                <label
                    for="identity"><?php echo(($type == 'email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label)); ?></label>
                <br/>
            </div>
            <div class="col-sm-8">
                <?php echo form_input($identity,'','class="form-control"'); ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-3 control-label">
                &nbsp;
            </div>
            <div class="col-sm-8">
                <?php echo form_submit('submit', lang('forgot_password_submit_btn'), "class='btn btn-primary'"); ?>
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>

