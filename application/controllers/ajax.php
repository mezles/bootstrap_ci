<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

	/**
	 * Class constructor
	 */
	public function __construct() {
		parent:: __construct();
	}
	
	/**
	 * Class function _remap
	 *
	 * override class method, set default method if method is not existing
	 * source: http://www.ellislab.com/codeigniter/user-guide/general/controllers.html
	 */
	public function _remap($method, $params = array()) {
        if (method_exists(__CLASS__, $method)) {
            $this->$method($params);
        } else {
            $this->ajax_default();
        }
    }
	
	/**
	 * Class index method, displaying default page
	 */
	public function index() {
		/* show 404 for direct access */
		if (! IS_AJAX) {
			show_404();
		}
	}
	
	
	/**
	 * Class function ajax_default
	 *
	 * this is the default method use if calling a non existing method in ajax
	 */
	public function ajax_default() {
		/* show 404 for direct access */
		if (! IS_AJAX) {
			show_404();
			
		} else {
			/* returns 0 for non existing method */
			echo 0;
		}
    }
	
	public function test_method() {
		/* show 404 for direct access */
		if (! IS_AJAX) {
			show_404();
			
		} else {
			echo "Yes, I am exists.";
			
		}
    }
	
	/**
	 * set session popup for first time login
	 *
	 * @access public
	 * @param none
	 * @return boolean true, or int 1
	 */
	public function session_popup() {
		/* show 404 for direct access */
		if (! IS_AJAX) {
			show_404();
			
		} else {
			/* set session for popup */
			$this->session->set_userdata( 'session_popup', TRUE );
			echo 1;
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/ajax.php */