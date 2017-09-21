<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Notes_model extends CI_Model
{


    function create($tag, $tag_id, $user, $desc) {

      
            $data = array(              
                'description'   => $desc,                                 
                'tag'           => $tag,                                     
                'tag_id'        => $tag_id,                                     
                'user'          => $user                                   
             );
       
            return $this->db->insert('notes', $data);      

    }


    function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('notes');
    }

    function fetch_notes($tag, $tag_id) {

            $this->db->where('tag', $tag);
            $this->db->where('tag_id', $tag_id);
       
            $query = $this->db->get("notes");

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }


            return false;

    }


}