<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Patients extends CI_Controller {

	public function __construct()	{
		parent::__construct();		
       $this->load->model('user_model');
       $this->load->model('patient_model');
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
			$data['total_cases'] = $this->patient_model->count_cases($patient_id);


			//check if it is partially deleted
			if((!$data['info']['is_deleted']) && $data['info'] && $patient_id) {
								
				$case_id = $this->uri->segment(5); //case ID segment 
				//check url
				if($case_id) {
					//Case Information - case information view
					$data['case'] = $this->patient_model->view_case($case_id, $patient_id);
					$data['title'] =  $data['case']['title'];	//Page title

					//check validity 
					if ($data['case']) {
						$this->load->view('case/view', $data);	
					} else {
						show_404();
					}

				} else {
					//Load default patient information view
					$data['title'] = $data['info']['fullname'] . ' ' . $data['info']['lastname'];	//Page title
					$data['cases'] = $this->patient_model->fetch_patient_case($patient_id);				
					$this->load->view('patient/view', $data);	
				}

			} else {
				show_404();
			}
			

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}
	}

	public function update($id)		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{

			$data['title'] = 'Update User';
			$data['site_title'] = APP_NAME;
			$data['user'] = $this->user_model->userdetails($userdata['username']); //fetches users record

			//Page Data 
			$data['usertypes']		= $this->user_model->usertypes();			

			$data['info']		= $this->user_model->userdetails($id);

			//Validate if record exist
			 //IF NO ID OR NO RESULT, REDIRECT
				if(!$id OR !$data['info']) {
					redirect('sys/users', 'refresh');
			}	

			//Form Validation for user
			$this->form_validation->set_rules('name', 'Name', 'trim|required');  
			$this->form_validation->set_rules('usertype', 'Usertype', 'trim|required'); 
		
			//Validate Usertype
			if($data['user']['usertype'] == 'Doctor') {
				if($this->form_validation->run() == FALSE)	{
				$this->load->view('user/update', $data);
				} else {			

					//Proceed saving candidate				
					$key_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row
					if($this->user_model->update_user($key_id)) {			
					
						$this->session->set_flashdata('success', 'Succes! User Updated!');
						redirect($_SERVER['HTTP_REFERER'], 'refresh');
					} else {
						//failure
						$this->session->set_flashdata('error', 'Oops! Error occured!');
						redirect($_SERVER['HTTP_REFERER'], 'refresh');
					}			
					
				}	
			} else {
				show_error('Oops! Your account does not have the privilege to view the content. Please Contact the Administrator', 403, 'Access Denied!');				
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

				if($this->user_model->delete_user($key_id)) {
					$this->session->set_flashdata('success', 'User Deleted!');
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}






}
