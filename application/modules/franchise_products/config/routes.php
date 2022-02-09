<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['franchise-products'] 					= "franchise_products/franchise_products/index";
	$route['get-franchise-products'] 				= "franchise_products/franchise_products/ajax_list";
	$route['add-franchise-product'] 				= "franchise_products/franchise_products/add";
	$route['edit-franchise-product/(:any)'] 		= "franchise_products/franchise_products/edit/$1";
	$route['change-franchise-product-status'] 		= "franchise_products/franchise_products/change";