<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Menu_add extends CI_Migration {
public function up()
{

$query = "INSERT INTO `menu_list` (`id`, `menu_name`, `menu_icon`, `uri`, `parent_id`, `menu_position`, `sub_menu`, `page_title`, `info_text`, `help_text`, `menu_type`, `disable`, `agent_rights`) VALUES
(49, 'CRM Config', 'fas fa-list', 'crm_data/index', 0, 0, 0, 'CRM Configration', 'CRM Configration', 'CRM Configration', 'Page', 'disabled', 0);";      

$this->db->query($query);  

}
 
public function down()
{
$this->dbforge->drop_table('menu_list');
}
}

