<?php

class Migration_issue_action extends CI_Migration {

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
                'auto_increment' => TRUE
            ),
            'action' => array(
                'type' => 'varchar',
                'constraint' => 255,
                'auto_increment' => TRUE
            )

        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('issue_action');
    }

    public function down() {
        $this->dbforge->drop_table('issue_action');
    }

}