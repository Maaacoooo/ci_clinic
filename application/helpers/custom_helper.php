<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

	function salt_pepper($str)		{
		//HELPER FOR HASHING
    	$salt      = 'r&r1d0%E160m<v|';
        $pepper    = 'nXG)4sNT5m&<E+5';
        return md5($salt.$str.$pepper);
    }

    /**
     * This provides an encrypted and/or unreadable data.
     * @param  String   $str    Any string to be encrypted.
     * @return String           Encrypted string. U NO SAY????
     */
    function cleancrypt($str) {

    	$crypt_str 	= crypt(md5($str), 'TrRz'); //encodes the string
    	$new_str 	= substr($crypt_str, 0, 6); //limits the string

    	return $new_str;
    }


    /**
     * Simply checks the existence of the file
     * @param  String   $file   The file name.
     * @return Boolean          Returns true if exists. U NO SAY????
     */
    function filexist($file) {

        if(file_exists('./uploads/'.$file)) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    function safelink($str) {
       return preg_replace("/[^a-zA-Z]/", "", $str);
    }


  


/* End of file Someclass.php */