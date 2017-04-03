<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import extends Auth_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('audits_model');
        $this->load->model('templates_model');

    }



    public function reloadIssues(){
        //$this->output->enable_profiler(TRUE);

        $result = $this->audits_model->loadIssues();

        echo json_encode($result);
    }

    public function getData(){
        $this->output->enable_profiler(TRUE);

        // Get templates
        $url = 'https://api.safetyculture.io/templates/search?field=template_id&field=name';
        $client = new Guzzle\Http\Client();
        $client->setDefaultOption('headers', array(
            'Authorization' => $this->config->item('authorisation'),
        ));
        $request = $client->get($url);
        $res = $request->send();

        $data = json_decode($res->getBody(), true);

        $result['templates'] = $this->templates_model->upsertBatch($data['templates']);

        // create map
        foreach($data['templates'] as $template){
            $map[$template['template_id']] = $template['name'];
        }

        // The rest is in the model
        $result2 = $this->audits_model->loadAudits($map, null);
        $result = array_merge($result, $result2);

        #header('Content-Type: application/json');
        echo json_encode($result);
    }



}