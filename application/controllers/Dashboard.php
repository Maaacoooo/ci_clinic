<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()	{
		parent::__construct();		
       $this->load->model('user_model');
       $this->load->model('patient_model');
	}	


	public function index()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{

			$data['title'] = 'Dashboard';
			$data['site_title'] = APP_NAME;
			$data['user'] = $this->user_model->userdetails($userdata['username']); //fetches users record

			$data['passwordverify'] = $this->user_model->check_user($userdata['username'], 'ClinicUser'); //boolean - returns false if default password

			//FORM VALIDATION  /////////////////////////////////////////////////////////////////////
			
			if($this->input->post('newpatient')) {
				$this->form_validation->set_rules('newpatient', '', 'trim');   
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

			} else {
				$this->form_validation->set_rules('patient_id', 'Patient ID', 'trim|required|callback_check_patient');   
				$this->form_validation->set_rules('weight', 'Weight', 'trim|required');   
				$this->form_validation->set_rules('height', 'Height', 'trim|required');   
				$this->form_validation->set_rules('title', 'Case Title', 'trim|required');   
				$this->form_validation->set_rules('description', 'Case Description', 'trim|required');   
			}	
			
			
			if($this->form_validation->run() == FALSE)	{

				$this->load->view('dashboard/dashboard', $data);

			} else {

				//SAVE DATA
				
				if($this->input->post('newpatient')) {
					$this->patient_model->create_patient(); // Save New Patient
					$patient_id = $this->db->insert_id(); //fetch user_id
				} else {
					$patient_id = cleanId($this->input->post('patient_id'));
				}

				if($this->patient_model->create_case($patient_id)) {
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
