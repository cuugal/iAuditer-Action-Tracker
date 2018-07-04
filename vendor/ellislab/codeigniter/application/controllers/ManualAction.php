<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManualAction extends Auth_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->output->set_template('default');
        $this->load->model('location_model');
        $this->load->model('areaofaccountability_model');
        $this->load->model('audits_model');
    }

    function index(){

        $this->load->library('form_builder');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('area_of_accountability', 'Area of Accountability','trim|required');
        $this->form_validation->set_rules('inspection_type', 'Inspection Type','trim|required');
        $this->form_validation->set_rules('inspector_name', 'Inspector Name','trim|required');
        $this->form_validation->set_rules('created_at', 'Created At','trim|required');
        $this->form_validation->set_rules('location', 'Location','trim|required');

        if($this->form_validation->run()===FALSE)
        {
            //$data = Array('aoa'=>$this->location_model->getAoa());
            $data = Array();
            $data['aoa'] = $this->areaofaccountability_model->getAOAPicklist();
            $data['types'] = $this->audits_model->getManualInspectionTypesPicklist();
            $data['hazards'] = $this->audits_model->getHazardsPicklist();
            $data['inspector_name'] = $this->ion_auth->user()->row()->first_name.' '.$this->ion_auth->user()->row()->last_name;
            $this->load->view("manualaction/index_view.php", $data);
        }
        else
        {
            $audit = $this->input->post();
            $action_items = $audit['items'];
            unset($audit['items']);
            unset($audit['submit']);

            $audit['audit_id'] = uniqid();
            $audit['template_id'] = uniqid();

            $audit['created_at'] = str_replace('/', '-', $audit['created_at']);
            $audit['created_at'] = date("Y-m-d H:i:s", strtotime($audit['created_at']));

            $audit['modified_at'] =  $audit['created_at'];
            $audit['name'] = $audit['inspection_type'];

            $audit['email'] = $this->ion_auth->user()->row()->email;

            $tmp = explode('.', $audit['area_of_accountability']);
            $audit['OrgUnit'] = $tmp[0];

            $auditsbatch = Array();
            $auditsbatch[] = $audit;

            try {

                $audit_result = $this->audits_model->upsertBatch($auditsbatch);
                echo json_encode($audit_result);

                $action_items = json_decode($action_items, True);

                echo json_encode($action_items);

                if(count($action_items) > 0) {
                    foreach ($action_items as &$item) {
                        $item['audit_id'] = $audit['audit_id'];
                        $item['item_id'] = uniqid();
                        $item['key'] = $item['audit_id'].$item['item_id'];
                        $item['response'] = 'No';
                    }

                    $action_registers = $this->actionregister_model->upsertBatch($action_items);
                    echo json_encode($action_registers);
                }

                $_SESSION['ma_message'] = 'The Manual Action Entry has been created';
                $this->session->mark_as_flash('ma_message');

            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }

            $data = Array();
            $data['aoa'] = $this->areaofaccountability_model->getAOAPicklist();
            $data['types'] = $this->audits_model->getManualInspectionTypesPicklist();
            $data['hazards'] = $this->audits_model->getHazardsPicklist();
            $data['inspector_name'] = $this->ion_auth->user()->row()->first_name.' '.$this->ion_auth->user()->row()->last_name;
            $this->load->view("manualaction/index_view.php", $data);
        }

    }
}