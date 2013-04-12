<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	var $user_id;
	
	/**
	  * Class constructor
	  */
	public function __construct() {
		parent::__construct();
		$this->load->library('phpass');
		
		if ($this->is_user_logged_in()) {
			$user = $this->session->userdata('user_data');
			$this->user_id = $user['id'];
		}
		
	}
	
	/**
	 * check if user is currently logged in
	 *
	 * @access public
	 * @return boolean
	 */
	public function is_user_logged_in() {
		$user = $this->session->userdata('user_data');
        return (isset($user) && !empty($user)) ? true: false;
	}
	
	
	/**
	 * check if user/email already exist in database
	 *
	 * @access public
	 * @param $username (email)
	 * @return boolean
	 */
	public function is_user_exist( $username ) {
		
		$query = $this->db->where('username', $username )
									->get('users');									
									
		return ( $query->num_rows() > 0 ) ? true : false;
		
	}
	
	/**
	 * check if username and password match, validate user log in
	 * if username and password match, set session for current user
	 * else, destroy session
	 *
	 * @access public
	 * @param $username - email
	 * @param @password - password
	 * @return boolean
	 */
	public function validate_user( $username, $password ) {
		/* get user data that match the username */
		$query = $this->db->where('username', $username )
									->get('users');
									
		$user = $query->row();
		$hashed = $user->password; /* hashed password */
		
		/** 
		 * password checking, 
		 * more info @ http://www.openwall.com/phpass/ 
		 */
		if ( $this->phpass->check( $password, $hashed ) ) {
			
			/* update login counter */
			$login_count_update = $this->update_user_login_count( $user->id );
			
			/* check for successful update for login counter */
			if ( $login_count_update ) {
				$userdata = array(
					'id' => $user->id,
					'username' => $user->username,
					'user_role_id' => $user->user_role_id
				);
				$this->session->set_userdata( 'user_data', $userdata );
				return array( 'success' => true, 'msg' => 'Login counter successfully updated.');
				
			} else {
				$this->session->sess_destroy();
				return array( 'success' => false, 'msg' => 'Unable to update login counter. Please contact administrator.' );
			}
			
			
		} else {
			$this->session->sess_destroy();
			return array( 'success' => false, 'msg' => 'Username and  password not match!' );
			
		}
		
	}
	
	/**
	 * register new user
	 *
	 * @access public
	 * @param array $data
	 * - username, password, user_role_id (1 - admin, 2 - user)
	 * @return array $response
	 */
	public function register_user( $data ) {
		$this->db->insert('users', $data);
		
		return ($this->db->affected_rows() > 0) ? $this->db->insert_id() : 0;
	}
	
	/**
	 * update user meta
	 *
	 * @access public
	 * @param array $data
	 * @return boolean
	 */
	public function update_user_meta( $data ) {
		/* check for userdata session */
		if ( !$this->is_user_logged_in() ) {
			return false;
		}
		
		/* retrieve user data from session */
		$user = $this->session->userdata('user_data');
		/* set user_data variables to be inserted on user_meta table */
		$user_data = array(
			'user_id' => (int) $user['id'],
			'firstname' => $data['first_name'],
			'lastname' => $data['last_name'],
			'birthday' => strtotime( $data['birthday'] ),
			'gender' => $data['gender'],
			'location' => $data['location'],
			'country' => $data['country']
		);
		
		
		/* check for existing usermeta */
		$query = $this->db->where('user_id', (int) $user['id'] )
									->get('user_meta');
		/* get first row from sql query */							
		$user_meta = $query->row();
		
		/* check if  user_meta exist base on user id */
		if ( $query->num_rows() > 0 ) {
			/* user meta does exist, update it. */
			$query = $this->db->update( 'user_meta', $user_data, array( 'user_id' => (int) $user['id']) );
			
		} else {
			/* user meta does not exist, save it. */
			$query = $this->db->insert( 'user_meta', $user_data );
		}
		
		// Check to see if the query actually performed correctly
		return ($this->db->affected_rows() > 0) ? true : false;
		
	}
	
	
	/**
	 * get user meta
	 *
	 * @access public
	 * @param none
	 * @return boolean
	 */
	public function get_user_meta() {
		/* check for userdata session */
		if ( !$this->is_user_logged_in() ) {
			return 0;
		}
		
		/* retrieve user data from session */
		$user = $this->session->userdata('user_data');
		
		/* check for existing usermeta */
		$query = $this->db->where('user_id', (int) $user['id'] )
									->get('user_meta');
		/* get first row from sql query */							
		$user_meta = $query->row();
		
		return $user_meta;
	}
	
	/**
	 * get user logs
	 *
	 * @access public
	 * @param none
	 * @return array $user_logs
	 */
	public function get_user_logs() {
		$user_logs = $this->db->get('user_logs')->result();
		return $user_logs;
	}
	
	/**
	 * get total login of user
	 *
	 * @access public
	 * @param int $user_id
	 * @return int $total (login count)
	 */
	public function get_login_count( $user_id ) {
		
		$this->db->select( "login_count");
		$this->db->from("users");
		$this->db->where("id", (int) $user_id);
		
		$query = $this->db->get();		
		$total =  $query->row()->login_count;
		
		return (int) $total;
		
	}
	
	/**
	 * update total login count of user
	 *
	 * @access public
	 * @param int $user_id
	 * @return boolean
	 */
	public function update_user_login_count( $user_id ) {
		$increment_login = $this->get_login_count( $user_id );
		$increment_login = $increment_login+1;
		
		/* get total login */
		$data = array( 'login_count' =>   $increment_login );
		
		$query = $this->db->update( 'users', $data , array( 'id' => (int) $user_id) );
		
		// Check to see if the query actually performed correctly
		return ($this->db->affected_rows() > 0) ? true : false;
	}
	
	/**
	 * check for existing profile of user
	 *
	 * @access public
	 * @param int $user_id, optional int $profile_id
	 * @return boolean
	 */
	public function has_existing_profile( $user_id, $profile_id = null ) {
	
		if ( is_null( $profile_id ) ) {
			$query = $this->db->where( 'user_id', $user_id )
									  ->get( 'user_profile_details' );
		} else {
			$query = $this->db->where( 'user_id', $user_id )
									  ->where( 'profile_id', $profile_id )
									  ->get( 'user_profile_details' );
		}
									
		return ( $query->num_rows() > 0 ) ? true : false;
	}
	
	/**
	 * add user profile
	 * 
	 * @access public
	 * @param array $data
	 */
	public function save_user_profile_details( $data ) {
		/* check for profile_id and user_id duplication, if duplicate we update */
		if ( $this->has_existing_profile( $data['user_id'], $data['profile_id'] ) ) {
			/* update user profile details */
			$query = $this->db->update( 'user_profile_details', $data, array( 'user_id' => $data['user_id'], 'profile_id' => $data['profile_id'] ) );
		} else {
			/* save newly created user profile details . */
			$query = $this->db->insert( 'user_profile_details', $data );
		}
		// Check to see if the query actually performed correctly
		return ($this->db->affected_rows() > 0) ? true : false;
	}
	
	/**
	 * get user profile names for tab header
	 *
	 * @access public
	 * @param int $user_id
	 * @return array
	 */
	public function get_user_profile_names( $user_id ) {
		$where = "user_id = 0 OR user_id = $user_id";
		$query = $this->db->where( $where )
									  ->get( 'profile' );
		return $query->result();
	}
	
	/**
	 * get profile detail lists
	 *
	 * @access public
	 * @param int $user_id, int $profile_id
	 * @return array
	 */
	public function get_profile_detail_list( $user_id, $profile_id ) {
		$query = $this->db->where( 'user_id', $user_id )
								 ->where( 'profile_id', $profile_id )
								 ->get( 'user_profile_details' );
								 
		return $query->row();
	}
	
	/**
	 * delete profile detail item
	 *
	 * @access public
	 * @param int $profile_detail_id
	 * @return boolean
	 */
	public function delete_profile_detail( $profile_detail_id ) {
		$query = $this->db->where( 'id', (int) $profile_detail_id )
								 ->delete( 'user_profile_details' );
		// Check to see if the query actually performed correctly
		return ($this->db->affected_rows() > 0) ? true : false;
	}
	
	/**
	 * adds new profile
	 *
	 * @access public
	 * @param array $data
	 * @return boolean
	 */
	public function add_new_profile( $data ) {
		$query = $this->db->insert( 'profile', $data );
		
		// Check to see if the query actually performed correctly
		return ($this->db->affected_rows() > 0) ? true : false;
	}
	
	/**
	 * delete profile
	 *
	 * @access public
	 * @param int $id
	 * @return boolean
	 */
	 public function delete_profile( $id ) {
		$query = $this->db->where( 'id', (int) $id )
								 ->delete( 'profile' );
		// Check to see if the query actually performed correctly
		return ($this->db->affected_rows() > 0) ? true : false;
	 }
	 
	 /**
	  * get profile photo
	  *
	  * @access public
	  * @param int $profile_id
	  * @return string
	  */
	 public function get_profile_photo( $profile_id ) {
		$user_id = $this->user_id;
		$details = $this->get_profile_detail_list( $user_id, $profile_id );
		$photo = '';
		
		if ($details) {
			$photo = json_decode($details->profile_photo);
			$photo = ($photo) ? base_url( '/assets/uploads/img_users/' . $photo->file_name ) : '';
		}
		
		return $photo;
	 }
}