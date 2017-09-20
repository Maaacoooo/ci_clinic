<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {

	public function __construct()	{
		parent::__construct();		
       $this->load->model('services_model');
       $this->load->model('user_model');
	}	



	public function clinic()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{

			$data['title'] 		= 'Clinic Services and Fees';
			$data['site_title'] = APP_NAME;
			$data['user'] 		= $this->user_model->userdetails($userdata['username']); //fetches users record

			$data['tag'] = 'clinic';

			//Paginated data		            
	   		$config['num_links'] = 5;
			$config['base_url'] = base_url('/services/'.$data['tag']);
			$config["total_rows"] = $this->services_model->count_services($data['tag']);
			$config['per_page'] = 20;		

			$this->load->config('pagination'); //LOAD PAGINATION CONFIG

			$this->pagination->initialize($config);
		    if($this->uri->segment(3)){
		       $page = ($this->uri->segment(3)) ;
		  	}	else 	{
		       $page = 1;		               
		    }

		    $data["results"] = $this->services_model->fetch_services($config["per_page"], $page, $data['tag']);
		    $str_links = $this->pagination->create_links();
		    $data["links"] = explode('&nbsp;',$str_links );

		    //ITEM NUMBERING
		    $data['per_page'] = $config['per_page'];
		    $data['page'] = $page;

		    //GET TOTAL RESULT
		    $data['total_result'] = $config["total_rows"];
		    //END PAGINATION		
		
			//Form Validation for user
			$this->form_validation->set_rules('title', 'Service Title', 'trim|required'); 
			$this->form_validation->set_rules('description', 'Service Title', 'trim'); 
			$this->form_validation->set_rules('code', 'Service Title', 'trim'); 
			$this->form_validation->set_rules('amount', 'Service Title', 'trim'); 
			
			if($this->form_validation->run() == FALSE)	{
					$this->load->view('services/list', $data);
				} else {	
			
					//Proceed saving user				
					if($this->services_model->create($data['tag'])) {			
					
						$this->session->set_flashdata('success', 'Succes! Service registered!');
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


	public function laboratory()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{

			$data['title'] 		= 'Laboratory Services';
			$data['site_title'] = APP_NAME;
			$data['user'] 		= $this->user_model->userdetails($userdata['username']); //fetches users record

			$data['tag'] = 'laboratory';

			//Paginated data		            
	   		$config['num_links'] = 5;
			$config['base_url'] = base_url('/services/'.$data['tag']);
			$config["total_rows"] = $this->services_model->count_services($data['tag']);
			$config['per_page'] = 20;		

			$this->load->config('pagination'); //LOAD PAGINATION CONFIG

			$this->pagination->initialize($config);
		    if($this->uri->segment(3)){
		       $page = ($this->uri->segment(3)) ;
		  	}	else 	{
		       $page = 1;		               
		    }

		    $data["results"] = $this->services_model->fetch_services($config["per_page"], $page, $data['tag']);
		    $str_links = $this->pagination->create_links();
		    $data["links"] = explode('&nbsp;',$str_links );

		    //ITEM NUMBERING
		    $data['per_page'] = $config['per_page'];
		    $data['page'] = $page;

		    //GET TOTAL RESULT
		    $data['total_result'] = $config["total_rows"];
		    //END PAGINATION		
		
			//Form Validation for user
			$this->form_validation->set_rules('title', 'Service Title', 'trim|required'); 
			$this->form_validation->set_rules('description', 'Service Title', 'trim'); 
			$this->form_validation->set_rules('code', 'Service Title', 'trim'); 
			$this->form_validation->set_rules('amount', 'Service Title', 'trim'); 
			
			if($this->form_validation->run() == FALSE)	{
					$this->load->view('services/list', $data);
				} else {	
			
					//Proceed saving user				
					if($this->services_model->create($data['tag'])) {			
					
						$this->session->set_flashdata('success', 'Succes! Service registered!');
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


	public function immunization()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{

			$data['title'] 		= 'Immunization Services';
			$data['site_title'] = APP_NAME;
			$data['user'] 		= $this->user_model->userdetails($userdata['username']); //fetches users record

			$data['tag'] = 'immunization';

			//Paginated data		            
	   		$config['num_links'] = 5;
			$config['base_url'] = base_url('/services/'.$data['tag']);
			$config["total_rows"] = $this->services_model->count_services($data['tag']);
			$config['per_page'] = 20;		

			$this->load->config('pagination'); //LOAD PAGINATION CONFIG

			$this->pagination->initialize($config);
		    if($this->uri->segment(3)){
		       $page = ($this->uri->segment(3)) ;
		  	}	else 	{
		       $page = 1;		               
		    }

		    $data["results"] = $this->services_model->fetch_services($config["per_page"], $page, $data['tag']);
		    $str_links = $this->pagination->create_links();
		    $data["links"] = explode('&nbsp;',$str_links );

		    //ITEM NUMBERING
		    $data['per_page'] = $config['per_page'];
		    $data['page'] = $page;

		    //GET TOTAL RESULT
		    $data['total_result'] = $config["total_rows"];
		    //END PAGINATION		
		
			//Form Validation for user
			$this->form_validation->set_rules('title', 'Service Title', 'trim|required'); 
			$this->form_validation->set_rules('description', 'Service Title', 'trim'); 
			$this->form_validation->set_rules('code', 'Service Title', 'trim'); 
			$this->form_validation->set_rules('amount', 'Service Title', 'trim'); 
			
			if($this->form_validation->run() == FALSE)	{
					$this->load->view('services/list', $data);
				} else {	
			
					//Proceed saving user				
					if($this->services_model->create($data['tag'])) {			
					
						$this->session->set_flashdata('success', 'Succes! Service registered!');
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



	public function update()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id', 'ID', 'trim|required');   
			$this->form_validation->set_rules('title', 'Service Title', 'trim|required'); 
			$this->form_validation->set_rules('description', 'Service Title', 'trim'); 
			$this->form_validation->set_rules('code', 'Service Title', 'trim'); 
			$this->form_validation->set_rules('amount', 'Service Title', 'trim'); 
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$key_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row				

				if($this->services_model->update($key_id)) {
					$this->session->set_flashdata('success', 'Service Updated!');
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

				if($this->services_model->delete($key_id)) {
					$this->session->set_flashdata('success', 'Service Deleted!');
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}






}
