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
$route['default_controller'] = 'login';
$route['404_override'] = 'error/404';
$route['translate_uri_dashes'] = FALSE;

//admin Login
$route["admin/organizationlist"]    =   "manageorganization/index";
$route["admin/addeditorganization/(:any)"]    =   "manageorganization/addeditorganization/$1";
$route["admin/deleteorganization/(:any)"]    =   "manageorganization/deleteorganization/$1";
$route["admin/controllerlist"]    =   "managecontroller/index";
$route["admin/addeditcontroller/(:any)"]    =   "managecontroller/addeditcontroller/$1";
$route["admin/deletecontroller/(:any)"]    =   "managecontroller/deletecontroller/$1";
$route["admin/assetcategory"]    =   "manageassetcategory/index";
$route["admin/addeditassetcategory/(:any)"]    =   "manageassetcategory/addeditcategory/$1";
$route["admin/deleteassetcategory/(:any)"]    =   "manageassetcategory/deletecategory/$1";

$route["admin/manageassets"]    =   "manageassets/index";
$route["admin/addeditassets/(:any)"]    =   "manageassets/addeditassets/$1";
$route["admin/deleteassets/(:any)"]    =   "manageassets/deleteassets/$1";

$route["admin/mapcontrol"]    =   "mapcontrol/index";

//organization login
$route["organization/index"]    =   "admin/index";
$route["organization/logout"]    =   "admin/logout";
$route["organization/changepassword"]    =   "admin/changepassword";
$route["organization/loginBackAdmin"]    =   "admin/loginBackAdmin";
$route["organization/manageassets"]    =   "manageassets/index";
$route["organization/addeditassets/(:any)"]    =   "manageassets/addeditassets/$1";
$route["organization/deleteassets/(:any)"]    =   "manageassets/deleteassets/$1";


//controller login
$route["controller/index"]    =   "admin/index";
$route["controller/logout"]    =   "admin/logout";
$route["controller/changepassword"]    =   "admin/changepassword";
$route["controller/loginBackAdmin"]    =   "admin/loginBackAdmin";
$route["controller/mapcontrol"]    =   "mapcontrol/index";
//$route['product/:num'] = 'catalog/product_lookup';