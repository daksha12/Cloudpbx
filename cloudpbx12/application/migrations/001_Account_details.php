<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Account_details extends CI_Migration {
public function up()
{ 
$this->dbforge->add_field(array(
'id' => array(
'type' => 'INT',
'null' => FALSE,
'auto_increment'=>TRUE,
'constraint' => 10,
),
'account_code' => array(
'type' => 'VARCHAR',
'constraint' => 15,
'null' => FALSE,
),
'organization_name' => array(
'type' => 'VARCHAR',
'constraint' => 100,
'null' => FALSE,
),
'address' => array(
'type' => 'TEXT',
'null' => FALSE,
),
'site_key_issued' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'sales_id' => array(
'type' => 'VARCHAR',
'constraint' => 10,
'null' => TRUE,
),
'tech_id' => array(
'type' => 'VARCHAR',
'constraint' => 10,
'null' => TRUE,
),
'admin_email' => array(
'type' => 'VARCHAR',
'constraint' => 100,
'null' => FALSE,
),
'admin_phone' => array(
'type' => 'VARCHAR',
'constraint' => 20,
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
$this->dbforge->create_table('account_details');           
}

public function down()
{
$this->dbforge->drop_table('account_details');
}
}

