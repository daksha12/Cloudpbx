    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Migration_Col_update extends CI_Migration {
            public function up()
            {             
                if (!$this->db->field_exists('user_type', 'login_details'))
                {
                $user_type = array('user_type' => array(
                'type' => 'VARCHAR',
                'null'=>TRUE,
                'constraint' => 30,
                ),
                );
                $this->dbforge->add_column('login_details', $user_type);
                }

                if(!$this->db->field_exists('admin_rights', 'menu_list'))
                {
                $admin_rights = array('admin_rights' => array(
                'type' => 'INT',
                'null'=>TRUE,
                'defult'=>'1',
                'constraint' => 20,
                ),
                );
                $this->dbforge->add_column('menu_list', $admin_rights);
                }

                 if(!$this->db->field_exists('super_rights', 'menu_list'))
                {
                $super_rights = array('super_rights' => array(
                'type' => 'INT',
                'null'=>TRUE,
                'defult'=>'0',
                'constraint' => 20,
                ),
                );
                $this->dbforge->add_column('menu_list', $super_rights);
                }

                $query = "UPDATE `menu_list` SET admin_rights='1';";
                $this->db->query($query);

                $query = "INSERT INTO `menu_list` (`menu_name`, `menu_icon`, `uri`, `parent_id`, `menu_position`, `sub_menu`, `page_title`, `info_text`, `help_text`, `menu_type`, `disable`, `agent_rights`, `admin_rights`, `super_rights`) VALUES
                ('Rate Card', 'fas fa-users', 'Rate_card/index', 0, 1, 0, 'Rate Caard', 'Rate Card', 'Rate Card', 'menu', '', 0, 0, 1),
                ('Rate Card Assign', 'fas fa-users', 'bill/index', 0, 2, 0, 'Assign Rate Card', 'Assign Rate Card', 'Assign Rate Card', 'menu', '', 0, 0, 1);";      

                $this->db->query($query);


                $query = "INSERT INTO `login_details` (`tenant_name`, `username`, `password`, `account_id`, `email`, `phone`, `force_password_reset`, `address`, `contat_person`, `country_code`, `time_zone`, `password_temp`, `user_type`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
                ('bizrtc', 'admin', '79e66a712a326f3693ad74550efbee67f6cf003f7a178fcef329c94003cacb4d041632b46a6d5dfe5f0ac1ef4077202ac9e49da1ef96db8d5713e82c6c67bf8e', '', '', '', '', '', '', '', '', 'Welcome@2020', 'Super Admin', NULL, NULL, NULL, NULL, NULL, NULL);";      

                $this->db->query($query);  

            }
            
            public function down()
            {
             // $this->dbforge->drop_table('page_setting');
            }
    }

