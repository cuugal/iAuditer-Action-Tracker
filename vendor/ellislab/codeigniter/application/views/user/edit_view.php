<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<?php if($this->ion_auth->is_admin()===FALSE): ?>
<div class="row">
    <div class="col-lg-12">
        <h1>User Profile</h1>


        <table class="table table-striped table-bordered table-hover" style="border: 2px solid #ddd" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th width="250px"></th>

                <th>&nbsp;</th>

            </tr>
            </thead>
            <tbody>


            <tr>
                <td><b>Accountable Areas:</b></td>
                <td><?=implode(',', $aoa);?></td>
            </tr>
            <tr>
                <td><b>Responsible Areas:</b></td>
                <td><?=implode(',', $rp);?></td>
            </tr>
            </tbody>

        </table>

    </div>
</div>

<?php endif; ?>

<div class="row">
    <div class="col-lg-12">
        <h1>Edit User</h1>
        <?php if (isset($_SESSION['edit_message'])) : ?>
        <div class="alert alert-success"><?=$_SESSION['edit_message'];?>
        </div>
        <?php endif; ?>

        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

        <?= $this->form_builder->open_form(array('action' => '/User/edit/'.$dataSet['user_id']));

         $form_items = array(
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
                    'id' => 'iAuditor_Name',
                    'value' => $dataSet['iAuditor_Name'],
                    'help' => 'The user\'s name as it appears in the iAuditor system.  Used for matching to inspector name in audits' ,
                ),

                array(
                    'id' => 'email',
                    'value' => $dataSet['email'],
                ),
        );
        if ($this->ion_auth->is_admin()) {
            $form_items[] = array(
                'id' => 'group',
                'type' => 'dropdown',
                'options' => $groups,
                'value' => $dataSet['group_id'],
            );
        }
        else{
            $form_items[] = array(
                'id' => 'group',
                'value' => $dataSet['group_id'],
                'type' => 'hidden'
            );
        }
        $form_items[] = array(
            'id' => 'submit',
            'type' => 'submit',
            'label' => 'Save'

        );
        echo $this->form_builder->build_form_horizontal($form_items);
        echo $this->form_builder->close_form();
        ?>
    </div>
    </div>

<div class="row">
    <div class="col-lg-12">

    <h3>Change Password</h3>
<?= $this->form_builder->open_form(array('action' => 'User/changepassword/'.$dataSet['user_id']));
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

