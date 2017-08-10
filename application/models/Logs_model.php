<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Logs Model
 *
 * This is a general log model. 
 * This should be autoloaded.
 */
Class Logs_model extends CI_Model
{

    /**
     * Inserting a Log
     * @param  String       $user       The user
     * @param  String       $tag        The table of module
     * @param  String       $tag_id     The row ID of record
     * @param  String       $action     The action of the User
     * @return Boolean                  returns TRUE if success
     */
    function create_log($user, $tag, $tag_id, $action) {

      
            $data = array(              
                'user'     => $user,  
                'tag'      => $tag,  
                'tag_id'   => $tag_id,                 
                'action'   => $action                         
             );
       
            return $this->db->insert('logs', $data);      

    }


    /**
     * Fetching Logs by Request
     * @param  String           $tag        The table of request / module
     * @param  String           $tag_id     The row ID of record
     * @param  String           $limit      The Limit of Request
     * @return String Array                 The result array 
     */
    function fetch_logs($tag, $tag_id, $limit) {

            if($limit) {
                $this->db->limit($limit);
            }

            $this->db->where('tag', $tag);
            $this->db->where('tag_id', $tag_id);
            $this->db->order_by('date_time', 'DESC');

            $query = $this->db->get("logs");

            return $query->result_array();
          
    }




}