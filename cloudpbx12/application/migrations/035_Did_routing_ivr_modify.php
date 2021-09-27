<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Did_routing_ivr_modify extends CI_Migration {
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
'did' => array(
'type' => 'VARCHAR',
'constraint' => 20,
'null' => FALSE,
),
'off_start' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'off_end' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'off_days' => array(
'type' => 'VARCHAR',
'constraint' => 100,
'null' => FALSE,
),
'IVR_Prompt_file' => array(
'type' => 'VARCHAR',
'constraint' => 100,
'null' => FALSE,
),
'ivr_level' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'ringingseconds' => array(
'type' => 'INT',
'constraint' => 20,
'null' => FALSE,
),
'choice1' => array(
'type' => 'VARCHAR',
'constraint' => 250,
'null' => FALSE,
),
'choice1_type' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'choice2' => array(
'type' => 'VARCHAR',
'constraint' => 250,
'null' => FALSE,
),
'choice2_type' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'choice3' => array(
'type' => 'VARCHAR',
'constraint' => 250,
'null' => FALSE,
),
'choice3_type' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'choice4' => array(
'type' => 'VARCHAR',
'constraint' => 250,
'null' => FALSE,
),
'choice4_type' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'choice5' => array(
'type' => 'VARCHAR',
'constraint' => 250,
'null' => FALSE,
),
'choice5_type' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'choice6' => array(
'type' => 'VARCHAR',
'constraint' => 250,
'null' => FALSE,
),
'choice6_type' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'choice7' => array(
'type' => 'VARCHAR',
'constraint' => 250,
'null' => FALSE,
),
'choice7_type' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'choice8' => array(
'type' => 'VARCHAR',
'constraint' => 250,
'null' => FALSE,
),
'choice8_type' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'choice9' => array(
'type' => 'VARCHAR',
'constraint' => 250,
'null' => FALSE,
),
'choice9_type' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'default_choice' => array(
'type' => 'VARCHAR',
'constraint' => 30,
'null' => FALSE,
),
'off_time_choice' => array(
'type' => 'VARCHAR',
'constraint' => 30,
'null' => FALSE,
),
'code' => array(
'type' => 'VARCHAR',
'constraint' => 100,
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
// $this->dbforge->create_table('did_routing_ivr');           
$this->db->query('ALTER TABLE `did_routing_ivr` CHANGE `trunk_id` `trunk_id` INT(20) NULL');  
}

public function down()
{
$this->dbforge->drop_table('did_routing_ivr');
}
}

