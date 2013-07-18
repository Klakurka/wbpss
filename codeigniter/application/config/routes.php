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

$route['default_controller'] = 'pages/view';
$route['404_override'] = '';

$route['features/ajax'] = 'features/ajax';
$route['features/create'] = 'features/create';
$route['features/update/(:num)'] = 'features/update/$1';
$route['features/destroy/(:num)/(:any)'] = 'features/destroy/$1/$2';
$route['features/(:num)/(:num)'] = 'features/index/$1/$2/html';
$route['features/(:num)/(:num)/(json)'] = 'features/index/$1/$2/$3';
$route['features'] = 'features/index/0/20/html';

$route['accessories/ajax'] = 'accessories/ajax';
$route['accessories/create'] = 'accessories/create';
$route['accessories/update/(:num)'] = 'accessories/update/$1';
$route['accessories/destroy/(:num)/(:any)'] = 'accessories/destroy/$1/$2';
$route['accessories/(:num)/(:num)'] = 'accessories/index/$1/$2/html';
$route['accessories/(:num)/(:num)/(json)'] = 'accessories/index/$1/$2/$3';
$route['accessories'] = 'accessories/index/0/20/html';

$route['vehicles/destroy/(:any)/(:any)'] = 'vehicles/destroy/$1/$2';

$route['(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = '$1/$2/$3/$4/$5/$6';
/* End of file routes.php */
/* Location: ./application/config/routes.php */