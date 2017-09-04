<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


Class Queue_model extends CI_Model
{


    function generate_queue($case_id) {

            $data = array(              
                'case_id'      => $case_id                      
             );
       
            return $this->db->insert('queues', $data);      
    }



    function fetch_queues($status) {

            $this->db->select('
                queues.status,
                queues.date_time,
                CONCAT(patients.fullname, " ", patients.lastname) as patient,
                cases.title as case_title,
                cases.id as case_id,
                patients.id as patient_id,
                queues.id as queue_id
            ');
            $this->db->join('cases', 'cases.id = queues.case_id', 'left');
            $this->db->join('patients', 'patients.id = cases.patient_id', 'left');
            $this->db->where('queues.status', $status); //fetch all pending        
            $this->db->order_by('queues.date_time', 'ASC');

            $query = $this->db->get("queues");

            return $query->result_array();
          
    }

    function check_queue($id) {

            $this->db->select('
                queues.status,
                queues.date_time,
                CONCAT(patients.fullname, " ", patients.lastname) as patient,
                cases.title as case_title,
                cases.id as case_id,
                patients.id as patient_id,
                queues.id as queue_id
            ');
            $this->db->join('cases', 'cases.id = queues.case_id', 'left');
            $this->db->join('patients', 'patients.id = cases.patient_id', 'left');  
            $this->db->order_by('queues.date_time', 'ASC');

            $this->db->where('queues.id', $id);      
            $query = $this->db->get("queues");

            return $query->row_array();
          
    }

    function change_queue($id, $status) {

            $data = array(              
                'status'      => $status                      
             );
            $this->db->where('id', $id);        
            return $this->db->update('queues', $data);      
    }


    function clear_queue($case_id) {
        $this->db->where('case_id', $case_id);
        return $this->db->delete('queues');
    }


    function next_queue() {

            $this->db->select('*');
            $query = $this->db->get("queues");
            return $query->first_row('array');
          
    }







}