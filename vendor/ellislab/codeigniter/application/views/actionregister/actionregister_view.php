
<div class="row">
    <div class="">
    <h2>Details</h2>
    <?php
    echo isset($_SESSION['ar_message']) ? $_SESSION['ar_message'] : FALSE;
    ?>

<?= $this->form_builder->open_form(array('action' => ''));
echo $this->form_builder->build_form_horizontal(
    array(
        array(
            'id' => 'audit_id',
            'label' => 'Inspection ID',
            'value' => $dataSet['audit_id'],
            'readonly' => 'readonly',
        ),
        array(
            'id' => 'item_id',
            'label' => 'Hazard ID',
            'value' => $dataSet['item_id'],
            'readonly' => 'readonly',
        ),
        array(
            'id' => 'created_at',
            'label' => 'Date Identified',
            'type' => 'date',
            'value' => $dataSet['created_at'],
            'readonly' => 'readonly',
        ),
        array(
            'id' => 'source',
            'label' => 'Source',
            'value' => $dataSet['source'],
            'readonly' => 'readonly',
        ),
        array(
            'id' => 'org',
            'label' => 'Org Unit',
            'value' => '',
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
        <?php
        echo isset($_SESSION['ar_message']) ? $_SESSION['ar_message'] : FALSE;
        ?>

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
            'label' => 'Issue',
            'value' => $dataSet['issue'],
            'readonly' => 'readonly',
        ),
        array(
            'id' => 'initial_risk',
            'label' => 'Initial Risk',
            'value' => $dataSet['initial_risk'],
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
        <h2>Action Plan</h2>
        <?php
        echo isset($_SESSION['ar_message']) ? $_SESSION['ar_message'] : FALSE;
        ?>

        <?= $this->form_builder->open_form(array('action' => ''));
        echo $this->form_builder->build_form_horizontal(
            array(
                array(
                    'id' => 'proposed_action',
                    'label' => 'Proposed Action',
                    'value' => $dataSet['proposed_action'],
                ),
                array(/* RADIO */
                    'id' => 'action_required',
                    'label' => 'Action Required',
                    'type' => 'radio',
                    'options' => array(
                        array(
                            'id' => 'radio_button_yes',
                            'value' => '',
                            'label' => 'Yes'
                        ),
                        array(
                            'id' => 'radio_button_no',
                            'value' => '',
                            'label' => 'No'
                        ),
                        array(
                            'id' => 'radio_button_out',
                            'value' => '',
                            'label' => 'Outside Supervisors Control'
                        ),

                    )
                ),
                array(
                    'id' => 'reviewed_action',
                    'label' => 'Reviewed Action',
                    'value' => $dataSet['reviewed_action'],
                ),
                array(/* RADIO */
                    'id' => 'residual_risk',
                    'label' => 'Residual Risk',
                    'type' => 'radio',
                    'options' => array(
                        array(
                            'id' => 'radio_button_high',
                            'value' => '',
                            'label' => 'High'
                        ),
                        array(
                            'id' => 'radio_button_medium',
                            'value' => '',
                            'label' => 'Medium'
                        ),
                        array(
                            'id' => 'radio_button_low',
                            'value' => '',
                            'label' => 'Low'
                        ),

                    )
                ),
                array(/* RADIO */
                    'id' => 'action_status',
                    'label' => 'Action Status',
                    'type' => 'radio',
                    'options' => array(
                        array(
                            'id' => 'radio_button_open',
                            'value' => '',
                            'label' => 'Open'
                        ),
                        array(
                            'id' => 'radio_button_progress',
                            'value' => '',
                            'label' => 'In Progress'
                        ),
                        array(
                            'id' => 'radio_button_closed',
                            'value' => '',
                            'label' => 'Closed'
                        ),

                    )
                ),
                array(
                    'id' => 'completion_date',
                    'label' => 'Completion Date',
                    'type' => 'date',
                    'value' => $dataSet['completion_date'],
                ),
            )
        );
        echo $this->form_builder->close_form();
        ?>
    </div>
</div>
