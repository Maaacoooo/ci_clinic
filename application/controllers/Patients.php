<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Patients extends CI_Controller {

	public function __construct()	{
		parent::__construct();		
       $this->load->model('user_model');
       $this->load->model('patient_model');
       $this->load->model('case_model');
       $this->load->model('prescription_model');
       $this->load->model('medcert_model');
       $this->load->model('laboratory_model');
       $this->load->model('immunization_model');
       $this->load->model('billing_model');
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
			$this->form_validation->set_rules('sex', 'Sex', 'trim|required');    
			$this->form_validation->set_rules('contactno', 'Contact Number', 'trim|required');   
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');    		

			$this->form_validation->set_rules('bplace_bldg', 'Birthplace Bldg', 'trim');   
			$this->form_validation->set_rules('bplace_strt', 'Birthplace Street', 'trim');   
			$this->form_validation->set_rules('bplace_brgy', 'Birthplace Barangay', 'trim');   
			$this->form_validation->set_rules('bplace_city', 'Birthplace City', 'trim|required');   
			$this->form_validation->set_rules('bplace_prov', 'Birthplace Province', 'trim|required');   
			$this->form_validation->set_rules('bplace_zip', 'Birthplace ZIP', 'trim|required');   
			$this->form_validation->set_rules('bplace_country', 'Birthplace Country', 'trim|required');   

			$this->form_validation->set_rules('addr_bldg', 'Present Address Bldg', 'trim|required');   
			$this->form_validation->set_rules('addr_strt', 'Present Address Street', 'trim|required');   
			$this->form_validation->set_rules('addr_brgy', 'Present Address Barangay', 'trim|required');   
			$this->form_validation->set_rules('addr_city', 'Present Address City', 'trim|required');   
			$this->form_validation->set_rules('addr_prov', 'Present Address Province', 'trim|required');   
			$this->form_validation->set_rules('addr_zip', 'Present Address ZIP', 'trim|required');   
			$this->form_validation->set_rules('addr_country', 'Present Address Country', 'trim|required');   


				if($this->form_validation->run() == FALSE)	{
					$this->load->view('patient/create', $data);
				} else {	

					//Proceed saving				
					if($this->patient_model->create_patient()) {			
						
						$patient_id = $this->db->insert_id(); // get patient ID

						// Save Log Data ///////////////////
						$log_user 	= $data['user']['username'];
						$log_tag 	= 'patient';	
						$log_tagID 	= $patient_id;	
						$log_action	= 'Patient Registered';		

						$this->logs_model->create_log($log_user, $log_tag, $log_tagID, $log_action);					
						////////////////////////////////////
						
						// Insert Address Data /////////////////////
						// birthplace
						$this->patient_model->create_address(
							$patient_id,
							0,
							$this->input->post('bplace_bldg'),
							$this->input->post('bplace_strt'),
							$this->input->post('bplace_brgy'),
							$this->input->post('bplace_city'),
							$this->input->post('bplace_prov'),
							$this->input->post('bplace_zip'),
							$this->input->post('bplace_country')
						);
						//address
						$this->patient_model->create_address(
							$patient_id,
							1,
							$this->input->post('addr_bldg'),
							$this->input->post('addr_strt'),
							$this->input->post('addr_brgy'),
							$this->input->post('addr_city'),
							$this->input->post('addr_prov'),
							$this->input->post('addr_zip'),
							$this->input->post('addr_country')
						);


						// Insert Contacts Data ///////////////////////
						//email						
						$this->patient_model->create_contacts($patient_id, 1, $this->input->post('email'));
						//mobile						
						$this->patient_model->create_contacts($patient_id, 0, $this->input->post('contactno'));
					
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

	public function view(int $patient_id) {
		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			$data['site_title'] = APP_NAME;
			$data['user'] = $this->user_model->userdetails($userdata['username']); //fetches users record
			
			$data['info'] = $this->patient_model->view_patient($patient_id);	
			$data['bplace'] = $this->patient_model->fetch_address($patient_id, 0);
			$data['addr'] = $this->patient_model->fetch_address($patient_id, 1);

			$data['meddoctors'] =$this->medcert_model->fetch_doctors(); //for MedCert Doctor Options

			//check if it is partially deleted
			if((!$data['info']['is_deleted']) && $data['info'] && $patient_id) {
								
				
				//check url for CASES
				if($this->uri->segment(4) == 'case') {

					$case_id = $this->uri->segment(5); //case ID segment 

					//Case Information
					$data['case'] = $this->case_model->view_case($case_id, $patient_id);

					//check validity of the CASE Row
					if ($data['case']) {											

						//check the prescription request
						if($this->uri->segment(6) == 'prescription') {
							//PRESCRIPTION MODULE
							//check the prescription request
							if($this->uri->segment(7) == 'create') {

								//load prescription/create
								$data['title'] =  'New Prescription';	//Page title								
								$this->load->view('prescription/create', $data);

							} elseif($this->uri->segment(7) == 'view') {
								$prescription_id = $this->uri->segment(8);

								$data['prescription'] = $this->prescription_model->view_prescription($prescription_id, $case_id);
								//prescription								
								if($data['prescription']) {								

									//load prescription/create
									$data['title'] =  'Prescription: ' . $data['prescription']['title'];	//Page title		
									$data['items'] = $this->prescription_model->fetch_prescription_items($prescription_id);			

									if($this->uri->segment(9) == 'print') {
										$this->load->view('prescription/print', $data);										
									} else {
										//Prescription View Restriction
										if($data['prescription']['created_by'] == $data['user']['username'] && $data['user']['usertype'] == 'Doctor') {
											$this->load->view('prescription/create', $data);
										} else {
											$this->load->view('prescription/view', $data);										
										}	
									}	
									

								} else {
									show_404();
								}

							} else {
								show_404();
							}

						} elseif($this->uri->segment(6) == 'laboratory') {
							//LABORATORY MODULE
							$labreq_id = $this->uri->segment(7); // Lab Request ID
							$data['labreq'] = $this->laboratory_model->view($labreq_id, $case_id);

							if($data['labreq']) {

								$data['title'] =  'Lab Request #'.prettyID($labreq_id). ': ' . $data['labreq']['service'];	//Page title	
								$data['lab_files'] = $this->laboratory_model->fetch_files($labreq_id); //Results and Files 
								$data['lab_report'] = $this->laboratory_model->fetch_lab_report($labreq_id); //Results and Files 

								if ($this->uri->segment(8) == 'print') {
									$this->load->view('laboratory/print', $data);									
								} else {
									$this->load->view('laboratory/view', $data);
								}

							} else {
								show_404();
							}

						} elseif($this->uri->segment(6) == 'immunization') {
							//LABORATORY MODULE
							$immu_id = $this->uri->segment(7);
							$data['immu'] = $this->immunization_model->view($immu_id, $case_id);

							if($data['immu']) {
								$data['title'] =  'Immunization Request #'.prettyID($immu_id). ': ' . $data['immu']['service'];	//Page title									
								$this->load->view('immunization/view', $data);

							} else {
								show_404();
							}

						} elseif($this->uri->segment(6) == 'print') {
							//CASE MODULE
							//load CASE View
							$data['title'] =  $data['case']['title'];	//Page title		
							$data['prescriptions'] = $this->prescription_model->fetch_case_prescription($case_id);
							$data['immunizations'] = $this->immunization_model->fetch_immunizations($case_id, $patient_id, '');	
							$data['medcerts'] = $this->medcert_model->fetch_medcert('', $case_id); //Overide Medical Certicate Information
							$data['labreqs'] = $this->laboratory_model->fetch_requests($case_id);
							$data['logs']	= $this->logs_model->fetch_logs('case', $case_id, 0); //cases 

							$this->load->view('case/print', $data);	

						} elseif(!$this->uri->segment(6)) {
							//CASE MODULE
							//load CASE View
							$data['title'] =  $data['case']['title'];	//Page title		
							$data['prescriptions'] = $this->prescription_model->fetch_case_prescription($case_id);
							$data['immunizations'] = $this->immunization_model->fetch_immunizations($case_id, $patient_id, '');	
							$data['medcerts'] = $this->medcert_model->fetch_medcert('', $case_id); //Overide Medical Certicate Information
							$data['labreqs'] = $this->laboratory_model->fetch_requests($case_id);
							$data['logs']	= $this->logs_model->fetch_logs('case', $case_id, 0); //cases 

							$this->load->view('case/view', $data);	
						} else {
							show_404();
						}

					} else {
						show_404();
					}

				} elseif(!$this->uri->segment(4)) {
					//PATIENT MODULE
					//Load default patient information view
					$data['title'] = $data['info']['fullname'] . ' ' . $data['info']['lastname'];	//Page title
					$data['cases'] = $this->case_model->fetch_patient_case($patient_id);		

					$data['email'] = $this->patient_model->fetch_contacts($patient_id, 1);
					$data['mobile'] = $this->patient_model->fetch_contacts($patient_id, 0);

					$data['medcerts'] = $this->medcert_model->fetch_medcert($patient_id, 0);	
					$data['immunizations'] = $this->immunization_model->fetch_immunizations('', $patient_id, 1);	
					$data['billing'] = $this->billing_model->fetch_billing_records(NULL, $patient_id, NULL);	

					$data['total_cases'] = $this->case_model->count_cases($patient_id);
					$data['logs']	= $this->logs_model->fetch_logs('patient', $patient_id, 10);

					$this->load->view('patient/view', $data);	

				}  elseif($this->uri->segment(4) == 'print') {
					//PATIENT MODULE
					//Load default patient information view
					$data['title'] = $data['info']['fullname'] . ' ' . $data['info']['lastname'];	//Page title
					$data['cases'] = $this->case_model->fetch_patient_case($patient_id);		

					$data['email'] = $this->patient_model->fetch_contacts($patient_id, 1);
					$data['mobile'] = $this->patient_model->fetch_contacts($patient_id, 0);

					$data['medcerts'] = $this->medcert_model->fetch_medcert($patient_id, 0);	
					$data['immunizations'] = $this->immunization_model->fetch_immunizations('', $patient_id, 1);	
					$data['billing'] = $this->billing_model->fetch_billing_records(NULL, $patient_id, NULL);	

					$data['total_cases'] = $this->case_model->count_cases($patient_id);
					$data['logs']	= $this->logs_model->fetch_logs('patient', $patient_id, 10);

					$this->load->view('patient/print', $data);	

				} elseif($this->uri->segment(4) == 'logs') {
					//LOGS MODULE
					//Show Logs
					$data['title'] = 'Logs: ' . $data['info']['fullname'] . ' ' . $data['info']['lastname'];	//Page title
					$data['logs']	= $this->logs_model->fetch_logs('patient', $patient_id, 0);
					
					$this->load->view('patient/logs', $data);	
					
				} elseif($this->uri->segment(4) == 'medcert') {
					//MEDICAL CERTIFICATES MODULE					
					$medcert_id = $this->uri->segment(6);
					$data['medcert'] = $this->medcert_model->view($medcert_id);
					
					if($this->uri->segment(5) == 'view') {						

						if($data['medcert']) {
							$data['title'] = 'Medical Certificate: ' . $data['medcert']['title'];	//Page title				
							$this->load->view('medcert/view', $data);	
						} else {
							show_404();
						}						

					} elseif($this->uri->segment(5) == 'print') {						

						if($data['medcert']) {
							$data['title'] = 'Medical Certificate: ' . $data['medcert']['title'];	//Page title				
							$this->load->view('medcert/print', $data);	
						} else {
							show_404();
						}						

					} else {
						show_404();
					}
					
				} else {
					show_404();
				}

			} else {
				show_404();
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
			$this->form_validation->set_rules('lname', 'Last Name', 'trim|required');   
			$this->form_validation->set_rules('mname', 'Middle Name', 'trim|required');   
			$this->form_validation->set_rules('fname', 'Full Name', 'trim|required');     
			$this->form_validation->set_rules('sex', 'Sex', 'trim|required');   
			$this->form_validation->set_rules('bdate', 'Birthdate', 'trim|required');    
			$this->form_validation->set_rules('remarks', 'Remarks', 'trim');
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$key_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row				

				if($this->patient_model->update_patient($key_id)) {

					// Save Log Data ///////////////////
					$log_user 	= $userdata['username'];
					$log_tag 	= 'patient';	
					$log_tagID 	= $key_id;	
					$log_action	= 'Updated Patient Record';		

					$this->logs_model->create_log($log_user, $log_tag, $log_tagID, $log_action);			
					////////////////////////////////////
						
					$this->session->set_flashdata('success', 'Patient Updated!');
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

				// Save Log Data ///////////////////
				$log_user 	= $userdata['username'];
				$log_tag 	= 'patient';	
				$log_tagID 	= $key_id;	
				$log_action	= 'Moved to Trash';		

				$this->logs_model->create_log($log_user, $log_tag, $log_tagID, $log_action);			
				////////////////////////////////////		

				if($this->patient_model->delete_patient($key_id)) {
					$this->session->set_flashdata('success', 'Patient Moved to Trash!');
					redirect('Patients', 'refresh');
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}


	public function delete_contact()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id', 'ID', 'trim|required');   
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$key_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row		
				$patient_id = $this->encryption->decrypt($this->input->post('pid')); //ID of the patient		
				$tag = $this->encryption->decrypt($this->input->post('tag'));	


				// Save Log Data ///////////////////
				$log_user 	= $userdata['username'];
				$log_tag 	= 'patient';	
				$log_tagID 	= $patient_id;	
				if($tag) {
					$log_action	= 'Removed Email';	
				} else {
					$log_action	= 'Removed Contact Number';	
				}	

				$this->logs_model->create_log($log_user, $log_tag, $log_tagID, $log_action);	
				//UPDATE lastupdate record 
				$this->patient_model->last_update($patient_id);			
				////////////////////////////////////		

				if($this->patient_model->delete_contact($key_id)) {					
					if($tag) {
						$this->session->set_flashdata('success', 'Success! Email Removed!');
					} else {
						$this->session->set_flashdata('success', 'Success! Contact Number Removed!');
					}

					//redirect
					redirect($_SERVER['HTTP_REFERER'], 'refresh');					
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}


	}


	public function create_contact()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('pid', 'Patient ID', 'trim|required');   
			$this->form_validation->set_rules('tag', 'TAG', 'trim|required');   
			$this->form_validation->set_rules('details', 'Detail', 'trim|required');   
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$patient_id = $this->encryption->decrypt($this->input->post('pid')); //ID of the patient		
				$tag = $this->encryption->decrypt($this->input->post('tag'));	


				// Save Log Data ///////////////////
				$log_user 	= $userdata['username'];
				$log_tag 	= 'patient';	
				$log_tagID 	= $patient_id;	
				if($tag) {
					$log_action	= 'Added Email';	
				} else {
					$log_action	= 'Added Contact Number';	
				}	

				$this->logs_model->create_log($log_user, $log_tag, $log_tagID, $log_action);		

				//UPDATE lastupdate record 
				$this->patient_model->last_update($patient_id);	
				////////////////////////////////////		

				if($this->patient_model->create_contacts($patient_id, $tag, $this->input->post('details'))) {					
					if($tag) {
						$this->session->set_flashdata('success', 'Success! Email Added!');
					} else {
						$this->session->set_flashdata('success', 'Success! Contact Number Added!');
					}

					//redirect
					redirect($_SERVER['HTTP_REFERER'], 'refresh');					
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}

	}



	public function update_address()		{

		$userdata = $this->session->userdata('admin_logged_in'); //it's pretty clear it's a userdata

		if($userdata)	{
			
			//FORM VALIDATION
			$this->form_validation->set_rules('id', 'ID', 'trim|required');   
			$this->form_validation->set_rules('pid', 'Patient ID', 'trim|required');   
			$this->form_validation->set_rules('tag', 'TAG', 'trim|required');   
		 
		   if($this->form_validation->run() == FALSE)	{

				$this->session->set_flashdata('error', 'An Error has Occured!');
				redirect($_SERVER['HTTP_REFERER'], 'refresh');

			} else {

				$key_id = $this->encryption->decrypt($this->input->post('id')); //ID of the row		
				$patient_id = $this->encryption->decrypt($this->input->post('pid')); //ID of the patient		
				$tag = $this->encryption->decrypt($this->input->post('tag'));	


				// Save Log Data ///////////////////
				$log_user 	= $userdata['username'];
				$log_tag 	= 'patient';	
				$log_tagID 	= $patient_id;	
				if($tag) {
					$log_action	= 'Updated Present Address';	
				} else {
					$log_action	= 'Updated Birthplace';	
				}	

				$this->logs_model->create_log($log_user, $log_tag, $log_tagID, $log_action);	
				//UPDATE lastupdate record 
				$this->patient_model->last_update($patient_id);			
				////////////////////////////////////		

				if($this->patient_model->update_address($key_id)) {					
					if($tag) {
						$this->session->set_flashdata('success', 'Success! Updated Present Address!');
					} else {
						$this->session->set_flashdata('success', 'Success! Updated Birthplace!');
					}

					//redirect
					redirect($_SERVER['HTTP_REFERER'], 'refresh');					
				}
			}

		} else {

			$this->session->set_flashdata('error', 'You need to login!');
			redirect('dashboard/login', 'refresh');
		}


	}






}
