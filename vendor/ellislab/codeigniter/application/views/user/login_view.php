<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="row">
    <div class="col-md-12">
        <h1>Log In to UTS Inspection Action Tracker</h1>
        <?php
        echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;
        ?>
        <?= $this->form_builder->open_form(array('action' => ''));
        echo $this->form_builder->build_form_horizontal(
            array(
                array(
                    'id' => 'email'
                ),
                array(
                    'id' => 'password',
                    'type' => 'password',
                ),
                array(
                    'id' => 'remember',
                    'type' => 'checkbox',
                    'options' => array(
                        array(

                            'label' => 'Remember Me',
                            'value'=>TRUE,

                        ),
                    ),
                ),
                array(
                    'id' => 'submit',
                    'label' => 'Log In',
                    'type' => 'submit'
                )

            ));
?>
        <div class="form-group">

            <div class="col-sm-12">
				<p> NOTE: This is not your UTS password</p>
                <a style="text-decoration: underline !important" href="<?php echo site_url('auth/forgot_password'); ?>">Forgot your password?</a><br/>
                <a style="text-decoration: underline !important" href="<?php echo site_url('User/register'); ?>">Create an account</a>
            </div>
        </div>
</div>
    </div>