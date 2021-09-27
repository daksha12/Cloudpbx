    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Migration_Phone_provisioning extends CI_Migration {
            public function up()
            { 
                $this->dbforge->add_field(array(
                    'id' => array(
                            'type' => 'INT',
                            'null' => FALSE,
                            'auto_increment'=>TRUE,
                            'constraint' => 20,
                    ),
                    'tenant_id' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'site_id' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'phone_company' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 30,
                    ),
                    'model' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'extension' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'phone_ip' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 30,
                    ),
                    'mac' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 30,
                    ),
                    'domain1' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'proxy1' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'port1' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 30,
                    ),
                    'domain2' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'proxy2' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'port2' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 30,
                    ),
                    'file_name' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 100,
                    ),
                    'datetime' => array(
                            'type'    => 'TIMESTAMP',
                            'null'=>FALSE,
                            'default' => date('Y-m-d H:i:s'),
                    ),
                )); 
                $this->dbforge->add_key('id',TRUE);
                $this->dbforge->create_table('phone_provisioning');           
            }
            
            public function down()
            {
              $this->dbforge->drop_table('phone_provisioning');
            }
    }

