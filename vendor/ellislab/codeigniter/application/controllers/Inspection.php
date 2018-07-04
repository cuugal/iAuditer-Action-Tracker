<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;

class Inspection extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->output->set_template('default');
        $this->load->model('audits_model');
        $this->load->model('templates_model');
        $this->load->model('actionregister_model');
    }

    function tester(){
        $this->output->enable_profiler(TRUE);
        echo json_encode($this->actionregister_model->getOutstandingMap());

    }

    public function index()
    {
        //$this->load->section('sidebar', 'ci_simplicity/sidebar');
        // Load new edits since the previous last modified date
        $mostRecent = $this->audits_model->getMostRecentTime();

        if($mostRecent && $mostRecent < strtotime("-15 minutes")) {
            print "RELOADING";
            //get templates to build map
            $templates = $this->templates_model->getTemplates();
            $map = array();
            // create map
            foreach ($templates as $template) {
                $map[$template['template_id']] = $template['name'];
            }
            $mostRecentISODate = $this->audits_model->getMostRecentDate();
            $this->audits_model->loadAudits($map, $mostRecentISODate);

        }
        //If here, it means we've not yet done the initial load
        else if(!$mostRecent){
            // Get templates
            $url = $this->config->item('template_url');
            $client = new Guzzle\Http\Client();
            $client->setDefaultOption('headers', array(
                'Authorization' => $this->config->item('authorisation'),
            ));
            $request = $client->get($url);
            $res = $request->send();

            $data = json_decode($res->getBody(), true);

            $result['templates'] = $this->templates_model->upsertBatch($data['templates']);

            $templates = $this->templates_model->getTemplates();
            $map = array();
            // create map
            foreach ($templates as $template) {
                $map[$template['template_id']] = $template['name'];
            }

            $this->audits_model->loadAudits($map, null);
        }

        if($this->ion_auth->is_admin()){
            $data = array('dataSet' => json_encode($this->audits_model->getAudits()));
        }
        else {
            $data = array('dataSet' => json_encode($this->audits_model->getAudits($this->ion_auth->get_user_id())));
        }


        $this->load->view('inspection/index_view', $data);
    }

    public function getActionItems($audit_id, $debug=false){
        ini_set('display_errors',true);
        $this->output->unset_template();
        $res = $this->audits_model->getAudits(false, $audit_id);
        $results['audit'] = $res[0];
        $results['inspections'] = $this->actionregister_model->getForAudit($audit_id);
        $this->load->view('inspection/actions_view', $results);

        //Uncomment this return statement if you want to have a look at the
        //html behind the report (in case you want to change layout etc)
        if($debug) {
            return;
        }


        $filename = 'WHS Inspection Action Report '.$results['audit']['id'];


        $html = $this->output->get_output();

        //return;
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream($filename ,array('Attachment'=>0));

    }

    public function request($audit_id, $request_id = NULL){

        //$this->output->enable_profiler(TRUE);
        if($request_id == NULL) {
            //Request Audit
            $url = 'https://api.safetyculture.io/audits/' . $audit_id . '/export?format=pdf&timezone=Australia/Sydney';
            $client = new Guzzle\Http\Client();
            $client->setDefaultOption('headers', array(
                'Authorization' => $this->config->item('authorisation'),
            ));
            $request = $client->post($url);
            $res = $request->send();

            $data = json_decode($res->getBody(), true);

            $data = array('audit_id'=>$audit_id, 'request_id'=>$data['id']);

            $this->load->view('inspection/request_view', $data);
        }
        else{
            //Check on audit
            $url = 'https://api.safetyculture.io/audits/'.$audit_id.'/exports/'.$request_id;
            $client = new Guzzle\Http\Client();
            $client->setDefaultOption('headers', array(
                'Authorization' => $this->config->item('authorisation'),
            ));
            $request = $client->get($url);
            $res = $request->send();

            $response = json_decode($res->getBody(), true);

            $data = array('audit_id'=>$audit_id, 'request_id'=>$request_id, 'status'=>$response['status']);
            if(isset($response['error'])){
                $data['error'] = $response['error'];
            }
            if(isset($response['message'])){
                $data['message'] = $response['message'];
            }

            if(isset($response['statusCode'])){
                $data['statusCode'] = $response['statusCode'];
            }
            if($response['status'] == 'IN PROGRESS' || $response['status'] == 'FAILED'){
                $this->load->view('inspection/request_view', $data);
            }
            else{
                $url = $response['href'];

                $client = new Guzzle\Http\Client();
                $client->setDefaultOption('headers', array(
                    'Authorization' => $this->config->item('authorisation'),
                ));
                $request = $client->get($url);

                $request->setResponseBody(APPPATH.'../tmp/'.$audit_id.'.pdf');
                $res = $request->send();

                $this->load->view('inspection/audit_view', $data);
            }
        }
    }
}