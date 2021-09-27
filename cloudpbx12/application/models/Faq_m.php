<?php
    
    class Faq_m extends MY_Model
    {

		protected $_table_name = 'faq';
		protected $_order_by = 'asc';

        public function __construct()
        {
          parent::__construct();
        }

          public function get_faq()
       	 {

            $this->db->select('*');
            $this->db->from('faq');
            $query = $this->db->get();
            $result =  $query->row();

            return $result;
        }
        public function get_category(){
        	
        	$this->db->select('faq_category');
            $this->db->from('faq');
            $query = $this->db->get();
            $result =  $query->result();

            return $result;
        }
        public function get_faq_by_id($id)
       	 {

            $this->db->select('*');
            $this->db->where('faq_id',$id);
            $this->db->from('faq');
            $query = $this->db->get();
            $result =  $query->row();

            return $result;
        }

        public function add_faq($data)
		{
		

		    $this->db->insert('faq',$data);
		}

		public function edit_faq($data,$id)
		{
		
			$this->db->where('faq_id', $id);
    		$this->db->update('faq', $data);
		}
		public function delete_faq($id){
    		$this->db->where('faq_id', $id);
			$this->db->delete('faq');

		}

}    