<?php
class User_model extends CI_Model{
	private $users;

	public function __construct(){
		parent::__construct();
		$this->users = $this->load->database('user', TRUE);
	}

	/***************************************
	 *	             CREATE                *
	 ***************************************/

	public function create_accessRights($accessrights_desc){
		$this->users->trans_start();

		//for later use

		$this->users->trans_complete();
	}

	public function create_user($partyrole_id, $dealership_id, $accessrights_id){
		$this->users->trans_start();

		$this->users->insert('tblUser', array(
				'intPartyRoleID' => $partyrole_id,
				'intDealershipID' => $dealership_id,
				'intAccessRightsID' => $accessrights_id
			));
		$user_id = $this->users->insert_id();

		$this->users->trans_complete();
		return $user_id;
	}

	/***************************************
	 *	             SELECT                *
	 ***************************************/

	public function select_accessRights(){
		$this->users->select('intAccessRightsID, strAccessRightsDescription, master');
		$accessrights = $this->users->get('vUserHierarchy');

		return $accessrights->result_array();
	}
	public function select_accessRights_byDesc($accessrights_desc){
		$this->users->select('intAccessRightsID, strAccessRightsDescription, master');
		$this->users->where('strAccessRightsDescription', $accessrights_desc);
		$accessrights = $this->users->get('vUserHierarchy');

		return $accessrights->row_array();
	}

	public function select_accessRights_byID($accessrights_id){
		$this->users->select('intAccessRightsID, strAccessRightsDescription, master');
		$this->users->where('intAccessRightsID', $accessrights_id);
		$accessrights = $this->users->get('vUserHierarchy');

		return $accessrights->row_array();
	}

	public function select_users($offset = 0, $limit = 1000){
	 	$this->users->select('strUserName, intDealershipID, intAccessRightsID');

	 	if ($this->uri->segment(1) == $this->session->flashdata('page')){
			$this->session->keep_flashdata('order');
			$this->session->keep_flashdata('dir');
 			$this->session->keep_flashdata('page');
		}

		if (isset($_POST['order']) && isset($_POST['dir'])){
	 		if ($_POST['order'] != NULL && $_POST['dir'] != NULL){
	 			$this->session->set_flashdata('order', $_POST['order']);
	 			$this->session->set_flashdata('dir', $_POST['dir']);
	 			$this->session->set_flashdata('page', $this->uri->segment(1));
	 			//$_SESSION['order'] = $_POST['order'];
	 			//$_SESSION['dir'] = $_POST['dir'];
	 		}
	 	}

	 	if ($this->session->flashdata('page') == $this->uri->segment(1)){
	 		$this->users->order_by($this->session->flashdata('order'), $this->session->flashdata('dir'));
	 	}

	 	if (isset($_POST['search'])){
	 		if ($_POST['search'] != 'NULL'){
	 			$this->users->like('strUserName', $_POST['search']);
	 			$this->users->or_like('intDealershipID', $_POST['search']);
	 			$this->users->or_like('intAccessRightsID', $_POST['search']);
	 		}
	 	}

	 	$users = $this->users->get('tblUser');

	 	return $users->result_array();
	}

	public function select_users_byID($userid){
		$this->users->select('intPartyRoleID, strUserName, strUserPass, intDealershipID, intAccessRightsID');
		$this->users->where('intPartyRoleID', $userid);
		$users = $this->users->get('tblUser');

		return $users->row_array();
	}

	public function select_users_byName($username){
		$this->users->select('intPartyRoleID, strUserName, strUserPass, intDealershipID, intAccessRightsID');
		$this->users->where('LOWER(strUserName)', strtolower($username));
		$users = $this->users->get('tblUser');

		return $users->row_array();
	}

	/***************************************
	 *	             UPDATE                *
	 ***************************************/

	public function update_accessRights($accessrights_id){
		$this->users->trans_start();

		// later use

		$this->users->trans_complete();
	}

	public function update_user_dealership($partyrole_id, $dealership_id){
		$this->users->trans_start();

		$this->users->where('intPartyRoleID', $partyrole_id);
		$this->users->update('tblUser', array(
				'intDealershipID' => $dealership_id
			));

		$this->users->trans_complete();
	}

	public function update_user_accessRights($partyrole_id, $accessrights_id){
		$this->users->trans_start();

		$this->users->where('intPartyRoleID', $partyrole_id);
		$this->users->update('tblUser', array(
				'intAccessRightsID' => $accessrights_id
			));
		$this->users->trans_complete();
	}

	public function update_user_name($partyrole_id, $name){
		$this->users->trans_start();

		$this->users->where('intPartyRoleID', $partyrole_id);
		$this->users->update('tblUser', array(
				'strUserName' => $name
			));

		$this->users->trans_complete();
	}

	public function update_user_password($partyrole_id, $password){
		$this->users->trans_start();

		$this->users->where('intPartyRoleID', $partyrole_id);
		$this->users->update('tblUser', array(
				'strUserPass' => $password
			));

		$this->users->trans_complete();
	}

	/***************************************
	 *	             DELETE                *
	 ***************************************/
}
?>