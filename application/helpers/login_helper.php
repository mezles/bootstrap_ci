<?php
/**
 * Check if user is currently login or not
 *
 * @access public
 * @param none
 * @returns boolean
 */
function is_logged_in() {
    // Get current CodeIgniter instance
    $CI =& get_instance();
    // We need to use $CI->session instead of $this->session
    $user = $CI->session->userdata('user_data');
    if($user)
		return true;
	else
		return false;
}