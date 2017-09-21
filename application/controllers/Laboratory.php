<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laboratory extends CI_Controller {

	public function __construct()	{
		parent::__construct();		
       $this->load->model('user_model');
       $this->load->model('services_model');
       $this->load->model('laboratory_model');
	}	


	public function index()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{

			$data['title'] 		= 'Pending Cases';
			$data['site_title'] = APP_NAME;
			$data['user'] 		= $this->user_model->userdetails($userdata['username']); //fetches users record


			//Paginated data		            
	   		$config['num_links'] = 5;
			$config['base_url'] = base_url('cases/index');
			$config["total_rows"] = $this->case_model->count_pending_cases();
			$config['per_page'] = 20;		

			$this->load->config('pagination'); //LOAD PAGINATION CONFIG

			$this->pagination->initialize($config);
		    if($this->uri->segment(3)){
		       $page = ($this->uri->segment(3)) ;
		  	}	else 	{
		       $page = 1;		               
		    }

		    $data["results"] = $this->case_model->fetch_pending_cases($config["per_page"], $page);
		    $str_links = $this->pagination->create_links();
		    $data["links"] = explode('&nbsp;',$str_links );

		    //ITEM NUMBERING
		    $data['per_page'] = $config['per_page'];
		    $data['page'] = $page;

		    //GET TOTAL RESULT
		    $data['total_result'] = $config["total_rows"];
		    //END PAGINATION		

			$this->load->view('case/list', $data);				
			

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}



	public function create()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id', 'ID', 'trim|required');   
			$this->form_validation->set_rules('labreq', 'Service Request', 'trim|required');   
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$case_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row				

				if($this->laboratory_model->create($case_id, $userdata['username'])) {

					$labreq_id = $this->db->insert_id(); //fetch last insert labreq Row ID

					// Save Log Data ///////////////////
					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'case',
						'tag_id'	=> 	$case_id,
						'action' 	=> 	'Requested a Laboratory Service : `'.$this->input->post('labreq').'`'
						);

					$log[] = array(
						'user' 		=> 	$userdata['username'],
						'tag' 		=> 	'laboratory',
						'tag_id'	=> 	$labreq_id,
						'action' 	=> 	'Request Created'
						);

			
					//Save log loop
					foreach($log as $lg) {
						$this->logs_model->create_log($lg['user'], $lg['tag'], $lg['tag_id'], $lg['action']);				
					}		
					////////////////////////////////////

					$this->session->set_flashdata('success', 'Laboratory Service Request Created!');
					redirect($_SERVER['HTTP_REFERER'].'#labrequest', 'refresh');
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}



	/**
	 * This function is used for Patient Autocomplete
	 * @return JSON 	the array of results
	 */
	public function autocomplete(){
	    
	    if (isset($_GET['term'])){
	      $q = strtolower($_GET['term']);
	      $result = $this->services_model->search_service($q, 'laboratory');

	      foreach($result as $row) {
	      	$new_row['label']=htmlentities(stripslashes($row['title'] . ' - ' . $row['code'] . ' - ' . $row['amount']));
            $new_row['value']=htmlentities(stripslashes('#'. prettyID($row['id']) . ' -- ' . $row['title'] . ' - ' . $row['code']));
            $row_set[] = $new_row; //build an array
          }
          echo json_encode($row_set); //format the array into json data     

	    }
	    
	  }




}
