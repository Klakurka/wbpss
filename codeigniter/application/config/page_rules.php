<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*	This file controls which pages a user can view
 *	The tiers are listed in reverse order (lowest to highest)
 *
 *	open 			- These are the pages open to anyone, no login is required
 *	dealer 			- These are the pages available to dealers, local_admins, and master_admins
 *	local_admin 	- Thess are the pages available to local_admins, and master_admins
 *	master_admin	- These are the pages available to master_admins
 *
 *	Any class/method combination listed here will not be available to anyone
 *	If the user tries to access and unlisted page or does not have the
 *	permissions to view the page they will be redirected to login, or
 *	sent back to their last viewed page with a warning message.
 *
 *	an entry in this array takes the following form:
 *	$config['pr'][<tier>][<class>] = array(<method1>, <method2>, etc.);
 */
$config['pr']['open']['users'] 				= array('login', 'logout');
$config['pr']['open']['pages'] 				= array('view');

$config['pr']['dealer']['vehicles'] 		= array('index', 'search');

$config['pr']['local_admin']['accessories'] = array('create', 'index', 'view', 'update', 'destroy', 'search');
$config['pr']['local_admin']['pricesheets'] = array('create', 'index', 'view', 'update', 'destroy', 'search');
$config['pr']['local_admin']['users'] 		= array('create', 'index', 'view', 'update', 'destroy', 'search');

$config['pr']['master_admin']['vehicles'] 	= array('create', 'index', 'view', 'update', 'destroy', 'search');
$config['pr']['master_admin']['features'] 	= array('create', 'index', 'view', 'update', 'destroy', 'search', 'ajax');
$config['pr']['master_admin']['packages'] 	= array('create', 'index', 'view', 'update', 'destroy', 'search');


?>