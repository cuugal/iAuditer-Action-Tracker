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
        <div class="item myCarouselImg <?=($firstRun)?'active':'';?>">
            <img class="myCarouselImg" src="<?=base_url();?>tmp/<?=$m;?>" alt="<?=$m;?>">
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
                array(
                    'id' => 'justification',
                    'label' => 'Justification',
                    'value' => $dataSet['justification'],
                    'req'=>true,
                    ($isOpen) ? '':  'disabled'=>'disabled',

                ),
                array(/* RADIO */
                    'id' => 'residual_risk',
                    'label' => 'Priority',
                    'type' => 'radio',
                    'req'=>true,

                    'options' => array(
                        array(

                            'class'=>'residual_risk riskhigh',
                            'value' => 'High',
                            'label' => 'High',
                            'checked' => $dataSet['residual_risk'] == 'High' ? true: false,
                            ($isOpen) ? '':  'readonly' => 'readonly',
                        ),
                        array(

                            'class'=>'residual_risk riskmed',
                            'value' => 'Medium',
                            'label' => 'Medium',
                            'checked' => $dataSet['residual_risk'] == 'Medium' ? true: false,
                            ($isOpen) ? '':  'readonly' => 'readonly',
                        ),
                        array(

                            'class'=>'residual_risk risklow',
                            'value' => 'Low',
                            'label' => 'Low',
                            'checked' => $dataSet['residual_risk'] == 'Low' ? true: false,
                            ($isOpen) ? '':  'readonly' => 'readonly',
                        ),
                        array(

                            'class'=>'residual_risk priority riskna',
                            'value' => 'N/A',
                            'label' => 'N/A',
                            'checked' => $dataSet['residual_risk'] == 'N/A' ? true: false,
                            ($isOpen) ? '':  'readonly' => 'readonly',
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
                            'class' => 'statusopen',
                            'value' => 'Open',
                            'label' => 'Open',
                            'checked' => $dataSet['action_status'] == 'Open' ? true: false,
                            ($isAccountable) ? '':  'readonly' => 'readonly',
                        ),
                        array(
                            'class' => 'statusprog',
                            'value' => 'In Progress',
                            'label' => 'In Progress',
                            'checked' => $dataSet['action_status'] == 'In Progress' ? true: false,
                            ($isAccountable) ? '':  'readonly' => 'readonly',
                        ),
                        array(
                            'class' => 'statusclosed',
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

                    'value' => (isset($dataSet['completion_date']) &&  $dataSet['completion_date'] != '' ? date("d/m/Y", strtotime($dataSet['completion_date'])) : date("d/m/Y")) ,
                    ($isAccountable && $isOpen) ? '' :  'disabled'=>'disabled',
                ),
                array(
                    'id' => 'action_closed_date',
                    'label' => 'Action Closed On',
                    'data-provide'=>'datepicker',
                    'data-date-format'=>"dd/mm/yyyy",
                    //'value' => (isset($dataSet['action_closed_date']) ? date("d/m/Y", strtotime($dataSet['action_closed_date'])): date("d/m/Y")) ,
                    'value' => (isset($dataSet['action_closed_date']) && $dataSet['action_closed_date'] != '' ? date("d/m/Y", strtotime($dataSet['action_closed_date'])): '') ,
                    'disabled'=>true,
                    //'help' => 'Action Closed date defaults to the completion date if the status is in progress, and the date closed if the status is closed.',
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


        //Sets the default date to the correct timestamp
        $('.residual_risk').click(function() {
            //console.log(this.value);
            var today = new Date();


            if (this.value == 'High'){
                var new_date = moment(today).add(1, 'days').format('DD/MM/YYYY');
                $('#completion_date').val(new_date);
            }
            else if(this.value == 'Medium'){
                var new_date = moment(today).add(1, 'week').format('DD/MM/YYYY');
                $('#completion_date').val(new_date);
            }
            else if(this.value == 'Low'){
                var new_date = moment(today).add(1, 'month').format('DD/MM/YYYY');
                $('#completion_date').val(new_date);
            }
            else{
                $('#completion_date').val('');
            }
        });


        //add disabled attribute to readonly radio fields (cant be done with form builder)
        $(':radio[readonly]:not(:checked)').attr('disabled', true);


        //if action is required, then make reviewed action editable
        //alter presentation of 'justification' field

        $('.action_required').click(function() {
            if (this.value == 'Yes'){
                $('#reviewed_action').prop('readonly', false);
                $('#justification').prop('readonly', true);
                $('#justification').val('');
                // Priority
                $('.riskna').prop('disabled', true);
                $('.risklow').prop('disabled', false);
                $('.riskmed').prop('disabled', false);
                $('.riskhigh').prop('disabled', false);
                //set the value so it makes sense
                $("input[name=residual_risk][value='N/A']").prop('checked', false);

                //Status
                $('.statusopen').prop('disabled', false);
                $('.statusprog').prop('disabled', false);
                //set the value so it makes sense
                $("input[name=action_status][value='Closed']").prop('checked', false);

                //completion date as per spec
                $('#completion_date').prop('readonly', false);
            }
            else{
                $('#reviewed_action').prop('readonly', true);
                $('#reviewed_action').val('');
                $('#justification').prop('readonly', false);

                //Priority
                $('.riskna').prop('disabled', false);
                $('.risklow').prop('disabled', true);
                $('.riskmed').prop('disabled', true);
                $('.riskhigh').prop('disabled', true);
                //set the value so it makes sense
                $("input[name=residual_risk][value='N/A']").prop('checked', true);


                //Status
                $('.statusopen').prop('disabled', true);
                $('.statusprog').prop('disabled', true);
                //set the value so it makes sense
                $("input[name=action_status][value='Closed']").prop('checked', true);

                //Don't need completion date as per spec
                $('#completion_date').prop('readonly', true);
            }
        });


        $( document ).ready(function() {

            //if action is requied on form load, update values accordingly
            if ($('[name="action_required"]:checked').val() == 'Yes'){

                $('#reviewed_action').prop('readonly', false);
                $('#justification').prop('readonly', true);
                // Priority
                $('.riskna').prop('disabled', true);
                $('.risklow').prop('disabled', false);
                $('.riskmed').prop('disabled', false);
                $('.riskhigh').prop('disabled', false);


                //Status
                $('.statusopen').prop('disabled', false);
                $('.statusprog').prop('disabled', false);

                //completion date as per spec
                $('#completion_date').prop('readonly', false);
            }
            else{
                $('#reviewed_action').prop('readonly', true);
                $('#justification').prop('readonly', false);
                // Priority
                $('.riskna').prop('disabled', false);
                $('.risklow').prop('disabled', true);
                $('.riskmed').prop('disabled', true);
                $('.riskhigh').prop('disabled', true);


                //Status
                $('.statusopen').prop('disabled', true);
                $('.statusprog').prop('disabled', true);

                //Dont' need completion date as per spec
                $('#completion_date').prop('readonly', true);
            }

            //insert help text as the 'help' doesn't work with Radios
            $( "<span class='help-block' style='clear:both'>Priority is risk level after the issue has been fixed.</span>" ).insertAfter($(".priority").closest(".radio-inline") );



        });
    </script>


</div>
<style type="text/css">
    .img-responsive, .thumbnail > img, .thumbnail a > img, .carousel-inner > .item > img, .carousel-inner > .item > a > img {
        display: inline !important;
    }
    .myCarouselImg img {
        width: auto !important;
        height: 325px !important;
        max-height: 325px !important;
    }
</style>

