<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Queues extends CI_Controller {

	public function __construct()	{
		parent::__construct();		
       $this->load->model('user_model');
       $this->load->model('queue_model');
	}	




	public function next_queue() {

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//checks if there's an existing serving queue
			if($this->queue_model->fetch_queues(1)) {
				//redirect
				$this->session->set_flashdata('error', 'Oops! You are currently serving another queue! Please check the case and clear the queue.');
				redirect('dashboard', 'refresh');
			} else {

				//fetch queue details
				$queue = $this->queue_model->next_queue(); 

				if($queue) {
					//redirect to checkout address				
					redirect('queues/checkout/'.$queue['id'], 'refresh');	
				} else {
					$this->session->set_flashdata('success', 'You have no Pending Queues!');
					redirect('dashboard', 'refresh');
				}			

			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}


	public function checkout($id) {

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//checks if there's an existing serving queue
			if($this->queue_model->fetch_queues(1)) {
				//redirect
				$this->session->set_flashdata('error', 'Oops! You are currently serving another queue! Please check the case and clear the queue.');
				redirect('dashboard', 'refresh');
			} else {

				//fetch queue details
				$queue = $this->queue_model->check_queue($id); 

				//change queue status
				$this->queue_model->change_queue($id, 1);

				//redirect to case address
				redirect('patients/view/'.$queue['patient_id'].'/case/'.$queue['case_id'], 'refresh');				

			}
			
		

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}


}
