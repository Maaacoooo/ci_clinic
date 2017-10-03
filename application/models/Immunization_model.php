<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Immunization_model extends CI_Model
{

    function create($case_id, $service, $user) {

      
            $data = array(              
                'service'  => $service,                 
                'case_id'  => $case_id,                 
                'user'     => $user                       
             );
       
            return $this->db->insert('immunizations', $data);      

    }

    function update($id) {

            $data = array(                             
                'description'     => $this->input->post('description')                       
             );

            $this->db->where('id', $id);
            return $this->db->update('immunizations', $data);      

    }    

    function update_status($status, $id) {

            $data = array(                             
                'status'     => $status                      
             );

            $this->db->where('id', $id);
            return $this->db->update('immunizations', $data);      

    }    

    function view($id, $case_id) {
            $this->db->select('
            immunizations.id as immu_id,
            immunizations.description,
            users.username as user,
            users.name as name,
            immunizations.service,
            immunizations.status,
            immunizations.created_at,
            immunizations.updated_at,
            immunizations.case_id,
            services.id,
            services.code,
            services.amount,
            patients.id as patient_id    
            ');
            $this->db->join('services', 'services.title = immunizations.service', 'left');            
            $this->db->join('cases', 'cases.id = immunizations.case_id', 'left');            
            $this->db->join('patients', 'patients.id = cases.patient_id', 'left');            
            $this->db->join('users', 'users.username = immunizations.user', 'left');            

            $this->db->where('immunizations.id', $id);

            if($case_id) {
                $this->db->where('immunizations.case_id', $case_id);
            }

            $query = $this->db->get("immunizations");

            return $query->row_array();
    }



    function fetch_immunizations($case_id, $patient_id, $status) {

            $this->db->join('cases', 'cases.id = immunizations.case_id', 'left');            
            $this->db->join('patients', 'patients.id = cases.patient_id', 'left');            
            $this->db->join('users', 'users.username = immunizations.user', 'left');            

            $this->db->select('
                immunizations.id,             
                immunizations.service,
                immunizations.status,             
                immunizations.created_at,             
                immunizations.updated_at,  
                patients.id as patient_id,
                cases.id as case_id,           
                users.username as username,             
                users.name as name            
            ');

            if(($case_id)) {
                $this->db->where('immunizations.case_id', $case_id);           
            }

            if(is_int($patient_id)) {
                $this->db->where('patients.id', $patient_id);
            }

            if(is_int($status)) {
                $this->db->where('immunizations.status', $status);
            }

            $this->db->order_by('immunizations.created_at', 'DESC');
            $query = $this->db->get("immunizations");

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }

            return false;

    }


     function fetch_immu($limit, $id, $search, $status) {

            if($search) {
              $this->db->group_start();
              $this->db->like('cases.title', $search);
              $this->db->or_like('immunizations.service', $search);
              $this->db->or_like('patients.fullname', $search);
              $this->db->or_like('patients.lastname', $search);
              $this->db->or_like('patients.middlename', $search);
              $this->db->group_end();
            }

            $this->db->where('immunizations.status', $status);              

            $this->db->join('cases', 'cases.id = immunizations.case_id', 'left');
            $this->db->join('patients', 'patients.id = cases.patient_id', 'left');            
            $this->db->join('users', 'users.username = immunizations.user', 'left');
            $this->db->select('
                immunizations.id,
                immunizations.service,
                immunizations.status,
                immunizations.created_at,
                immunizations.updated_at,
                users.name as user,
                users.username,
                cases.id as case_id,
                cases.title as case_title,
                patients.id as patient_id,
                CONCAT(patients.lastname, ", ", patients.fullname) as patient_name
            ');
            
            $this->db->group_by('immunizations.id');
            $this->db->order_by('immunizations.created_at', 'DESC');
            $this->db->limit($limit, (($id-1)*$limit));

            $query = $this->db->get("immunizations");

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            return false;

    }

    /**
     * Returns the total number of rows of users
     * @return int       the total rows
     */
    function count_immu($search, $status) {
        
            if($search) {
              $this->db->group_start();
              $this->db->like('cases.title', $search);
              $this->db->or_like('immunizations.service', $search);
              $this->db->or_like('patients.fullname', $search);
              $this->db->or_like('patients.lastname', $search);
              $this->db->or_like('patients.middlename', $search);
              $this->db->group_end();
            }

            $this->db->where('immunizations.status', $status);

            $this->db->join('cases', 'cases.id = immunizations.case_id', 'left');
            $this->db->join('patients', 'patients.id = cases.patient_id', 'left');
            $this->db->join('users', 'users.username = immunizations.user', 'left');            

            return $this->db->count_all_results("immunizations"); 

    
    }





}