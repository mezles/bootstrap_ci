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
 * This will return the current controller and method of page
 *
 * @access public
 * @param none
 * @return array
 */
function get_current_controller_method() {
	/* get instance */
	$CI = & get_instance();
	
	/* get current controller use */
	$current_controller = $CI->router->class;
	/* this will get current method use in controller */
	$current_method = $CI->router->method;
	
	return array( 'controller' => $current_controller, 'method' => $current_method  );
}

/**
 * This will return the slug of a string
 *
 * @access public
 * @param string $string
 * @return string $slug
 */
function slug_name( $string ) {
    $url = $string;
    $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url); // substitutes anything but letters, numbers and '_' with separator 
    $url = trim($url, "-");
    $url = iconv("utf-8", "us-ascii//TRANSLIT", $url); // TRANSLIT does the whole job
    $url = strtolower($url);
    $url = preg_replace('~[^-a-z0-9_]+~', '', $url); // keep only letters, numbers, '_' and separator
    return $url;
}

/**
 * This will return an alert message format in bootstrap
 * http://twitter.github.io/bootstrap/javascript.html#alerts
 *
 * @access public
 * @param $content - alert message content
 * @param $class - alert message class, (accepts string, array, or null)
 * @return html/string
 */
function _bootstrap_alert( $content, $class = null ) {
	$prep_class = '';
	
	if ( is_null( $class ) ) {
		$prep_class = '';
			
	} else if ( is_array( $class ) ) {
		$prep_class = implode( ' ', $class );
		
	} else {
		$prep_class = $class;
	}
	
	$html = '<div class="alert ' . $prep_class . '"><button data-dismiss="alert" class="close" type="button">&times;</button>' . $content . '</div>';
	return $html;
}