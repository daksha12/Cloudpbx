    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Migration_Assign_rate_card extends CI_Migration {
            public function up()
            { 
                $this->dbforge->add_field(array(
                    'id' => array(
                            'type' => 'INT', 
                            'null' => FALSE,
                            'auto_increment'=>TRUE,
                            'constraint' => 20,
                    ),
                    'account_id' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 30,
                    ),
                    'account_code' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 20,
                    ),
                    'rate_card' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),                            
                    'create_date' => array(
                            'type'    => 'TIMESTAMP', 
                            'null'=>FALSE,
                            'default' => date('Y-m-d H:i:s'),
                    ),
                    'create_by' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),                    
                )); 
                $this->dbforge->add_key('id',TRUE);
                $this->dbforge->create_table('assign_rate_card');           
            }
            
            public function down()
            {
              $this->dbforge->drop_table('assign_rate_card');
            }
    }

