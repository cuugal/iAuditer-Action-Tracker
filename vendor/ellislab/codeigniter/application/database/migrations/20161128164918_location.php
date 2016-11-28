<?php

class Migration_location extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'area_of_accountability' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'name' => array(
                'type' => 'varchar',
                'constraint' => 255,
                'auto_increment' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('location');
    }

    public function down() {
        $this->dbforge->drop_table('location');
    }

}