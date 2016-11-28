<?php

class Migration_aoa_rp extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'aoa' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'rp' => array(
                'type' => 'INT',
                'constraint' => 11,
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('aoa_rp');
    }

    public function down() {
        $this->dbforge->drop_table('aoa_rp');
    }

}