<?php

class Migration_orgunit extends CI_Migration {

    public function up() {
        $fields = array(
            'OrgUnit'=>array(
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => TRUE,
            )
        );
        $this->dbforge->add_column('audits', $fields);
        $this->dbforge->add_column('area_of_accountability', $fields);


        //Update and force recalculate within AOA table
        $query = $this->db->get('area_of_accountability');
        $results = $query->result_array();

        $this->load->model('areaofaccountability_model');
        foreach ($results as $res){
            $this->areaofaccountability_model->update($res);
        }
    }

    public function down() {
        $this->dbforge->drop_column('audits', 'OrgUnit');
        $this->dbforge->drop_column('area_of_accountability', 'OrgUnit');
    }

}