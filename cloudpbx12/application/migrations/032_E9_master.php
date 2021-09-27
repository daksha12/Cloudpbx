    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Migration_E9_master extends CI_Migration {
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
                    'trunk_did' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'emergencyenable' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'emergencynumber' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 100,
                    ),
                    'address1' => array(
                            'type' => 'TEXT',
                    ),
                    'address2' => array(
                            'type' => 'TEXT',
                    ),
                    'city' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'state' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'pincode' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
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
                $this->db->query('ALTER TABLE `e911_master` CHANGE `created_at` `created_at` TIMESTAMP NULL');
                $this->db->query('ALTER TABLE `e911_master` CHANGE `updated_at` `updated_at` TIMESTAMP NULL');            
                $this->db->query('ALTER TABLE `e911_master` CHANGE `deleted_at` `deleted_at` TIMESTAMP null');
            }
            
            public function down()
            {
              $this->dbforge->drop_table('e911_master');
            }
    }

