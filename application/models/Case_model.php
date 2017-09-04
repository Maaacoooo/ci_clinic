<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Case_model extends CI_Model
{


    function create_case($patient_id) {

      
            $data = array(              
                'patient_id'     => $patient_id,  
                'title'          => $this->input->post('title'),  
                'description'    => $this->input->post('description'),                 
                'weight'         => $this->input->post('weight'),   
                'height'         => $this->input->post('height')                           
             );
       
            return $this->db->insert('cases', $data);      

    }

    function update_status($case_id, $status) {

            $data = array(               
                'status'         => $status                         
             );
            
            $this->db->where('id', $case_id);
            return $this->db->update('cases', $data);      

    }


    /**
     * Returns the cases of a specific patient
     * @param  int     $patient_id     the ID of the patient
     * @return String Array            the result of rows
     */
    function fetch_patient_case($patient_id) {

            $this->db->where('patient_id', $patient_id);
            $this->db->order_by('created_at', 'DESC');
            $query = $this->db->get("cases");

            return $query->result_array();
          
    }


    

    /**
     * Returns the row of a `case`
     * @param  [type] $id         [description]
     * @param  [type] $patient_id [description]
     * @return [type]             [description]
     */
    function view_case($id, $patient_id) {

            $this->db->select('*');        
            $this->db->where('id', $id);
            $this->db->where('patient_id', $patient_id);          
            $this->db->limit(1);

            $query = $this->db->get('cases');

            return $query->row_array();
    }



    /**
     * Returns the total number of rows of users
     * @return int       the total rows
     */
    function count_cases($patient_id) {
        $this->db->where('patient_id', $patient_id);
        return $this->db->count_all_results("cases");
    }

}