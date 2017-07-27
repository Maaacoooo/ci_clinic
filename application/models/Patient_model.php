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
                'address'       => $this->input->post('addr'),                 
                'contact_no'    => $this->input->post('contactno'),                 
                'email'         => $this->input->post('email'),                 
                'remarks'       => $this->input->post('remarks')               
             );
       
            return $this->db->insert('patients', $data);      

    }


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
     * Updates a user record
     * @param  int      $id    the DECODED id of the item. 
     * @return void            returns TRUE if success
     */
    function update_user($user) { 

            $filename = $this->userdetails($user)['img']; //gets the old data 

            //Process Image Upload
              if($_FILES['img']['name'] != NULL)  { 


                //Deletes the old photo
                if(!filexist($filename)) {
                  unlink('./uploads/'.$filename); 
                }

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
                
            }
      
            $data = array(           
                'name'      => $this->input->post('name'),  
                'usertype'  => $this->input->post('usertype'),                 
                'img'       => $filename  
             );
            
            $this->db->where('username', $user);
            return $this->db->update('users', $data);          
        
    }


        /**
     * Deletes a user record
     * @param  int    $id    the DECODED id of the item.   
     * @return boolean    returns TRUE if success
     */
    function delete_user($user) {

        $filename = $this->userdetails($user)['img'];

        //Deletes the old photo
        if(!filexist($filename)) {
          unlink('./uploads/'.$filename); 
        }

        return $this->db->delete('users', array('username' => $user)); 

    }


    /**
     * Returns the paginated array of rows 
     * @param  int      $limit      The limit of the results; defined at the controller
     * @param  int      $id         the Page ID of the request. 
     * @return Array        The array of returned rows 
     */
    function fetch_patients($limit, $id) {

            $this->db->limit($limit, (($id-1)*$limit));

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
        return $this->db->count_all("patients");
    }

  



}