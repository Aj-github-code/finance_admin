<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['product-categories'] 				= "products/product_categories/index";
	$route['get-product-categories'] 			= "products/product_categories/ajax_list";
	$route['get-product-category-options'] 		= "products/product_categories/get_category_options";
	$route['get-product-categories-options'] 	= "products/product_categories/get_categories_options";

	$route['get-product-multi-categories-options'] 	= "products/product_categories/get_multi_categories_options";
	$route['add-product-category'] 				= "products/product_categories/add";
	$route['edit-product-category/(:any)'] 		= "products/product_categories/edit/$1";
	$route['change-product-category-status'] 	= "products/product_categories/change";

	$route['product-brands'] 					= "products/product_brands/index";
	$route['get-product-brands'] 				= "products/product_brands/ajax_list";
	$route['get-product-brand-options'] 		= "products/product_brands/get_brand_options";
	$route['add-product-brand'] 				= "products/product_brands/add";
	$route['edit-product-brand/(:any)'] 		= "products/product_brands/edit/$1";
	$route['change-product-brand-status'] 		= "products/product_brands/change";

	$route['product-sizes'] 					= "products/product_sizes/index";
	$route['get-product-sizes'] 				= "products/product_sizes/ajax_list";
	$route['get-product-size-options'] 			= "products/product_sizes/get_size_options";
	$route['get-product-size-tag-options'] 		= "products/product_sizes/get_size_tag_options";
	$route['add-product-size'] 					= "products/product_sizes/add";
	$route['edit-product-size/(:any)'] 			= "products/product_sizes/edit/$1";
	$route['change-product-size-status'] 		= "products/product_sizes/change";

	$route['product-colors'] 					= "products/product_colors/index";
	$route['get-product-colors'] 				= "products/product_colors/ajax_list";
	$route['get-product-color-options'] 		= "products/product_colors/get_color_options";
	$route['add-product-color'] 				= "products/product_colors/add";
	$route['edit-product-color/(:any)'] 		= "products/product_colors/edit/$1";
	$route['change-product-color-status'] 		= "products/product_colors/change";
	$route['check-unique-color']				= "products/product_colors/check_unique_color";

	$route['products'] 							= "products/products/index";
	$route['get-product'] 						= "products/products/ajax_list";
	$route['get-product-options'] 				= "products/products/get_product_options";
	$route['get-coupon-product-options']		= "products/products/get_coupon_product_options";
	$route['add-product'] 						= "products/products/add";
	$route['edit-product/(:any)'] 				= "products/products/edit/$1";
	$route['change-product-status'] 			= "products/products/change";
	$route['check-unique-product-name']			= "products/products/check_unique_product_name";
	$route['check-unique-product-code']			= "products/products/check_unique_product_code";

	$route['product-coupons'] 					= "products/product_coupons/index";
	$route['get-product-coupons'] 				= "products/product_coupons/ajax_list";
	$route['get-product-coupon-options'] 		= "products/product_coupons/get_coupon_options";
	$route['get-product-user-options'] 			= "products/product_coupons/get_user_options";
	$route['add-product-coupon'] 				= "products/product_coupons/add";
	$route['edit-product-coupon/(:any)'] 		= "products/product_coupons/edit/$1";
	$route['change-product-coupon-status'] 		= "products/product_coupons/change";
	$route['check-unique-coupon']				= "products/product_coupons/check_unique_coupon";

	// add by Maruti
	$route['product-coupons/bulk'] 								= "products/bulk_products_coupon/index";
	$route['product-coupons/bulk/load'] 						= "products/bulk_products_coupon/load_batch";
	$route['product-coupons/bulk/ajax_list'] 					= "products/bulk_products_coupon/ajax_list";
	$route['product-coupons/bulk/batch_details'] 				= "products/bulk_products_coupon/load_batch_details";
	$route['product-coupons/bulk/ajax_list_batch_records'] 		= "products/bulk_products_coupon/ajax_list_batch_records";
	$route['product-coupons/bulk/load-bulk'] 					= "products/bulk_products_coupon/load_bulk";
	$route['product-coupons/bulk/save-bulk'] 					= "products/bulk_products_coupon/save_bulk";