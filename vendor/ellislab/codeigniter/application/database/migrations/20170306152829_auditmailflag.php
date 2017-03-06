<?php

class Migration_auditmailflag extends CI_Migration {

    public function up() {
        $fields = array(
            'mail_sent'=>array(
                'type' => 'TINYINT',
                'null' => false,
                'default'=>0
            )
        );
        $this->dbforge->add_column('audits', $fields);
    }

    public function down() {

    }

}