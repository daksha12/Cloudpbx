    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Migration_Trunk_master extends CI_Migration {
            public function up()
            { 
                $this->dbforge->add_field(array(
                    'id' => array(
                            'type' => 'INT',
                            'null' => FALSE,
                            'auto_increment'=>TRUE,
                            'constraint' => 20,
                    ),
                    'trunk_name' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                            'null' => FALSE,
                    ),
                    'tenant_id' => array(
                            'type' => 'INT',
                            'constraint' => 20,
                            'null' => FALSE,
                    ),
                    'site_id' => array(
                            'type' => 'INT',
                            'constraint' => 20,
                            'null' => FALSE,
                    ),
                    'username' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 30,
                            'null' => FALSE,
                    ),
                    'password' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 255,
                            'null' => FALSE,
                    ),
                    'host' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                            'null' => FALSE,
                    ),
                    'port' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 20,
                            'null' => FALSE,
                    ),
                    'domain' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 100,
                            'null' => FALSE,
                    ),
                    'dtmf_mode' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 20,
                            'null' => FALSE,
                    ),
                    'nat' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 20,
                            'null' => FALSE,
                    ),
                    'directrtp' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 20,
                            'null' => FALSE,
                    ),
                    'trunk_did' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                            'null' => FALSE,
                    ),
                    'register_trunk' => array(
                            'type' => 'ENUM("Y","N")',
                            'null' => FALSE,
                    ),
                    'created_at' => array(
                            'type' => 'TIMESTAMP',
                            'null' => TRUE,
                    ),
                    'created_by' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                            'null' => TRUE,
                    ),
                    'updated_at' => array(
                            'type' => 'TIMESTAMP',
                            'null' => TRUE,
                    ),
                    'updated_by' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                            'null' => TRUE,
                    ),
                    'deleted_at' => array(
                            'type' => 'TIMESTAMP',
                            'null' => TRUE,
                    ),
                    'deleted_by' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                            'null' => TRUE,
                    ),
                )); 
                $this->dbforge->add_key('id',TRUE);
                $this->dbforge->create_table('trunk_master');           
            }
            
            public function down()
            {
              $this->dbforge->drop_table('trunk_master');
            }
    }

