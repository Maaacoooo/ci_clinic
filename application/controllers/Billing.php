<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Billing extends CI_Controller {

	public function __construct()	{
		parent::__construct();		
       $this->load->model('user_model');
       $this->load->model('services_model');
       $this->load->model('immunization_model');
       $this->load->model('billing_model');
	}	


	public function index()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{

			$data['title'] 		= 'Pending Billing Records';
			$data['site_title'] = APP_NAME;
			$data['user'] 		= $this->user_model->userdetails($userdata['username']); //fetches users record

			//Search
			$search = '';
			if(isset($_GET['search'])) {
				$search = $_GET['search'];
			}

			//Paginated data		            
	   		$config['num_links'] = 5;
			$config['base_url'] = base_url('billing/index');
			$config["total_rows"] = $this->billing_model->count_billing($search, 0);
			$config['per_page'] = 20;		

			$this->load->config('pagination'); //LOAD PAGINATION CONFIG

			$this->pagination->initialize($config);
		    if($this->uri->segment(3)){
		       $page = ($this->uri->segment(3)) ;
		  	}	else 	{
		       $page = 1;		               
		    }

		    $data["results"] = $this->billing_model->fetch_billing($config["per_page"], $page, $search, 0);
		    $str_links = $this->pagination->create_links();
		    $data["links"] = explode('&nbsp;',$str_links );

		    //ITEM NUMBERING
		    $data['per_page'] = $config['per_page'];
		    $data['page'] = $page;

		    //GET TOTAL RESULT
		    $data['total_result'] = $config["total_rows"];
		    //END PAGINATION		

			$this->load->view('billing/list', $data);				
			

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}



	public function create()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id', 'ID', 'trim|required');   
			$this->form_validation->set_rules('immu', 'Service Request', 'trim|required|callback_check_service');   
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'].'#labrequest', 'refresh');

			} else {

				$case_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row	
				$service_id = cleanId($this->input->post('immu')); //gets the service row ID
				$service = $this->services_model->view($service_id, 'immunization')['title'];//sets the service title		

				if($this->immunization_model->create($case_id, $service, $userdata['username'])) {

					$immu_id = $this->db->insert_id(); //fetch last insert labreq Row ID

					// Save Log Data ///////////////////
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'case',
						'tag_id'	=> 	$case_id,
						'action' 	=> 	'Requested an Immunization Service : `'.$this->input->post('immu').'`'
						);

					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'immunization',
						'tag_id'	=> 	$immu_id,
						'action' 	=> 	'Request Created'
						);

			
					//Save log loop
					foreach($log as $lg) {
						$this->logs_model->create_log($lg['user'], $lg['tag'], $lg['tag_id'], $lg['action']);				
					}		
					////////////////////////////////////

					$this->session->set_flashdata('success', 'Immunization Service Request Created!');
					redirect($_SERVER['HTTP_REFERER'].'#immunization', 'refresh');
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}



	function check_service($str) {

		$id = cleanId($str);

		$result = $this->services_model->view($id, 'immunization');

		if($result) {			
			return TRUE;
		} else {
			$this->form_validation->set_message('check_service', 'No Service Found!');			
			return FALSE;
		}
	}


	public function update()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id', 'ID', 'trim|required');   
			$this->form_validation->set_rules('description', 'Description', 'trim');   
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$immu_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row	

				if($this->immunization_model->update($immu_id)) {


					// Save Log Data ///////////////////
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'immunization',
						'tag_id'	=> 	$immu_id,
						'action' 	=> 	'Updated Description'
						);

			
					//Save log loop
					foreach($log as $lg) {
						$this->logs_model->create_log($lg['user'], $lg['tag'], $lg['tag_id'], $lg['action']);				
					}		
					////////////////////////////////////

					$this->session->set_flashdata('success', 'Description / Remarks Updated!');
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}


	public function change_status()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id', 'ID', 'trim|required');   
			$this->form_validation->set_rules('status', 'Status', 'trim|required');   
 
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {
			
				$immu = $this->encryption->decrypt($this->input->post('id')); //ID of the Laboratory Request

				$status = $this->encryption->decrypt($this->input->post('status')); 		

				$case = $this->immunization_model->view($immu, '');

				//proceed action
				if($this->immunization_model->update_status($status, $immu)) {

					//IF Status set to 1 or 'served'
					if($status == 1) {
						$billing = $this->billing_model->get_Open_Billing($case['case_id']); //get current Open Billing 
						$this->billing_model->add_item($billing['id'], $case['service'], 1); //add Service in the current Billing

						// Save Log ///////////////////
						$log[] = array(
							'user' 		=> 	$userdata['username'],
							'tag' 		=> 	'billing',
							'tag_id'	=> 	$billing['id'],
							'action' 	=> 	'Added Service - ' . $case['service']
						);
					}


					// Save Log Data ///////////////////
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'immunization',
						'tag_id'	=> 	$immu,
						'action' 	=> 	'Updated an Immunization Request Status'
					);

					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'case',
						'tag_id'	=> 	$case['case_id'],
						'action' 	=> 	'Updated an Immunization Request Status #'.prettyID($immu).' - '.$case['service']
					);

			
					//Save log loop
					foreach($log as $lg) {
						$this->logs_model->create_log($lg['user'], $lg['tag'], $lg['tag_id'], $lg['action']);				
					}		
					////////////////////////////////////


					$this->session->set_flashdata('success', 'Laboratory Request Status Updated!');
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
					
					
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}



	/**
	 * @return JSON 	the array of results
	 */
	public function autocomplete(){
	    
	    if (isset($_GET['term'])){
	      $q = strtolower($_GET['term']);
	      $result = $this->services_model->search_service($q, 'immunization');

	      foreach($result as $row) {
	      	$new_row['label']=htmlentities(stripslashes($row['title'] . ' - ' . $row['code'] . ' - ' . $row['amount']));
            $new_row['value']=htmlentities(stripslashes('#'. prettyID($row['id']) . ' -- ' . $row['title'] . ' - ' . $row['code']));
            $row_set[] = $new_row; //build an array
          }
          echo json_encode($row_set); //format the array into json data     

	    }
	    
	  }




}
