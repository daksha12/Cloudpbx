    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Migration_Phone_family extends CI_Migration {
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
                    'file_prifix' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                    ),
                    'tenant_id' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 30,
                    ),
                    'datetime' => array(
                            'type'    => 'TIMESTAMP',
                            'null'=>FALSE,
                            'default' => date('Y-m-d H:i:s'),
                    ),
                )); 
                $this->dbforge->add_key('id',TRUE);
                $this->dbforge->create_table('phone_family');           
            }
            
            public function down()
            {
              $this->dbforge->drop_table('phone_family');
            }
    }

