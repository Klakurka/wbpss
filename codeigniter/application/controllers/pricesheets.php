<?php
class Pricesheets extends CI_Controller{
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in')){
			$this->load->model('accessory/pricesheet_model', 'pricesheets');
		}
	}
	
	public function index($offset = 0, $limit = 1000){
		$data['title'] = 'Price-Sheets';
		$data['view'] = 'pricesheets/index';
		$data['view_data']['pricesheets'] = $this->pricesheets->select_pricesheets($offset, $limit);
		$data['view_data']['offset'] = $offset;
		$data['view_data']['limit'] = $limit;
		$data['view_data']['more'] = FALSE;

		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->load->model('party/party_model', 'parties');
		$this->load->model('party/contact_model', 'contacts');
		
		$this->load->view('templates/standard', $data);
		
		$this->load->helper('form');
		$this->load->library('form_validation');
	}
	
	public function create(){
		$data['title'] = 'Create Price-Sheet';
		$data['view'] = 'pricesheets/create';

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->load->model('party/party_model', 'parties');
		$this->load->model('party/contact_model', 'contacts');
		
		$this->load->view('templates/standard', $data);
	}

	public function view($pricesheet_id){
		$data['title'] = $pricesheet_id;
		$data['view'] = 'pricesheets/view';
		
		$this->load->view('templates/standard', $data);
	}
	
	public function update($pricesheet_id){
		$data['title'] = 'Update Pricesheet';
		$data['view'] = 'pricesheets/update';

		$this->load->model('party/party_model', 'parties');
		$this->load->model('party/contact_model', 'contacts');

		$this->load->helper('form');
		$this->load->library('form_validation');
	}
	
	public function destroy($pricesheet_id){
		$data['title'] = 'Delete Price-Sheet';
		$data['view'] = 'pricesheets/destroy';

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->load->view('templates/standard', $data);
	}
	
	public function printPricesheet($pricesheet_id){
		$data['title'] = 'Print Price-Sheet';
		$data['view'] = 'pricesheets/print';

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->load->view('templates/standard', $data);
	}
}
?>