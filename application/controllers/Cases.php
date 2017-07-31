<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cases extends CI_Controller {

	public function __construct()	{
		parent::__construct();		
       $this->load->model('user_model');
       $this->load->model('patient_model');
	}	




	public function create()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id', 'ID', 'trim|required');   
			$this->form_validation->set_rules('weight', 'Weight', 'trim|required');   
			$this->form_validation->set_rules('height', 'Height', 'trim|required');   
			$this->form_validation->set_rules('title', 'Case Title', 'trim|required');   
			$this->form_validation->set_rules('description', 'Case Description', 'trim|required');  
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$patient_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row				

				if($this->patient_model->create_case($patient_id)) {
					$this->session->set_flashdata('success', 'Case Created!');
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}






}
