<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cases extends CI_Controller {

	public function __construct()	{
		parent::__construct();		
       $this->load->model('user_model');
       $this->load->model('case_model');
       $this->load->model('queue_model');
       $this->load->model('medcert_model');
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

				if($this->case_model->create_case($patient_id)) {

					$case_id = $this->db->insert_id(); //fetch last insert case Row ID

					// Save Log Data ///////////////////
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'patient',
						'tag_id'	=> 	$patient_id,
						'action' 	=> 	'Added New Case : `'.$this->input->post('title').'`'
						);

					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'case',
						'tag_id'	=> 	$case_id,
						'action' 	=> 	'Case Added'
						);

			
					//Save log loop
					foreach($log as $lg) {
						$this->logs_model->create_log($lg['user'], $lg['tag'], $lg['tag_id'], $lg['action']);				
					}		
					////////////////////////////////////

					$this->session->set_flashdata('success', 'Case Created!');
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
			$this->form_validation->set_rules('pid', 'Patient ID', 'trim|required');   
			$this->form_validation->set_rules('status', 'Status', 'trim|required');   
 
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$patient_id = $this->encryption->decrypt($this->input->post('pid')); //ID of the patient				
				$case_id = $this->encryption->decrypt($this->input->post('id')); //ID of the case

				$status = $this->encryption->decrypt($this->input->post('status')); 		


				//advanced options action
				
				if($this->input->post('clearqueue'))	{
					//clear queues in the table
					$this->queue_model->clear_queue($case_id);
				}

				if($this->input->post('generatequeue'))	{
					//generate queue
					$this->queue_model->generate_queue($case_id);
					// Save Log Data ///////////////////
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'case',
						'tag_id'	=> 	$case_id,
						'action' 	=> 	'Generated new Queue'
						);
				}

				//proceed action
				if($this->case_model->update_status($case_id, $status)) {


					// Save Log Data ///////////////////
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'case',
						'tag_id'	=> 	$case_id,
						'action' 	=> 	'Updated the Case Status'
						);

			
					//Save log loop
					foreach($log as $lg) {
						$this->logs_model->create_log($lg['user'], $lg['tag'], $lg['tag_id'], $lg['action']);				
					}		
					////////////////////////////////////

					//redirect to the next queue
					if($this->input->post('nextqueue')) {
						$this->session->set_flashdata('success', 'Case Status Updated!');
						redirect('queues/next_queue', 'refresh');
					} else {
						$this->session->set_flashdata('success', 'Case Status Updated!');
						redirect($_SERVER['HTTP_REFERER'], 'refresh');
					}
					
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}



	public function create_medcert()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id', 'ID', 'trim|required');   
			$this->form_validation->set_rules('title', 'title', 'trim|required');   
			$this->form_validation->set_rules('remarks', 'Remarks', 'trim|required');   
			$this->form_validation->set_rules('doctor', 'Attending Physician', 'trim|required');   
			$this->form_validation->set_rules('pid', 'Patient ID', 'trim|required');   
 
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$patient_id = $this->encryption->decrypt($this->input->post('pid')); //ID of the patient				
				$case_id = $this->encryption->decrypt($this->input->post('id')); //ID of the case

				
				//proceed action
				if($this->medcert_model->create($case_id)) {

					$medcert_id = $this->db->insert_id();

					// Save Log Data ///////////////////
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'case',
						'tag_id'	=> 	$case_id,
						'action' 	=> 	'Issued Medical Certificate #'.prettyID($medcert_id)
						);

					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'patient',
						'tag_id'	=> 	$patient_id,
						'action' 	=> 	'Issued Medical Certificate from CASE ' . prettyID($this->case_model->view_case($case_id, $patient_id)['id']) . ' - ' . $this->case_model->view_case($case_id, $patient_id)['title']
						);

			
					//Save log loop
					foreach($log as $lg) {
						$this->logs_model->create_log($lg['user'], $lg['tag'], $lg['tag_id'], $lg['action']);				
					}		
					////////////////////////////////////

				
					$this->session->set_flashdata('success', 'Medical Certificate Issued!');
					redirect('patients/view/'.$patient_id.'/medcert/view/'.$medcert_id, 'refresh');
					
					
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}


}
