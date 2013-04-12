<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Global_model extends CI_Model {
	
	/**
	  * Class constructor
	  */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Returns list of country
	 *
	 * @access public
	 * @param none
	 * @return object country list
	 */
	 public function get_country() {
		$this->db->from( 'country_all' )
					->order_by( 'short_name', 'ASC' );
		$query = $this->db->get();
		return $query->result();
	 }
	 
	 /**
	 * Returns country name
	 *
	 * @access public
	 * @param string $ccode / iso2
	 * @return string country name
	 */
	 public function get_country_name( $ccode ) {
		$this->db->where( 'ccode', $ccode )
					->from( 'countries' )
					->order_by( 'country', 'ASC' );
		$query = $this->db->get();
		$row = $query->row();
		return $row->country;
	 }
	 
	 /**
	  * Returns country calling code
	  *
	  * @access public
	  * @param int id
	  * @return string
	  */
	 public function get_calling_code( $id ) {
		$this->db->where( 'country_id', (int) $id )
					->from( 'country_all' );
		$query = $this->db->get();
		$row = $query->row();
		
		return ($row && !empty($row->calling_code)) ? "($row->calling_code) " : '';
	 }
	
}
?>