<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Services_model extends CI_Model
{


    function create() {

      
            $data = array(              
                'title'          => $this->input->post('title'),  
                'description'    => $this->input->post('description'),                 
                'code'           => $this->input->post('code'),                 
                'service_cat'    => $this->input->post('category'),                 
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

    function view($id) {

            $this->db->select('*');        
            $this->db->where('id', $id);

            $query = $this->db->get('services');

            return $query->row_array();
    }


    function fetch_services($services_cat) {
        
            $this->db->where('services_cat', $services_cat);
            $query = $this->db->get("services");

            return $query->result_array();
          
    }




/**
 * ----------------------------------------------------------
 * SERVICES CATEGORY
 * ----------------------------------------------------------
 */

    function create_cat() {

      
            $data = array(              
                'title'          => $this->input->post('title')                        
             );
       
            return $this->db->insert('services_cat', $data);      

    }

    function update_cat($service_cat_id) {

            $data = array(              
                'title'          => $this->input->post('title')                        
             );
            
            $this->db->where('id', $service_cat_id);
            return $this->db->update('services_cat', $data);      

    }






}