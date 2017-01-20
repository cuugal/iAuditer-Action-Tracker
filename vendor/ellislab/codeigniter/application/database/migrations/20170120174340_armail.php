<?php

class Migration_armail extends CI_Migration {

    public function up() {
        $fields = array(
            'mail_sent'=>array(
                'type' => 'TINYINT',
                'null' => false,
                'default'=>0
            )
        );
        $this->dbforge->add_column('action_register', $fields);

        $fields = array(
            'task_created'=>array(
                'type' => 'DATE',
                'null' => true,
            )
        );
        $this->dbforge->add_column('tasks', $fields);
    }

    public function down() {
        $this->dbforge->drop_column('action_register', 'mail_sent');
        $this->dbforge->drop_column('tasks', 'task_created');
    }

}