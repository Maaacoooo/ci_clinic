<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Medcert_model extends CI_Model
{


    function create($case_id) {

      
            $data = array(              
                'title'          => $this->input->post('title'),  
                'remarks'        => $this->input->post('remarks'),                          
                'case_id'        => $case_id,                 
                'doctor'         => $this->input->post('doctor')                         
             );
       
            return $this->db->insert('medical_cert', $data);      

    }


    function fetch_medcert($patient_id, $case_id) {
            
            
            $this->db->select('
            medical_cert.id as cert_id,
            medical_cert.title,
            medical_cert.doctor,
            medical_cert.remarks,
            medical_cert.created_at,
            medical_cert.status,
            patients.id as patient_id,
            cases.id as case_id,
            ');
            $this->db->group_by('medical_cert.id');
            $this->db->join('cases', 'cases.id = medical_cert.case_id');
            $this->db->join('patients', 'patients.id = cases.patient_id');
            
            if($case_id) {
                $this->db->where('medical_cert.case_id', $case_id);
            } else {
                $this->db->where('patients.id', $patient_id);
            }

            $query = $this->db->get("medical_cert");

            return $query->result_array();
          
    }


    function view($id) {            
            
            $this->db->select('
            medical_cert.id as cert_id,
            medical_cert.title,
            medical_cert.doctor,
            medical_cert.remarks,
            medical_cert.created_at,
            medical_cert.status,
            patients.id as patient_id,
            cases.id as case_id,
            cases.created_at as case_date,
            users.lic_no,
            cases.title as case_title
            ');
            $this->db->group_by('medical_cert.id');
            $this->db->join('cases', 'cases.id = medical_cert.case_id');
            $this->db->join('patients', 'patients.id = cases.patient_id');
            $this->db->join('users', 'users.name = medical_cert.doctor');            

            $this->db->where('medical_cert.id', $id);

            $query = $this->db->get("medical_cert");

            return $query->row_array();
          
    }


    function fetch_doctors() {
        $this->db->where('usertype', 'Doctor');
        $query = $this->db->get("users");
        return $query->result_array();
    }






}