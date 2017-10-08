<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()	{
		parent::__construct();		
       $this->load->model('user_model');
       $this->load->model('patient_model');
       $this->load->model('case_model');
       $this->load->model('queue_model');
       $this->load->model('billing_model');
	}	


	public function index()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{

			$data['title'] = 'Dashboard';
			$data['site_title'] = APP_NAME;
			$data['user'] = $this->user_model->userdetails($userdata['username']); //fetches users record

			$data['passwordverify'] = $this->user_model->check_user($userdata['username'], 'ClinicUser'); //boolean - returns false if default password

			$data['serving'] = $this->queue_model->fetch_queues(1);
			$data['queue'] = $this->queue_model->fetch_queues(0);

			//FORM VALIDATION  /////////////////////////////////////////////////////////////////////
			
			if($this->input->post('newpatient')) {
				$this->form_validation->set_rules('newpatient', '', 'trim');   
				$this->form_validation->set_rules('lname', 'Last Name', 'trim|required');   
				$this->form_validation->set_rules('mname', 'Middle Name', 'trim|required');   
				$this->form_validation->set_rules('fname', 'Full Name', 'trim|required');   
				$this->form_validation->set_rules('sex', 'Sex', 'trim|required');   
				$this->form_validation->set_rules('contactno', 'Contact Number', 'trim|required');   
				$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');   

				$this->form_validation->set_rules('bplace_bldg', 'Birthplace Bldg', 'trim');   
				$this->form_validation->set_rules('bplace_strt', 'Birthplace Street', 'trim');   
				$this->form_validation->set_rules('bplace_brgy', 'Birthplace Barangay', 'trim');   
				$this->form_validation->set_rules('bplace_city', 'Birthplace City', 'trim|required');   
				$this->form_validation->set_rules('bplace_prov', 'Birthplace Province', 'trim|required');   
				$this->form_validation->set_rules('bplace_zip', 'Birthplace ZIP', 'trim|required');   
				$this->form_validation->set_rules('bplace_country', 'Birthplace Country', 'trim|required');   

				$this->form_validation->set_rules('addr_bldg', 'Present Address Bldg', 'trim|required');   
				$this->form_validation->set_rules('addr_strt', 'Present Address Street', 'trim|required');   
				$this->form_validation->set_rules('addr_brgy', 'Present Address Barangay', 'trim|required');   
				$this->form_validation->set_rules('addr_city', 'Present Address City', 'trim|required');   
				$this->form_validation->set_rules('addr_prov', 'Present Address Province', 'trim|required');   
				$this->form_validation->set_rules('addr_zip', 'Present Address ZIP', 'trim|required');   
				$this->form_validation->set_rules('addr_country', 'Present Address Country', 'trim|required');   

			} else {
				$this->form_validation->set_rules('patient_id', 'Patient ID', 'trim|required|callback_check_patient');   

			}
				$this->form_validation->set_rules('weight', 'Weight', 'trim|required');   
				$this->form_validation->set_rules('height', 'Height', 'trim|required');   
				$this->form_validation->set_rules('title', 'Case Title', 'trim|required');   
				$this->form_validation->set_rules('description', 'Case Description', 'trim|required');   
				
			
			
			if($this->form_validation->run() == FALSE)	{

				if($data['user']['usertype'] == 'Doctor') {
					//Load Doctor view
					$this->load->view('dashboard/doctor_dashboard', $data);					
				} else {
					//Load Assistant View
					$this->load->view('dashboard/assistant_dashboard', $data);
				}

			} else {

				//SAVE DATA
				
				if($this->input->post('newpatient')) {
					$this->patient_model->create_patient(); // Save New Patient
					$patient_id = $this->db->insert_id(); //fetch user_id

					//Log Data Array
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'patient',
						'tag_id'	=> 	$patient_id,
						'action' 	=> 	'Patient Registered'
						);
					///////////
					
					// Insert Address Data /////////////////////
						// birthplace
						$this->patient_model->create_address(
							$patient_id,
							0,
							$this->input->post('bplace_bldg'),
							$this->input->post('bplace_strt'),
							$this->input->post('bplace_brgy'),
							$this->input->post('bplace_city'),
							$this->input->post('bplace_prov'),
							$this->input->post('bplace_zip'),
							$this->input->post('bplace_country')
						);
						//address
						$this->patient_model->create_address(
							$patient_id,
							1,
							$this->input->post('addr_bldg'),
							$this->input->post('addr_strt'),
							$this->input->post('addr_brgy'),
							$this->input->post('addr_city'),
							$this->input->post('addr_prov'),
							$this->input->post('addr_zip'),
							$this->input->post('addr_country')
						);


				// Insert Contacts Data ///////////////////////
						//email						
						$this->patient_model->create_contacts($patient_id, 1, $this->input->post('email'));
						//mobile						
						$this->patient_model->create_contacts($patient_id, 0, $this->input->post('contactno'));
					
				} else {
					$patient_id = cleanId($this->input->post('patient_id'));
				}			

				$case_id = $this->case_model->create_case($patient_id); //fetch last insert case Row ID

				// Insert Case Data
				if($case_id) {

					//Generate a Billing Queue ///////////////
					$this->billing_model->create($case_id, $userdata['username']);					
					/////////////////////////////////////////

					//Generate Queue
					if($this->input->post('generateQueue')) {
						$this->queue_model->generate_queue($case_id);
					}


					// Save Log Data ///////////////////			
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'case',
						'tag_id'	=> 	$case_id,
						'action' 	=> 	'Case Added'
						);

					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'patient',
						'tag_id'	=> 	$patient_id,
						'action' 	=> 	'Added New Case : `'.$this->input->post('title').'`'						
						);
					//Save log loop
					foreach($log as $lg) {
						$this->logs_model->create_log($lg['user'], $lg['tag'], $lg['tag_id'], $lg['action']);				
					}		
					////////////////////////////////////
					
					$this->session->set_flashdata('success', 'Success! Case Submitted!');					
				} else {
					$this->session->set_flashdata('error', 'Oops! Error occured!');					
				}

					redirect('dashboard', 'refresh');

			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}


	public function check_patient($patient) {

		$patient_id = cleanId($patient);

		$result = $this->patient_model->view_patient($patient_id);

		if($result) {
			
			return TRUE;
		} else {
			$this->form_validation->set_message('check_patient', 'No Patient Record Found!');			
			return FALSE;
		}
	}


	/**
	 * -------------------------------------------------------------------------------------------------------
	 * Login Functionality
	 */

	public function login()		{

		$data['title'] = 'Login';
		$data['site_title'] = APP_NAME;	


		if($this->session->userdata('admin_logged_in'))	{
		        redirect('dashboard', 'refresh');
		} else {
			
			//FORM VALIDATION
			$this->form_validation->set_rules('username', 'Username', 'trim|required|callback_check_user');   
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			 
			   if($this->form_validation->run() == FALSE)	{

					$this->load->view('admin/admin_login', $data);

				} else {

					redirect('dashboard', 'refresh');
			}
				
		}	
	}

	public function check_user($username) {

		$result = $this->user_model->check_user($username, $this->input->post('password'));

		if($result) {
			$this->session->set_userdata('admin_logged_in', array('username' => $username)); //set userdata
			return TRUE;
		} else {
			$this->form_validation->set_message('check_user', 'Username or Password does not match!');
			return FALSE;
		}
	}

	/**
	 * ---------------------------------------------------------------------------------------------------------
	 */



	public function logout() {
		$this->session->set_flashdata('success', 'You sucessfuly logged out!');
		$this->session->unset_userdata('admin_logged_in');		  
		redirect('dashboard/login', 'refresh');
	}


	/**
	 * This function is used for Patient Autocomplete
	 * @return JSON 	the array of results
	 */
	public function autocomplete(){
	    
	    if (isset($_GET['term'])){
	      $q = strtolower($_GET['term']);
	      $result = $this->patient_model->search_patients($q);

	      foreach($result as $row) {
	      	$new_row['label']=htmlentities(stripslashes($row['lastname'] . ', ' . $row['fullname'] . ' ' . $row['middlename']));
            $new_row['value']=htmlentities(stripslashes('#'. prettyID($row['id']) . ' -- ' . $row['lastname'] . ', ' . $row['fullname'] . ' ' . $row['middlename']));
            $row_set[] = $new_row; //build an array
          }
          echo json_encode($row_set); //format the array into json data     

	    }
	    
	  }
}
