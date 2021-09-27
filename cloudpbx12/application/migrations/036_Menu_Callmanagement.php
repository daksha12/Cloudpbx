<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Menu_Callmanagement extends CI_Migration {
public function up()
{ 

$query = "INSERT INTO `menu_list` (`id`, `menu_name`, `menu_icon`, `uri`, `parent_id`, `menu_position`, `sub_menu`, `page_title`, `info_text`, `help_text`, `menu_type`, `disable`, `agent_rights`) VALUES
(56, 'Rate Card', 'fas fa-users', 'Rate_card/index', 0, 1, 0, 'Rate Caard', 'Rate Card', 'Rate Card', 'menu', '', 0, 0, 1),
(57, 'Rate Card Assign', 'fas fa-users', 'bill/index', 0, 2, 0, 'Assign Rate Card', 'Assign Rate Card', 'Assign Rate Card', 'menu', '', 0, 0, 1),
(58, 'Caller ID block', 'fas fa-list', 'Call_forward/Caller_id_block', 48, 1, 0, 'Caller ID block', 'Caller ID block Info', 'Caller ID block Help', 'Menu', '', 0, 1),
(59, 'Conference PIN', 'fas fa-list', 'Call_forward/Conference_pin', 48, 1, 0, 'Conference PIN', 'Conference PIN Info', 'Conference PIN Help', 'Menu', '', 0, 1),
(60, 'Speed Dial', 'fas fa-list', 'Call_forward/speed_dial', 48, 1, 0, 'Speed Dial', 'Speed Dial Info', 'Speed Dial Help', 'Menu', '', 0, 1)";   

$this->db->query($query);  

}
 
public function down()
{
$this->dbforge->drop_table('menu_list');
}
}
