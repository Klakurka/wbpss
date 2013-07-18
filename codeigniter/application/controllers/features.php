<?php
class Features extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('vehicle/feature_model', 'features');
		$this->load->model('vehicle/vehicle_model', 'vehicles');
	}
	
	public function ajax(){
		$feature_name = $this->input->get('term');
		$features_model = $this->features->select_features_byNameLike($feature_name);
		$features = array();
		foreach($features_model as $f){
		$features[] = array(
				'id' => $f['intFeatureID'],
				'label' => $f['strFeatureName'],
				'value' => $f['strFeatureName']
			);
		}
		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($features));
	}

	public function index($offset = 0, $limit = 1000, $format = 'html'){
		$data['title'] = 'Features';
		$data['view'] = 'features/index';
		$data['view_data']['features'] = $this->features->select_features($offset, $limit);
		$data['view_data']['offset'] = $offset;
		$data['view_data']['limit'] = $limit;
		$data['view_data']['more'] = FALSE;

		$this->load->helper('form');
		$this->load->library('form_validation');

		$next = $this->features->select_features($offset + $limit, $limit);
		if(!empty($next)){
			$data['view_data']['more'] = TRUE;
		}
		

		if($format == 'html'){
			$this->load->view('templates/standard', $data);
		} else {
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($data['view_data']['features']));
		}
	}
	
	public function create(){
		$data['title'] = 'Create Feature';
		$data['view'] = 'features/create';

		$this->load->model('vehicle/vehicle_model', 'vehicles');

		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('feature_name', 'Feature Name', 'required');

		if($this->form_validation->run() == FALSE){
			$this->load->view('templates/standard', $data);
		} else {
			$form = $this->input->post(NULL, TRUE);

			$feature_name = trim($form['feature_name']);
			$feature = $this->features->select_feature_byName($feature_name);
			if(!isset($feature['intFeatureID'])){
				$feature_id = $this->features->create_feature($feature_name);
			} else {
				$feature_id = $feature['intFeatureID'];
			}
			$model_feature = $this->features->select_modelFeature_byIDandCode($feature_id, $form['model_code']);
			if(!isset($model_feature['intFeatureID']) && isset($form['model_code'])){
				$this->vehicles->create_model_feature_connection($form['model_code'], $feature_id);
			} else {
				$this->session->set_flashdata('warning', 'That feature is already attached to model '.$form['model_code']);
				redirect('features');
			}

			redirect('features');
		}
	}

	public function view($feature_id, $format = 'html'){
		$data['view'] = 'features/view';
		$data['view_data']['feature'] = $this->features->select_feature_byID($feature_id);
		$data['title'] = $data['view_data']['feature']['strFeatureName'];
		
		if($format == 'html'){
			$this->load->view('templates/standard', $data);
		} else {
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($data['view_data']['feature']));
		}
	}
	
	public function update($feature_id){
		$data['view'] = 'features/update';
		$data['view_data']['feature'] = $this->features->select_feature_byID($feature_id);
		$data['view_data']['models'] = $this->features->select_modelFeatures_byID($feature_id);
		$data['title'] = 'Update Feature';

		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('feature_name', 'Feature name', 'required');

		if($this->form_validation->run() == FALSE){
			$this->load->view('templates/standard', $data);
		} else {
			$form = $this->input->post(NULL, TRUE);
			$this->features->update_feature_byID($feature_id, $form['feature_name']);
			redirect('features');
		}
	}
	
	public function destroy($feature_id, $model_code = NULL){
		$data['title'] = 'Delete Feature';
		$data['view'] = 'features/destroy';
		$data['view_data']['feature'] = $this->features->select_feature_byID($feature_id);
		if(isset($model_code)){
			$data['view_data']['feature']['strModelCode'] = $model_code;
		}

		$this->load->helper('form');

		switch($this->input->post('delete')){
			case 'yes':
				if(isset($model_code)){
					$this->vehicles->delete_model_feature_connection($model_code, $feature_id);
				} else {
					$this->features->delete_feature_byID($feature_id);
				}
			case 'no':
				if(isset($model_code)){
					redirect("features/update/{$feature_id}");
				}
				redirect('features');
		}

		$this->load->view('templates/standard', $data);
	}
}
?>