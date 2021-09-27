    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Migration_Crm_config extends CI_Migration {
            public function up()
            { 
     
               if(!$this->db->table_exists('crm_config'))
               { 
     
                $this->dbforge->add_field(array(
                    'id' => array(
                            'type' => 'INT',
                            'null' => FALSE,
                            'auto_increment'=>TRUE,
                            'constraint' => 20,
                    ),
                    'crm_ip' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                            'null' => FALSE,
                    ),
                    'account_code' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 30,
                            'null' => FALSE,
                    ),
                    'tenant_name' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                            'null' => FALSE,
                    ),
                    'token_number' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 100,
                            'null' => FALSE,
                    ),
                    'date' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                            'null' => FALSE,
                    ),
                )); 
                $this->dbforge->add_key('id',TRUE);
                $this->dbforge->create_table('crm_config');           
              }       
            }
            
            public function down()
            {
              $this->dbforge->drop_table('crm_config');
            }
    }

