<div class="row">
    <div class="">
    <h2>Details</h2>


<?= $this->form_builder->open_form(array('action' => ''));
echo $this->form_builder->build_form_horizontal(
    array(
        array(
            'id' => 'audit_pk',
            'label' => 'Inspection ID',
            'value' => $dataSet['audit_pk'],
            'readonly' => 'readonly',
        ),
        array(
            'id' => 'id',
            'label' => 'Hazard ID',
            'value' => $dataSet['id'],
            'readonly' => 'readonly',
        ),
        array(
            'id' => 'created_at',
            'label' => 'Date Identified',
            'value' => date("d/m/Y", strtotime($dataSet['created_at'])) ,
            'readonly' => 'readonly',
        ),
        array(
            'id' => 'source',
            'label' => 'Source',
            'value' => $dataSet['source'],
            'readonly' => 'readonly',
        ),
        array(
            'id' => 'aoa',
            'label' => 'Area of Accountability',
            'value' => $dataSet['area_of_accountability'],
            'readonly' => 'readonly',
        ),
        array(
            'id' => 'inspector_name',
            'label' => 'Inspector Name',
            'value' => $dataSet['inspector_name'],
            'readonly' => 'readonly',
        ),
        array(
            'id' => 'location',
            'label' => 'Location',
            'value' => $dataSet['location'],
            'readonly' => 'readonly',
        ),
    )
);
echo $this->form_builder->close_form();
?>

</div>
    </div>
<div class="row">
    <div class="">
        <h2>Hazard</h2>


<?= $this->form_builder->open_form(array('action' => ''));
echo $this->form_builder->build_form_horizontal(
    array(
        array(
            'id' => 'type_of_hazard',
            'label' => 'Type of Hazard',
            'value' => $dataSet['type_of_hazard'],
            'readonly' => 'readonly',
        ),
        array(
            'id' => 'issue',
            'type'=>'textarea',
            'label' => 'Issue',
            'value' => $dataSet['issue'].' - NO',
            'readonly' => 'readonly',
        ),
        array(
            'id' => 'notes',
            'label' => 'Notes',
            'value' => $dataSet['notes'],
            'readonly' => 'readonly',
        ),
        /*
        array(
            'id' => 'initial_risk',
            'label' => 'Initial Risk',
            'value' => $dataSet['initial_risk'],
            'readonly' => 'readonly',
        ),
        */
    )
);
echo $this->form_builder->close_form();
?>
    </div>
</div>


<?php if(isset($media) && count($media) > 0):?>

<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="4000" style="background-color:grey">
    <!-- Indicators -->
    <ol class="carousel-indicators">

        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <?php for ($i = 1; $i < count($media); $i++) : ?>
            <li data-target="#myCarousel" data-slide-to="<?=$i;?>"></li>
        <?php endfor;?>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <?php
        $firstRun = true;
        foreach($media as $m): ?>
        <div class="item <?=($firstRun)?'active':'';?>">
            <img src="<?=base_url();?>tmp/<?=$m;?>" alt="<?=$m;?>">
        </div>
            <?php $firstRun = false; ?>
        <?php endforeach;?>


    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<?php endif;?>

