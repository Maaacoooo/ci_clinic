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


    /**
     * This cleans a string to simply get the INT id 
     * @param  String   $str    the string starting with # . e.g  "#000143-- John Jones Smith"
     * @return int              the int ID. e.g     "143"
     */
    function cleanId($str) {

        sscanf($str,"#%d",$id);

        return $id;
    }

    /**
     * Returns the age. This is stupidly coded for some reasons
     * @param  String   $date   a MySQL Date format str
     * @return int              the Age
     */
    function getAge($date) {

        $str = "#".timespan(mysql_to_unix($date . '00:00:00'), time(), 1);

        sscanf($str,"#%d",$age);

        return $age;
    }


  


/* End of file Someclass.php */