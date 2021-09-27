<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Migration_Prefix_number_old extends CI_Migration {
            public function up()
            { 
               if(!$this->db->table_exists('prefix_number_old'))
               { 
                $this->dbforge->add_field(array(
                    'id' => array(
                            'type' => 'INT',
                            'null' => FALSE,
                            'auto_increment'=>TRUE,
                            'constraint' => 20,
                    ),
                    'softphone_prefix' => array(
                            'type' => 'INT',
                            'constraint' => 20,
                            'null' => FALSE,
                    ),
                    'mobile_prefix' => array(
                            'type' => 'INT',
                            'constraint' => 20,
                            'null' => FALSE,
                    ),
                    'desktop_prefix' => array(
                            'type' => 'INT',
                            'constraint' => 20,
                            'null' => FALSE,
                    ),
                )); 
                $this->dbforge->add_key('id',TRUE);
                $this->dbforge->create_table('prefix_number_old');           
                                             
                $query = "INSERT INTO `prefix_number_old` (`id`,`softphone_prefix`,`mobile_prefix`, `desktop_prefix`) VALUES (1,6,7,8);";      
                $this->db->query($query);  
              }
            }
            
            public function down()
            {
              $this->dbforge->drop_table('prefix_number_old');
            } 
    }

?>