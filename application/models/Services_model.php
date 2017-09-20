<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Services_model extends CI_Model
{


    function create($category) {

      
            $data = array(              
                'title'          => $this->input->post('title'),  
                'description'    => $this->input->post('description'),                 
                'code'           => $this->input->post('code'),                 
                'service_cat'    => $category,                 
                'amount'         => $this->input->post('amount')                         
             );
       
            return $this->db->insert('services', $data);      

    }

    function update($service_id) {

            $data = array(              
                'title'          => $this->input->post('title'),  
                'description'    => $this->input->post('description'),                 
                'code'           => $this->input->post('code'),                 
                'service_cat'    => $this->input->post('category'),                 
                'amount'         => $this->input->post('amount')                         
             );
            
            $this->db->where('id', $service_id);
            return $this->db->update('services', $data);      

    }    

    function delete($service_id) {

            $data = array(              
                'is_deleted'          => 1                      
             );
            
            $this->db->where('id', $service_id);
            return $this->db->update('services', $data);      

    }    


    /**
     * Returns the paginated array of rows 
     * @param  int      $limit      The limit of the results; defined at the controller
     * @param  int      $id         the Page ID of the request. 
     * @return Array        The array of returned rows 
     */
    function fetch_services($limit, $id, $category) {
            $this->db->where('is_deleted', 0);
            $this->db->where('service_cat', $category);
            $this->db->limit($limit, (($id-1)*$limit));           
            $query = $this->db->get("services");

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }


            return false;

    }

    /**
     * Returns the total number of rows of users
     * @return int       the total rows
     */
    function count_services($category) {
        $this->db->where('service_cat', $category);
        $this->db->where('is_deleted', 0);
        return $this->db->count_all_results("services");
    }



}