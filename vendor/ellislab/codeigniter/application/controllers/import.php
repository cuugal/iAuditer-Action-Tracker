<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->_init();
    }

    private function _init()
    {
        $this->output->set_template('default');
    }
    public function process(){
        $url = 'https://api.safetyculture.io/audits/search?field=audit_id&field=modified_at&field=template_id';
        $client = new Guzzle\Http\Client();
        $client->setDefaultOption('headers', [
            'Authorization' => 'Bearer d00508d44e39a51fcefa604b9540d03f02f9b9fef8a25ca84f782f61956b96f5',
        ]);
        $request = $client->get($url);
        $res = $request->send();

        $data = array(
            'response' => $res->getBody(),
        );

        $this->load->view('dashboard/data_view', $data);

    }
}