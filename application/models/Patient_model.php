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
                'sex'           => $this->input->post('sex')             
             );
       
            return $this->db->insert('patients', $data);      

    }



    function update_patient($id) {

      
            $data = array(              
                'fullname'      => $this->input->post('fname'),  
                'middlename'    => $this->input->post('mname'),  
                'lastname'      => $this->input->post('lname'),                 
                'birthdate'     => $this->input->post('bdate'),  
                'sex'           => $this->input->post('sex')          
             );
            
            $this->db->where('id', $id);
            return $this->db->update('patients', $data);      

    }

    /**
     * Updates the UPDATED_AT stamp
     * @param  int $id    patient ID
     * @return [type]     [description]
     */
    function last_update($id) {

      
            $data = array(              
                'updated_at'      => unix_to_human(now(), TRUE, 'eu')      
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
            $this->db->join('patients_address', 'patients_address.patient_id = patients.id', 'left');
            $this->db->group_by('patients.id');
            $this->db->select('
              patients.id,
              patients.fullname,
              patients.middlename,
              patients.lastname,
              patients.sex,
              patients.birthdate,
              CONCAT(patients_address.city, ", ", patients_address.province) AS address,
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




    ///////////////////////////////////////////////
    /// CONTACTS AND ADDRESS
    //////////////////////////////////////////////
    

    /**
     * Inserts a Patient Address Record
     * @param  int        $patient_id     
     * @param  String     $tag        
     * @param  String     $bldg       
     * @param  String     $street     
     * @param  String     $brgy       
     * @param  String     $city       
     * @param  String     $prov       
     * @param  String     $zip        
     * @param  String     $ctry       
     * @return Boolean                returns TRUE if success
     */
    function create_address($patient_id, $tag, $bldg, $street, $brgy, $city, $prov, $zip, $ctry) {

          $data = array(
            'patient_id' => $patient_id,
            'tag'        => $tag,
            'building'   => $bldg,
            'street'     => $street,
            'barangay'   => $brgy,
            'city'       => $city,
            'province'   => $prov,
            'zip'        => $zip,
            'country'    => $ctry
            );

          return $this->db->insert('patients_address', $data);

    }


    function update_address($id) {

          $data = array(
            'building'   => $this->input->post('bldg'),
            'street'     => $this->input->post('strt'),
            'barangay'   => $this->input->post('brgy'),
            'city'       => $this->input->post('city'),
            'province'   => $this->input->post('province'),
            'zip'        => $this->input->post('zip'),
            'country'    => $this->input->post('country')
            );

          $this->db->where('id', $id);
          return $this->db->update('patients_address', $data);

    }


    function create_contacts($patient_id, $tag, $details) {

      $data = array(
            'patient_id' => $patient_id,
            'tag'        => $tag,
            'details'   => $details           
            );

          return $this->db->insert('patients_contacts', $data);

    }

    function fetch_address($patient_id, $tag) {

            $this->db->select('*');        
            $this->db->where('patient_id', $patient_id);          
            $this->db->where('tag', $tag);          
            
            $query = $this->db->get('patients_address');

            return $query->row_array();
    }


    function fetch_contacts($patient_id, $tag) {

            $this->db->select('*');        
            $this->db->where('patient_id', $patient_id);          
            $this->db->where('tag', $tag);          
            
            $query = $this->db->get('patients_contacts');

            return $query->result_array();
    }


    function delete_contact($id) {
           
            $this->db->where('id', $id);
            return $this->db->delete('patients_contacts');      

    }



}