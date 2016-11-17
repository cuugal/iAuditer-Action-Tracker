<?php

class Migration_actionregister extends CI_Migration {

    public function up() {

        $fields = array(
            'faculty_unit'=>array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
            )
        );
        $this->dbforge->add_column('users', $fields);



        $fields = array(
            'key' => array(
                'type' => 'VARCHAR',
                'constraint' => '80',
            ),
            'item_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '40',
            ),
            'user'=>array(
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'audit_id'=>array(
                'type' => 'VARCHAR',
                'constraint' => '50',
            ),
            'source'=>array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
            ),
            'type_of_hazard'=>array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
            ),
            'proposed_action'=>array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
            ),
            'initial_risk'=>array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
            ),
            'issue'=>array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
            ),
            'response'=>array(
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE,
            ),

            'action_required'=>array(
                'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => TRUE,
                ),
            'reviewed_action'=>array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
            ),

            'residual_risk'=>array(
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => TRUE,
            ),
            'action_status'=>array(
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => TRUE,
            ),
            'completion_date'=>array(
                'type' => 'DATETIME',
                'constraint' => 10,
                'null' => TRUE,
            ),

        );
        $this->dbforge->add_field($fields);

        $this->dbforge->add_key('key');
        $this->dbforge->create_table('action_register');
    }

    public function down() {
        //$this->dbforge->drop_table('actionregister');
        $this->dbforge->drop_column('users', 'faculty_unit');
        $this->dbforge->drop_table('action_register');
    }

}