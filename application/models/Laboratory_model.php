<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Laboratory_model extends CI_Model
{


    function create($case_id, $service, $user) {

      
            $data = array(              
                'service'  => $service,                 
                'case_id'  => $case_id,                 
                'user'     => $user                       
             );
       
            return $this->db->insert('lab_request', $data);      

    }

    function delete($id) {

            $this->db->where('id', $id);
            return $this->db->update('lab_request', $data);      

    }    

    function view($id) {
            $this->db->select('
            lab_request.id as labreq_id,
            lab_request.description,
            lab_request.user,
            lab_request.status,
            patients.id as patient_id,
            cases.id as case_id,
            cases.created_at as case_date,
            cases.title as case_title
            ');
            $this->db->group_by('medical_cert.id');
            $this->db->join('cases', 'cases.id = lab_request.case_id');
            $this->db->join('patients', 'patients.id = cases.patient_id');        

            $this->db->where('lab_request.id', $id);

            $query = $this->db->get("lab_request");

            return $query->row_array();
    }



    /**
     * Fetches all files / results of the laboratory request
     * @param  [type] $case_id [description]
     * @return [type]          [description]
     */
    function fetch_files($case_id) {
            $this->db->where('case_id', $case_id);
      
            $query = $this->db->get("lab_request_files");

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }

            return false;

    }


    function create_file($labreq_id, $user) {


        $info = $this->view($labreq_id); // fetch lab req data

        $filename = ''; //img filename empty if not present

            //Process Image Upload
              if($_FILES['file']['name'] != NULL)  {        

                //Create Upload Path 
                //Create main path for patient
                if(!is_dir('./uploads/patients')) {
                    mkdir('./uploads/patients');
                }
                //Create main path for patient account
                if(!is_dir('./uploads/patients/'.$info['patient_id'])) {
                    mkdir('./uploads/patients/'.$info['patient_id']);
                }
                //Create main path for case
                if(!is_dir('./uploads/patients/'.$info['patient_id'].'/case')) {
                    mkdir('./uploads/patients/'.$info['patient_id'].'/case');
                }
                //Create path for distinct case
                if(!is_dir('./uploads/patients/'.$info['patient_id'].'/case/'.$info['case_id'])) {
                    mkdir('./uploads/patients/'.$info['patient_id'].'/case/'.$info['case_id']);
                }
                //Create path for laboratory
                if(!is_dir('./uploads/patients/'.$info['patient_id'].'/case/'.$info['case_id'].'/laboratory')) {
                    mkdir('./uploads/patients/'.$info['patient_id'].'/case/'.$info['case_id'].'/laboratory');
                }
                //Create path for distinct laboratory result / request
                if(!is_dir('./uploads/patients/'.$info['patient_id'].'/case/'.$info['case_id'].'/laboratory/'.$labreq_id)) {
                    mkdir('./uploads/patients/'.$info['patient_id'].'/case/'.$info['case_id'].'/laboratory/'.$labreq_id);
                }


                $config['upload_path'] = './uploads/patients/'.$info['patient_id'].'/case/'.$info['case_id'].'/laboratory/'.$labreq_id.'/';
                $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|xls|xlsx|txt|tiff'; 
                $config['encrypt_name'] = TRUE;                        

                $this->load->library('upload', $config);
                $this->upload->initialize($config);         
                
                $field_name = "file";
                $this->upload->do_upload($field_name);
                $data2 = array('upload_data' => $this->upload->data());
                foreach ($data2 as $key => $value) {     
                  $filename = $value['file_name'];
                }
                
            }


            $data = array(              
                'title'  => $this->input->post('title'),                 
                'description'  => $this->input->post('description'),                            
                'labreq_id'  => $labreq_id,                 
                'link'  => $filename,                 
                'user'     => $user                       
             );
       
            return $this->db->insert('lab_request_files', $data);


    }






}