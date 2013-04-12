<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Digicard extends CI_Controller {

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
		$this->load->model('user_model');
		$this->load->model('global_model');
		
		if(! is_logged_in() )
			redirect('/login');
		
	}
	
	
	/**
	 * Class index method, displaying default page
	 */
	public function index() {
		$data['title'] 					= 'My Digicards: Qiky Website';
		$data['page_title']		= 'My Digicards';
		
		$data[ 'header' ] 			= $this->load->view( 'include/header/header', $data, TRUE );
		$data[ 'menu_nav' ] 	= $this->load->view( 'include/header/menu-nav', $data, TRUE );
		$data[ 'sidebar' ] 			= $this->load->view( 'include/sidebar/sidebar', $data, TRUE );
		$data[ 'footer' ] 			= $this->load->view( 'include/footer/footer', $data, TRUE );
		
		$this->load->view('/digicard/digicard_index', $data);
	}
	
	/**
	 * Class personal_id method, displaying My Personal ID page
	 */
	public function personal_id() {		
		/* retrieve user data from session */
		$user 						= $this->session->userdata('user_data');
		
		$data['title'] 				= 'My Personal ID: Qiky Website';
		$data['page_title']		= 'My Personal ID';
		$data['country']			= $this->global_model->get_country();
		$data['user_meta']		= $this->user_model->get_user_meta();

		$data[ 'header' ] 			= $this->load->view( 'include/header/header', $data, TRUE );
		$data[ 'menu_nav' ] 	= $this->load->view( 'include/header/menu-nav', $data, TRUE );
		$data[ 'sidebar' ] 		= $this->load->view( 'include/sidebar/sidebar', $data, TRUE );
		$data[ 'footer' ] 			= $this->load->view( 'include/footer/footer', $data, TRUE );
		
		$data['login_count'] 		= $this->user_model->get_login_count( $user['id']);

		$this->load->view('/digicard/digicard_personal_id', $data);
	}
	
	/**
	 * Class details method, handles details page
	 *
	 * @access public
	 * @param none
	 * @return html
	 */
	public function details() {
		/* retrieve user data from session */
		$data['user'] 				= $this->session->userdata('user_data');
		$data['user_meta']		= $this->user_model->get_user_meta();		
		$data['has_profile'] 		= $this->user_model->has_existing_profile( $data['user']['id'] );
		$data['profile_names'] 	= $this->user_model->get_user_profile_names( $data['user']['id'] );

		$data['country']			= $this->global_model->get_country();

		$data['title'] 				= 'My Details: Qiky Website';
		$data['page_title']		= 'My Details';		

		$data[ 'header' ] 			= $this->load->view( 'include/header/header', $data, TRUE );
		$data[ 'menu_nav' ] 	= $this->load->view( 'include/header/menu-nav', $data, TRUE );
		$data[ 'sidebar' ] 		= $this->load->view( 'include/sidebar/sidebar', $data, TRUE );
		$data[ 'footer' ] 			= $this->load->view( 'include/footer/footer', $data, TRUE );

		if ( $data['user_meta'] )
			$this->load->view('/digicard/digicard_details', $data);
		else
			$this->load->view('/digicard/digicard_no_details', $data);
	}
	
	/**
	 * Class new_digicard method, handles new digicard page
	 *
	 * @access public
	 * @param none
	 * @return html
	 */
	public function new_digicard() {
		
	}
	
	
	/**
	 * Class save_personal_id method, handles saving of user personal information
	 *
	 * @access public
	 * @param none
	 * @return json_encode $response
	 */
	public function save_personal_id() {
		/* show 404 for direct access */
		if (! IS_AJAX) {
			show_404();
			
		} else {
			/* set default response */
			$response = array('error' => true, 'msg' => 'Error validating your request!');
			
			/* set form validation rule */
			$this->form_validation->set_rules('first_name', 'First Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('birthday', 'Birth Day', 'required|trim|xss_clean');
			$this->form_validation->set_rules('gender', 'Sex', 'required|trim|alpha|exact_length[1]|xss_clean');
			$this->form_validation->set_rules('location', 'Current Location', 'required|trim|xss_clean');
			$this->form_validation->set_rules('country', 'Country', 'required|trim|xss_clean');
			
			/* check form validity */
			if ( $this->form_validation->run() != FALSE ) {
				/* update usermeta in database */
				$user_meta = $this->user_model->update_user_meta( $this->input->post());
				
				if ( $user_meta ) {
					$response['error'] = FALSE;
					$response['msg'] = 'Personal Information successfully udpated!';
					
				} else {
					$response['error'] = TRUE;
					$response['msg'] = 'Personal Info not updated!';			
				}
				
			} else {
				$response['error'] = TRUE;
				$response['msg'] = validation_errors();			
			}
		}
		
		echo json_encode( $response );
		die();
		
	}
	
	/**
	 * Class save_personal_id method, handles saving of user personal information
	 *
	 * @access public
	 * @param none
	 * @return json_encode $response
	 */
	public function save_digital_profile_details() {
		/* show 404 for direct access */
		if (! IS_AJAX) {
			show_404();
			
		} else {
			/* retrieve user data from session */
			$user = $this->session->userdata('user_data');
			
			/* set default response */
			$response = array('error' => true, 'msg' => 'Error validating your request!');
			
			$data = array( '_FILES' => $_FILES, '_POST' => $_POST );
			
			/* upload settings */
			$config['upload_path'] = SITE_ROOT . 'assets/uploads/img_users/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '2048';
			// $config['max_width']  = '1024';
			// $config['max_height']  = '768';

			$this->load->library('upload');
			
			foreach( $_FILES as $key => $value ) {
				if ( !empty( $value['name'] ) ) {
				
					$this->upload->initialize($config);
					if ( ! $this->upload->do_upload($key)) {
						$error = array('error' => $this->upload->display_errors());
						$data['error'][] = $error;
						
					} else {
						$upload_data[] = array('upload_data' => $this->upload->data());
						$data['data'][] = $upload_data;
					}
					
				}
			}
			
			$profile_photo = (isset($upload_data[0]['upload_data'])) ? $upload_data[0]['upload_data'] : '';
			$company_logo = (isset($upload_data[1]['upload_data'])) ? $upload_data[1]['upload_data'] : '';
			
			if ( empty($data['error']) ) {
				/* set form validation rule */
				$this->form_validation->set_rules('title', 'Title', 'trim|xss_clean');
				$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|xss_clean');
				$this->form_validation->set_rules('phone_mobile', 'Mobile Phone', 'trim|xss_clean');
				$this->form_validation->set_rules('phone_home', 'Home Phone', 'trim|xss_clean');
				$this->form_validation->set_rules('skype', 'Skype', 'trim|xss_clean');
				$this->form_validation->set_rules('personal_url', 'Personal URL', 'trim|prep_url|xss_clean');
				$this->form_validation->set_rules('job_title', 'Job Title', 'trim|xss_clean');
				$this->form_validation->set_rules('company', 'Company', 'trim|xss_clean');
				$this->form_validation->set_rules('address', 'Address', 'trim|xss_clean');
				$this->form_validation->set_rules('social_link_fb', 'Facebook URL', 'trim|prep_url|xss_clean');
				$this->form_validation->set_rules('social_link_twitter', 'Twitter URL', 'trim|prep_url|xss_clean');
				$this->form_validation->set_rules('social_link_linkedin', 'Linkedin URL', 'trim|prep_url|xss_clean');
				
				/* check form validity */
				if ( $this->form_validation->run() != FALSE ) {
					$profile = array(
						'user_id' => (int) $user['id'],
						'profile_id' => $this->input->post('profile_id'),
						'title' => $this->input->post('title'),
						'email' => $this->input->post('email'),
						'phone_mobile' => $this->input->post('phone_mobile'),
						'phone_mobile_code' => (int) $this->input->post('phone_mobile_code'),
						'phone_home' => $this->input->post('phone_home'),
						'phone_home_code' => (int) $this->input->post('phone_home_code'),
						'skype' => $this->input->post('skype'),
						'personal_url' => $this->input->post('personal_url'),
						'job_title' => $this->input->post('job_title'),
						'company' => $this->input->post('company'),
						'address' => $this->input->post('address'),
						'social_link_fb' => $this->input->post('social_link_fb'),
						'social_link_twitter' => $this->input->post('social_link_twitter'),
						'social_link_linkedin' => $this->input->post('social_link_linkedin')
					);
					
					if ($_FILES) {
						$profile['profile_photo'] = json_encode($profile_photo);
						$profile['company_logo'] = json_encode($company_logo);
					}
					
					$result = $this->user_model->save_user_profile_details( $profile );
					
					if ( $result ) {
						$response['error'] = FALSE;
						$response['msg'] = '<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">&times;</button>Sucessfully saved. Reloading Page . . .</div>';	
						
					} else {
						$response['error'] = TRUE;
						$response['msg'] = '<div class="alert alert-error"><button data-dismiss="alert" class="close" type="button">&times;</button>No changes done. Reloading Page . . .</div>';			
					}
				} else {
					$response['error'] = TRUE;
					$response['msg'] = '<div class="alert alert-error"><button data-dismiss="alert" class="close" type="button">&times;</button>' .validation_errors() .'</div>';			
				}
				
			}
		
			echo $response['msg'];
			
			die();
		}
		
	}
	
	/**
	 * delete user profile details
	 *
	 * @access public
	 * @param none
	 * - accepts POST user_profile_details id
	 * @return boolean
	 */
	public function delete_user_profile_detail() {
		/* show 404 for direct access */
		if (! IS_AJAX) {
			show_404();
		
		} else {
			/* set default response */
			$response = array('error' => true, 'msg' => 'Error validating your request!');
			
			/* verify that user is actually login */
			if ( is_logged_in() ) {
				/* check for post */
				if ( $this->input->post() ) {
					/* delete data from db */
					$is_deleted = $this->user_model->delete_profile_detail( $this->input->post( 'id' ) );
					
					/* if successfully deleted, error is false */
					if ( $is_deleted ) {
						$response['error'] = FALSE;
						$response['msg'] = 'Item successfully deleted.';
						
					} else {
						$response['msg'] = 'Error in deleting item.';
					}
					
				} else {
					$response['msg'] = 'No data post.';
				}
			} else {
				$response['msg'] = 'Restricted Page.';
			}
			
			echo json_encode( $response );
			die();
		}
	}
	
	/**
	 * addds new profile name
	 *
	 * @access public
	 * @param none
	 * @return json_encode $response
	 */
	public function add_new_profile() {
		/* show 404 for direct access */
		if (! IS_AJAX) {
			show_404();
		
		} else {
			/* retrieve user data from session */
			$user = $this->session->userdata('user_data');
			
			/* set default response */
			$response = array('error' => true, 'msg' => _bootstrap_alert( 'Error validating your request!', array( 'alert-error', 'pull-left') ) );
			
			/* verify that user is actually login */
			if ( is_logged_in() ) {
			
				/* check for post */
				if ( $this->input->post() ) {
					
					/* form validation */
					$this->form_validation->set_rules('profile_name', 'Profile Name', 'required|trim|xss_clean|alpha_dash_space');
					
					if ($this->form_validation->run() != FALSE) {
						$data = array(
							'user_id' => $user['id'],
							'title' => $this->input->post('profile_name', TRUE),
							'built_in' => 0
						);
						
						$is_added = $this->user_model->add_new_profile( $data );
						
						if ( $is_added ) {
							$response['error'] = false;
							$response['msg'] = _bootstrap_alert('Profile successfully added!', array('alert-success', 'pull-left'));
							
						} else {
							$response['msg'] = _bootstrap_alert( 'Error in saving to database', array('alert-error', 'pull-left') );
						}
						
					} else {
						$response['msg'] = _bootstrap_alert(validation_errors(), array('alert-error', 'pull-left'));
					}
					
					
				} else {
					$response['msg'] = _bootstrap_alert( 'No data post.', array('alert-error', 'pull-left') );
				}
			} else {
				$response['msg'] = _bootstrap_alert( 'Restricted Page.', array('alert-error', 'pull-left') );
			}
			
			echo json_encode( $response );
			die();
		}
	}
	
	/**
	 * deletes profile by id
	 *
	 * @access public
	 * @param none
	 * @return array $response
	 */
	public function delete_profile() {
		/* show 404 for direct access */
		if (! IS_AJAX) {
			show_404();
		
		} else {
			/* retrieve user data from session */
			$user = $this->session->userdata('user_data');
			
			/* set default response */
			$response = array('error' => true, 'msg' => 'Error validating your request!');
			
			/* verify that user is actually login */
			if ( is_logged_in() ) {
			
				/* check for post */
				if ( $this->input->post() ) {			
				
					$is_deleted = $this->user_model->delete_profile( $this->input->post( 'id' ) );
					
					if ( $is_deleted ) {
						$response['error'] = false;
						$response['msg'] = 'Profile successfully deleted!';
						
					} else {
						$response['msg'] = 'Error in deleting selected profile.';
					}
						
				} else {
					$response['msg'] = 'No data post.';
				}
			} else {
				$response['msg'] = 'Restricted Page.';
			}
			
			echo json_encode( $response );
			die();
		}
	}
}

/* End of file digicard.php */
/* Location: ./application/controllers/digicard.php */