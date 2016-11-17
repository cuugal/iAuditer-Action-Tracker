<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('audits_model');
        $this->load->model('templates_model');
        $this->_init();
    }

    private function _init()
    {

    }
    public function process(){

        $data = array('nothing'=>'spam');
        $this->output->set_template('default');
        $this->load->view('dashboard/data_view', $data);

    }

    public function getData(){
        $this->output->enable_profiler(TRUE);

        // Get templates
        $url = 'https://api.safetyculture.io/templates/search?field=template_id&field=name';
        $client = new Guzzle\Http\Client();
        $client->setDefaultOption('headers', [
            'Authorization' => 'Bearer d00508d44e39a51fcefa604b9540d03f02f9b9fef8a25ca84f782f61956b96f5',
        ]);
        $request = $client->get($url);
        $res = $request->send();

        $data = json_decode($res->getBody(), true);

        $result['templates'] = $this->templates_model->upsertBatch($data['templates']);

        // create map
        foreach($data['templates'] as $template){
            $map[$template['template_id']] = $template['name'];
        }

        // The rest is in the model
        $result = $this->audits_model->loadAudits($map, null);


        #header('Content-Type: application/json');
        echo json_encode($result);
    }



}