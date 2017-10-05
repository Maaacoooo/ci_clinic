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
           $this->db->join('billing_items', 'billing_items.billing_id = billing.id', 'left');
           $this->db->join('cases', 'cases.id = billing.case_id', 'left');
           $this->db->join('users', 'users.username = billing.user', 'left');
           $this->db->join('patients', 'patients.id = cases.patient_id', 'left'); 
           $this->db->select('
                billing.id,
                billing.status,
                billing.created_at,
                billing.updated_at,
                billing.remarks,
                cases.id as case_id,
                cases.title as case_title,
                patients.id as patient_id,
                CONCAT(patients.lastname, ", ", patients.fullname) as patient_name,
                SUM(billing_items.qty * billing_items.amount ) as payables,
                SUM(billing_items.qty * billing_items.discount ) as discounts,
                users.name as user,
                users.username as username,
            ');
            $this->db->where('billing.id', $id);
            $query1 = $this->db->get("billing");
            $q1 = $query1->row_array();

              $this->db->select_sum('amount', 'payments');
              $this->db->where('billing_id', $q1['id']);
              $query2 = $this->db->get('billing_payments');

              $bill['id'] = $q1['id'];
              $bill['status'] = $q1['status'];
              $bill['remarks'] = $q1['remarks'];
              $bill['created_at'] = $q1['created_at'];
              $bill['updated_at'] = $q1['updated_at'];
              $bill['case_id'] = $q1['case_id'];
              $bill['case_title'] = $q1['case_title'];
              $bill['patient_id'] = $q1['patient_id'];
              $bill['patient_name'] = $q1['patient_name'];
              $bill['payables'] = $q1['payables'];
              $bill['discounts'] = $q1['discounts'];
              $bill['user']  = $q1['user'];
              $bill['payments'] = $query2->row_array()['payments'];
            
            return $bill;
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

            if(!is_null($status)) {
              $this->db->where('billing.status', $status);
            }  
            $this->db->group_by('billing.id');

           $this->db->join('billing_items', 'billing_items.billing_id = billing.id', 'left');
           $this->db->join('cases', 'cases.id = billing.case_id', 'left');
           $this->db->join('patients', 'patients.id = cases.patient_id', 'left'); 
           $this->db->select('
                billing.id as billing_id,
                billing.status,
                billing.created_at,
                billing.updated_at,
                cases.id as case_id,
                cases.title as case_title,
                patients.id as patient_id,
                CONCAT(patients.lastname, ", ", patients.fullname) as patient_name,
                SUM(billing_items.qty * billing_items.discount ) as discounts,
                SUM(billing_items.qty * billing_items.amount) as payables
            ');

            $this->db->order_by('billing.created_at', 'DESC');
            $this->db->limit($limit, (($id-1)*$limit));

            $query1 = $this->db->get("billing");
            $q1 = $query1->result_array();

            foreach ($q1 as $row) {
              $this->db->select_sum('amount', 'payments');
              $this->db->where('billing_id', $row['billing_id']);
              $query2 = $this->db->get('billing_payments');

              $bill['billing_id'] = $row['billing_id'];
              $bill['status'] = $row['status'];
              $bill['created_at'] = $row['created_at'];
              $bill['updated_at'] = $row['updated_at'];
              $bill['case_id'] = $row['case_id'];
              $bill['case_title'] = $row['case_title'];
              $bill['patient_id'] = $row['patient_id'];
              $bill['patient_name'] = $row['patient_name'];
              $bill['payables'] = $row['payables'];
              $bill['discounts'] = $row['discounts'];

              $bill['payments'] = $query2->row_array()['payments'];
              $bill_arr[] = $bill;
            }

            return $bill_arr;

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

            if(!is_null($status)) {
              $this->db->where('billing.status', $status);
            }   

            $this->db->join('cases', 'cases.id = billing.case_id', 'left');
            $this->db->join('patients', 'patients.id = cases.patient_id', 'left');

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


    function fetch_billing_records($case_id, $patient_id, $status) {

            $this->db->join('cases', 'cases.id = billing.case_id', 'left');
            $this->db->join('patients', 'patients.id = cases.patient_id', 'left');            
            $this->db->join('billing_payments', 'billing_payments.billing_id = billing.id', 'left');
            $this->db->select('
                billing.id,
                billing.status,
                billing.created_at,
                billing.updated_at,
                cases.id as case_id,
                cases.title as case_title,
                "test" as payables,
                SUM(billing_payments.amount) as payments
            ');

            if(!is_null($case_id)) {
                $this->db->where('billing.case_id', $case_id);           
            }

            if(!is_null($patient_id)) {
                $this->db->where('patients.id', $patient_id);
            }

            if(!is_null($status)) {
                $this->db->where('billing.status', $status);
            }

            $this->db->group_by('billing.id');
            $this->db->where('billing.is_deleted', 0);

            $query = $this->db->get("billing");

            log_message('error', $this->db->last_query());
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }

            return false;

    }







    // BILLING ITEMS ////////////////////////////////////////////////////////////////////////////


    /**
     * Adds an ITEM in the Billing Record
     * @param [type] $item      [description]
     * @param [type] $qty       [description]
     * @param [type] $export_id [description]
     * @param [type] $user      [description]
     */
    function add_item($billing, $service, $qty, $amount, $remarks) {

            $data = array(              
                'billing_id'   => $billing,  
                'service'      => $service,
                'amount'       => $amount,
                'qty'          => $qty,            
                'remarks'      => $remarks            
             );
       
            return $this->db->insert('billing_items', $data);    

    }

    function update_item_qty($billing, $row_id, $remarks, $discount) {

            $disc = array(                                               
                'discount'   => $discount                    
             );
            
            $this->db->where('billing_id', $billing);
            $this->db->where('id', $row_id);
            $this->db->update('billing_items', $disc); 

            

            return TRUE;

    }



    function fetch_billing_items($billing) {

            $this->db->join('services', 'services.title = billing_items.service', 'left');
            $this->db->select('
            billing_items.id,
            services.title,
            services.code,
            services.service_cat,
            billing_items.amount,
            billing_items.qty,
            billing_items.discount,
            billing_items.remarks
            ');          
            $this->db->order_by('services.service_cat', "ASC");
            $this->db->where('billing_items.billing_id', $billing);
            $query = $this->db->get("billing_items");

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            return false;

    }



    // PAYMENTS ////////////////////////////////////////////////////////////////////////////////////////
    
    function add_payment($billing, $balance, $user) {

        $data = array(                          
                'billing_id'     => $billing,
                'user'           => $user,
                'payee'          => $this->input->post('payee'),       
                'balance'        => $balance,       
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

    function view_payment($id, $billing_id) {
            $this->db->join('users', 'users.username = billing_payments.user', 'left');
            $this->db->select('
              billing_payments.id,
              billing_payments.payee,
              billing_payments.amount,
              billing_payments.balance,
              billing_payments.remarks,
              billing_payments.created_at,
              users.username as username,
              users.name as user
              ');           
            $this->db->where('id', $id);
            $this->db->where('billing_id', $billing_id);
            $query = $this->db->get("billing_payments");

    
            return $query->row_array();
           
    }



  

}