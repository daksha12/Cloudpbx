<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Migration_Page_setting_modify extends CI_Migration {
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
                    'pageparameter' => array(
                            'type' => 'TEXT',                            
                    ),            
                    'created_at' => array(
                            'type'    => 'TIMESTAMP', 
                            'null'=>FALSE,
                            'default' => date('Y-m-d H:i:s'),
                    ),
                    'created_by' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'updated_at' => array(
                            'type'    => 'TIMESTAMP',
                            'null'=>FALSE,
                            'default' => date('Y-m-d H:i:s'),
                    ),
                    'updated_by' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'deleted_at' => array(
                            'type'    => 'TIMESTAMP',
                            'null'=>FALSE,
                            'default' => date('Y-m-d H:i:s'),
                    ),
                    'deleted_by' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                )); 
                $this->dbforge->add_key('id',TRUE);
                // $this->dbforge->create_table('page_setting');  
                $this->db->query("ALTER TABLE `page_setting` CHANGE `updated_at` `updated_at` TIMESTAMP NULL;");
                $this->db->query("ALTER TABLE `page_setting` CHANGE `updated_at` `updated_at` TIMESTAMP NULL;");      
                $this->db->query('ALTER TABLE `page_setting` CHANGE `deleted_at` `deleted_at` TIMESTAMP NULL;');         
            }
            
            public function down()
            {
              $this->dbforge->drop_table('page_setting');
            }
    }

