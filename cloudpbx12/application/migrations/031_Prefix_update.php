<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Migration_Prefix_update extends CI_Migration {
            public function up()
            {             

              $query = "DELETE FROM `prefix_number` where 1=1;";
              $this->db->query($query);

              $query = "INSERT INTO `prefix_number` (`id`, `name`, `prefix`) VALUES (1, 'softphone_prefix', 8),(2, 'mobile_prefix', 7),(3, 'desktop_prefix', 6);";      
              $this->db->query($query);  

              $query = "UPDATE `prefix_number_old` SET softphone_prefix='8', desktop_prefix='6';";
              $this->db->query($query);
            }
            
            public function down()
            {
              //$this->dbforge->drop_column('cdr','did_number');
            }
    }
?>
