<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Patient_model extends CI_Model
{

    function create_patient() {

        /*

            $filename = ''; //img filename empty if not present

            //Process Image Upload
              if($_FILES['img']['name'] != NULL)  {        

                $config['upload_path'] = './uploads/';
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
                
            } */
      
            $data = array(              
                'fullname'      => $this->input->post('fname'),  
                'middlename'    => $this->input->post('mname'),  
                'lastname'      => $this->input->post('lname'),                 
                'birthdate'     => $this->input->post('bdate'),   
                'birthplace'    => $this->input->post('bplace'),                 
                'sex'           => $this->input->post('sex'),                 
                'address'       => $this->input->post('addr'),                 
                'contact_no'    => $this->input->post('contactno'),                 
                'email'         => $this->input->post('email'),                 
                'remarks'       => $this->input->post('remarks')               
             );
       
            return $this->db->insert('patients', $data);      

    }

    function update_patient($id) {

      
            $data = array(              
                'fullname'      => $this->input->post('fname'),  
                'middlename'    => $this->input->post('mname'),  
                'lastname'      => $this->input->post('lname'),                 
                'birthdate'     => $this->input->post('bdate'),   
                'birthplace'    => $this->input->post('bplace'),                 
                'sex'           => $this->input->post('sex'),                 
                'address'       => $this->input->post('addr'),                 
                'contact_no'    => $this->input->post('contactno'),                 
                'email'         => $this->input->post('email'),                 
                'remarks'       => $this->input->post('remarks')               
             );
            
            $this->db->where('id', $id);
            return $this->db->update('patients', $data);      

    }

    function delete_patient($id) {

          $data = array(                   
                'is_deleted'  => 1               
             );
            
            $this->db->where('id', $id);
            return $this->db->update('patients', $data);      

    }


    function view_patient($id) {

            $this->db->select('*');        
            $this->db->where('id', $id);          
            $this->db->limit(1);

            $query = $this->db->get('patients');

            return $query->row_array();
    }

    function search_patients($q){
      
            $this->db->like('fullname', $q);
            $this->db->or_like('lastname', $q);
            $this->db->limit(15);
            $query = $this->db->get('patients');
            
            return $query->result_array();
  }

    /**
     * Returns the paginated array of rows 
     * @param  int      $limit      The limit of the results; defined at the controller
     * @param  int      $id         the Page ID of the request. 
     * @return Array        The array of returned rows 
     */
    function fetch_patients($limit, $id) {

            $this->db->limit($limit, (($id-1)*$limit));
            $this->db->where('patients.is_deleted', 0);
            $this->db->join('cases', 'cases.patient_id = patients.id', 'left');
            $this->db->group_by('patients.id');
            $this->db->select('
              patients.id,
              patients.fullname,
              patients.middlename,
              patients.lastname,
              patients.sex,
              patients.birthdate,
              patients.address,
              patients.contact_no,
              count(cases.id) as cases
              ');
            $query = $this->db->get("patients");

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            return false;

    }

    /**
     * Returns the total number of rows of users
     * @return int       the total rows
     */
    function count_patients() {
        $this->db->where('is_deleted', 0);
        return $this->db->count_all_results("patients");
    }


//////////////////////////////////////////////////
/// CASES                                       //
//////////////////////////////////////////////////

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