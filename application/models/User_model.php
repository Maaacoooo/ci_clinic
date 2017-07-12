<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Copyright (c)2017, Jenmar "Maco" Cortes
 * Copyright TechDepot PH
 * All Rights Reserved
 * 
 * This license is a legal agreement between you and the Maco Cortes
 * for the use of STI Online Voting Systen referred to as the "Software"
 * By obtaining the Software you agree to comply with the terms and conditions of this license.
 *
 * PERMITTED USE
 * With approval from Maco Cortes, You are permitted to use the program for educational purposes only.
 * 
 * MODIFICATION AND REDISTRIBUTION 
 * Unless with written approval obtained from Maco Cortes, 
 * You are NOT allowed to modify, copy, redistribute, and sell the Software.
 *
 * For any concerns, you may reach Maco Cortes via:
 * maco.techdepot@gmail.com
 * facebook.com/Maaacoooo
 * maco@techdepot-ph.com
 * TechDepot-PH.com
 */

Class User_model extends CI_Model
{

/**
 * This model controls all VOTE  related functionalties
 */

     function check_user($user, $pass) {

             $this->db->select('*');        
             $this->db->where('username', $user);          
             $this->db->limit(1);

             $query = $this->db->get('users');

             if($query->num_rows() == 1)   { //checks if username exists

                $result = $query->row_array(); //fetch the row array

                if(password_verify($pass, $result['password'])) {
                    return $result;
                } else {
                    return FALSE;
                }
                
               
             }   else   {

                return FALSE;

             }

    }

    /**
     * Fetches the User Records
     * @param  String       $user     the username
     * @return String Array           the array of row 
     */
    function userdetails($user) {

             $this->db->select('*');        
             $this->db->where('username', $user);          
             $this->db->limit(1);

             $query = $this->db->get('users');

             return $query->row_array();
    }


    function create_user() {

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
                
            }
      
            $data = array(              
                'username'  => $this->input->post('username'),  
                'password'  => password_hash('STIDipolog', PASSWORD_DEFAULT),  //Default Password
                'name'      => $this->input->post('name'),  
                'usertype'  => $this->input->post('usertype'),                 
                'img'       => $filename  
             );
       
            return $this->db->insert('users', $data);      

    }

    function reset_password($user) {

        $data = array(            
                'password'  => password_hash('STIDipolog', PASSWORD_DEFAULT)  //Default Password
             );
            $this->db->where('username', $user);            
            
            return $this->db->update('users', $data);   
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
    function fetch_users($limit, $id) {

            $this->db->limit($limit, (($id-1)*$limit));

            $query = $this->db->get("users");

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            return false;

    }

    /**
     * Returns the total number of rows of users
     * @return int       the total rows
     */
    function count_users() {
        return $this->db->count_all("users");
    }

    ////////////////////////////////
    /// HELPER                    //
    ////////////////////////////////
   

    function usertypes() {

            $this->db->select('*');
            $query = $this->db->get('usertypes');

            return $query->result_array();

    }



}