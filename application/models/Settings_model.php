<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Settings_model extends CI_Model
{


    /**
     * This fetches the row data from the Settings table as requested
     * @param  String        $id     The Unique Key or ID
     * @return String Array          The array of row
     */
    function setting($id) {

             $this->db->select('*');        
             $this->db->where('key', $id);          

             $query = $this->db->get('settings');

             return $query->row_array();

    }

    /**
     * This fetches all the results from the Settings table as requested
     * @param  String        $grp    The settings_grp 
     * @return String Array          The array of results
     */
    function fetch_settings($grp) {

             $this->db->select('*');        
             $this->db->where('setting_grp', $grp);          

             $query = $this->db->get('settings');

             return $query->result_array();
    }

    /**
     * The General Setting Updater
     * This is also used in pages
     * @param  String       $key    The key or the row ID
     * @param  String       $title 
     * @param  String       $value 
     * @return Boolean              returns TRUE if success
     */
    function update_setting($key, $title, $value) {

            $data = array(             
                'title'     => $title,  
                'value'     => $value        
             );
            
            $this->db->where('key', $key);
            return $this->db->update('settings', $data);     
    }


    function reset_setting() {

        //Empty all tables
        $this->db->empty_table('votes');
        $this->db->empty_table('vote_keys');
        $this->db->empty_table('candidate');
        $this->db->empty_table('course');
        $this->db->empty_table('party');
        $this->db->empty_table('position');
        $this->db->empty_table('year');

        //Update Default Setting Values
        $data = array(
                   array(
                      'title' => 'Publish Vote Results' ,
                      'value' => '1' ,
                      'key' => 'publish_vote_result'
                   ),
                    array(
                      'title' => 'Voting Status' ,
                      'value' => '1' ,
                      'key' => 'voting_status'
                   ),
                    array(
                      'title' => 'Oops! An Error has Occured' ,
                      'value' => '<p>We are very sorry for this inconvenience! :(</p><p>Please contact the Election Supervisor and/or the Developer, and submit your Voting Pass.</p>' ,
                      'key' => 'vote_error'
                   ),
                    array(
                      'title' => 'General Instructions' ,
                      'value' => '<p>By using the Voting System, please be guided accordingly:</p><ol><li>You must secure your<strong> VOTING PASS.</strong></li><li>You can only choose one candidate per position</li><li>You can only vote <strong>ONCE</strong>.</li><li>You must vote all positions.</li><li>If you wish to vote later, proceed to the lower part of the page and click <strong>Vote Later</strong> or <strong>Submit Later</strong>.</li><li>After selecting your candidate, review the form before submitting. The system will prohibit you from<br />submitting if all candidates are not checked.</li><li>After submitting, please be sure that the system will redirect you into a&nbsp;<strong>Success Page</strong>. If it redirects you to<br />an&nbsp;<strong>Error Page</strong>, please contact the Voting Supervisor or the System Developer with your Voting Pass.</li><li>and Please don&#39;t forget to rate the experience of your voting! :)</li></ol><p>Happy Voting! Please proceed to the Voting Page...</p>' ,
                      'key' => 'vote_instruc'
                   ),
                    array(
                      'title' => 'Your vote is Submitted!' ,
                      'value' => '<p>Thank you for voting! To check the results, please visit the&nbsp;<a href="http://localhost/sti_voting/vote/results">Result Page</a>.</p><p>Are you happy with the new Voting System? Rate us a Five Star!</p>' ,
                      'key' => 'vote_success'
                   ),
                   
                );

        $this->db->update_batch('settings', $data, 'key');
        return TRUE;
    }
     

}