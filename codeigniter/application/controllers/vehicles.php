<?php
class Vehicles extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('vehicle/vehicle_model', 'vehicles');
		$this->load->model('vehicle/package_model', 'packages');
	}
	
	public function ajax(){
		$model_name = $this->input->get('term');
		$vehicles_model = $this->vehicles->select_models_byNameLike($model_name);
		$models = array();
		foreach($vehicles_model as $f){
		$models[] = array(
				'id' => $f['intModelID'],
				'label' => $f['strModelName'],
				'value' => $f['strModelName']
			);
		}
		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($models));
	}
	
	public function index($offset = 0, $limit = 1000, $format = 'html'){
		$data['title'] = 'Vehicles';
		$data['view'] = 'vehicles/index';

		$data['view_data']['vehicles'] = array();
		$vehicles = $this->vehicles->select_models($offset, $limit);
		
		foreach($vehicles as $k => $v){
			$trim = $this->vehicles->select_trim_byID($v['intTrimID']);
			$engineering = $this->vehicles->select_engineering_feature_byID($v['intEngineeringFeatureID']);
			$transmission = $this->vehicles->select_transmission_byID($engineering['intTransmissionID']);

			$options = $this->packages->select_packages_byModelIDTrimID($v['intModelID'], $v['intTrimID']);

			$model = $v;
			$model['strTrimName'] = $trim['strTrimName'];
			$model['strTransmissionName'] = $transmission['strTransmissionName'];

			if(count($options) > 0){
				foreach($options as $o){
					array_push($data['view_data']['vehicles'], array_merge($model, $o));
				}
			} else {
				array_push($data['view_data']['vehicles'], array_merge($model, array('strOptionCode' => '', 'intMSRP' => 0)));
			}
		}

		$data['view_data']['offset'] = $offset;
		$data['view_data']['limit'] = $limit;
		$data['view_data']['more'] = FALSE;

		$this->load->helper('form');
		$this->load->library('form_validation');

		$next = $this->vehicles->select_models($offset + $limit, $limit);
		if(!empty($next)){
			$data['view_data']['more'] = TRUE;
		}
		

		if($format == 'html'){
			$this->load->view('templates/standard', $data);
		} else {
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($data['view_data']['vehicles']));
		}
	}
	
	public function create(){
		$data['title'] = 'Create Vehicle';
		$data['view'] = 'vehicles/create';

		$data['view_data']['years'] = array();
		for($i = (intval(date("Y")) - 2); $i <= (intval(date("Y")) + 2); $i++){
			$data['view_data']['years'][$i] = $i;
		}

		$data['view_data']['trims'] = array();
		$trims = $this->vehicles->select_trims();
		foreach($trims as $t){
			$data['view_data']['trims'][$t['strTrimName']] = $t['strTrimName'];
		}

		$data['view_data']['makes'] = array();
		$makes = $this->vehicles->select_makes();
		foreach($makes as $m){
			$data['view_data']['makes'][$m['strMakeName']] = $m['strMakeName'];
		}

		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('model_code', 'Model Code', 'required');
		$this->form_validation->set_rules('model_name', 'Model Name', 'required');
		$this->form_validation->set_rules('make', 'Make', 'required');
		$this->form_validation->set_rules('year', 'Year', 'required');
		$this->form_validation->set_rules('trim', 'Trim', 'required');

		$this->form_validation->set_rules('city', 'City Fuel Efficiency', 'required|is_numeric');
		$this->form_validation->set_rules('highway', 'Highway Fuel Efficiency', 'required|is_numeric');
		$this->form_validation->set_rules('capacity', 'Fuel Capacity', 'required|is_numeric');

		$this->form_validation->set_rules('engine_name', 'Engine Name', 'required');
		$this->form_validation->set_rules('horse_power', 'Horse Power', 'required|is_numeric');
		$this->form_validation->set_rules('torque', 'Torque', 'required|is_numeric');
		$this->form_validation->set_rules('horse_rpm', 'Horse Power RPM', 'required|is_numeric');
		$this->form_validation->set_rules('torque_rpm', 'Torque RPM', 'required|is_numeric');
		$this->form_validation->set_rules('transmission', 'Transmission', 'required');
		$this->form_validation->set_rules('brakes', 'Brakes', 'required');
		$this->form_validation->set_rules('steering', 'Steering', 'required');

		//$this->form_validation->set_rules('option_code[]', 'Option Code', 'required');

		if($this->form_validation->run() == FALSE){
			$this->load->view('templates/standard', $data);
		} else {
			$form = $this->input->post(NULL, TRUE);

			$trim = $this->vehicles->select_trim_byName($form['trim']);
			
			//if the trim doesn't exist we need to create it
			if(!isset($trim['intTrimID'])){
				$trim_id = $this->vehicles->create_trim($form['trim']);
			} else {
				$trim_id = $trim['intTrimID'];
			}

			//does this model code exist already?
			$form['model_code'] = strtoupper($form['model_code']);
			$model = $this->vehicles->select_model_byCode($form['model_code']);

			$model_exists = FALSE;
			foreach($model as $m){
				if($m['intTrimID'] == $trim_id){
					$model_exists = TRUE;
					$model = $m;
					break;
				}
			}

			if(!$model_exists){
				$make = $this->vehicles->select_make_byName($form['make']);
				$make_id = $make['intMakeID'];

				//engine
				$engine = $this->vehicles->select_engine_byName($form['engine_name']);
				if(!isset($engine['intEngineID'])){
					$engine_id = $this->vehicles->create_engine($form['engine_name'],
						array('val' => $form['horse_power'], 'rpm' => $form['horse_rpm']), 
						array('val' => $form['torque'], 'rpm' => $form['torque_rpm']));
				} else {
					$engine_id = $engine['intEngineID'];
				}

				//transmission
				$transmission = $this->vehicles->select_transmission_byName($form['transmission']);
				if(!isset($transmission['intTransmissionID'])){
					$transmission_id = $this->vehicles->create_transmission($form['transmission']);
				} else {
					$transmission_id = $transmission['intTransmissionID'];
				}

				//brakes
				$brakes = $this->vehicles->select_brake_byName($form['brakes']);
				if(!isset($brakes['intBrakeID'])){
					$brake_id = $this->vehicles->create_brake($form['brakes']);
				} else {
					$brake_id = $brakes['intBrakeID'];
				}

				//steering
				$steering = $this->vehicles->select_steering_byName($form['steering']);
				if(!isset($steering['intSteeringID'])){
					$steering_id = $this->vehicles->create_steering($form['steering']);
				} else {
					$steering_id = $steering['intSteeringID'];
				}
				
				//engineering feature
				$engineering = $this->vehicles->select_engineering_feature(
					$brake_id,
					$engine_id,
					$transmission_id,
					$steering_id,
					$form['capacity'],
					$form['city'],
					$form['highway']
				);
				if(!isset($engineering['intEngineeringFeatureID'])){
					$engineering_id = $this->vehicles->create_engineering_feature(
						$brake_id,
						$engine_id,
						$transmission_id,
						$steering_id,
						$form['capacity'],
						$form['city'],
						$form['highway']
					);
				} else {
					$engineering_id = $engineering['intEngineeringFeatureID'];
				}

				//model
				$model = $this->vehicles->create_model(
					$form['model_code'], $form['model_name'], $form['year'], $trim_id, $make_id, $engineering_id, $form['slogan']);
			}
			
			$option_codes = array();
			foreach($form['option_code'] as $k => $v){
				if(!is_null($v) && !empty($v)){
					$option_codes[] = $v;
				}
			}
			
			if(count($option_codes) > 0){
				$this->load->model('vehicle/package_model', 'packages');
				foreach($option_codes as $o){
					$this->packages->create_package(strtoupper($o), $model, $trim_id);
				}
			
				$initial_code = array_shift($option_codes);
				$this->session->set_flashdata('option_codes', $option_codes);
				redirect("packages/create/{$form['model_code']}/{$initial_code}");
			}
		}
	}

	public function view($model_code, $option_code){
		$data['title'] = $model_code . $option_code;
		$data['view'] = 'vehicles/view';
		$data['view_data']['user'] = $this->users->select_vehicle_byName($user_slug);
		
		
		$this->load->view('templates/standard', $data);
	}
	
	public function update($model_code, $option_code){
		$data['title'] = 'Update Vehicle';
		$data['view'] = 'vehicles/update';
		$data['view_data']['vehicle'] = $this->vehicles->select_vehicle_byModelCode($model_code);
		$data['view_data']['vehicle']['trim'] = $this->vehicles->select_trim_byID($data['view_data']['vehicle']['intTrimID']);
		$data['view_data']['vehicle']['engineeringFeature'] = $this->vehicles->select_engineering_feature_byID($data['view_data']['vehicle']['intEngineeringFeatureID']);
		$data['view_data']['vehicle']['engineeringFeature']['engine'] = $this->vehicles->select_engine_byID($data['view_data']['vehicle']['engineeringFeature']['intEngineID']);
		$data['view_data']['vehicle']['engineeringFeature']['transmission'] = $this->vehicles->select_transmission_byID($data['view_data']['vehicle']['engineeringFeature']['intTransmissionID']);
		$data['view_data']['vehicle']['engineeringFeature']['brake'] = $this->vehicles->select_brake_byID($data['view_data']['vehicle']['engineeringFeature']['intBrakeID']);
		$data['view_data']['vehicle']['engineeringFeature']['steering'] = $this->vehicles->select_steering_byID($data['view_data']['vehicle']['engineeringFeature']['intSteeringID']);
		$data['view_data']['package']['strOptionCode'] = $option_code;
		
		$data['view_data']['years'] = array();
		for($i = (intval(date("Y")) - 2); $i <= (intval(date("Y")) + 2); $i++){
			$data['view_data']['years'][$i] = $i;
		}
		
		$data['view_data']['trims'] = array();
		$trims = $this->vehicles->select_trims();
		foreach($trims as $t){
			$data['view_data']['trims'][$t['strTrimName']] = $t['strTrimName'];
		}

		$data['view_data']['makes'] = array();
		$makes = $this->vehicles->select_makes();
		foreach($makes as $m){
			$data['view_data']['makes'][$m['strMakeName']] = $m['strMakeName'];
		}

		$this->load->helper('form');
		$this->load->library('form_validation');
		
		if($this->form_validation->run() == FALSE){
			$this->load->view('templates/standard', $data);
		} else {

		}
	}
	
	public function destroy($model_code, $option_code){
		$data['title'] = 'Delete Vehicle';
		$data['view'] = 'vehicles/destroy';
		$data['view_data']['vehicle'] = $this->vehicles->select_vehicle_byID($model_code, $option_code);

		$this->load->helper('form');
		$this->load->library('form_validation');
		
		switch($this->input->post('delete')){
			// $model_code becomes $intModelID in here because of the last line ($this->load->view('templates/standard', $data);)... not sure why.
			case 'yes':
				$this->vehicles->delete_vehicle_byID($model_code, $option_code);
				
				// Check if there are no more options for that model. Remove the model if this is the case.
				$numberOfRows = $this->vehicles->select_vehicle_options_rows_byModelID($model_code);
				//echo $numberOfRows;
				if ($numberOfRows == 0) {
					$this->vehicles->delete_model_byID($model_code);	
				}
			case 'no':
				redirect('vehicles');
		}

		$this->load->view('templates/standard', $data);
	}
}
?>
