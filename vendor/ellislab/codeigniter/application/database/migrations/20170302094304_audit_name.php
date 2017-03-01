<?php

class Migration_audit_name extends CI_Migration {

    public function up() {
        $fields = array(
            'name' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            )
        );
        $this->dbforge->add_column('audits', $fields);

    }

    public function down() {

    }

}