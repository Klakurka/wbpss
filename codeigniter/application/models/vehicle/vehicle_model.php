<?php
class Vehicle_model extends CI_Model{
	private $vehicles;

	public function __construct(){
		parent::__construct();
		$this->vehicles = $this->load->database('vehicle', TRUE);
	}

	/***************************************
	 *	             CREATE                *
	 ***************************************/

	public function create_model($model_code, $model_name, $year, $trim_id, $make_id, $engineering_id, $slogan = ''){
		$this->vehicles->trans_start();

		$this->vehicles->insert('tblModel', array(
				'strModelCode' => $model_code,
				'strModelName' => $model_name,
				'intYear' => $year,
				'intTrimID' => $trim_id,
				'intMakeID' => $make_id,
				'intEngineeringFeatureID' => $engineering_id,
				'strModelSlogan' => $slogan
			));

		$model_id = $this->vehicles->insert_id();

		$this->vehicles->trans_complete();
		return $model_id;
	}

	public function create_model_feature_connection($model_code, $feature_id){
		$this->vehicles->trans_start();

		$this->vehicles->insert('tblModelFeature', array(
				'strModelCode' => $model_code,
				'intFeatureID' => $feature_id
			));

		$this->vehicles->trans_complete();
	}

	public function create_trim($trim_name){
		$this->vehicles->trans_start();

		$this->vehicles->insert('tblTrim', array(
				'strTrimName' => $trim_name
			));

		$trim_id = $this->vehicles->insert_id();

		$this->vehicles->trans_complete();
		return $trim_id;
	}

	public function create_engineering_feature($brake_id, $engine_id, $transmission_id, $steering_id, $capacity, $litres_city, $litres_hwy){
		$this->vehicles->trans_start();

		$this->vehicles->insert('tblEngineeringFeature', array(
				'intBrakeID' => $brake_id,
				'intEngineID' => $engine_id,
				'intSteeringID' => $steering_id,
				'intTransmissionID' => $transmission_id,
				'numFuelCapacity' => $capacity,
				'numLitresPer100km_City' => $litres_city,
				'numLitresPer100km_Hwy' => $litres_hwy
			));

		$engineering_id = $this->vehicles->insert_id();

		$this->vehicles->trans_complete();

		return $engineering_id;
	}

	public function create_engine($name, $horse_power, $torque){
		$this->vehicles->trans_start();

		$this->vehicles->insert('tblEngine', array(
				'strEngineName' => $name,
				'intHorsePower' => $horse_power['val'],
				'intHorsePowerRPM' => $horse_power['rpm'],
				'intTorque' => $torque['val'],
				'intTorqueRPM' => $torque['rpm']
			));

		$engine_id = $this->vehicles->insert_id();

		$this->vehicles->trans_complete();

		return $engine_id;
	}

	public function create_brake($name){
		$this->vehicles->trans_start();

		$this->vehicles->insert('tblBrake', array(
				'strBrakeName' => $name
			));

		$brake_id = $this->vehicles->insert_id();

		$this->vehicles->trans_complete();

		return $brake_id;
	}

	public function create_transmission($name){
		$this->vehicles->trans_start();

		$this->vehicles->insert('tblTransmission', array(
				'strTransmissionName' => $name
			));

		$transmission_id = $this->vehicles->insert_id();

		$this->vehicles->trans_complete();

		return $transmission_id;
	}

	public function create_steering($name){
		$this->vehicles->trans_start();

		$this->vehicles->insert('tblSteering', array(
				'strSteeringName' => $name
			));

		$steering_id = $this->vehicles->insert_id();

		$this->vehicles->trans_complete();

		return $steering_id;
	}

	public function create_colour($name, $code){
		$this->vehicles->trans_start();

		$this->vehicles->insert('tblColour', array(
				'strColourName' => $name,
				'strColourCode' => $code
			));

		$colour_id = $this->vehicles->insert_id();

		$this->vehicles->trans_complete();

		return $colour_id;
	}

	public function create_model_colour($model_id, $interior_id, $exterior_id){
		$this->vehicles->trans_start();
		$this->vehicles->trans_complete();
	}

	/***************************************
	 *	             SELECT                *
	 ***************************************/

	public function select_models($offset = 0, $limit = 1000){
		$this->vehicles->select('*');
		$this->vehicles->limit($limit, $offset);
		$this->vehicles->order_by('intYear', 'desc');

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
	 		$this->vehicles->order_by($this->session->flashdata('order'), $this->session->flashdata('dir'));
	 	}
	 	/*--- Search Database ---*/
	 	if (isset($_POST['search'])){
	 		$this->vehicles->like('strModelName', $_POST['search']);
	 		$this->vehicles->or_like('strModelCode', $_POST['search']);
	 		$this->vehicles->or_like('intYear', $_POST['search']);
	 	}

