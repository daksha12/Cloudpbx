    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Migration_Umc_Details extends CI_Migration {
            public function up()
            { 
                $this->dbforge->add_field(array(
                    'id' => array(
                            'type' => 'INT',
                            'null' => FALSE,
                            'auto_increment'=>TRUE,
                            'constraint' => 20,
                    ),
                    'umc_site_name' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 100,
                            'null' => FALSE,
                    ),
                    'umc_ip' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                            'null' => FALSE,
                    ),
                    'umc_port' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 20,
                            'null' => FALSE,
                    ),
                )); 
                $this->dbforge->add_key('id',TRUE);
                $this->dbforge->create_table('umc_details');           
            
                $query = "INSERT INTO `umc_details` (`id`,`umc_site_name` ,`umc_ip`, `umc_port`) VALUES ('1', 'bizrtcumc', '49.50.70.68','8443');";      
                $this->db->query($query);  
            }
            
            public function down()
            {
              $this->dbforge->drop_table('umc_details');
            }
    }

