<?php

class Migration_email_field extends CI_Migration {

    public function up() {

        $fields = array(
            'email'=>array(
                'type' => 'TEXT',
                'null' => true,
            )
        );
        $this->dbforge->add_column('audits', $fields);
    }

    public function down() {
        $this->dbforge->drop_column('audits', 'mail_sent');
    }

}