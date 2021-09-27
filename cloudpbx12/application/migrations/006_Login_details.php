<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Login_details extends CI_Migration {
public function up()
{ 
$this->dbforge->add_field(array(
'id' => array(
'type' => 'INT',
'null' => FALSE,
'auto_increment'=>TRUE,
'constraint' => 20,
),
'tenant_name' => array(
'type' => 'VARCHAR',
'constraint' => 100,
'null' => FALSE,
),
'username' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'password' => array(
'type' => 'TEXT',
'null' => FALSE,
),
'account_id' => array(
'type' => 'VARCHAR',
'constraint' => 20,
'null' => FALSE,
),
'email' => array(
'type' => 'VARCHAR',
'constraint' => 100,
'null' => FALSE,
),
'phone' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'force_password_reset' => array(
'type' => 'ENUM("Y","N")',
'null' => FALSE,
),
'address' => array(
'type' => 'TEXT',
'null' => FALSE,
),
'contat_person' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'country_code' => array(
'type' => 'VARCHAR',
'constraint' => 20,
'null' => FALSE,
),
'time_zone' => array(
'type' => 'VARCHAR',
'constraint' => 20,
'null' => FALSE,
),
'password_temp' => array(
'type' => 'TEXT',
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
$this->dbforge->create_table('login_details');           
}

public function down()
{
$this->dbforge->drop_table('login_details');
}
}

