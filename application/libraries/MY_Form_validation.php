<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Form validation for QIKY
 * 
 * Custom form validation
 * @author John Jason Taladro
 * @version 1.0
 */

class MY_Form_validation extends CI_Form_validation {

    public function __construct() {
        parent::__construct();  
    }

    /**
	 * Form validation, accepts alpha, dash and space
	 *
	 * @access public
	 * @param none
	 * @returns boolean
	 */
	public function alpha_dash_space( $string ) {
		if ( ! preg_match("/^([-a-z ])+$/i", $string)) {
			$this->set_message( 'alpha_dash_space', 'The field may only contain alphabetical characters, dash and space.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
}