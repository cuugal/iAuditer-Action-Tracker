<?php

class Migration_tasks extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'task_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'user'=>array(
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'key' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
            ),
            'status'=>array(
                'type' => 'TINYINT',
                'constraint' => '8',
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'action_register'=>array(
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'audit'=>array(
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => TRUE,
                'null' => TRUE,
            ),

            'completion_date'=>array(
                'type' => 'DATETIME',
                'constraint' => 10,
                'null' => TRUE,
            ),



        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('tasks');
    }

    public function down() {
        $this->dbforge->drop_table('tasks');
    }

}