	 	$vehicles = $this->vehicles->get('tblModel');
		return $vehicles->result_array();
	}

	public function select_models_byCode($model_code){
		$this->vehicles->where('strModelCode', strtoupper($model_code));
		$models = $this->vehicles->get('tblModel');

		return $models->result_array();
	}

	public function select_makes(){
		$this->vehicles->select('intMakeID, strMakeName');
		$makes = $this->vehicles->get('tblMake');
		
		return $makes->result_array();
	}

	public function select_make_byName($name){
		$this->vehicles->select('intMakeID, strMakeName');
		$this->vehicles->where('strMakeName', $name);
		$make = $this->vehicles->get('tblMake');

		return $make->row_array();
	}

	public function select_trims(){
		$this->vehicles->select('intTrimID, strTrimName');
		$trims = $this->vehicles->get('tblTrim');

		return $trims->result_array();
	}

	public function select_trim_byID($id){
		$this->vehicles->select('intTrimID, strTrimName');
		$this->vehicles->where('intTrimID', $id);
		$trim = $this->vehicles->get('tblTrim');

		return $trim->row_array();
	}

	public function select_trim_byName($name){
		$this->vehicles->select('intTrimID, strTrimName');
		$this->vehicles->where('strTrimName', $name);
		$trim = $this->vehicles->get('tblTrim');

		return $trim->row_array();
	}

	public function select_engineering_feature($brake_id, $engine_id, $transmission_id, $steering_id, $capacity, $litres_city, $litres_hwy){
		$this->vehicles->select('*');
		$this->vehicles->where('intBrakeID', $brake_id);
		$this->vehicles->where('intEngineID', $engine_id);
		$this->vehicles->where('intSteeringID', $steering_id);
		$this->vehicles->where('intTransmissionID', $transmission_id);
		$this->vehicles->where('numFuelCapacity', $capacity);
		$this->vehicles->where('numLitresPer100km_City', $litres_city);
		$this->vehicles->where('numLitresPer100km_Hwy', $litres_hwy);
		
		$engineering = $this->vehicles->get('tblEngineeringFeature');
		return $engineering->row_array();
	}

	public function select_engineering_feature_byID($id){
		$this->vehicles->where('intEngineeringFeatureID', $id);
		$engineering = $this->vehicles->get('tblEngineeringFeature');
		return $engineering->row_array();
	}

	public function select_engines(){
		$this->vehicles->select('intEngineID, strEngineName');
		$engines = $this->vehicles->get('tblEngine');

		return $engines->result_array();
	}

	public function select_engine_byName($name){
		$this->vehicles->select('intEngineID, strEngineName');
		$this->vehicles->where('strEngineName', $name);
		$engines = $this->vehicles->get('tblEngine');

		return $engines->row_array();
	}

	public function select_engine_byID($id){
		$this->vehicles->select('*');
		$this->vehicles->where('intEngineID', $id);
		$engines = $this->vehicles->get('tblEngine');

		return $engines->row_array();
	}
	
	public function select_brakes(){
		$this->vehicles->select('intBrakeID, strBrakeName');
		$brakes = $this->vehicles->get('tblBrake');

		return $brakes->result_array();
	}

	public function select_brake_byName($name){
		$this->vehicles->select('intBrakeID, strBrakeName');
		$this->vehicles->where('strBrakeName', $name);
		$brakes = $this->vehicles->get('tblBrake');

		return $brakes->row_array();
	}
	
	public function select_brake_byID($id){
		$this->vehicles->select('*');
		$this->vehicles->where('intBrakeID', $id);
		$brakes = $this->vehicles->get('tblBrake');

		return $brakes->row_array();
	}

	public function select_transmissions(){
		$this->vehicles->select('intTransmissionID, strTransmissionName');
		$transmissions = $this->vehicles->get('tblTransmission');

		return $transmissions->result_array();
	}

	public function select_transmission_byName($name){
		$this->vehicles->select('intTransmissionID, strTransmissionName');
		$this->vehicles->where('strTransmissionName', $name);
		$transmissions = $this->vehicles->get('tblTransmission');

		return $transmissions->row_array();
	}

	public function select_transmission_byID($id){
		$this->vehicles->select('*');
		$this->vehicles->where('intTransmissionID', $id);
		$transmissions = $this->vehicles->get('tblTransmission');

		return $transmissions->row_array();
	}

	public function select_steerings(){
		$this->vehicles->select('intSteeringID, strSteeringName');
		$steerings = $this->vehicles->get('tblSteering');

		return $steerings->result_array();
	}

	public function select_steering_byName($name){
		$this->vehicles->select('intSteeringID, strSteeringName');
		$this->vehicles->where('strSteeringName', $name);
		$steering = $this->vehicles->get('tblSteering');

		return $steering->row_array();
	}
	
	public function select_steering_byID($id){
		$this->vehicles->select('*');
		$this->vehicles->where('intSteeringID', $id);
		$steering = $this->vehicles->get('tblSteering');

		return $steering->row_array();
	}

	public function select_colours(){
		$this->vehicles->select('intColourID, strColourCode, strColourName');
		$colours = $this->vehicles->get('tblColour');

		return $colours->result_array();
	}
	
	public function select_vehicle_byModelCode($model_code) {
		$this->vehicles->select('*');
		$this->vehicles->where('strModelCode', $model_code);
		$vehicles = $this->vehicles->get('tblModel');
		
		return $vehicles->row_array();
	}
	
	/***************************************
	 *	             UPDATE                *
	 ***************************************/

	public function update_model_code() {
		$this->vehicles->trans_start();
		
		$this->vehicles->trans_complete();
	}

	/***************************************
	 *	             DELETE                *
	 ***************************************/

	public function delete_model_feature_connection($model_code, $feature_id){
		$this->vehicles->where('strModelCode', $model_code);
		$this->vehicles->where('intFeatureID', $feature_id);
		$this->vehicles->delete('tblModelFeature');
	}
}
?>
