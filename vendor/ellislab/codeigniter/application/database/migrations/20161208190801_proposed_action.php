<?php

class Migration_proposed_action extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'proposed_action' => array(
                'type' => 'varchar',
                'constraint' => 255,
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('proposed_action');
    }

    public function down() {
        $this->dbforge->drop_table('proposed_action');
    }

}