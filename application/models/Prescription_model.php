<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Prescription_model extends CI_Model
{


    function create_prescription($case_id) {

      
            $data = array(              
                'case_id'        => $case_id,  
                'title'          => $this->input->post('title'),  
                'description'    => $this->input->post('description')                          
             );
       
            return $this->db->insert('prescription', $data);      

    }


    /**
     * Returns the prescriptions of a specific case
     * @param  int            $case_id     the ID of the case
     * @return String Array                the result of rows
     */
    function fetch_case_prescription($case_id) {

            $this->db->where('case_id', $case_id);
            $this->db->order_by('created_at', 'DESC');
            $query = $this->db->get("prescription");

            return $query->result_array();
          
    }


    

    /**
     * Returns the row of a `case`
     * @param   int         $id         Row ID
     * @param   int         $case_id    Case_ID
     * @return  String[]                [description]
     */
    function view_prescription($id, $case_id) {

            $this->db->select('*');        
            $this->db->where('id', $id);
            $this->db->where('case_id', $case_id);          
            $this->db->limit(1);

            $query = $this->db->get('prescription');

            return $query->row_array();
    }

    /**
     * The Prescription items 
     * @param  [type] $prescription_id [description]
     * @return [type]                  [description]
     */
    function fetch_prescription_items($prescription_id) {

            $this->db->where('prescription_id', $prescription_id);
            $query = $this->db->get("prescription_items");

            return $query->result_array();
          
    }


    function search_items($q){
      
            $this->db->like('title', $q);
            $this->db->limit(15);
            $query = $this->db->get('items');
            
            return $query->result_array();
  }





}