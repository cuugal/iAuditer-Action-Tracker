<?php

class Migration_area_of_accountability extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'accountable_person' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'name' => array(
                'type' => 'varchar',
                'constraint' => 255,
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('area_of_accountability');
    }

    public function down() {
        $this->dbforge->drop_table('area_of_accountability');
    }

}