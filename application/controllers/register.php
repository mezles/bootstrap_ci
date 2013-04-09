<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

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
	 
	public function __construct() {
		parent::__construct();
		$this->load->library('phpass');
		$this->load->model('user_model');
		
	}
	
	/**
	 * Class default method
	 */
	public function index() {
		
		$data['title'] 					= 'Register: Qiky Website';
		$data[ 'header' ] 			= $this->load->view( 'include/header/header', $data, TRUE );
		$data[ 'footer' ] 			= $this->load->view( 'include/footer/footer', $data, TRUE );

		$data['page_title']		= 'Timeline';
		$this->load->view('register_view', $data);
	}
	
	/**
	 * Class save method
	 *
	 * this will save the newly registered user
	 */
	public function save() {
		/* show 404 for direct access */
		if (! IS_AJAX) {
			show_404();
			
		} else {
			/* set default response */
			$response = array('error' => true, 'msg' => 'Error validating your request!');
			
			/* set form validation rule */
			$this->form_validation->set_rules('email', 'Email address', 'required|trim|valid_email|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
			$this->form_validation->set_rules('re_password', 'Password Confirmation', 'required|trim|matches[password]');
			
			/* check form validity */
			if ( $this->form_validation->run() != FALSE ) {
					/* check if username/email exist in database */
					$user_exist = $this->user_model->is_user_exist($this->input->post('email'));
				
				/* if username/ email not exist, data is save */
				if ( !$user_exist ) {
					
					$data = array(
						'username' => $this->input->post('email'),
						'password' => $this->phpass->hash($this->input->post('password')), /* hash password, use this for all hashing of password */
						'user_role_id' => 2
					);
					
					/* check if successfull saved to database, must return the inserted id */
					$inserted_id = $this->user_model->register_user($data);
					
					if ($inserted_id > 0) {
						$response['error'] = false;
						$response['msg'] = 'User successfully registered!';
						
					} else {
						$response['error'] = true;
						$response['msg'] = 'Email already exist!';
					}
					
					
				} else {
					$response['error'] = true;
					$response['msg'] = 'Email already exist!';
				}
					
			} else {
				$response['error'] = true;
				$response['msg'] = validation_errors();
				
			}
			
			/* return, echo in json_encode string for js script */
			echo json_encode( $response );
			die();
		}
	}
}

/* End of file register.php */
/* Location: ./application/controllers/register.php */