<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Copyright (c)2016, Jenmar "Maco" Cortes
 * Copyright TechDepot PH
 * All Rights Reserved
 * 
 * This license is a legal agreement between you and the Maco Cortes
 * for the use of ALUMNI INFORMATION SYSTEM referred to as the "Software"
 * By obtaining the Software you agree to comply with the terms and conditions of this license.
 *
 * PERMITTED USE
 * With approval from Maco Cortes, You are permitted to use the program for educational purposes only.
 * 
 * MODIFICATION AND REDISTRIBUTION 
 * Unless with written approval obtained from Maco Cortes, 
 * You are NOT allowed to modify, copy, redistribute, and sell the Software.
 *
 * For any concerns, you may reach Maco Cortes via:
 * maco.techdepot@gmail.com
 * facebook.com/Maaacoooo
 * maco@techdepot-ph.com
 * TechDepot-PH.com
 */

/*
| -------------------------------------------------------------------------
| PAGINATION CONFIG
| -------------------------------------------------------------------------
| This file contains the Pagination Configuration
|
*/

                $config['full_tag_open'] = '<ul class="pagination right">';          
                $config['cur_tag_open'] = '<li class="active"><a href="#">';
                $config['cur_tag_close'] = '</a></li>';
                $config['num_tag_open'] = '<li class="waves-effect">';
                $config['num_tag_close'] = '</li>';
                $config['full_tag_close'] = '</ul></nav>';          
                $config['next_tag_open'] = '<li><span aria-hidden="true">';
                $config['next_link'] = '&raquo;';
                $config['next_tag_close'] = '</span></li>';         
                $config['last_link'] = 'Last';
                $config['last_tag_open'] = '<li>';
                $config['last_tag_close'] = '</li>';
                $config['first_link'] = 'First';
                $config['first_tag_open'] = '<li>';
                $config['first_tag_close'] = '</li>';
                $config['prev_tag_open'] = '<li><span aria-hidden="true">';
                $config['prev_link'] = '&laquo;';
                $config['prev_tag_close'] = '</span></li>'; 
                $config['use_page_numbers'] = TRUE;      



/* End of file pagination.php */
/* Location: ./application/config/pagination.php */