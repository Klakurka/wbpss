<?php
class User_validation{
	private $CI;

	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->model('party/user_model', 'users');
	}

	public function validate_viewer(){
		$class = $this->CI->router->class;
		$method = $this->CI->router->method;

		//load our config file to see which files the user can view
		$this->CI->config->load('page_rules');
		$page_rules = $this->CI->config->item('pr');
		$tiers = $this->CI->users->select_accessRights();

		if(array_key_exists('open', $page_rules)){
			if(array_key_exists($class, $page_rules['open'])
				&& in_array($method, $page_rules['open'][$class])){
				return true;
			}
		}
		if($this->is_logged_in()){
			//go through user tiers and see if we have a rule for them
			foreach($tiers as $tier){
				//we have a rule for that user tier
				if(array_key_exists($tier['strAccessRightsDescription'], $page_rules)){
					//we have a rule for that page
					if(array_key_exists($class, $page_rules[$tier['strAccessRightsDescription']])
						&& in_array($method, $page_rules[$tier['strAccessRightsDescription']][$class])){
						//if user has the correct permissions
						if($this->validate_accessright($tier['strAccessRightsDescription'], $this->CI->session->userdata('user_id'))){
							return true;
						}
					}
				}
			}
			$this->CI->session->set_flashdata('warning', 'Account does not have the needed permissions to view that resource.');
			$this->redirect_home();
		}
		$url = base_url() . $class . '/';
		$url .= ($method != 'index')? $method:'';
		$this->redirect_login($url);
	}

	public function validate_user($user_name, $password){
		$user = $this->CI->users->select_users_byName($user_name);
		if(isset($user['strUserPass'])){
			if(crypt($password, $user['strUserPass']) == $user['strUserPass']){
				return true;
			}
		}
		return false;
	}

	public function validate_accessright($access_right, $user_id){
		$tiers = $this->CI->users->select_accessRights();
		$user = $this->CI->users->select_users_byID($user_id);

		$required_rights = $this->CI->users->select_accessRights_byDesc($access_right);
		$user_rights = $this->CI->users->select_accessRights_byID($user['intAccessRightsID']);

		//user meets the required access
		if($user_rights == $required_rights){
			return true;
		}

		$current_rights = $user_rights;
		do{
			foreach($tiers as $t){
				if($t['strAccessRightsDescription'] == $current_rights['master']){
					$current_rights = $t;
					break;
				}
			}
		}while($current_rights != $user_rights && $current_rights != $required_rights);

		//user is too low in the hierarchy to view page
		if($current_rights == $required_rights){
			return false;
		}
		return true;
	}

	public function is_logged_in($user = NULL){
		return ($this->CI->session->userdata('logged_in'))?true:false;
	}

	public function redirect_login($previous_page){
		$this->CI->session->set_flashdata('last_page', $previous_page);
		$this->CI->session->set_flashdata('warning', 'Please login to view page.');
		redirect('users/login');
	}

	public function return_to_lastpage(){
		if($last_page = $this->CI->session->flashdata('last_page')){
			redirect($last_page);
		}
	}

	public function redirect_home(){
		redirect('/');
	}
}
?>