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
            $audit['modified_at'] = $d->format('Y-m-d H:i:s');
            if(isset($map[$audit['template_id']])) {
                $audit['inspection_type'] = $map[$audit['template_id']];
            }
            else{
                $audit['inspection_type'] = '(template archived)';
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
                $d = new DateTime($audit_data['created_at']);
                $audit['created_at'] = $d->format('Y-m-d H:i:s');

                //Location
                foreach ($audit_data['header_items'] as $header_item) {
                    if ($header_item['label'] == 'Location') {
                        $audit['location'] = $header_item['responses']['location_text'];
                    }
                }


                //Inspector
                $audit['inspector_name'] = $audit_data['audit_data']['authorship']['author'];
            }

        }
        $result['audits'] = $this->audits_model->upsertBatch($data['audits']);




        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function tester1(){
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

        echo json_encode($this->audits_model->tester($data['audits']));
    }

    public function tester(){
        header('Content-Type: application/json');
        echo json_encode(Date("2015-11-05T02:13:04.576Z"));
    }

}