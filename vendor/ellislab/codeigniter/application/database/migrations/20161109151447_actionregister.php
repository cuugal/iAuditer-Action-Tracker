<?php

class Migration_actionregister extends CI_Migration {

    public function up() {

        $fields = array(
            'faculty_unit'=>array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
            )
        );
        $this->dbforge->add_column('users', $fields);



        $fields = array(
            'action_required'=>array(
                'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => TRUE,
                ),
            'reviewed_action'=>array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
            ),
            'residual_risk'=>array(
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => TRUE,
            ),
            'action_status'=>array(
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => TRUE,
            ),
            'completion_date'=>array(
                'type' => 'DATETIME',
                'constraint' => 10,
                'null' => TRUE,
            ),

        );
        $this->dbforge->add_column('audits', $fields);
    }

    public function down() {
        //$this->dbforge->drop_table('actionregister');
        $this->dbforge->drop_column('table_name', 'column_to_drop');
    }

}