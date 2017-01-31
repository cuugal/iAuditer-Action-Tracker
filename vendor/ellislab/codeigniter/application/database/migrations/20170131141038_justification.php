<?php

class Migration_justification extends CI_Migration {

    public function up() {
        $fields = array(
            'justification'=>array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
            )
        );
        $this->dbforge->add_column('action_register', $fields);



    }

    public function down() {
        $this->dbforge->drop_column('action_register', 'justification');
    }

}