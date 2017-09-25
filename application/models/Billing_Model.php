<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

Class Billing_Model extends CI_Model {


    function create($case_id, $user) {

        $data = array(                          
                'case_id'     => $case_id,
                'user'        => $user       
             );
       
           return $this->db->insert('billing', $data);    

    }


    function update($id) {
          $data = array(                          
                'remarks'     => $this->input->post('remarks')                      
             );

           $this->db->where('id', $id);
           return $this->db->update('billing', $data);              
    }


    function update_status($id, $status) {
          $data = array(                          
                'status'     => $status                   
             );

           $this->db->where('id', $id);
           return $this->db->update('billing', $data);              
    }


    function view($id) {
            $this->db->join('patients', 'patients.id = cases.patient_id', 'left');
            $this->db->join('cases', 'cases.id = billing.case_id', 'left');
            $this->db->join('users', 'users.username = billing.user', 'left');
            $this->db->join('billing_payments', 'billing_payments.billing_id = billing.id', 'left');
            $this->db->join('billing_items', 'billing_items.billing_id = billing.id', 'left');
            $this->db->select('
                billing.billing_id,
                billing.remarks,
                billing.status,
                billing.created_at,
                billing.updated_at,
                users.name as user,
                users.username,
                cases.id as case_id,
                cases.title as case_title,
                patients.id as patient_id,
                CONCAT(patients.lastname, ", ", $patients.fullname) as patient_name,
                SUM(billing_payments.amount) as payments,
                SUM((billing_items.amount - billing_items.discount)*billing_items.qty) as payables
            ');
            $this->db->where('billing.id', $id);
            $query = $this->db->get('billing');

            return $query->row_array();
    }



    function fetch_billing($limit, $id, $search, $status) {

            if($search) {
              $this->db->group_start();
              $this->db->like('cases.title', $search);
              $this->db->or_like('patients.fullname', $search);
              $this->db->or_like('patients.lastname', $search);
              $this->db->or_like('patients.middlename', $search);
              $this->db->group_end();
            }

            if($status) {
              $this->db->where('billing.status', $status);
            }  

            $this->db->join('patients', 'patients.id = cases.patient_id', 'left');
            $this->db->join('cases', 'cases.id = billing.case_id', 'left');
            $this->db->join('users', 'users.username = billing.user', 'left');
            $this->db->join('billing_payments', 'billing_payments.billing_id = billing.id', 'left');
            $this->db->join('billing_items', 'billing_items.billing_id = billing.id', 'left');
            $this->db->select('
                billing.billing_id,
                billing.remarks,
                billing.status,
                billing.created_at,
                billing.updated_at,
                users.name as user,
                users.username,
                cases.id as case_id,
                cases.title as case_title,
                patients.id as patient_id,
                CONCAT(patients.lastname, ", ", $patients.fullname) as patient_name,
                SUM(billing_payments.amount) as payments,
                SUM((billing_items.amount - billing_items.discount)*billing_items.qty) as payables
            ');
            
            $this->db->group_by('billing.id');
            $this->db->order_by('billing.created_at', 'DESC');
            $this->db->limit($limit, (($id-1)*$limit));

            $query = $this->db->get("billing");

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            return false;

    }

    /**
     * Returns the total number of rows of users
     * @return int       the total rows
     */
    function count_billing($search, $status) {
            if($search) {
              $this->db->group_start();
              $this->db->like('cases.title', $search);
              $this->db->or_like('patients.fullname', $search);
              $this->db->or_like('patients.lastname', $search);
              $this->db->or_like('patients.middlename', $search);
              $this->db->group_end();
            }

            if($status) {
              $this->db->where('billing.status', $status);
            }   

            $this->db->join('patients', 'patients.id = cases.patient_id', 'left');
            $this->db->join('cases', 'cases.id = billing.case_id', 'left');
            $this->db->group_by('billing.id');

            return $this->db->count_all_results("billing");
    }


    /**
     * Fetches a Billing Record of Case
     * - used for checking an open Billing record
     * @param  [type] $case_id [description]
     * @return [type]          [description]
     */
    function get_Open_Billing($case_id) {

            $this->db->where('case_id', $case_id);
            $this->db->where('status', 0);
            $query = $this->db->get('billing');

            return $query->row_array();
    }






    // BILLING ITEMS ////////////////////////////////////////////////////////////////////////////


    /**
     * Adds an ITEM in the Billing Record
     * @param [type] $item      [description]
     * @param [type] $qty       [description]
     * @param [type] $export_id [description]
     * @param [type] $user      [description]
     */
    function add_item($billing, $service, $qty) {

            $data = array(              
                'billing_id'   => $billing,  
                'service'      => $service,
                'qty'          => $qty            
             );
       
            return $this->db->insert('billing_items', $data);    

    }

    function update_item_qty($billing, $row_id, $qty, $remarks, $discount) {

            //if $qty > 0 - update row 
            if($qty) {
              
              $data = array(              
                'qty'        => $qty,                    
                'remarks'    => $remarks,                    
                'discount'   => $discount                    
             );
            
              $this->db->where('billing_id', $billing);
              $this->db->where('id', $row_id);
              return $this->db->update('billing_items', $data); 

            } else {    
              $this->db->where('id', $row_id);
              $this->db->where('billing_id', $billing);
              return $this->db->delete('billing_items'); 

            }     

    }



    function fetch_billing_items($billing) {

            $this->db->join('services', 'services.title = billing_items.service', 'left');
            $this->db->select('
            services.title,
            services.code,
            services.amount,
            billing_items.qty,
            billing_items.discount
            ');          
           
            $this->db->where('billing_items.billing_id', $billing);
            $query = $this->db->get("billing_items");

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            return false;

    }



    // PAYMENTS ////////////////////////////////////////////////////////////////////////////////////////
    
    function add_payment($billing, $user) {

        $data = array(                          
                'billing_id'     => $billing,
                'user'           => $user,
                'payee'          => $this->input->post('payee'),       
                'amount'         => $this->input->post('amount'),       
                'remarks'        => $this->input->post('remarks'),       
             );
       
           return $this->db->insert('billing_payments', $data);    
    }

    function fetch_billing_payments($billing) {

           
            $this->db->where('billing_id', $billing);
            $query = $this->db->get("billing_payments");

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            return false;

    }



  

}