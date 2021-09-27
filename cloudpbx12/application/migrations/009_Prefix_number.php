    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Migration_Prefix_number extends CI_Migration {
            public function up()
            { 
                $this->dbforge->add_field(array(
                    'id' => array(
                            'type' => 'INT',
                            'null' => FALSE,
                            'auto_increment'=>TRUE,
                            'constraint' => 20,
                    ),
                    'name' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 100,
                            'null' => FALSE,
                    ),
                    'prefix' => array(
                            'type' => 'INT',
                            'constraint' => 20,
                            'null' => FALSE,
                    ),
                )); 
                $this->dbforge->add_key('id',TRUE);
                $this->dbforge->create_table('prefix_number');           
            
                $query = "INSERT INTO `prefix_number` (`id`, `name`, `prefix`) VALUES (1, 'softphone_prefix', 6),(2, 'mobile_prefix', 7),(3, 'desktop_prefix', 8);";      
                $this->db->query($query);  
            }
            
            public function down()
            {
              $this->dbforge->drop_table('prefix_number');
            }
    }

