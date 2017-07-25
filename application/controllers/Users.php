<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()	{
		parent::__construct();		
       $this->load->model('user_model');
	}	



	public function index()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{

			$data['title'] 		= 'Users';
			$data['site_title'] = APP_NAME;
			$data['user'] 		= $this->user_model->userdetails($userdata['username']); //fetches users record


			//Page Data 
			$data['usertypes']		= $this->user_model->usertypes();

			//Paginated data - Candidate Names				            
	   		$config['num_links'] = 5;
			$config['base_url'] = base_url('/users/index/');
			$config["total_rows"] = $this->user_model->count_users();
			$config['per_page'] = 10;				
			$this->load->config('pagination'); //LOAD PAGINATION CONFIG

			$this->pagination->initialize($config);
		    if($this->uri->segment(4)){
		       $page = ($this->uri->segment(4)) ;
		  	}	else 	{
		       $page = 1;		               
		    }

		    $data["results"] = $this->user_model->fetch_users($config["per_page"], $page);
		    $str_links = $this->pagination->create_links();
		    $data["links"] = explode('&nbsp;',$str_links );

		    //ITEM NUMBERING
		    $data['per_page'] = $config['per_page'];
		    $data['page'] = $page;

		    //GET TOTAL RESULT
		    $data['total_result'] = $config["total_rows"];
		    //END PAGINATION		
		
			//Form Validation for user
			$this->form_validation->set_rules('name', 'Name', 'trim|required'); 
			$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]|alpha_dash'); 
			$this->form_validation->set_rules('usertype', 'Usertype', 'trim|required'); 
			
			

			if($this->form_validation->run() == FALSE)	{
				$this->load->view('user/list', $data);
			} else {	
		
				//Proceed saving user				
				if($this->user_model->create_user()) {			
				
					$this->session->set_flashdata('success', 'Succes! User registered!');
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


	public function resetpassword()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id', 'ID', 'trim|required');   
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$key_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row				

				if($this->user_model->reset_password($key_id)) {
					$this->session->set_flashdata('success', 'Password Resetted to Default!');
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}



}
