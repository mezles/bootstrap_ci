<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$this->load->model('user_model');
		
		if(! is_logged_in() )
			redirect('/login');
	}
	
	/**
	 * Class default method
	 */
	public function index() {
		$data['title'] 					= 'Welcome: Qiky Website';
		$data[ 'header' ] 			= $this->load->view( 'include/header/header', $data, TRUE );
		$data[ 'menu_nav' ] 	= $this->load->view( 'include/header/menu-nav', $data, TRUE );
		$data[ 'sidebar' ] 			= $this->load->view( 'include/sidebar/sidebar', $data, TRUE );
		$data[ 'footer' ] 			= $this->load->view( 'include/footer/footer', $data, TRUE );

		$data['page_title']		= 'Timeline';
		$this->load->view('home_view', $data);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */