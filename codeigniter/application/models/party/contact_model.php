<?php
//include 'party_model.php';

class Contact_model extends CI_Model{
	private $contacts;

	public function __construct(){
		parent::__construct();
		$this->contacts = $this->load->database('user', TRUE);
	}
	/***************************************
	 *	             CREATE                *
	 ***************************************/

	public function create_partyContactMechanism($party_id, $role_id, $phone_no, $email, $contact_mechanism_id = NULL){
		$this->contacts->trans_start();

		$this->contacts->insert('tblPartyContactMechanism', array(
				'intPartyID' => $party_id,
				'intRoleID' => $role_id,
				'strPhoneNumber' => $phone_no,
				'strEmail' => $email,
				'intContactMechanismID' => $contact_mechanism_id
			));
		$pcm_id = $this->contacts->insert_id();

		$this->contacts->trans_complete();
		return $pcm_id;
	}

	public function create_contactMechanism($address1, $address2, $postal_code, $geo_id = NULL){
		$this->contacts->trans_start();

		$this->contacts->insert('tblContactMechanism', array(
				'strAddressLine1' => $address1,
				'strAddressLine2' => $address2,
				'strPostalCode' => $postal_code,
				'intGeographicBoundaryID' => $geo_id
			));
		$contact_id = $this->contacts->insert_id();

		$this->contacts->trans_complete();
		return $contact_id;
	}

	public function create_geographicBoundary($city, $prov, $country){
		$this->contacts->trans_start();

		$this->contacts->insert('tblGeographicBoundary', array(
				'strCityName' => $city,
				'strProvName' => $prov,
				'strCountryName' => $country
			));
		$geo_id = $this->contacts->insert_id();

		$this->contacts->trans_complete();
		return $geo_id;
	}

	/***************************************
	 *	             SELECT                *
	 ***************************************/
	
	public function select_partyContactMechanisms_byPartyID($partyID) {
		$this->contacts->select('intPartyContactMechanismID, intContactMechanismID, strPhoneNumber, strEmail');
		$this->contacts->where('intPartyID', $partyID);
		$contacts = $this->contacts->get('tblPartyContactMechanism');

		return $contacts->result_array();
	}

	public function select_partyContactMechanism_byID($pcm_id){
		$this->contacts->select('intPartyContactMechanismID, intContactMechanismID, strPhoneNumber, strEmail');
		$this->contacts->where('intPartyContactMechanismID', $pcm_id);
		$contacts = $this->contacts->get('tblPartyContactMechanism');

		return $contacts->row_array();
	}
	
	public function select_contactMechanism_byID($contactMechanismID) {
		$this->contacts->select('intContactMechanismID, intGeographicBoundaryID, strAddressLine1, strAddressLine2, strPostalCode');
		$this->contacts->where('intContactMechanismID', $contactMechanismID);
		$contacts = $this->contacts->get('tblContactMechanism');

		return $contacts->row_array();
	}
	
	public function select_geographicBoundary_byID($geographicBoundaryID) {
		$this->contacts->select('intGeographicBoundaryID, strCityName, strProvName, strCountryName');
		$this->contacts->where('intGeographicBoundaryID', $geographicBoundaryID);
		$contacts = $this->contacts->get('tblGeographicBoundary');

		return $contacts->row_array();
	}

	public function select_geographicBoundary_byValues($city, $prov, $country){
		$this->contacts->select('intGeographicBoundaryID, strCityName, strProvName, strCountryName');
		$this->contacts->like('strCityName', $city);
		$this->contacts->like('strProvName', $prov);
		$this->contacts->like('strCountryName', $country);
		$contacts = $this->contacts->get('tblGeographicBoundary');

		return $contacts->row_array();
	}

	/***************************************
	 *	             UPDATE                *
	 ***************************************/

	public function update_partyContactMechanism_phoneNumber($party_id, $role_id, $phone_number){
		$this->contacts->trans_start();

		$this->contacts->where('intPartyID', $party_id);
		$this->contacts->where('intRoleID', $role_id);
		$this->contacts->update('tblPartyContactMechanism', array(
				'strPhoneNumber' => $phone_number
			));

		$this->contacts->trans_complete();
	}
	
	public function update_partyContactMechanism_eMail($party_id, $role_id, $email){
		$this->contacts->trans_start();

		$this->contacts->where('intPartyID', $party_id);
		$this->contacts->where('intRoleID', $role_id);
		$this->contacts->update('tblPartyContactMechanism', array(
				'strEmail' => $email
			));

		$this->contacts->trans_complete();
	}

	public function update_partyContactMechanism_contactMechanismID($party_id, $role_id, $contact_mechanism_id){
		$this->contacts->trans_start();

		$this->contacts->where('intPartyID', $party_id);
		$this->contacts->where('intRoleID', $role_id);
		$this->contacts->update('tblPartyContactMechanism', array(
				'intContactMechanismID' => $contact_mechanism_id
			));

		$this->contacts->trans_complete();
	}


	public function update_contactMechanism_addressLines($cm_id, $line1, $line2 = NULL){
		$this->contacts->trans_start();

		$address = array('strAddressLine1' => $line1);
		if(isset($line2)){
			$address = array_merge($address, array('strAddressLine2' => $line2));
		}

		$this->contacts->where('intContactMechanismID', $cm_id);
		$this->contacts->update('tblContactMechanism', $address);

		$this->contacts->trans_complete();
	}

	public function update_contactMechanism_postalCode($cm_id, $postal_code){
		$this->contacts->trans_start();

		$this->contacts->where('intContactMechanismID', $cm_id);
		$this->contacts->update('tblContactMechanism', array(
				'strPostalCode' => strtoupper(str_replace(' ', '', $postal_code))
			));

		$this->contacts->trans_complete();
	}

	public function update_contactMechanism_geographicBoundaryID($cm_id, $geo_id){
		$this->contacts->trans_start();

		$this->contacts->where('intContactMechanismID', $cm_id);
		$this->contacts->update('tblContactMechanism', array(
				'intGeographicBoundaryID' => $geo_id
			));

		$this->contacts->trans_complete();
	}
	
	public function update_geographicBoundary($party_id, $role_id){
		$this->contacts->trans_start();

		$this->contacts->where('intPartyID', $party_id);
		$this->contacts->where('intRoleID', $role_id);

		$this->contacts->trans_complete();
	}
	
	/***************************************
	 *	             DELETE                *
	 ***************************************/

	public function delete_contact_by_party_and_role_id($party_id, $role_id){
		$this->contacts->trans_start();

		$this->contacts->where('intPartyID', $party_id);
		$this->contacts->where('intRoleID', $role_id);
		$this->contacts->delete('tblPartyContactMechanism');

		//delete_party_by_id();

		$this->contacts->trans_complete();
	}
}
?>