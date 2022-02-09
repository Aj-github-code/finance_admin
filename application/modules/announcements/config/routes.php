<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['announcements'] 					= "announcements/announcements/index";
	$route['get-announcements'] 				= "announcements/announcements/ajax_list";
	$route['add-announcement'] 					= "announcements/announcements/add";
	$route['edit-announcement/(:any)'] 			= "announcements/announcements/edit/$1";
	$route['change-announcement-status'] 		= "announcements/announcements/change";