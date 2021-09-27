<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Cdr extends CI_Migration {
public function up()
{ 
$this->dbforge->add_field(array(
'id' => array(
'type' => 'INT',
'constraint' => 100,
'null' => FALSE,
'auto_increment'=>TRUE,
),
'calldate' => array(
'type' => 'datetime',
'null' => FALSE,
),
'clid' => array(
'type' => 'VARCHAR',
'constraint' => 80,
'null' => FALSE,
),
'src' => array(
'type' => 'VARCHAR',
'constraint' => 80,
'null' => FALSE,
),
'dst' => array(
'type' => 'VARCHAR',
'constraint' => 80,
'null' => FALSE,
),
'dcontext' => array(
'type' => 'VARCHAR',
'constraint' => 80,
'null' => FALSE,
),
'channel' => array(
'type' => 'VARCHAR',
'constraint' => 80,
'null' => FALSE,
),
'dstchannel' => array(
'type' => 'VARCHAR',
'constraint' => 80,
'null' => FALSE,
),
'lastapp' => array(
'type' => 'VARCHAR',
'constraint' => 80,
'null' => FALSE,
),
'lastdata' => array(
'type' => 'VARCHAR',
'constraint' => 80,
'null' => FALSE,
),
'duration' => array(
'type' => 'INT',
'constraint' => 11,
'null' => FALSE,
),
'billsec' => array(
'type' => 'INT',
'constraint' => 11,
'null' => FALSE,
),
'disposition' => array(
'type' => 'VARCHAR',
'constraint' => 45,
'null' => FALSE,
),
'amaflags' => array(
'type' => 'INT',
'constraint' => 11,
'null' => FALSE,
),
'accountcode' => array(
'type' => 'VARCHAR',
'constraint' => 20,
'null' => FALSE,
),
'uniqueid' => array(
'type' => 'VARCHAR',
'constraint' => 32,
'null' => FALSE,
),
'userfield' => array(
'type' => 'VARCHAR',
'constraint' => 255,
'null' => FALSE,
),
'did' => array(
'type' => 'VARCHAR',
'constraint' => 50,
'null' => FALSE,
),
'recordingfile' => array(
'type' => 'VARCHAR',
'constraint' => 255,
'null' => FALSE,
),
'didkeypress' => array(
'type' => 'VARCHAR',
'constraint' => 15,
'null' => FALSE,
),
'extsrc' => array(
'type' => 'VARCHAR',
'constraint' => 100,
'null' => FALSE,
),
'extdst' => array(
'type' => 'VARCHAR',
'constraint' => 100,
'null' => FALSE,
),
)); 

$this->dbforge->add_key('id',TRUE);
$this->dbforge->create_table('cdr');           
}

public function down()
{
$this->dbforge->drop_table('cdr');
}
}

