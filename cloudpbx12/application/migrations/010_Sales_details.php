    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Migration_Sales_details extends CI_Migration {
            public function up()
            { 
                $this->dbforge->add_field(array(
                    'id' => array(
                            'type' => 'INT',
                            'null' => FALSE,
                            'auto_increment'=>TRUE,
                            'constraint' => 20,
                    ),
                    'account_code' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 20,
                            'null' => FALSE,
                    ),
                    'first_name' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                            'null' => FALSE,
                    ),
                    'last_name' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                            'null' => FALSE,
                    ),
                    'phone' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                            'null' => FALSE,
                    ),
                    'email' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 100,
                            'null' => FALSE,
                    ),
                    'user_type' => array(
                            'type' => 'ENUM("sales","technical")',
                            'null' => FALSE,
                    ),                    
                    'created_at' => array(
                            'type' => 'TIMESTAMP',
                            'null' => TRUE,
                    ),
                    'created_by' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                            'null' => TRUE,
                    ),
                    'updated_at' => array(
                            'type' => 'TIMESTAMP',
                            'null' => TRUE,
                    ),
                    'updated_by' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                            'null' => TRUE,
                    ),
                    'deleted_at' => array(
                            'type' => 'TIMESTAMP',
                            'null' => TRUE,
                    ),
                    'deleted_by' => array(
                        'type' => 'VARCHAR',
                        'constraint' => 50,
                        'null' => TRUE,
                    ),
                )); 
                $this->dbforge->add_key('id',TRUE);
                $this->dbforge->create_table('sales_details');           
            }
            
            public function down()
            {
              $this->dbforge->drop_table('sales_details');
            }
    }

