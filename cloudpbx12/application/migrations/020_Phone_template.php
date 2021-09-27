    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Migration_Phone_template extends CI_Migration {
            public function up()
            { 
                $this->dbforge->add_field(array(
                    'id' => array(
                            'type' => 'INT',
                            'null' => FALSE,
                            'auto_increment'=>TRUE,
                            'constraint' => 20,
                    ),
                    'company' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'model' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'tenant_id' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 30,
                    ),
                    'username' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'auth_username' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'password' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 30,
                    ),
                    'domain1' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 100,
                    ),
                    'proxy1' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 100,
                    ),
                    'port1' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 30,
                    ),
                    'domain2' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 100,
                    ),
                    'proxy2' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 100,
                    ),
                    'port2' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 30,
                    ),
                    'mac' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 30,
                    ),
                    'ldap_ip_address' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'ldap_name' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'ldap_port' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'ldap_username' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'ldap_password' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'ldap_base_domain' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 100,
                    ),
                    'ldap_on_filter' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
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
                $this->dbforge->create_table('phone_template');           
            }
            
            public function down()
            {
              $this->dbforge->drop_table('phone_template');
            }
    }

