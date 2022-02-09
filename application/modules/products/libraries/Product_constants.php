<?php
	if(!defined('BASEPATH')) exit('No direct script access allowed');

	class Product_constants {
		/***** Categories Uri *****/
		
		const product_categories_url 				= "product-categories";
		const get_product_categories_url 			= "get-product-categories";
		const get_product_category_options_url 		= "get-product-category-options";
		const get_product_categories_options_url 	= "get-product-categories-options";
		const get_product_multi_categories_options_url 	= "get-product-multi-categories-options";
		const add_product_category_url 				= "add-product-category";
		const view_product_category_url 			= "view-product-category";
		const edit_product_category_url 			= "edit-product-category";
		const change_product_category_status_url 	= "change-product-category-status";

		/***** Brands Uri *****/
		
		const product_brands_url 					= "product-brands";
		const get_product_brands_url 				= "get-product-brands";
		const get_product_brand_options_url 		= "get-product-brand-options";
		const add_product_brand_url 				= "add-product-brand";
		const view_product_brand_url 				= "view-product-brand";
		const edit_product_brand_url 				= "edit-product-brand";
		const change_product_brand_status_url 		= "change-product-brand-status";

		/***** Sizes Uri *****/
		
		const product_sizes_url 					= "product-sizes";
		const get_product_sizes_url 				= "get-product-sizes";
		const get_product_size_options_url 			= "get-product-size-options";
		const get_product_size_tag_options_url 		= "get-product-size-tag-options";
		const add_product_size_url 					= "add-product-size";
		const view_product_size_url 				= "view-product-size";
		const edit_product_size_url 				= "edit-product-size";
		const change_product_size_status_url 		= "change-product-size-status";

		/***** Colors Uri *****/
		
		const product_colors_url 					= "product-colors";
		const get_product_colors_url 				= "get-product-colors";
		const get_product_color_options_url 		= "get-product-color-options";
		const add_product_color_url 				= "add-product-color";
		const view_product_color_url 				= "view-product-color";
		const edit_product_color_url 				= "edit-product-color";
		const change_product_color_status_url 		= "change-product-color-status";
		const check_unique_color 					= "check-unique-color";

		/***** Products Uri *****/

		const products_url 							= "products";
		const get_product_url 						= "get-product";
		const get_product_options_url 				= "get-product-options";
		const get_coupon_product_options_url 		= "get-coupon-product-options";
		const add_product_url 						= "add-product";
		const view_product_url 						= "view-product";
		const edit_product_url 						= "edit-product";
		const change_product_status_url 			= "change-product-status";
		const check_unique_product_name 			= "check-unique-product-name";
		const check_unique_product_code 			= "check-unique-product-code";

		/***** Products Coupons *****/
		const product_coupons_url 					= "product-coupons";
		const get_product_coupons_url 				= "get-product-coupons";
		const get_product_coupon_options_url 		= "get-product-coupon-options";
		const get_product_user_options_url 			= "get-product-user-options";
		const add_product_coupon_url 				= "add-product-coupon";
		const view_product_coupon_url 				= "view-product-coupon";
		const edit_product_coupon_url 				= "edit-product-coupon";
		const change_product_coupon_status_url 		= "change-product-coupon-status";
		const check_unique_coupon 					= "check-unique-coupon";

		/***** Prod coupon Points *****/

		const bulk_coupon_url 						= "product-coupons/bulk";
		const load_bulk_coupon_batch_url 			= "product-coupons/bulk/load";
		const get_bulk_batch_coupon_url 			= "product-coupons/bulk/ajax_list";
		const load_batch_details_url 				= "product-coupons/bulk/batch_details";
		const get_batch_records_url 				= "product-coupons/bulk/ajax_list_batch_records";
		const load_bulk_coupon_url 					= "product-coupons/bulk/load-bulk";
		const save_bulk_coupon_url 					= "product-coupons/bulk/save-bulk";
	}