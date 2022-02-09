<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['news'] 					= "news/news/index";
	$route['get-news'] 				= "news/news/ajax_list";
	$route['add-news'] 				= "news/news/add";
	$route['edit-news/(:any)'] 		= "news/news/edit/$1";
	$route['change-news-status'] 	= "news/news/change";