<?php
class Users extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('party/party_model', 'parties');
		$this->load->model('party/user_model', 'users');
		$this->load->model('party/contact_model', 'contacts');
	}

	public function create(){
		$data['title'] = 'Create user';
		$data['view'] = 'users/create';

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('first_name', 'First name', 'required');
		$this->form_validation->set_rules('last_name', 'Last name', 'required');
		$this->form_validation->set_rules('user_name', 'User name', 'required|is_unique[user.tblUser.strUserName]|alpha_dash');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[password_conf]');


		if($this->form_validation->run() == FALSE){
			$creator = $this->users->select_users_byID($this->session->userdata('user_id'));
			$creator['accessrights'] = $this->users->select_accessRights_byID($creator['intAccessRightsID']);
			$creator['dealership'] = $this->parties->select_dealership_byID($creator['intDealershipID']);
			//clean-up the creator obeject before passing it on
			unset($creator['strUserPass'], $creator['intAccessRightsID'], $creator['intDealershipID']);
			$data['view_data']['creator'] =  $creator;
			$data['view_data']['dealerships'] = $this->parties->select_dealerships();
			$data['view_data']['accessrights'] = $this->users->select_accessRights();

			$this->load->view('templates/standard', $data);
		} else {
			$form = $this->input->post(NULL, TRUE);

			//get the intPartyID of the person who created the account
			$creator_id = $this->session->userdata('user_id');
			if(!$creator_id){
				$creator_id = NULL;
			}

			//create a new party for the user and select their role
			$party_id = $this->parties->create_party($creator_id);
			$role_id = $this->parties->select_role('user');
			$role_id = $role_id['intRoleID'];
			$partyrole_id = $this->parties->create_partyRole($party_id, $role_id);

			$this->parties->create_person($party_id, $form['first_name'], $form['last_name']);

			//select or create a dealership
			$dealership_id = $this->parties->select_dealerships($form['dealership']);
			if(!isset($dealership_id['intPartyID'])){
				$dealership_id = $this->parties->create_party($creator_id);
				$this->parties->create_dealership($dealership_id, $form['dealership']);
			} else {
				$dealership_id = $dealership_id['intPartyID'];
			}

			//select access rights
			$accessrights_id = $this->users->select_accessRights_byDesc($form['access_rights']);
			if(!isset($accessrights_id['intAccessRightsID'])){
				$this->session->set_flashdata('warning', 'Unknown access right.');
				redirect('users/create');
			} else {
				$accessrights_id = $accessrights_id['intAccessRightsID'];
			}
			
			//create a new user
			$this->users->create_user($partyrole_id, $dealership_id, $accessrights_id);
			$this->users->update_user_name($partyrole_id, $form['user_name']);
			$this->users->update_user_password($partyrole_id, crypt($form['password']));

			redirect('users');
		}
	}

	public function update($user_name){
		$data['title'] = 'Update ' . $user_name;
		$data['view'] = 'users/update';

		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// user data
		$data['view_data']['user'] = $this->users->select_users_byName($user_name);
		$data['view_data']['user']['access_right'] = $this->users->select_accessRights_byID($data['view_data']['user']['intAccessRightsID']);
		$data['view_data']['user']['dealership'] = $this->parties->select_dealership_byID($data['view_data']['user']['intDealershipID']);

		// party data
		$partyrole_id = $data['view_data']['user']['intPartyRoleID'];
		$partyrole = $this->parties->select_partyRole_byID($partyrole_id);
		$data['view_data']['user']['person'] = $this->parties->select_person_byID($partyrole['intPartyID']);

		// contact data
		$phone_email = $this->contacts->select_partyContactMechanisms_byPartyID($partyrole['intPartyID']);

		// check if a result was returned
		if(!isset($phone_email[0]['intPartyContactMechanismID'])){
			$phone_email_id = $this->contacts->create_partyContactMechanism($partyrole['intPartyID'], $partyrole['intRoleID'], '', '');
			$phone_email = $this->contacts->select_partyContactMechanism_byID($phone_email_id);
		} else {
			$phone_email = $phone_email[0];
		}

		$address = $this->contacts->select_contactMechanism_byID($phone_email['intContactMechanismID']);
		if(!isset($address['intGeographicBoundaryID'])){
			$address_id = $this->contacts->create_contactMechanism('','','');
			$address = $this->contacts->select_contactMechanism_byID($address_id);
			$this->contacts->update_partyContactMechanism_contactMechanismID($partyrole['intPartyID'], $partyrole['intRoleID'], $address_id);
		}

		$region = $this->contacts->select_geographicBoundary_byID($address['intGeographicBoundaryID']);
		if(!isset($region['intGeographicBoundaryID'])){
			$region = $this->contacts->select_geographicBoundary_byValues('', '', '');
			$region_id = $region['intGeographicBoundaryID'];
			$this->contacts->update_contactMechanism_geographicBoundaryID($address['intContactMechanismID'], $region_id);
		}
		
		$this->form_validation->set_rules('first_name', 'First name', 'required');
		$this->form_validation->set_rules('last_name', 'Last name', 'required');
		$this->form_validation->set_rules('user_name', 'User name', 'required|alpha_dash');

		if($this->form_validation->run() == FALSE){
			$data['view_data']['user']['contact'] = array_merge($phone_email, $address, $region);
			
			// editor data (user that is making the edits)
			$editor = $this->users->select_users_byID($this->session->userdata('user_id'));
			$editor['accessrights'] = $this->users->select_accessRights_byID($editor['intAccessRightsID']);
			$editor['dealership'] = $this->parties->select_dealership_byID($editor['intDealershipID']);
			//clean-up the editor obeject before passing it on
			unset($editor['strUserPass'], $editor['intAccessRightsID'], $editor['intDealershipID']);
			$data['view_data']['editor'] =  $editor;

			$data['view_data']['dealerships'] = $this->parties->select_dealerships();
			$data['view_data']['accessrights'] = $this->users->select_accessRights();

			$this->load->view('templates/standard', $data);	
		} else {
			$form = $this->input->post(NULL, TRUE);

			$this->parties->update_person($partyrole['intPartyID'], $form['first_name'], $form['last_name']);
			$this->contacts->update_contactMechanism_addressLines($address['intContactMechanismID'], $form['address_line1'], $form['address_line2']);
			$this->contacts->update_contactMechanism_postalCode($address['intContactMechanismID'], $form['postal_code']);

			$region = $this->contacts->select_geographicBoundary_byValues($form['city_name'], $form['prov_name'], $form['country_name']);
			if(!isset($region['intGeographicBoundaryID'])){
				$region_id = $this->contacts->create_geographicBoundary($form['city_name'], $form['prov_name'], $form['country_name']);
			} else {
				$region_id = $region['intGeographicBoundaryID'];
			}
			$this->contacts->update_contactMechanism_geographicBoundaryID($address['intContactMechanismID'], $region_id);

			$accessright = $this->users->select_accessRights_byDesc($form['access_rights']);
			$this->users->update_user_accessRights($partyrole_id, $accessright['intAccessRightsID']);

			$dealership = $this->parties->select_dealership_byName($form['dealership']);
			if(!isset($dealership['intDealershipID'])){
				$dealership_party_id = $this->parties->create_party($this->session->userdata('user_id'));
				$dealership_id = $this->parties->create_dealership($dealership_party_id, $form['dealership']);
			} else {
				$dealership_id = $dealership['intDealershipID'];
			}
			$this->users->update_user_dealership($partyrole_id, $dealership_id);
			redirect('/users/');
		}
	}

	public function destroy($user_name){
		$data['title'] = 'Delete user';
		$data['view'] = 'users/destroy';
		$data['view_data']['user'] = $this->users->select_users_byName($user_name);
		unset($data['view_data']['user']['strUserPass']);

		$this->load->helper('form');

		if($this->input->post('delete') == 'yes'){
			$this->load->model('party/party_model', 'parties');
			$user = $this->users->select_users_byName($user_name);
			$partyrole = $this->parties->select_partyRole_byID($user['intPartyRoleID']);

			//database is constructed to cascade when the party is deleted
			$this->parties->delete_party_byID($partyrole['intPartyID']);

			redirect('users');
		}
		if($this->input->post('delete') == 'no'){
			redirect('users');
		}

		$this->load->view('templates/standard', $data);
	}

	public function index($offset = 0, $limit = 1000, $format = 'html'){
		$data['title'] = 'Users';
		$data['view'] = 'users/index';
		$data['view_data']['users'] = $this->users->select_users($offset, $limit);

		$this->load->helper('form');
		$this->load->library('form_validation');

		if($format == 'html'){
			$this->load->view('templates/standard', $data);
		} else {
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data['view_data']['users']));
		}
	}

	public function view($user_slug, $format = 'html'){
		$data['title'] = ucfirst($user_slug);
		$data['view'] = 'users/view';
		$data['view_data']['user'] = $this->users->select_users_byName($user_slug);
		unset($data['view_data']['user']['strUserPass']);

		if($format == 'html'){
			$this->load->view('templates/standard', $data);
		} else {
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data['view_data']['user']));
		}
	}

	public function login(){
		$data['title'] = 'Login';
		$data['view'] = 'users/login';

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('user_name', 'User name', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run() == FALSE){
			$this->load->view('templates/standard', $data);
		} else {
			$form = $this->input->post(NULL, TRUE);

			$valid = $this->user_validation->validate_user($form['user_name'], $form['password']);
			if(!$valid){
				$this->session->set_flashdata('warning', 'Username or Password are incorrect.');
				redirect('users/login');
			} else {
				$user = $this->users->select_users_byName($form['user_name']);
				$this->session->set_userdata('user_id', $user['intPartyRoleID']);
				$this->session->set_userdata('accessrights', $user['intAccessRightsID']);
				$dealership = $this->parties->select_dealership_byID($user['intDealershipID']);
				$this->session->set_userdata('dealership', $dealership['strDealershipName']);
				$this->session->set_userdata('logged_in', TRUE);
				$this->user_validation->return_to_lastpage();
				redirect('/');
			}
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('/');
	}
}
?>