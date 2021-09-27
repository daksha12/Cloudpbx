<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Menu_provisi extends CI_Migration {
public function up()
{ 

$query = "INSERT INTO `menu_list` (`id`, `menu_name`, `menu_icon`, `uri`, `parent_id`, `menu_position`, `sub_menu`, `page_title`, `info_text`, `help_text`, `menu_type`, `disable`, `agent_rights`) VALUES
(50, 'Provisioning', 'fas fa-list', 'Provisioning', 0, 12, 1, 'Provisioning', 'Provisioning info ', 'Provisioning Help ', 'Menu', '', 0),
(51, 'Phone Company', 'fas fa-list', 'Provisioning/company', 50, 1, 0, 'Phone Company', 'Phone Company info ', 'Phone Company Help ', 'Menu', '', 0),
(52, 'Phone Family', 'fas fa-list', 'Provisioning/family', 50, 2, 0, 'Phone Family', 'Phone Family Info', 'Phone Family help', 'Menu', '', 0),
(53, 'Phone Template', 'fas fa-list', 'Provisioning/template', 50, 3, 0, 'Phone Templates', 'Phone Template Info', 'Phone Template Help', 'Menu', '', 0),
(54, 'Phone Provisioning', 'fas fa-list', 'Provisioning/provisioning', 50, 4, 0, 'Phone Provisioning', 'Extension Provisioning Info', 'Extension Provisioning help', 'Menu', '', 0),
(55, 'LDAP Config', 'fas fa-list', 'LDAP/index', 0, 0, 0, 'LDAP Config', 'LDAP Config', 'LDAP Config', 'page', 'disabled', 0);";      

$this->db->query($query);  

}
 
public function down()
{
$this->dbforge->drop_table('menu_list');
}
}

