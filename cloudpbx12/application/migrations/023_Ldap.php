    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Migration_Ldap extends CI_Migration {
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
                    'ip_address' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'ldap_name' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'port' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'username' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'password' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'base_domain' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 100,
                    ),
                    'on_filter' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'datetime' => array(
                            'type'    => 'TIMESTAMP',
                            'null'=>FALSE,
                            'default' => date('Y-m-d H:i:s'),
                    ),
                )); 
                $this->dbforge->add_key('id',TRUE);
                $this->dbforge->create_table('ldap_config');           
            }
            
            public function down()
            {
              $this->dbforge->drop_table('ldap_config');
            }
    }

