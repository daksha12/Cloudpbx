    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Migration_Faq extends CI_Migration {
            public function up()
            { 
                $this->dbforge->add_field(array(
                    'faq_id' => array(
                            'type' => 'INT',
                            'null' => FALSE,
                            'auto_increment'=>TRUE,
                            'constraint' => 10,
                    ),
                    'faq_title' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 500,
                            'null' => FALSE,
                    ),
                    'faq_desc' => array(
                            'type' => 'TEXT',
                            'null' => FALSE,
                    ),
                    'faq_category' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 255,
                            'null' => FALSE,
                    ),
                    'faq_created_at' => array(
                            'type' => 'DATETIME',
                            'null' => FALSE,
                    ),
                )); 
                $this->dbforge->add_key('faq_id',TRUE);
                $this->dbforge->create_table('faq');           
            }
            
            public function down()
            {
              $this->dbforge->drop_table('faq');
            }
    }

