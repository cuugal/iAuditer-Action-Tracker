<?php

class Migration_templates extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'template_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
            ),
        ));
        $this->dbforge->add_key('template_id', TRUE);
        $this->dbforge->create_table('templates');
    }

    public function down() {
        $this->dbforge->drop_table('templates');
    }

}