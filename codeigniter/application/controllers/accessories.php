<?php
class Accessories extends CI_Controller{
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in')){
			$this->load->model('accessory/accessory_model', 'accessories');
		}
	}

	public function index($offset = 0, $limit = 1000, $format = 'html'){
		$data['title'] = 'Accessories';
		$data['view'] = 'accessories/index';
		$data['view_data']['accessories'] = $this->accessories->select_accessories($offset, $limit);
		$data['view_data']['offset'] = $offset;
		$data['view_data']['limit'] = $limit;
		$data['view_data']['more'] = FALSE;

		$this->load->helper('form');
		$this->load->library('form_validation');

		$next = $this->accessories->select_accessories($offset + $limit, $limit);
		if(!empty($next)){
			$data['view_data']['more'] = TRUE;
		}
		
		if($format == 'html'){
			$this->load->view('templates/standard', $data);
		} else {
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data['view_data']['accessories']));
		}
	}
	
	public function create(){
		$data['title'] = 'Create Accessory';
		$data['view'] = 'accessories/create';
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('vehicle/vehicle_model', 'vehicles');
		
		$dealership_name = str_replace(' ', '', strtolower($this->session->userdata('dealership')));

		$this->form_validation->set_rules('accessory_name', 'Accessory Name', 'required');
		$this->form_validation->set_rules('model_code', 'Model Code', 'required');
		$this->form_validation->set_rules('accessory_price', 'Accessory Price', 'required|is_numeric');

		if($this->form_validation->run() == FALSE){
			$this->load->view('templates/standard', $data);
		} else {
			$form = $this->input->post(NULL, TRUE);

			$accessory_name = trim($form['accessory_name']);
			$accessory = $this->accessories->select_accessory_byName($accessory_name);
			if(!isset($accessory['intAccessoryID'])){
				$accessory_id = $this->accessories->create_accessory($accessory_name);
			} else {
				$accessory_id = $accessory['intAccessoryID'];
			}
			
			$this->accessories->create_accessory_model_connection($accessory_id, $form['model_code'], $form['accessory_price']);
			redirect('accessories');
		}
	}

	public function view($accessory_name){
		$data['title'] = $accessory_name;
		$data['view'] = 'accessories/view';
		
		$this->load->view('templates/standard', $data);
	}
	
	public function update($accessory_id){
		$data['title'] = 'Update Accessory';
		$data['view'] = 'accessories/update';
		$data['view_data']['accessory'] = $this->accessories->select_accessory_byID($accessory_id);
		$data['view_data']['model_prices'] = $this->accessories->select_modelAccessories_byID($data['view_data']['accessory']['intAccessoryID']);
		
		$this->load->model('party/party_model', 'parties');
		$this->load->model('party/contact_model', 'contacts');

		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('accessory_name', 'Accessory name', 'required');

		if($this->form_validation->run() == FALSE){
			$this->load->view('templates/standard', $data);
		} else {
			$form = $this->input->post(NULL, TRUE);
			$this->accessories->update_accessory_byID($accessory_id, $form['accessory_name']);
			redirect('accessories');
		}
	}
	
	public function destroy($accessory_id, $model_code = NULL){
		$data['title'] = 'Delete Accessory';
		$data['view'] = 'accessories/destroy';
		$data['view_data']['accessory'] = $this->accessories->select_accessory_byID($accessory_id);
		if(isset($model_code)){
			$data['view_data']['accessory']['strModelCode'] = $model_code;
		}

		$this->load->helper('form');
		
		switch($this->input->post('delete')){
			case 'yes':
				if(isset($model_code)){
					$this->accessories->delete_accessory_model_connection($accessory_id, $model_code);
				} else {
					$this->accessories->delete_accessory_byID($accessory_id);
				}
			case 'no':
				if(isset($model_code)){
					redirect("accessories/update/{$accessory_id}");
				}
				redirect('accessories');
		}

		$this->load->view('templates/standard', $data);
	}
}
?>