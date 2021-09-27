    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Migration_Update_col extends CI_Migration {
            public function up()
            { 
            
                if (!$this->db->field_exists('prefix', 'trunk_master'))
                {
                $prefix = array('prefix' => array(
                'type' => 'VARCHAR',
                'null'=>TRUE,
                'constraint' => 20,
                ),
                );
                $this->dbforge->add_column('trunk_master', $prefix);
                }

                 if (!$this->db->field_exists('failover', 'trunk_master'))
                {
                $failover = array('failover' => array(
                'type' => 'VARCHAR',
                'null'=>TRUE,
                'constraint' => 100,
                ),
                );
                $this->dbforge->add_column('trunk_master', $failover);
                }

                 if (!$this->db->field_exists('ringduration', 'trunk_master'))
                {
                $ringduration = array('ringduration' => array(
                'type' => 'VARCHAR',
                'null'=>TRUE,
                'constraint' => 50,
                ),
                );
                $this->dbforge->add_column('trunk_master', $ringduration);
                }

                 if (!$this->db->field_exists('cpe_ip', 'trunk_master'))
                {
                $cpe_ip = array('cpe_ip' => array(
                'type' => 'VARCHAR',
                'null'=>TRUE,
                'constraint' => 100,
                ),
                );
                $this->dbforge->add_column('trunk_master', $cpe_ip);
                }
                
                if (!$this->db->field_exists('d2e', 'trunk_master'))
                {
                $d2e = array('d2e' => array(
                'type' => 'VARCHAR',
                'null'=>TRUE,
                'constraint' => 20,
                ),
                );
                $this->dbforge->add_column('trunk_master', $d2e);
                }


                //// UPDATE EXTENSION AND SITE TABLE ////
                $this->db->select('*');
                $this->db->from('login_details');
                $query = $this->db->get();
                $result = $query->result();
                foreach ($result as $key => $value) {
                
                $site_table = $value->tenant_name.'_site';
                $ext_table  = $value->tenant_name.'_extensions';


                if (!$this->db->field_exists('off_start', $site_table))
                {
                $off_start = array('off_start' => array(
                'type' => 'VARCHAR',
                'null'=>TRUE,
                'constraint' => 30,
                ),
                );
                $this->dbforge->add_column($site_table, $off_start);
                }

                if (!$this->db->field_exists('off_end', $site_table))
                {
                $off_end = array('off_end' => array(
                'type' => 'VARCHAR',
                'null'=>TRUE,
                'constraint' => 30,
                ),
                );
                $this->dbforge->add_column($site_table, $off_end);
                }

                if (!$this->db->field_exists('off_days', $site_table))
                {
                $off_days = array('off_days' => array(
                'type' => 'VARCHAR',
                'null'=>TRUE,
                'constraint' => 100,
                ),
                );
                $this->dbforge->add_column($site_table, $off_days);
                }

                if (!$this->db->field_exists('audio_file', $site_table))
                {
                $audio_file = array('audio_file' => array(
                'type' => 'VARCHAR',
                'null'=>TRUE,
                'constraint' => 100,
                ),
                );
                $this->dbforge->add_column($ext_table, $audio_file);
                }

                if (!$this->db->field_exists('audio_avoid', $site_table))
                {
                $audio_avoid = array('audio_avoid' => array(
                'type' => 'VARCHAR',
                'null'=>TRUE,
                'constraint' => 20,
                ),
                );
                $this->dbforge->add_column($ext_table, $audio_avoid);
                }
              }
            }
            
            public function down()
            {
             //$this->dbforge->drop_table('page_setting');
            }       
    }

