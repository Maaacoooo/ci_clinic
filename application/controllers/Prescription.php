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

				if($this->prescription_model->create_prescription($case_id)) {

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
