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
        $mostRecent = $this->audits_model->getMostRecentDate();

        //get templates to build map
        $templates = $this->templates_model->getTemplates();

        // create map
        foreach($templates as $template){
            $map[$template['template_id']] = $template['name'];
        }

        $url = 'https://api.safetyculture.io/audits/search?field=audit_id&field=modified_at&field=template_id&modified_after='.$mostRecent;
        $client = new Guzzle\Http\Client();
        $client->setDefaultOption('headers', [
            'Authorization' => 'Bearer d00508d44e39a51fcefa604b9540d03f02f9b9fef8a25ca84f782f61956b96f5',
        ]);
        $request = $client->get($url);
        $res = $request->send();

        $data = json_decode($res->getBody(), true);

        foreach($data['audits'] as &$audit){

            //initialise values because insert_batch hates it when you don't initialise values.
            $audit['inspection_type'] = '';
            $audit['location'] = '';
            $audit['modified_at'] = '';
            $audit['created_at'] = '';
            $audit['description'] = '';
            $audit['location'] = '';
            $audit['inspector_name'] = '';
            $audit['area_of_accountability'] = '';

            if(isset($map[$audit['template_id']])) {
                $audit['inspection_type'] = $map[$audit['template_id']];
                $audit['template_archived'] = false;
            }
            else{
                $audit['inspection_type'] = '';
                $audit['template_archived'] = true;
            }

            //backfill with data from individual calls, as required
            // (at this stage, only where the template isn't archived
            if(isset($map[$audit['template_id']])) {
                $url = 'https://api.safetyculture.io/audits/' . $audit['audit_id'];
                $client = new Guzzle\Http\Client();
                $client->setDefaultOption('headers', [
                    'Authorization' => 'Bearer d00508d44e39a51fcefa604b9540d03f02f9b9fef8a25ca84f782f61956b96f5',
                ]);
                $request = $client->get($url);
                $res = $request->send();

                //created at
                $audit_data = json_decode($res->getBody(), true);

                //Get rid of this blasted ISO8601 format
                $d = new DateTime($audit_data['created_at']);
                $audit['created_at'] = $d->format('Y-m-d H:i:s');

                $d = new DateTime($audit_data['modified_at']);
                $audit['modified_at'] = $d->format('Y-m-d H:i:s');

                $audit['description'] = $audit_data['template_data']['metadata']['description'];
                //Location
                foreach ($audit_data['header_items'] as $header_item) {
                    if (strpos($header_item['label'], 'Location') !== false) {
                        if (isset($header_item['responses']['text'])) {
                            $audit['location'] = $header_item['responses']['text'];
                        }
                    }

                    if (strpos($header_item['label'], 'Area to be Inspected') !== false) {
                        $area = '';
                        if (isset($header_item['responses']['selected'])) {
                            foreach ($header_item['responses']['selected'] as $item) {
                                $area .= $item['label'] . " ";
                            }
                        }
                        $audit['area_of_accountability'] = $area;
                    }

                }

                //Inspector
                if (isset($audit_data['audit_data']['authorship']['author'])) {
                    $audit['inspector_name'] = $audit_data['audit_data']['authorship']['author'];
                }


            }

        }


        $result['audits'] = $this->audits_model->upsertBatch($data['audits']);



        $data = array('dataSet'=>json_encode($this->audits_model->getAudits()));
        $this->load->view('inspection/index_view', $data);
    }

    public function request($audit_id, $request_id = NULL){

        //$this->output->enable_profiler(TRUE);
        if($request_id == NULL) {
            //Request Audit
            $url = 'https://api.safetyculture.io/audits/' . $audit_id . '/export?format=pdf&timezone=Australia/Sydney';
            $client = new Guzzle\Http\Client();
            $client->setDefaultOption('headers', [
                'Authorization' => 'Bearer d00508d44e39a51fcefa604b9540d03f02f9b9fef8a25ca84f782f61956b96f5',
            ]);
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
            $client->setDefaultOption('headers', [
                'Authorization' => 'Bearer d00508d44e39a51fcefa604b9540d03f02f9b9fef8a25ca84f782f61956b96f5',
            ]);
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
                $client->setDefaultOption('headers', [
                    'Authorization' => 'Bearer d00508d44e39a51fcefa604b9540d03f02f9b9fef8a25ca84f782f61956b96f5',
                ]);
                $request = $client->get($url);

                $request->setResponseBody(APPPATH.'../tmp/'.$audit_id.'.pdf');
                $res = $request->send();

                $this->load->view('inspection/audit_view', $data);
            }
        }
    }
}