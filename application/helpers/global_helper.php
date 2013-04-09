<?php

/**
 * This will print passed string
 *
 * @access public
 * @param $string
 * @return string
 */
function _e( $string ) {
	echo $string;
}

/**
 * This will return active class status 
 * on current page for menu navigation
 *
 * @access public
 * @param none
 * @return array
 */
function menu_nav_current_active() {
	/* get instance */
	$CI = & get_instance();
	
	/* set default value for navigation */
	$navigation = array(
		'timeline' => '',
		'digicard' => '',
		'contact' => '',
		'directory' => ''
	);
	
	/* get current controller use */
	$current = $CI->router->class;
	/* this will get current method use in controller */
	/* $this->router->method; */
	
	switch( $current ):
		case 'home':
			$navigation['timeline'] = 'active';
			break;
		case 'digicard':
			$navigation['digicard'] = 'active';
			break;
		default:
			break;
	endswitch;

	return (object)$navigation;
		
}

/**
 * This will return active class status 
 * on current page for sidebar navigation
 *
 * @access public
 * @param none
 * @return array
 */
function sidebar_nav_current_active() {
	/* get instance */
	$CI = & get_instance();
	
	/* set default value for navigation */
	$navigation = array(
		'digicard' => '',
		'personal_id' => '',
		'details' => '',
		'new_digicard' => ''
	);
	
	/* get current controller use */
	$current_controller = $CI->router->class;
	/* this will get current method use in controller */
	$current_method = $CI->router->method;
	
	if ( $current_controller == 'digicard' ) :
		switch( $current_method ):
			case 'index':
				$navigation['digicard'] = 'active';
				break;
			case 'personal_id':
				$navigation['personal_id'] = 'active';
				break;
			case 'details':
				$navigation['details'] = 'active';
				break;
			case 'new_digicard':
				$navigation['new_digicard'] = 'active';
				break;
			default:
				break;
		endswitch;
	endif;	

	return (object)$navigation;

}

/**
 * This will return dropdown date from 01-31
 * 
 * @access public
 * @param string $name
 * @return html
 */
function custom_select( $name ) {
	$select = "<select id='$name' class='$name' name='$name'>";
	
	for( $ctr = 0; $ctr <= 31; $ctr++ ):
	endfor;
	
	$select .= "</select>";
}

function get_current_controller_method() {
	/* get instance */
	$CI = & get_instance();
	
	/* get current controller use */
	$current_controller = $CI->router->class;
	/* this will get current method use in controller */
	$current_method = $CI->router->method;
	
	return array( 'controller' => $current_controller, 'method' => $current_method  );
}