<?php
class AxcotoModalRegisterUser {
	
	function __construct() {
		
	}
	
	function userAdd($username, $password, $email) {
		if (get_user_by_email($email)) {
			return array('error' => 1, 'msg' => '<span>This email has already taken</span>');
		} 
		if (get_user_by('login', $username) || get_user_by('slug', $username)) {
			return array('error' => 2, 'msg' => '<span>This username has already taken</span>');			
		}
		if (wp_create_user($username, $password, $email)) {
			return array('error' => 0);
		};	
		return array('error' => 3, 'msg' => '<span>Unknow error</span>');
	}
	
}