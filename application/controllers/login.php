<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	/**
	 * Class constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->load->library('phpass');
		$this->load->model('user_model');
	}
	
	/**
	 * Class default method
	 */
	public function index() {
		$data['title'] 					= 'Login: Qiky Website';
		$data[ 'header' ] 			= $this->load->view( 'include/header/header', $data, TRUE );
		$data[ 'footer' ] 			= $this->load->view( 'include/footer/footer', $data, TRUE );
		
		$data['page_title']		= 'Timeline';
		$this->load->view('login_view', $data);
	}
	
	/**
	 * Class check method
	 *
	 * @description: check user login
	 * @access public
	 * @param none
	 * @return json_encode $response
	 */
	public function check() {
		/* show 404 for direct access */
		if (! IS_AJAX) {
			show_404();
			
		} else {
			/* set default response */
			$response = array('error' => true, 'msg' => 'Error validating your request!');
			
			/* set form validation rule */
			$this->form_validation->set_rules('email', 'Email address', 'required|trim|valid_email|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
			
			/* check form validity */
			if ( $this->form_validation->run() != FALSE ) {
				/* check if username/email exist in database */
				$user_exist = $this->user_model->is_user_exist($this->input->post('email'));
				
				if ( $user_exist ) {
					$validate_user = $this->user_model->validate_user($this->input->post('email'), $this->input->post('password'));
					
					if ( $validate_user['success'] ) {
						$response['error'] = false;
						$response['msg'] = 'Successfully logged in!';
						
					} else {
						$response['error'] = true;
						$response['msg'] = $validate_user['msg'];
					}
					
				} else {
					$response['error'] = true;
					$response['msg'] = 'The email you entered does not belong to any acount.';
				}
				
			} else {
				$response['error'] = true;
				$response['msg'] = validation_errors();			
			}
			
			
			echo json_encode( $response );
			die();
			
		}
	
	}
	
	/**
	 *
	 */
	public function signout() {
		$this->session->sess_destroy();
		redirect( '/login' );
	}
	
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */