<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prescription extends CI_Controller {

	public function __construct()	{
		parent::__construct();		
       $this->load->model('user_model');
       $this->load->model('prescription_model');
       $this->load->model('case_model');
	}	




	public function create()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id', 'ID', 'trim|required');     
			$this->form_validation->set_rules('title', 'Prescription Title', 'trim');   
			$this->form_validation->set_rules('description', 'Prescription Description', 'trim');  
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$case_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row				

				if($this->prescription_model->create_prescription($case_id, $userdata['username'])) {

					$prescription_id = $this->db->insert_id(); //fetch last insert case Row ID

					// Save Log Data ///////////////////
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'case',
						'tag_id'	=> 	$case_id,
						'action' 	=> 	'Added New Prescription : `'.$this->input->post('title').'`'
						);

					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'prescription',
						'tag_id'	=> 	$prescription_id,
						'action' 	=> 	'Prescription Added'
						);

			
					//Save log loop
					foreach($log as $lg) {
						$this->logs_model->create_log($lg['user'], $lg['tag'], $lg['tag_id'], $lg['action']);				
					}		
					////////////////////////////////////

					$this->session->set_flashdata('success', 'Prescription Created!');

					$patient_id = $this->encryption->decrypt($this->input->post('pid')); //ID of the patient	
					redirect('patients/view/'.$patient_id.'/case/'.$case_id.'/prescription/view/'.$prescription_id, 'refresh');
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
			$this->form_validation->set_rules('title', 'Prescription Title', 'trim');   
			$this->form_validation->set_rules('description', 'Prescription Description', 'trim');  
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$prescription_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row				

				if($this->prescription_model->update_prescription($prescription_id)) {


					// Save Log Data ///////////////////
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'prescription',
						'tag_id'	=> 	$prescription_id,
						'action' 	=> 	'Updated Prescription'
						);
			
					//Save log loop
					foreach($log as $lg) {
						$this->logs_model->create_log($lg['user'], $lg['tag'], $lg['tag_id'], $lg['action']);				
					}		
					////////////////////////////////////

					$this->session->set_flashdata('success', 'Prescription Updated!');

					$patient_id = $this->encryption->decrypt($this->input->post('pid')); //ID of the patient	
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
					
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}


	public function add_item()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id', 'ID', 'trim|required');   
			$this->form_validation->set_rules('item', 'Item', 'trim|required|callback_check_itemstack');   
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$prescription_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row				
				$item 			 = $this->input->post('item');

				if($this->prescription_model->check_item($prescription_id, $item)) {

					$qty  = $this->prescription_model->view_item($item, $prescription_id)['qty']; //gets the value of the existing quantity

					$action = $this->prescription_model->update_item_qty($item, $prescription_id, ($qty + 1)); // existing qty + 1; update quantity

				} else {
					$action = $this->prescription_model->add_item($prescription_id);
				}

				if($action) {

					// Save Log Data ///////////////////

					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'prescription',
						'tag_id'	=> 	$prescription_id,
						'action' 	=> 	'Added an Item: ' . $this->input->post('item')
						);

			
					//Save log loop
					foreach($log as $lg) {
						$this->logs_model->create_log($lg['user'], $lg['tag'], $lg['tag_id'], $lg['action']);				
					}		
					////////////////////////////////////

					$this->session->set_flashdata('success', 'Item Added!');
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}

	/**
	 * Potentially checks the item in the `items` table (used by autocomplete)
	 * if item doesn't exist in the table, item will be saved
	 * @param  String 		$item 	 the title of the item
	 * @return Boolean      		 this is always TRUE
	 */
	function check_itemstack($item) {

		if(!$this->prescription_model->check_item_stack($item)) {
			//save new item
			$this->prescription_model->add_item_stack($item);
		}


		return TRUE;
	}



	public function update_items() {

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id[]', 'ID', 'trim|required');     
			$this->form_validation->set_rules('item[]', 'Item', 'trim|required');   
			$this->form_validation->set_rules('qty[]', 'Quantity', 'trim|required');  
			$this->form_validation->set_rules('remark[]', 'Remark', 'trim');  
			$this->form_validation->set_rules('pid', 'PID', 'trim|required');  
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$prescription_id = $this->encryption->decrypt($this->input->post('pid')); //ID of the row				

				if($this->prescription_model->update_items()) {


					// Save Log Data ///////////////////
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'prescription',
						'tag_id'	=> 	$prescription_id,
						'action' 	=> 	'Updated Prescription Items'
						);
			
					//Save log loop
					foreach($log as $lg) {
						$this->logs_model->create_log($lg['user'], $lg['tag'], $lg['tag_id'], $lg['action']);				
					}		
					////////////////////////////////////

					$this->session->set_flashdata('success', 'Items Updated!');
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
					
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}
		
	}


	/**
	 * This function is used for Item Autocomplete
	 * @return JSON 	the array of results
	 */
	public function autocomplete(){
	    
	    if (isset($_GET['term'])){
	      $q = strtolower($_GET['term']);
	      $result = $this->prescription_model->search_items($q);

	      foreach($result as $row) {
	      	$new_row['label']=htmlentities(stripslashes($row['title']));
            $new_row['value']=htmlentities(stripslashes($row['title']));
            $row_set[] = $new_row; //build an array
          }
          echo json_encode($row_set); //format the array into json data     

	    }
	    
	  }


}
