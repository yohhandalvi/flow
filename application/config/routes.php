<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'front/page/home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

/**
 * Admin Routes
 */

// User Routes
$route['admin'] = 'admin/user';
$route['admin/dashboard'] = 'admin/user/dashboard';
$route['admin/logout'] = 'admin/user/logout';
$route['admin/profile'] = 'admin/user/profile';
$route['admin/forgot-password'] = 'admin/user/forgot_password';
$route['admin/reset-password'] = 'admin/user/reset_password';
$route['register'] = 'admin/user/register';
$route['confirmation'] = 'admin/user/confirmation';
$route['personal'] = 'admin/user/personal';
$route['organization'] = 'admin/user/organization';
$route['domain'] = 'admin/user/domain';
$route['terms'] = 'admin/user/terms';

// Flow Routes
$route['admin/flows'] = 'admin/flow/index';
$route['admin/flow/add'] = 'admin/flow/add';
$route['admin/flow/edit/(:num)'] = 'admin/flow/edit/$1';
$route['admin/flow/delete/(:num)'] = 'admin/flow/delete/$1';
$route['admin/flow/steps/(:num)'] = 'admin/flow/steps/$1';
$route['admin/flow/step/add/(:num)'] = 'admin/flow/add_step/$1';
$route['admin/flow/step/edit/(:num)'] = 'admin/flow/edit_step/$1';
$route['admin/flow/step/delete/(:num)'] = 'admin/flow/delete_step/$1';
$route['admin/flow/publish/(:num)'] = 'admin/flow/publish/$1';
$route['admin/flow/publish'] = 'admin/flow/publish';

// Submission Routes
$route['admin/submissions'] = 'admin/submission/index';
$route['admin/submission/view/(:num)'] = 'admin/submission/view/$1';

/**
 * Site Routes
 */

// Activity Routes
$route['flow/start/(:any)'] = 'front/flow/start/$1';
$route['flow/end/(:any)'] = 'front/flow/end/$1';
$route['flow/error'] = 'front/flow/error';
$route['flow/result/(:any)'] = 'front/flow/result/$1';
$route['flow/(:any)/(:num)'] = 'front/flow/step/$1/$2';
$route['flow/(:any)'] = 'front/flow/index/$1';
