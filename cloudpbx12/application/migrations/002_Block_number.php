<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Block_number extends CI_Migration {
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
'did' => array(
'type' => 'VARCHAR',
'constraint' => 20,
'null' => FALSE,
),
'number' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'type' => array(
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
$this->dbforge->create_table('block_number');           
}
public function down()
{
$this->dbforge->drop_table('block_number');
}
}