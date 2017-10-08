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

    function update_status($status, $id) {

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
            lab_request.pathologist,
            lab_request.medtech,
            lab_request.report_no,
            services.id,
            services.code,
            services.amount,
            services.is_constant,
            patients.id as patient_id,
            users.name as requestor    
            ');
            $this->db->join('services', 'services.title = lab_request.service', 'left');            
            $this->db->join('cases', 'cases.id = lab_request.case_id', 'left');            
            $this->db->join('patients', 'patients.id = cases.patient_id', 'left');            
            $this->db->join('users', 'users.username = lab_request.user', 'left');            

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


     function fetch_labreq($limit, $id, $search, $status) {

            if($search) {
              $this->db->group_start();
              $this->db->like('cases.title', $search);
              $this->db->or_like('lab_request.service', $search);
              $this->db->or_like('patients.fullname', $search);
              $this->db->or_like('patients.lastname', $search);
              $this->db->or_like('patients.middlename', $search);
              $this->db->group_end();
            }

            $this->db->where('lab_request.status', $status);              

            $this->db->join('cases', 'cases.id = lab_request.case_id', 'left');
            $this->db->join('patients', 'patients.id = cases.patient_id', 'left');            
            $this->db->join('users', 'users.username = lab_request.user', 'left');
            $this->db->select('
                lab_request.id,
                lab_request.service,
                lab_request.status,
                lab_request.created_at,
                lab_request.updated_at,
                users.name as user,
                users.username,
                cases.id as case_id,
                cases.title as case_title,
                patients.id as patient_id,
                CONCAT(patients.lastname, ", ", patients.fullname) as patient_name
            ');
            
            $this->db->group_by('lab_request.id');
            $this->db->order_by('lab_request.created_at', 'DESC');
            $this->db->limit($limit, (($id-1)*$limit));

            $query = $this->db->get("lab_request");

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            return false;

    }

    /**
     * Returns the total number of rows of users
     * @return int       the total rows
     */
    function count_labreq($search, $status) {
        
            if($search) {
              $this->db->group_start();
              $this->db->like('cases.title', $search);
              $this->db->or_like('lab_request.service', $search);
              $this->db->or_like('patients.fullname', $search);
              $this->db->or_like('patients.lastname', $search);
              $this->db->or_like('patients.middlename', $search);
              $this->db->group_end();
            }

            $this->db->where('lab_request.status', $status);

            $this->db->join('cases', 'cases.id = lab_request.case_id', 'left');
            $this->db->join('patients', 'patients.id = cases.patient_id', 'left');
            $this->db->join('users', 'users.username = lab_request.user', 'left');            

            return $this->db->count_all_results("lab_request"); 

    
    }

    // LAB REPORTS ///////////////////////////////////////////////////////
    
    function fetch_lab_report($labreq_id) {
        
        $labreq = $this->view($labreq_id, ''); //gets the Lab Request information

        $this->db->select('
            service_examinations.id as exam_id,
            service_examinations.title,
            service_examinations.normal_values
        ');        
        $this->db->where('service_examinations.service', $labreq['service']);
        $query_exams = $this->db->get('service_examinations');

        $dataset = NULL;
        foreach($query_exams->result_array() as $exams) {

            //gets service_examnizations
            $result['title'] = $exams['title'];
            $result['normal_values'] = $exams['normal_values'];
            $result['exam_id'] = $exams['exam_id'];

            //gets the result of the examinations
            $this->db->where('labreq_id', $labreq_id);
            $this->db->where('exam_id', $exams['exam_id']);
            $query_value = $this->db->get('lab_report_values');

            $result['value']    = $query_value->row_array()['value'];
            $result['id']       = $query_value->row_array()['id'];

            //Compile result
            $dataset[] = $result;
        }

        if($dataset) {
           return $dataset; 
        } else {
            return FALSE;
        } 
        

    }

    function update_lab_report($labreq_id) {

            $data = array(                             
                'report_no'     => $this->input->post('report_no'),                       
                'medtech'       => $this->input->post('medtech'),                       
                'pathologist'   => $this->input->post('patho')                       
             );

            $this->db->where('id', $labreq_id);
            $this->db->update('lab_request', $data);

            //Loop the input_result
            $exam_id = $this->input->post('exam_id');
            foreach ($exam_id as $key => $value) {

                $exam_id = $this->encryption->decrypt($value);  //override variable
                $val_id  = $this->encryption->decrypt($this->input->post('val_id')[$key]);

                if($val_id) {
                    //update row 
                    $data = array(                                              
                        'value'   => $this->input->post('value')[$key]                       
                     );
                    $this->db->where('id', $val_id);
                    $this->db->update('lab_report_values', $data);
                } else {
                    //add new data
                    $data = array(                             
                        'exam_id'   => $exam_id,                       
                        'labreq_id' => $labreq_id,                       
                        'value'     => $this->input->post('value')[$key]                       
                     );
                    $this->db->insert('lab_report_values', $data);
                }
                
            }

            return TRUE;
    }   


    //////////////////////////////////////////////////////////////////////


    // LAB REQUEST FILES /////////////////////////////////////////////////


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