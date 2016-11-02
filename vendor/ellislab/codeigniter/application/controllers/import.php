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


        $url = 'https://api.safetyculture.io/audits/search?field=audit_id&field=modified_at&field=template_id';
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

        #header('Content-Type: application/json');
        echo json_encode($result);
    }



}