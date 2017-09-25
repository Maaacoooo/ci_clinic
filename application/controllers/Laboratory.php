<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laboratory extends CI_Controller {

	public function __construct()	{
		parent::__construct();		
       $this->load->model('user_model');
       $this->load->model('services_model');
       $this->load->model('laboratory_model');
       $this->load->model('billing_model');
	}	


	public function index()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{

			$data['title'] 		= 'Pending Laboratory Requests';
			$data['site_title'] = APP_NAME;
			$data['user'] 		= $this->user_model->userdetails($userdata['username']); //fetches users record

			//Search
			$search = '';
			if(isset($_GET['search'])) {
				$search = $_GET['search'];
			}

			//Paginated data		            
	   		$config['num_links'] = 5;
			$config['base_url'] = base_url('laboratory/index');
			$config["total_rows"] = $this->laboratory_model->count_labreq($search, 0);
			$config['per_page'] = 20;		

			$this->load->config('pagination'); //LOAD PAGINATION CONFIG

			$this->pagination->initialize($config);
		    if($this->uri->segment(3)){
		       $page = ($this->uri->segment(3)) ;
		  	}	else 	{
		       $page = 1;		               
		    }

		    $data["results"] = $this->laboratory_model->fetch_labreq($config["per_page"], $page, $search, 0);
		    $str_links = $this->pagination->create_links();
		    $data["links"] = explode('&nbsp;',$str_links );

		    //ITEM NUMBERING
		    $data['per_page'] = $config['per_page'];
		    $data['page'] = $page;

		    //GET TOTAL RESULT
		    $data['total_result'] = $config["total_rows"];
		    //END PAGINATION		

			$this->load->view('laboratory/list', $data);				
			

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
			$this->form_validation->set_rules('labreq', 'Service Request', 'trim|required|callback_check_service');   
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'].'#labrequest', 'refresh');

			} else {

				$case_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row	
				$service_id = cleanId($this->input->post('labreq')); //gets the service row ID
				$service = $this->services_model->view($service_id, 'laboratory')['title'];//sets the service title		

				if($this->laboratory_model->create($case_id, $service, $userdata['username'])) {

					$labreq_id = $this->db->insert_id(); //fetch last insert labreq Row ID

					// Save Log Data ///////////////////
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'case',
						'tag_id'	=> 	$case_id,
						'action' 	=> 	'Requested a Laboratory Service : `'.$this->input->post('labreq').'`'
						);

					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'laboratory',
						'tag_id'	=> 	$labreq_id,
						'action' 	=> 	'Request Created'
						);

			
					//Save log loop
					foreach($log as $lg) {
						$this->logs_model->create_log($lg['user'], $lg['tag'], $lg['tag_id'], $lg['action']);				
					}		
					////////////////////////////////////

					$this->session->set_flashdata('success', 'Laboratory Service Request Created!');
					redirect($_SERVER['HTTP_REFERER'].'#labrequest', 'refresh');
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}



	function check_service($str) {

		$id = cleanId($str);

		$result = $this->services_model->view($id, 'laboratory');

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

				$labreq_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row	

				if($this->laboratory_model->update($labreq_id)) {


					// Save Log Data ///////////////////
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'laboratory',
						'tag_id'	=> 	$labreq_id,
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
			
				$labreq_id = $this->encryption->decrypt($this->input->post('id')); //ID of the Laboratory Request

				$status = $this->encryption->decrypt($this->input->post('status')); 		

				$case = $this->laboratory_model->view($labreq_id, '');

				//proceed action
				if($this->laboratory_model->update_status($status, $labreq_id)) {

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
						'tag' 		=> 	'laboratory',
						'tag_id'	=> 	$labreq_id,
						'action' 	=> 	'Updated a Laboratory Request Status'
					);

					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'case',
						'tag_id'	=> 	$case['case_id'],
						'action' 	=> 	'Updated a Laboratory Request Status #'.prettyID($labreq_id).' - '.$case['service']
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


	public function attach_result()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id', 'ID', 'trim|required');   
			$this->form_validation->set_rules('title', 'Title', 'trim|required');   
			$this->form_validation->set_rules('description', 'Description', 'trim');   
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$labreq_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row	

				if($this->laboratory_model->create_file($labreq_id, $userdata['username'])) {


					// Save Log Data ///////////////////
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'laboratory',
						'tag_id'	=> 	$labreq_id,
						'action' 	=> 	'Attached a Result : `'.$this->input->post('title').'`'
						);

			
					//Save log loop
					foreach($log as $lg) {
						$this->logs_model->create_log($lg['user'], $lg['tag'], $lg['tag_id'], $lg['action']);				
					}		
					////////////////////////////////////

					$this->session->set_flashdata('success', 'Result Attached!');
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}


	public function update_result()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id', 'ID', 'trim|required');   
			$this->form_validation->set_rules('title', 'Title', 'trim|required');   
			$this->form_validation->set_rules('description', 'Description', 'trim');   
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$file_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row	

				if($this->laboratory_model->update_file($file_id)) {


					// Save Log Data ///////////////////
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'lab_file',
						'tag_id'	=> 	$file_id,
						'action' 	=> 	'Updated a Result : `'.$this->input->post('title').'`'
					);

			
					//Save log loop
					foreach($log as $lg) {
						$this->logs_model->create_log($lg['user'], $lg['tag'], $lg['tag_id'], $lg['action']);				
					}		
					////////////////////////////////////

					$this->session->set_flashdata('success', 'Result Updated!');
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}


	public function delete_result()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id', 'ID', 'trim|required');     
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$file_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row	

				if($this->laboratory_model->delete_file($file_id)) {


					// Save Log Data ///////////////////
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'lab_file',
						'tag_id'	=> 	$file_id,
						'action' 	=> 	'Deleted a Result'
					);

			
					//Save log loop
					foreach($log as $lg) {
						$this->logs_model->create_log($lg['user'], $lg['tag'], $lg['tag_id'], $lg['action']);				
					}		
					////////////////////////////////////

					$this->session->set_flashdata('success', 'Result Deleted!');
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}


	public function download($file_id)		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			$download = $this->laboratory_model->view_file($file_id);
			$path = './uploads/patients/'.$download['patient_id'].'/case/'.$download['case_id'].'/laboratory/'.$download['labreq_id'].'/'.$download['link'];

			var_dump(force_download($path, NULL));

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
	      $result = $this->services_model->search_service($q, 'laboratory');

	      foreach($result as $row) {
	      	$new_row['label']=htmlentities(stripslashes($row['title'] . ' - ' . $row['code'] . ' - ' . $row['amount']));
            $new_row['value']=htmlentities(stripslashes('#'. prettyID($row['id']) . ' -- ' . $row['title'] . ' - ' . $row['code']));
            $row_set[] = $new_row; //build an array
          }
          echo json_encode($row_set); //format the array into json data     

	    }
	    
	  }




}
