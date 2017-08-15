<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Prescription_model extends CI_Model
{


    function create_prescription($case_id, $user) {

      
            $data = array(              
                'case_id'        => $case_id,  
                'title'          => $this->input->post('title'),  
                'description'    => $this->input->post('description'),
                'created_by'     => $user                          
             );
       
            return $this->db->insert('prescription', $data);      

    }


    function update_prescription($id) {

      
            $data = array(              
                'title'          => $this->input->post('title'),  
                'description'    => $this->input->post('description')                
             );
            
            $this->db->where('id', $id);
            return $this->db->update('prescription', $data);      

    }


    /**
     * This adds the items in the Prescription
     * @param   int         $prescription_id      ID of Row
     * @return  boolean                           returns TRUE if success. like. duh
     */
    function add_item($prescription_id) {

      
            $data = array(              
                'prescription_id'    => $prescription_id,  
                'item'               => $this->input->post('item'),
                'qty'                => 1                         
             );
       
            return $this->db->insert('prescription_items', $data);      

    }

    /**
     * This updates the qty of the item
     * @param  String   $item               the title of the item
     * @param  int      $prescription_id    the prescription ID
     * @param  Double   $qty                qty
     * @return Boolean                      returns TRUE if success
     */
    function update_item_qty($item, $prescription_id, $qty) {

      
            $data = array(              
                'qty'    => $qty                    
             );
            
            $this->db->where('item', $item);
            $this->db->where('prescription_id', $prescription_id);
            return $this->db->update('prescription_items', $data);      

    }


    /**
     * [update_item description]
     * @return [type] [description]
     */
    function update_items() {
        foreach ($this->input->post('id') as $key => $id) {

            if($this->input->post('qty')[$key]) {
               //update 
               $data = array(              
                'item'      => $this->input->post('item')[$key],  
                'qty'       => $this->input->post('qty')[$key],  
                'remark'    => $this->input->post('remark')[$key]             
             );
            
                $this->db->where('id', $this->encryption->decrypt($id));
                $this->db->update('prescription_items', $data);   
            } else {
                //delete
                $this->db->delete('prescription_items', array('id' => $this->encryption->decrypt($id)));                 
            }            
        }

        return TRUE;
    }


    function view_item($item, $prescription_id) {

            $this->db->select('*');        
            $this->db->where('item', $item);
            $this->db->where('prescription_id', $prescription_id);         
            $this->db->limit(1);

            $query = $this->db->get('prescription_items');

            return $query->row_array();
    }


    /**
     * Returns the prescriptions of a specific case
     * @param  int            $case_id     the ID of the case
     * @return String Array                the result of rows
     */
    function fetch_case_prescription($case_id) {

            $this->db->where('case_id', $case_id);
            $this->db->order_by('created_at', 'DESC');
            $query = $this->db->get("prescription");

            return $query->result_array();
          
    }


    

    /**
     * Returns the row of a `case`
     * @param   int         $id         Row ID
     * @param   int         $case_id    Case_ID
     * @return  String[]                [description]
     */
    function view_prescription($id, $case_id) {

            $this->db->select('*');        
            $this->db->where('id', $id);
            $this->db->where('case_id', $case_id);          
            $this->db->limit(1);

            $query = $this->db->get('prescription');

            return $query->row_array();
    }

    /**
     * The Prescription items 
     * @param  [type] $prescription_id [description]
     * @return [type]                  [description]
     */
    function fetch_prescription_items($prescription_id) {

            $this->db->where('prescription_id', $prescription_id);
            $query = $this->db->get("prescription_items");

            return $query->result_array();
          
    }


    /**
     * Used by Autocomplete
     * @param  String       $q      the search parameter
     * @return String[]             the result
     */
    function search_items($q){
      
            $this->db->like('title', $q);
            $this->db->limit(15);
            $query = $this->db->get('items');
            
            return $query->result_array();
  }


  /**
   * This is used to check if the item already exist in the prescription items table
   * @param  int        $prescription_id    the ID of the prescription
   * @param  String     $item               the title of the item
   * @return Boolean                        returns TRUE if item exist
   */
  function check_item($prescription_id, $item) {

             $this->db->select('*');        
             $this->db->where('item', $item);          
             $this->db->where('prescription_id', $prescription_id);          
             $this->db->limit(1);

             $query = $this->db->get('prescription_items');

             if($query->num_rows() == 1)   {

                return TRUE;              
               
             }   else   {

                return FALSE;

             }

  }


  /**
   * Used by callback; potentially checks if ITEM has a duplicate
   * @param  String         $item    the Item name
   * @return Boolean                 returns TRUE if item exist
   */
  function check_item_stack($item) {

             $this->db->select('*');        
             $this->db->where('title', $item);          
             $this->db->limit(1);

             $query = $this->db->get('items');

             if($query->num_rows() == 1)   {

                return TRUE;              
               
             }   else   {

                return FALSE;

             }

  }

/**
 * Used by callback; adds an item in the suggestion
 * @param String        $item       the title of the item
 * @return Boolean                  returns TRUE if success
 */
   function add_item_stack($item) {

      
            $data = array(              
                'title'    => $item                              
             );
       
            return $this->db->insert('items', $data);      

    }





}