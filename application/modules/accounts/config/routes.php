<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	// $route['customers'] 							= "customers/customers/index";

	// $route['add-customer'] 							= "customers/customers/add";
	// $route['edit-customer/(:any)'] 					= "customers/customers/edit/$1";
	// $route['change-customer-status'] 				= "customers/customers/change";
	// $route['customer_check_unique_email'] 			= "customers/customers/check_unique_email";
	// $route['customer_check_unique_mobile'] 			= "customers/customers/check_unique_mobile";

	$route['payouts_records'] 					= "accounts/payouts_records";
	$route['payouts_records_list'] 				= "accounts/payouts_records/ajax_list";
	$route['payouts_records_update']			= "accounts/payouts_records/update";
	$route['payouts'] 							= "accounts/payouts";
	$route['payouts_list'] 						= "accounts/payouts/ajax_list";
	$route['binary_calculate'] 					= "accounts/binary";
	$route['crud_check_unique_mobile'] 			= "crud/crud/check_unique_mobile";
	