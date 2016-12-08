<?php

class Migration_issues extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'issue' => array(
                'type' => 'varchar',
                'constraint' => 255,
            ),
            'proposed_action' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('issues');
    }

    public function down() {
        $this->dbforge->drop_table('issues');
    }

}