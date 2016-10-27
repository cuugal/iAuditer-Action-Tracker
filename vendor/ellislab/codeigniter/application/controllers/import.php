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

    }
    public function process(){
    /*
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
*/
        $data = array('nothing'=>'spam');
        $this->output->set_template('default');
        $this->load->view('dashboard/data_view', $data);

    }

    public function getData(){
        $url = 'https://api.safetyculture.io/audits/search?field=audit_id&field=modified_at&field=template_id';
        $client = new Guzzle\Http\Client();
        $client->setDefaultOption('headers', [
            'Authorization' => 'Bearer d00508d44e39a51fcefa604b9540d03f02f9b9fef8a25ca84f782f61956b96f5',
        ]);
        $request = $client->get($url);
        $res = $request->send();

        $data = json_decode($res->getBody(), true);

        foreach($data['audits'] as &$audit){
            //Get rid of this blasted ISO8601 format
            $d = new DateTime($audit['modified_at']);
            //$audit['modified_at'] = $d->format('D M d Y H:i:s');
            $audit['modified_at'] = $d->format('Y-m-d H:i:s');
        }

        $this->db->insert_batch('audits', $data['audits']);
        header('Content-Type: application/json');
        echo json_encode($data['audits']);
    }

    public function tester(){
        header('Content-Type: application/json');
        echo json_encode(Date("2015-11-05T02:13:04.576Z"));
    }

}