<div class="row">
    <div class="">
        <h2>Action Plan</h2>
        <?php
        if (isset($_SESSION['ar_message'])) : ?>
        <div class="alert alert-success"><?=$_SESSION['ar_message'];?>
            </div>
        <?php endif; ?>

       <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>



        <?= $this->form_builder->open_form(array('action' => '', 'id'=>'mainform'));
        echo $this->form_builder->build_form_horizontal(
            array(
                array(/* HIDDEN */
                    'id' => 'key',
                    'type' => 'hidden',
                    'value' => $dataSet['key']
                ),
                array(
                    'id' => 'id',
                    'type' => 'hidden',
                    'value' => $dataSet['id'],
                ),
                array(
                    'id' => 'proposed_action',
                    'label' => 'Proposed Action',
                    'class' => 'required',
                    'value' => $dataSet['proposed_action'],
                    'readonly' => 'readonly',

                ),
                array(/* RADIO */
                    'id' => 'action_required',

                    'label' => 'Action Required',
                    'type' => 'radio',
                    'req'=>true,
                    'value' => $dataSet['action_required'],
                    'options' => array(
                        array(
                            'id' => 'radio_button_yes',
                            'class'=>'action_required',
                            'value' => 'Yes',
                            'label' => 'Yes',
                            'checked' => ($dataSet['action_required'] == 'Yes'|| !isset($dataSet['action_required'])) ? true: false,
                            ($isOpen) ? '':  'disabled'=>'disabled',
                        ),
                        array(
                            'id' => 'radio_button_no',
                            'class'=>'action_required',
                            'value' => 'No',
                            'label' => 'No',
                            'checked' => $dataSet['action_required'] == 'No' ? true: false,
                            ($isOpen) ? '':  'disabled'=>'disabled',
                        ),
                        array(
                            'id' => 'radio_button_out',
                            'class'=>'action_required',
                            'value' => 'Outside Supervisor\'s Control',
                            'label' => 'Outside Supervisor\'s Control',
                            'checked' => $dataSet['action_required'] == 'Outside Supervisor\'s Control' ? true: false,
                            ($isOpen) ? '':  'disabled'=>'disabled',
                        ),

                    )
                ),
                array(
                    'id' => 'reviewed_action',
                    'label' => 'Reviewed Action',
                    'value' => $dataSet['reviewed_action'],
                    'req'=>true,
                    'help' => "Action Status will update to 'In Progress' once a Reviewed Action is proposed.",
                    ($isOpen) ? '':  'disabled'=>'disabled',

                ),
                array(/* RADIO */
                    'id' => 'residual_risk',
                    'label' => 'Residual Risk',
                    'type' => 'radio',
                    'req'=>true,

                    'options' => array(
                        array(
                            'id' => 'radio_button_high',
                            'value' => 'High',
                            'label' => 'High',
                            'checked' => $dataSet['residual_risk'] == 'High' ? true: false,
                            ($isOpen) ? '':  'readonly' => 'readonly',
                        ),
                        array(
                            'id' => 'radio_button_medium',
                            'value' => 'Medium',
                            'label' => 'Medium',
                            'checked' => $dataSet['residual_risk'] == 'Medium' ? true: false,
                            ($isOpen) ? '':  'readonly' => 'readonly',
                        ),
                        array(
                            'id' => 'radio_button_low',
                            'value' => 'Low',
                            'label' => 'Low',
                            'checked' => $dataSet['residual_risk'] == 'Low' ? true: false,
                            ($isOpen) ? '':  'readonly' => 'readonly',
                            'class'=>'priority',
                        ),

                    )
                ),
                array(/* RADIO */
                    'id' => 'action_status',
                    'label' => 'Action Status',
                    'type' => 'radio',
                    (!$isAccountable) ? '':'req'=>true,
                    'options' => array(
                        array(
                            'id' => 'radio_button_open',
                            'value' => 'Open',
                            'label' => 'Open',
                            'checked' => $dataSet['action_status'] == 'Open' ? true: false,
                            ($isAccountable) ? '':  'readonly' => 'readonly',
                        ),
                        array(
                            'id' => 'radio_button_progress',
                            'value' => 'In Progress',
                            'label' => 'In Progress',
                            'checked' => $dataSet['action_status'] == 'In Progress' ? true: false,
                            ($isAccountable) ? '':  'readonly' => 'readonly',
                        ),
                        array(
                            'id' => 'radio_button_closed',
                            'value' => 'Closed',
                            'label' => 'Closed',
                            'checked' => $dataSet['action_status'] == 'Closed' ? true: false,
                            ($isAccountable) ? '':  'readonly' => 'readonly',
                        ),

                    )
                ),
                array(
                    'id' => 'completion_date',
                    'label' => 'Completion Due Date',
                    'data-provide'=>'datepicker',
                    'data-date-format'=>"dd/mm/yyyy",
                    'value' => (isset($dataSet['completion_date']) ? date("d/m/Y", strtotime($dataSet['completion_date'])) : date("d/m/Y")) ,
                    ($isAccountable && $isOpen) ? '' :  'disabled'=>'disabled',
                ),
                array(
                    'id' => 'action_closed_date',
                    'label' => 'Action Closed On',
                    'data-provide'=>'datepicker',
                    'data-date-format'=>"dd/mm/yyyy",
                    'value' => (isset($dataSet['action_closed_date']) ? date("d/m/Y", strtotime($dataSet['action_closed_date'])): date("d/m/Y")) ,
                    'disabled'=>true,
                    'help' => 'Action Closed date defaults to the completion date if the status is in progress, and the date closed if the status is closed.',
                ),
                array(/* SUBMIT */
                    'id' => 'submit',
                    'label' => 'Save',
                    'type' => 'submit'
                )
            )

        );
        echo $this->form_builder->close_form();

        ?>
    </div>
    <script type="text/javascript">
        $(':radio[readonly]:not(:checked)').attr('disabled', true);


            $('.action_required').click(function() {
                if (this.value == 'Yes'){
                    $('#reviewed_action').prop('readonly', false);
                }
                else{
                    $('#reviewed_action').prop('readonly', true);
                }
            });

        $( document ).ready(function() {


            if ($('[name="action_required"]:checked').val() == 'Yes'){

                $('#reviewed_action').prop('readonly', false);
            }
            else{
                $('#reviewed_action').prop('readonly', true);
            }

            //insert hep text as the 'help' doesn't work with Radios
            $( "<span class='help-block' style='clear:both'>Residual risk is risk level after the issue has been fixed.</span>" ).insertAfter($(".priority").closest(".radio-inline") );
        });
    </script>


</div>
<style type="text/css">
    .img-responsive, .thumbnail > img, .thumbnail a > img, .carousel-inner > .item > img, .carousel-inner > .item > a > img {
        display: inline !important;
</style>

