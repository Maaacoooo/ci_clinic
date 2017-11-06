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
       
            $this->db->insert('cases', $data);      
            $case_id = $this->db->insert_id();

            //Process Image Upload
              if($_FILES['img']['name'] != NULL)  {     

                //Create Upload Path 
                //Create main path for patient
                if(!is_dir('./uploads/patients')) {
                    mkdir('./uploads/patients');
                }
                //Create main path for patient account
                if(!is_dir('./uploads/patients/'.$patient_id)) {
                    mkdir('./uploads/patients/'.$patient_id);
                }
                //Create main path for case
                if(!is_dir('./uploads/patients/'.$patient_id.'/case')) {
                    mkdir('./uploads/patients/'.$patient_id.'/case');
                }
                //Create path for distinct case
                $path = './uploads/patients/'.$patient_id.'/case/'.$case_id;
                if(!is_dir($path)) {
                    mkdir($path);
                }

                //Upload 
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'gif|jpg|png'; 
                $config['encrypt_name'] = TRUE;                        

                $this->load->library('upload', $config);
                $this->upload->initialize($config);         
                
                $field_name = "img";
                $this->upload->do_upload($field_name);
                $data2 = array('upload_data' => $this->upload->data());
                foreach ($data2 as $key => $value) {     
                  $filename = $value['file_name'];
                }

                //Save to database
                $this->db->update('cases', array('img' => $filename), array('id' => $case_id));
                
            }

            return $case_id;

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


     /**
     * Returns the paginated array of rows 
     * @param  int      $limit      The limit of the results; defined at the controller
     * @param  int      $id         the Page ID of the request. 
     * @return Array        The array of returned rows 
     */
    function fetch_pending_cases($limit, $id, $search) {
      
          if ($search) {
            $this->db->group_start();
            $this->db->like('patients.lastname', $search);
            $this->db->or_like('patients.fullname', $search);
            $this->db->or_like('title', $search);
            $this->db->group_end();
          }

            $this->db->select('
            patients.id as patient_id,
            CONCAT(patients.fullname, " ", patients.lastname) as patient_name,
            cases.id as case_id,
            cases.title,
            cases.status,
            cases.created_at
                ');
            $this->db->join('patients', 'patients.id = cases.patient_id', 'left');
            $this->db->order_by('cases.created_at', 'ASC');
            $this->db->where('cases.status', 0);
            $this->db->limit($limit, (($id-1)*$limit));           
            $query = $this->db->get("cases");

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }


            return false;

    }

    /**
     * Returns the total number of rows of users
     * @return int       the total rows
     */
    function count_pending_cases($search) {

      if($search) {
        $this->db->group_start();
        $this->db->like('patients.lastname', $search);
        $this->db->or_like('patients.fullname', $search);
        $this->db->or_like('title', $search);
        $this->db->group_end();
      }
        $this->db->join('patients', 'patients.id = cases.patient_id', 'left');
        $this->db->where('status', 0);
        return $this->db->count_all_results("cases");
    }

}