<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="row">
    <div class="col-md-12 col-lg-8">
        <h1>Log In</h1>
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

</div>
    </div>