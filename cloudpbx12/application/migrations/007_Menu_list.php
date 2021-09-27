<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Menu_list extends CI_Migration {
public function up()
{ 
$this->dbforge->add_field(array(
'id' => array(
'type' => 'INT',
'null' => FALSE,
'auto_increment'=>TRUE,
'constraint' => 20,
),
'menu_name' => array(
'type' => 'VARCHAR',
'constraint' => 100,
'null' => FALSE,
),
'menu_icon' => array(
'type' => 'TEXT',
'null' => FALSE,
),
'uri' => array(
'type' => 'VARCHAR',
'constraint' => 100,
'null' => FALSE,
),
'parent_id' => array(
'type' => 'INT',
'constraint' => 10,
'null' => FALSE,
),
'menu_position' => array(
'type' => 'INT',
'constraint' => 10,
'null' => FALSE,
),
'sub_menu' => array(
'type' => 'INT',
'constraint' => 10,
'null' => FALSE,
),
'page_title' => array(
'type' => 'VARCHAR',
'constraint' => 100,
'null' => FALSE,
),
'info_text' => array(
'type' => 'TEXT',
'null' => FALSE,
),
'help_text' => array(
'type' => 'TEXT',
'null' => FALSE,
),
'menu_type' => array(
'type' => 'VARCHAR',
'constraint' => 20,
'null' => FALSE,
),
'disable' => array(
'type' => 'VARCHAR',
'constraint' => 10,
'null' => FALSE,
),
'agent_rights' => array(
'type' => 'INT',
'constraint' => 10,
'null' => FALSE,
),
)); 
$this->dbforge->add_key('id',TRUE);
$this->dbforge->create_table('menu_list');


$query = "INSERT INTO `menu_list` (`id`, `menu_name`, `menu_icon`, `uri`, `parent_id`, `menu_position`, `sub_menu`, `page_title`, `info_text`, `help_text`, `menu_type`, `disable`, `agent_rights`) VALUES
(1, 'Dashboard', 'fas fa-home', 'Dashboard/index', 0, 1, 0, 'Dashboard', 'Dashboard page shows two tables: extension list/directory list of users and Site list', 'Dashboard page shows list of extensions and its corresponding branch details. User can select any branch with help of select branch button present on upper right side of page', 'Menu', '', 1),
(2, 'Users', 'fas fa-user', 'Users/index', 0, 2, 0, 'Users', 'List user page shows the list of\nextensions with display name, site under which extension is present and info button for all sites by default', 'Here all the list of users is displayed with its corresponding status details. With reset password admin can change password of any user.', 'Menu', '', 0),
(3, 'Add User', 'fas fa-user', 'dashboard/index', 2, 4, 0, 'Add User', 'Info Text', 'help_text', 'Menu', 'disabled', 0),
(4, 'Edit User', 'fas fa-user', 'dashboard/index', 2, 3, 0, 'Edit User', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(6, 'Legends', 'fas fa-user', 'Users/status', 2, 2, 0, 'Legends', 'Extension status shows the list of extensions with fix phone, mobile  and desktop details', 'The extension status of users\nshows red when offline and green when online', 'Menu', 'disabled', 0),
(7, 'LDAP', 'fas fa-user', 'dashboard/index', 2, 5, 0, 'LDAP', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(8, 'Outbound', 'fas fa-user', 'dashboard/index', 0, 4, 1, 'Number', 'Info Text', 'Help Text', 'Menu', '', 0),
(9, 'Outbound routing', 'fas fa-phone fa-rotate-90 lighten-1 dashboard_icon', 'Number/outgoing_number', 8, 1, 0, 'Outbound routing', 'Outgoing number page shows list of users with its extension \nnumber, extension type, outbound DID number, email ID and site name for all sites by default', 'Select site from dropdown for\nsite specific details', 'Menu', '', 0),
(10, 'List Block Number', 'fas fa-ban', 'Number/index', 8, 2, 0, 'List Block Number', 'Block number page shows the\nincoming block list with site name, DID number and incoming number. Outgoing block list shows site name and outgoing number', 'Block number page shows \nIncoming block list and Outgoing\nblock list', 'Menu', '', 0),
(11, 'Number Allocation', 'fas fa-user', 'dashboard/index', 8, 3, 0, 'Number Allocation', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(12, 'E911 Number', 'fas fa-user', 'dashboard/index', 8, 4, 0, 'E911 Number', 'Info Text', 'help_text', 'Menu', 'disabled', 0),
(13, 'OutBound', 'fas fa-user', 'dashboard/index', 0, 5, 1, 'OutBound', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(14, 'Dialing Prefix', 'fas fa-user', 'dashboard/index', 13, 1, 0, 'Dialing Prefix', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(15, 'Feature Codes', 'fas fa-user', 'dashboard/index', 13, 2, 0, 'Feature Codes', 'Info Text', 'help_text', 'Menu', 'disabled', 0),
(16, 'Alias [Quick Dial]', 'fas fa-user', 'dashboard/index', 13, 3, 0, 'Alias [Quick Dial]', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(17, 'International Calling', 'fas fa-user', 'dashboard/index', 13, 4, 0, 'International Calling', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(18, 'Inbound', 'fas fa-user', 'dashboard/index', 0, 6, 1, 'Inbound', 'Info Text', 'Help Text', 'Menu', '', 0),
(19, 'Add Routing', 'fas fa-user', 'dashboard/index', 18, 1, 0, 'Add Routing', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(20, 'Current Inbound Plan', 'fas fa-phone fa-rotate-90', 'Incoming/inbound_plan', 18, 2, 0, 'Current Inbound Plan', 'This page allows user to view the current inbound call plan ie: the route of incoming call of user', 'with current inbound plan, user can know on which number the incoming call will land depending on office time and out of office time', 'Menu', '', 0),
(21, 'Override Temporary Routing', 'fas fa-user', 'dashboard/index', 18, 3, 0, 'Override Temporary Routing', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(22, '24 Hours Routing', 'fas fa-user', 'dashboard/index', 18, 4, 0, '24 Hours Routing', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(23, 'Working Hours Routing', 'fas fa-user', 'dashboard/index', 18, 5, 0, 'Working Hours Routing', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(24, 'OFF Hours Routing', 'fas fa-user', 'dashboard/index', 18, 6, 0, 'OFF Hours Routing', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(25, 'Voice Mail', 'fas fa-envelope', 'Voice_mail/voice_list', 0, 7, 0, 'Voice Mail', 'Voice mail list shows call date,\ncaller, recepients, voice mail and\nduration for selected extension and selected mail type', 'With download option user can \ndownload any voicemail detail of\nextension and mail type that is selected', 'Menu', '', 1),
(26, 'System VoiceMail Greetings', 'fas fa-user', 'dashboard/index', 25, 2, 0, 'System VoiceMail Greetings', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(27, 'User Specific Voice Mail Greetings', 'fas fa-user', 'dashboard/index', 25, 3, 0, 'User Specific Voice Mail Greetings', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(28, 'Call Records', 'fas fa-list', 'Reports/cdr', 0, 8, 0, 'Call Records', 'Call records page shows the\nrecording of calls with call date, \ncaller, recepients, bill sec and \ndisposition', 'By changing from and to date, user can view all the call details from selected dates only. On select download all button, all the entries will get downloaded. Likewise user can manually select particular entries for download', 'Menu', '', 1),
(30, 'Archive', 'fas fa-user', 'dashboard/index', 28, 2, 0, 'Archive', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(31, 'Provisioning', 'fas fa-user', 'dashboard/index', 0, 9, 1, 'Provisioning', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(32, 'Manual Configuration', 'fas fa-user', 'dashboard/index', 31, 1, 0, 'Manual Configuration', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(33, 'Deskphone', 'fas fa-user', 'dashboard/index', 31, 2, 0, 'Deskphone', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(34, 'Mobile', 'fas fa-user', 'dashboard/index', 31, 3, 0, 'Mobile', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(35, 'Company', 'fas fa-user', 'dashboard/index', 0, 10, 1, 'Company', 'Info Text', 'Help Text', 'Menu', '', 0),
(36, 'Time Zone', 'fas fa-clock', 'Company/time_zone', 35, 2, 0, 'Time Zone', 'Company Time Zone ', 'Company Time Zone ', 'Menu', '', 0),
(37, 'Holidays', 'fas fa-user', 'dashboard/index', 35, 3, 0, 'Holidays', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(38, 'Prompt Language', 'fas fa-user', 'dashboard/index', 35, 4, 0, 'Prompt Language', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(39, 'Conference Prompt Message', 'fas fa-user', 'dashboard/index', 35, 5, 0, 'Conference Prompt Message', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(40, 'Create Sub Account', 'fas fa-user', 'dashboard/index', 35, 6, 0, 'Create Sub Account', 'Info Text', 'Help Text', 'Menu', 'disabled', 0),
(42, 'Branch', 'fas fa-user', 'Site', 0, 3, 1, 'Branch', 'Branch list page shows the list of all \nsites with extensions, trunk name, series and info ', 'The info button present in site \nlist shows the site details ', 'Menu', '', 0),
(44, 'Info', 'fas fa-info-circle', 'Company/info', 35, 1, 0, 'Info', 'Company info page shows all the details of company as well as sales details', 'Company details and saled details are shown here', 'Menu', '', 0),
(45, 'Feature Codes', 'fas fa-headset', 'Site/codes', 42, 2, 0, 'Feature Codes', 'This is the list of features available to admin as per selected branch.', 'Listen, Barge, Whishper is only allowed and available to User type Super (defined in Extensions_Detail)', 'Menu', '', 0),
(46, 'List Block Number', 'fas fa-ban', 'Incoming/block_number', 18, 2, 0, 'List Block Number', 'Block number page shows the\r\nincoming block list with site name, DID number and incoming number. Outgoing block list shows site name and outgoing number', 'Block number page shows \r\nIncoming block list and Outgoing\r\nblock list', 'Menu', '', 0),
(47, 'List', 'fas fa-list', 'Site/index', 42, 1, 0, 'List', 'Branch list page shows the list of all \r\nsites with extensions, trunk name, series and info ', 'The info button present in site \r\nlist shows the site details ', 'Menu', '', 0),
-- (48, 'Call Management', 'fas fa-list', 'Call_forward/index', 0, 11, 0, 'Call Management', 'Call management shows the incoming and outgoing numbers that are blocked and also conference PIN by which conference calling can be executed', 'Add inbound DID button allows user to add DID number. Number that are blocked will not be allowed to participate in incoming or outgoing calling. Numbers blocked will only be applicable for specific branch.', 'Menu', '', 1);
(48, 'Call Management', 'fas fa-list', 'Call_forward/index', 0, 11, 1, 'Call Management', 'Call management shows the incoming and outgoing numbers that are blocked and also conference PIN by which conference calling can be executed', 'Add inbound DID button allows user to add DID number. Number that are blocked will not be allowed to participate in incoming or outgoing calling. Numbers blocked will only be applicable for specific branch.', 'Menu', '', 0, 1)";      

$this->db->query($query);  

}

public function down()
{
$this->dbforge->drop_table('menu_list');
}
}

