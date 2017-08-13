<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Patients extends CI_Controller {

	public function __construct()	{
		parent::__construct();		
       $this->load->model('user_model');
       $this->load->model('patient_model');
       $this->load->model('case_model');
	}	



	public function index()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{

			$data['title'] 		= 'Patients';
			$data['site_title'] = APP_NAME;
			$data['user'] 		= $this->user_model->userdetails($userdata['username']); //fetches users record

			//Paginated data - Candidate Names				            
	   		$config['num_links'] = 5;
			$config['base_url'] = base_url('/patients/index/');
			$config["total_rows"] = $this->patient_model->count_patients();
			$config['per_page'] = 20;				
			$this->load->config('pagination'); //LOAD PAGINATION CONFIG

			$this->pagination->initialize($config);
		    if($this->uri->segment(3)){
		       $page = ($this->uri->segment(3)) ;
		  	}	else 	{
		       $page = 1;		               
		    }

		    $data["results"] = $this->patient_model->fetch_patients($config["per_page"], $page);
		    $str_links = $this->pagination->create_links();
		    $data["links"] = explode('&nbsp;',$str_links );

		    //ITEM NUMBERING
		    $data['per_page'] = $config['per_page'];
		    $data['page'] = $page;

		    //GET TOTAL RESULT
		    $data['total_result'] = $config["total_rows"];
		    //END PAGINATION	
		
			$this->load->view('patient/list', $data);
			

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}

	public function create()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{

			$data['title'] = 'Register Patient';
			$data['site_title'] = APP_NAME;
			$data['user'] = $this->user_model->userdetails($userdata['username']); //fetches users record
		

			//Form Validation			  
			$this->form_validation->set_rules('lname', 'Last Name', 'trim|required');   
			$this->form_validation->set_rules('mname', 'Middle Name', 'trim|required');   
			$this->form_validation->set_rules('fname', 'Full Name', 'trim|required');   
			$this->form_validation->set_rules('bplace', 'Birthplace', 'trim|required');   
			$this->form_validation->set_rules('sex', 'Sex', 'trim|required');   
			$this->form_validation->set_rules('bdate', 'Birthdate', 'trim|required');   
			$this->form_validation->set_rules('addr', 'Address', 'trim|required');   
			$this->form_validation->set_rules('contactno', 'Contact Number', 'trim|required');   
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');   
			$this->form_validation->set_rules('remarks', 'Remarks', 'trim');   		

				if($this->form_validation->run() == FALSE)	{
					$this->load->view('patient/create', $data);
				} else {	

					//Proceed saving				
					if($this->patient_model->create_patient()) {			
						
						// Save Log Data ///////////////////
						$log_user 	= $data['user']['username'];
						$log_tag 	= 'patient';	
						$log_tagID 	= $this->db->insert_id();	
						$log_action	= 'Patient Registered';		

						$this->logs_model->create_log($log_user, $log_tag, $log_tagID, $log_action);					
						////////////////////////////////////
					
						$this->session->set_flashdata('success', 'Succes! Patient Registered!');
						redirect($_SERVER['HTTP_REFERER'], 'refresh');
					} else {
						//failure
						$this->session->set_flashdata('error', 'Oops! Error occured!');
						redirect($_SERVER['HTTP_REFERER'], 'refresh');
					}			
					
				}		

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}

	public function view($patient_id) {
		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			$data['site_title'] = APP_NAME;
			$data['user'] = $this->user_model->userdetails($userdata['username']); //fetches users record
			
			$data['info'] = $this->patient_model->view_patient($patient_id);

			//check if it is partially deleted
			if((!$data['info']['is_deleted']) && $data['info'] && $patient_id) {
								
				
				//check url for CASES
				if($this->uri->segment(4) == 'case') {

					$case_id = $this->uri->segment(5); //case ID segment 

					//Case Information
					$data['case'] = $this->case_model->view_case($case_id, $patient_id);
					//check validity of the CASE Row
					if ($data['case']) {						

						//check the prescription request
						if($this->uri->segment(6) == 'prescription') {
							//check the prescription request
							if($this->uri->segment(7) == 'create') {

								//load prescription/create
								$data['title'] =  'New Prescription';	//Page title								
								$this->load->view('prescription/create', $data);

							} elseif($this->uri->segment(7) == 'view') {
								$prescription_id = $this->uri->segment(8);
								//prescription								
								if($prescription_id) {
									echo $prescription_id;
								} else {
									show_404();
								}

							} else {
								show_404();
							}

						} elseif(!$this->uri->segment(6)) {
							//load CASE View
							$data['title'] =  $data['case']['title'];	//Page title		
							$data['logs']	= $this->logs_model->fetch_logs('case', $case_id, 0);

							$this->load->view('case/view', $data);	
						} else {
							show_404();
						}

					} else {
						show_404();
					}

				} elseif(!$this->uri->segment(4)) {
					//Load default patient information view
					$data['title'] = $data['info']['fullname'] . ' ' . $data['info']['lastname'];	//Page title
					$data['cases'] = $this->case_model->fetch_patient_case($patient_id);				

					$data['total_cases'] = $this->case_model->count_cases($patient_id);
					$data['logs']	= $this->logs_model->fetch_logs('patient', $patient_id, 10);

					$this->load->view('patient/view', $data);	

				} elseif($this->uri->segment(4) == 'logs') {
					//Show Logs
					$data['title'] = 'Logs: ' . $data['info']['fullname'] . ' ' . $data['info']['lastname'];	//Page title
					$data['logs']	= $this->logs_model->fetch_logs('patient', $patient_id, 0);
					
					$this->load->view('patient/logs', $data);	
					
				} else {
					show_404();
				}

			} else {
				show_404();
			}			
			

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}
	}




	public function update()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id', 'ID', 'trim|required');   		  
			$this->form_validation->set_rules('lname', 'Last Name', 'trim|required');   
			$this->form_validation->set_rules('mname', 'Middle Name', 'trim|required');   
			$this->form_validation->set_rules('fname', 'Full Name', 'trim|required');   
			$this->form_validation->set_rules('bplace', 'Birthplace', 'trim|required');   
			$this->form_validation->set_rules('sex', 'Sex', 'trim|required');   
			$this->form_validation->set_rules('bdate', 'Birthdate', 'trim|required');   
			$this->form_validation->set_rules('addr', 'Address', 'trim|required');   
			$this->form_validation->set_rules('contactno', 'Contact Number', 'trim|required');   
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');   
			$this->form_validation->set_rules('remarks', 'Remarks', 'trim');
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$key_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row				

				if($this->patient_model->update_patient($key_id)) {

					// Save Log Data ///////////////////
					$log_user 	= $userdata['username'];
					$log_tag 	= 'patient';	
					$log_tagID 	= $key_id;	
					$log_action	= 'Updated Patient Record';		

					$this->logs_model->create_log($log_user, $log_tag, $log_tagID, $log_action);			
					////////////////////////////////////
						
					$this->session->set_flashdata('success', 'Patient Updated!');
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}


	public function delete()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id', 'ID', 'trim|required');   
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$key_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row		

				// Save Log Data ///////////////////
				$log_user 	= $userdata['username'];
				$log_tag 	= 'patient';	
				$log_tagID 	= $key_id;	
				$log_action	= 'Moved to Trash';		

				$this->logs_model->create_log($log_user, $log_tag, $log_tagID, $log_action);			
				////////////////////////////////////		

				if($this->patient_model->delete_patient($key_id)) {
					$this->session->set_flashdata('success', 'Patient Moved to Trash!');
					redirect('Patients', 'refresh');
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}






}
