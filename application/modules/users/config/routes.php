<?php
	defined('BASEPATH') OR exit('No direct script access allowed');


	$route['users'] 							= "users/users";
	$route['users_list']						= "users/users/ajax_list";
	$route['users_package'] 					= "users/users/users_package";
	$route['users_free'] 						= "users/users_free/user_free";
	$route['users_retopup']						= "users/users_re/users_retopup";
	$route['crud_check_unique_mobile'] 			= "crud/crud/check_unique_mobile";
	