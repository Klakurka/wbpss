<?php
class Packages extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('vehicle/package_model', 'packages');
		$this->load->model('vehicle/feature_model', 'features');
	}
	
	public function create($model_code, $option_code){
		$offset = 0;
		$limit = 1000;
		$data['title'] = 'Create Feature Package';
		$data['view'] = 'packages/create';
		$data['view_data']['model_code'] = $model_code;
		$data['view_data']['option_code'] = $option_code;
		$data['view_data']['options'] = $this->session->flashdata('option_codes');
		$data['view_data']['features'] = $this->features->select_modelFeatures_byModelCode($model_code);

		$this->session->set_flashdata('option_codes', $data['view_data']['options']);
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		if($this->form_validation->run() == FALSE){
			$this->load->view('templates/standard', $data);
		} else {
			$form = $this->input->post(NULL, TRUE);
			
			//select package
			$package = $this->packages->select_packageID_byModelOption($model_code, $option_code);
			$package_id = $package['intOptionID'];
			
			//add the features to the package
			$this->load->model('vehicle/feature_model', 'features');
			foreach($form['features'] as $f){
				$feature = $this->features->select_feature_byName($f);
				$feature_id = $feature['intFeatureID'];
				$this->packages->create_package_feature_connection($package_id, $feature_id);
			}
			
			//check if we are done
			if(count($data['view_data']['options']) > 0){
			
				//get next option code
				$option_codes = $this->session->flashdata('option_codes');
				$option_code = array_shift($option_codes);
				$this->session->set_flashdata('option_codes', $option_codes);
			
				//redirect to next package
				redirect("packages/create/{$model_code}/{$option_code}");
			} else {
				redirect('vehicles');
			}
		}
	}
	
	public function update($model_code, $option_code){
		$data['title'] = 'Update Feature Package';
		$data['view'] = 'packages/update';
		
		$this->load->helper('form');
	}
}
?>
