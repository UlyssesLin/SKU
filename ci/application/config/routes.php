<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
// $route['default_controller'] = 'products_process/get_products';
// $route['index'] = 'products_process/index';

$route['products_page'] = 'products_process/get_products';
$route['orders'] = '/orders/index';
$route['logOut'] = '/logins/logOut';

//Ulysses' routes
$route['get_page/(:num)']='products_process/get_page/$1';
$route['prep_page/(:num)']='products_process/prep_page/$1';

$route['deleteImage/(:num)/(:num)']='products_process/deleteImage/$1/$2';
$route['organizeImages/(:num)']='products_process/organizeImages/$1';

$route['setCategory/(:num)']='products_process/setCategory/$1';
$route['deleteCategory/(:num)']='products_process/deleteCategory/$1';
$route['updateCategory/(:num)/(:any)']='products_process/updateCategory/$1/$2';

$route['update/(:any)']='products_process/update/$1';
$route['delete/(:num)']='products_process/delete/$1';
$route['editView']='products_process/editView';
$route['add']='products_process/add';

//Sara's Routes
$route['admin'] = "/logins/validate";
$route['order_page/(:num)'] = '/orders/orderPage/$1';
$route['status_change/(:num)/(:num)'] = '/orders/status_change/$1/$2';
$route['show/(:num)'] = '/orders/orderInfo/$1';
$route['search/(:any)'] = '/orders/search/$1';

//Kendall's routes
$route['default_controller'] = 'welcome';
$route['findItems'] = 'welcome/findItems';
$route['product/(:num)'] = 'welcome/loaddetail/$1';
$route['category/(:num)'] = 'welcome/loadcategory/$1';
$route['shoppingbag/(:num)'] = 'welcome/AddtoCart/$1';
$route['deleteItem/(:num)'] = 'welcome/deleteItem/$1';
$route['checkout'] = 'welcome/LoadCart/';

$route['404_override'] = '';




/* End of file routes.php */
/* Location: ./application/config/routes.php */