<?php

class Migration_audits extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'audit_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
            ),
            'template_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '50',
            ),

            'modified_at' => array(
                'type' => 'DATETIME',
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            'inspection_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
            ),
            'description' => array(
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => TRUE,
            ),
            'location' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
            ),
            'inspector_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
            ),
            'area_of_accountability' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
            ),
            'risk_overview' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
            ),
            'area_of_accountability' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
            ),
            'number_of_outstanding_actions' => array(
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'number_of_actions_in_progress' => array(
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'template_archived' => array(
                'type' => 'BOOL',
                'unsigned' => TRUE,
                'default' => FALSE,
                'null' => TRUE,
            ),




        ));
        $this->dbforge->add_key('audit_id', TRUE);
        $this->dbforge->create_table('audits');
    }

    public function down() {
        $this->dbforge->drop_table('audits');
    }

}