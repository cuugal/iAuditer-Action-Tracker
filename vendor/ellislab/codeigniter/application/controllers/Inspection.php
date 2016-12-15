<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inspection extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->output->set_template('default');
        $this->load->model('audits_model');
        $this->load->model('templates_model');
    }

    function tester(){

        $data = array('message'=>json_encode($this->audits_model->getMostRecentDate()));
        $this->load->view('inspection/request_view', $data);
    }

    public function index()
    {
        //$this->load->section('sidebar', 'ci_simplicity/sidebar');
        // Load new edits since the previous last modified date
        $mostRecent = $this->audits_model->getMostRecentTime();
        //print "MOST RECENT".$mostRecent;
        //print "MOST RECENT".$mostRecent."fiftenn".strtotime("-15 minutes");
        if($mostRecent && $mostRecent < strtotime("-15 minutes")) {
            print "RELOADING";
            //get templates to build map
            $templates = $this->templates_model->getTemplates();

            // create map
            foreach ($templates as $template) {
                $map[$template['template_id']] = $template['name'];
            }
            $mostRecentISODate = $this->audits_model->getMostRecentDate();
            $this->audits_model->loadAudits($map, $mostRecentISODate);
            //$this->audits_model->loadAudits($map, $mostRecent);
        }
        //If here, it means we've not yet done the initial load
        else if(!$mostRecent){
            // Get templates
            $url = 'https://api.safetyculture.io/templates/search?field=template_id&field=name';
            $client = new Guzzle\Http\Client();
            $client->setDefaultOption('headers', array(
                'Authorization' => 'Bearer d00508d44e39a51fcefa604b9540d03f02f9b9fef8a25ca84f782f61956b96f5',
            ));
            $request = $client->get($url);
            $res = $request->send();

            $data = json_decode($res->getBody(), true);

            $result['templates'] = $this->templates_model->upsertBatch($data['templates']);

            $templates = $this->templates_model->getTemplates();

            // create map
            foreach ($templates as $template) {
                $map[$template['template_id']] = $template['name'];
            }

            $this->audits_model->loadAudits($map, null);
        }
        $data = array('dataSet'=>json_encode($this->audits_model->getAudits()));
        $this->load->view('inspection/index_view', $data);
    }

    public function request($audit_id, $request_id = NULL){

        //$this->output->enable_profiler(TRUE);
        if($request_id == NULL) {
            //Request Audit
            $url = 'https://api.safetyculture.io/audits/' . $audit_id . '/export?format=pdf&timezone=Australia/Sydney';
            $client = new Guzzle\Http\Client();
            $client->setDefaultOption('headers', array(
                'Authorization' => 'Bearer d00508d44e39a51fcefa604b9540d03f02f9b9fef8a25ca84f782f61956b96f5',
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
                'Authorization' => 'Bearer d00508d44e39a51fcefa604b9540d03f02f9b9fef8a25ca84f782f61956b96f5',
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
                    'Authorization' => 'Bearer d00508d44e39a51fcefa604b9540d03f02f9b9fef8a25ca84f782f61956b96f5',
                ));
                $request = $client->get($url);

                $request->setResponseBody(APPPATH.'../tmp/'.$audit_id.'.pdf');
                $res = $request->send();

                $this->load->view('inspection/audit_view', $data);
            }
        }
    }
}