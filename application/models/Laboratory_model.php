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

    function update($id) {

            $data = array(                             
                'description'     => $this->input->post('description')                       
             );

            $this->db->where('id', $id);
            return $this->db->update('lab_request', $data);      

    }    

    function change_status($status, $id) {

            $data = array(                             
                'status'     => $status                      
             );

            $this->db->where('id', $id);
            return $this->db->update('lab_request', $data);      

    }    

    function view($id, $case_id) {
            $this->db->select('
            lab_request.id as labreq_id,
            lab_request.description,
            lab_request.user,
            lab_request.service,
            lab_request.status,
            lab_request.created_at,
            lab_request.updated_at,
            lab_request.case_id,
            services.code,
            patients.id as patient_id    
            ');
            $this->db->join('services', 'services.title = lab_request.service', 'left');            
            $this->db->join('cases', 'cases.id = lab_request.case_id', 'left');            
            $this->db->join('patients', 'patients.id = cases.patient_id', 'left');            

            $this->db->where('lab_request.id', $id);
            if($case_id) {
                $this->db->where('lab_request.case_id', $case_id);
            }

            $query = $this->db->get("lab_request");

            return $query->row_array();
    }



    function fetch_requests($case_id) {
            $this->db->select('
                lab_request.id,
                lab_request.description,
                lab_request.user,
                lab_request.status,
                lab_request.created_at,
                lab_request.service,
                services.code,
                lab_request.case_id                
            ');
            $this->db->join('services', 'services.title = lab_request.service', 'left');
            $this->db->where('case_id', $case_id);            
            $query = $this->db->get("lab_request");

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }

            return false;

    }


    /**
     * Fetches all files / results of the laboratory request
     * @param  [type] $case_id [description]
     * @return [type]          [description]
     */
    function fetch_files($labreq_id) {
            $this->db->where('labreq_id', $labreq_id);      
            $query = $this->db->get("lab_request_files");

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }

            return false;

    }


    function create_file($labreq_id, $user) {


        $info = $this->view($labreq_id, ''); // fetch lab req data

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
                $config['remove_spaces'] = TRUE;                        
                $config['file_name'] = preg_replace('/:/', '', $this->input->post('title'));  

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


    function update_file($file_id) {


        $info = $this->view_file($file_id); // fetch lab req data

        $filename = $info['link']; //img filename empty if not present

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
                if(!is_dir('./uploads/patients/'.$info['patient_id'].'/case/'.$info['case_id'].'/laboratory/'.$info['labreq_id'])) {
                    mkdir('./uploads/patients/'.$info['patient_id'].'/case/'.$info['case_id'].'/laboratory/'.$info['labreq_id']);
                }

                $path = 'patients/'.$info['patient_id'].'/case/'.$info['case_id'].'/laboratory/'.$info['labreq_id'].'/';

                //Delete old file
                if(filexist($path.$filename)) {
                  unlink('./uploads/'.$path.$filename); 
                }

                $config['upload_path'] = './uploads/'.$path;
                $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|xls|xlsx|txt|tiff'; 
                $config['remove_spaces'] = TRUE;                        
                $config['file_name'] = preg_replace('/:/', '', $this->input->post('title'));  

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
                'link'  => $filename            
             );
            
            $this->db->where('id', $file_id);
            return $this->db->update('lab_request_files', $data);


    }


    function delete_file($id) {

            $info = $this->view_file($id); // fetch lab req data

            $filename = $info['link']; //img filename empty if not present

            $path = 'patients/'.$info['patient_id'].'/case/'.$info['case_id'].'/laboratory/'.$info['labreq_id'].'/';

            //Delete old file
            if(filexist($path.$filename)) {
                unlink('./uploads/'.$path.$filename); 
            }

            $this->db->where('id', $id);
            return $this->db->delete('lab_request_files');
    }


    function view_file($id) {

        $this->db->select('
            lab_request_files.id,
            lab_request_files.link,
            lab_request_files.title,
            lab_request_files.labreq_id,
            lab_request_files.description,
            lab_request_files.user,
            lab_request_files.created_at,
            lab_request_files.updated_at,
            cases.id as case_id,
            patients.id as patient_id
        ');
        $this->db->join('lab_request', 'lab_request.id = lab_request_files.labreq_id', 'left');            
        $this->db->join('cases', 'cases.id = lab_request.case_id', 'left');            
        $this->db->join('patients', 'patients.id = cases.patient_id', 'left');

        $this->db->where('lab_request_files.id', $id);
        $query = $this->db->get("lab_request_files");
        return $query->row_array();
    }


}