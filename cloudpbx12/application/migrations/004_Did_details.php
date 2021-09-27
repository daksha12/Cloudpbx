<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Did_details extends CI_Migration {
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
'type' => 'INT',
'constraint' => 20,
'null' => FALSE,
),
'site_id' => array(
'type' => 'INT',
'constraint' => 20,
'null' => FALSE,
),
'trunk_id' => array(
'type' => 'INT',
'constraint' => 20,
'null' => FALSE,
),
'did_number' => array(
'type' => 'VARCHAR',
'constraint' => 20,
'null' => FALSE,
),
'extension' => array(
'type' => 'VARCHAR',
'constraint' => 250,
'null' => FALSE,
),
'did_type' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'call_type' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'did_mask' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => TRUE,
),
'fax_did' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => TRUE,
),
'fax2_mail' => array(
'type' => 'VARCHAR',
'constraint' => 100,
'null' => TRUE,
),
'sms' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => TRUE,
),
'sms2_mail' => array(
'type' => 'VARCHAR',
'constraint' => 100,
'null' => TRUE,
),
'E911_enable' => array(
'type' => 'ENUM("Y","N")',
'null' => FALSE,
),
'address1' => array(
'type' => 'TEXT',
'null' => FALSE,
),
'address2' => array(
'type' => 'TEXT',
'null' => FALSE,
),
'city' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'state' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'pincode' => array(
'type' => 'VARCHAR',
'constraint' => 50,
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
$this->dbforge->create_table('did_details');           
}

public function down()
{
$this->dbforge->drop_table('did_details');
}
}

