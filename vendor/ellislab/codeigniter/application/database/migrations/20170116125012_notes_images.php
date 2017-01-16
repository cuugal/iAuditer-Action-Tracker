<?php

class Migration_notes_images extends CI_Migration {

    public function up()
    {
        $fields = array(
            'notes' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            )
        );
        $this->dbforge->add_column('action_register', $fields);


        $this->dbforge->add_field(array(
            'id'=>array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'ar_id'=>array(
                'type' => 'VARCHAR',
                'constraint' => '50',
            ),
            'key' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'label' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'media_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'href' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
        ));

        $this->dbforge->create_table('media');

    }
    public function down() {
        $this->dbforge->drop_column('action_register', 'notes');
    }

}