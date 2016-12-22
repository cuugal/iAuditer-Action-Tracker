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
            'iAuditor_Name'=>array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
            )
        );
        $this->dbforge->add_column('users', $fields);

        $data = array(
            'id' => '2',
            'ip_address' => '127.0.0.1',
            'username' => 'dlj',
            'password' => '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36',
            'salt' => '',
            'email' => 'dlj@admin.com',
            'activation_code' => '',
            'forgotten_password_code' => NULL,
            'created_on' => '1268889823',
            'last_login' => '1268889823',
            'active' => '1',
            'first_name' => 'David',
            'last_name' => 'Lloyd-Jones',
            'company' => 'ADMIN',
            'phone' => '0',
            'iAuditor_Name' => 'David Lloyd-Jones',
            'faculty_unit' => 'PMO.office;HRU.floor '
        );
        $this->db->insert('users', $data);

        $data = array(
            array(
                'id' => '3',
                'user_id' => '2',
                'group_id' => '1',
            ),
            array(
                'id' => '4',
                'user_id' => '2',
                'group_id' => '2',
            )
        );
        $this->db->insert_batch('users_groups', $data);


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
                'default'=>'Open'
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