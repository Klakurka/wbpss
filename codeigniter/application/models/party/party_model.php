<?php
class Party_model extends CI_Model{
	private $parties;

	public function __construct(){
		parent::__construct();
		$this->parties = $this->load->database('user', TRUE);
	}

	/***************************************
	 *	             CREATE                *
	 ***************************************/

	public function create_party($creator = NULL){
		$this->parties->trans_start();

		$values = array();
		if($creator != NULL){
			$creator = $this->select_party($creator);
			$creator = $creator['intPartyID'];	
		}
		$values['intCreatedByPartyID'] = $creator;

		$this->parties->insert('tblParty', $values);

		$party_id = $this->parties->insert_id();

		$this->parties->trans_complete();
		return $party_id;
	}

	public function create_role($role_description){
		$this->parties->trans_start();

		$this->parties->insert('tblRole', array(
				'strRoleDescription' => $role_description
			));

		$role_id = $this->parties->insert_id();

		$this->parties->trans_complete();
		return $role_id;
	}

	public function create_partyRole($party_id, $role_id){
		$this->parties->trans_start();

		$this->parties->insert('tblPartyRole', array(
				'intPartyID' => $party_id,
				'intRoleID' => $role_id
			));
		$partyrole_id = $this->parties->insert_id();

		$this->parties->trans_complete();
		return $partyrole_id;
	}

	public function create_dealership($party_id, $dealership_name){
		$this->parties->trans_start();

		$this->parties->insert('tblDealership', array(
				'intPartyID' => $party_id,
				'strDealershipName' => $dealership_name
			));
		$dealership_id = $this->parties->insert_id();

		$this->parties->trans_complete();
		return $dealership_id;
	}

	public function create_person($party_id, $first_name, $last_name){
		$this->parties->trans_start();

		$this->parties->insert('tblPerson', array(
				'intPartyID' => $party_id,
				'strFirstName' => $first_name,
				'strLastName' => $last_name
			));
		$person_id = $this->parties->insert_id();

		$this->parties->trans_complete();
		return $person_id;
	}

	/***************************************
	 *	             SELECT                *
	 ***************************************/

	public function select_party($party_id){
		$this->parties->select('intPartyID, tmCreationDate, intCreatedByPartyID');
		$party = $this->parties->get('tblParty');

		return $party->row_array();
	}

	public function select_role($role_description){
		$this->parties->select('intRoleID');
		$this->parties->where('strRoleDescription', $role_description);
		$role = $this->parties->get('tblRole');

		return $role->row_array();
	}

	public function select_partyRole_byID($partyrole_id){
		$this->parties->select('intPartyRoleID, intPartyID, intRoleID');
		$this->parties->where('intPartyRoleID', $partyrole_id);
		$party_role = $this->parties->get('tblPartyRole');

		return $party_role->row_array();
	}

	public function select_dealerships(){
		$this->parties->select('intPartyID, strDealershipName');
		$dealership = $this->parties->get('tblDealership');

		return $dealership->result_array();
	}

	public function select_dealership_byID($dealership_id){
		$this->parties->select('intPartyID, strDealershipName');
		$this->parties->where('intPartyID', $dealership_id);
		$dealership = $this->parties->get('tblDealership');

		return $dealership->row_array();
	}

	public function select_dealership_byName($dealership_name){
		$this->parties->select('intPartyID, strDealershipName');
		$this->parties->where('strDealershipName', $dealership_name);
		$dealership = $this->parties->get('tblDealership');

		return $dealership->row_array();
	}

	public function select_person_byID($party_id){
		$this->parties->select('intPartyID, strFirstName, strLastName');
		$this->parties->where('intPartyID', $party_id);
		$person = $this->parties->get('tblPerson');
		return $person->row_array();
	}

	public function select_persons($first_name = NULL, $last_name = NULL){
		$this->parties->select('intPartyID, strFirstName, strLastName');
		if($first_name != NULL){
			$this->parties->where('strFirstName', $first_name);
		}
		if($last_name != NULL){
			$this->parties->where('strLastName', $last_name);
		}
		$persons = $this->parties->get('tblPerson');

		if($persons->num_rows() > 1){
			return $persons->result_array();
		}
		return $person->row_array();
	}

	/***************************************
	 *	             UPDATE                *
	 ***************************************/

	public function update_role($role_id, $role_desc){
		$this->parties->trans_start();

		$this->parties->where('intRoleID', $role_id);
		$this->parties->update('tblRole', array(
				'strRoleDescription' => $role_desc
			));

		$this->parties->trans_complete();
	}

	public function update_dealership($party_id, $dealership_name){
		$this->parties->trans_start();
		$this->parties->trans_complete();
	}

	public function update_person($party_id, $first_name, $last_name = NULL){
		$this->parties->trans_start();

		$person = array('strFirstName' => $first_name);
		if(isset($last_name)){
			$person = array_merge($person, array('strLastName' => $last_name));
		}
		$this->parties->where('intPartyID', $party_id);
		$this->parties->update('tblPerson', $person);

		$this->parties->trans_complete();
	}

	/***************************************
	 *	             DELETE                *
	 ***************************************/

	public function delete_party_byID($party_id){
		$this->parties->trans_start();

		$this->parties->where('intPartyID', $party_id);
		$this->parties->delete('tblParty');

		$this->parties->trans_complete();
	}
}
?>