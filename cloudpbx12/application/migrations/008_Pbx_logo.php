<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Pbx_logo extends CI_Migration {
        public function up()
        { 
            $this->dbforge->add_field(array(
                'id' => array(
                        'type' => 'INT',
                        'null' => FALSE,
                        'auto_increment'=>TRUE,
                        'constraint' => 20,
                ),
                'user_id' => array(
                        'type' => 'INT',
                         'constraint' => 20,
                         'null' => FALSE,
                ),
                'logo_name' => array(
                        'type' => 'VARCHAR',
                        'constraint' => 100,
                        'null' => FALSE,
                ),
                'logo_path' => array(
                        'type' => 'TEXT',
                         'null' => FALSE,
                ),
            )); 
            $this->dbforge->add_key('id',TRUE);
            $this->dbforge->create_table('pbx_logo');                   

        }
        
        public function down()
        {
          $this->dbforge->drop_table('pbx_logo');
        }
}

