<?php
class Pricesheet_model extends CI_Model{
	private $pricesheets;

	public function __construct(){
		parent::__construct();
		$dealership = str_replace(' ', '', strtolower($this->session->userdata('dealership')));
		$this->pricesheets = $this->load->database('accessory_'.$dealership, TRUE);
	}

	/***************************************
	 *	             CREATE                *
	 ***************************************/

	public function create_pricesheet($model_code, $option_code, $color_code){
		$this->pricesheets->trans_start();

		$this->pricesheets->insert('tblPricesheet', array(
				'strModelCode' => $model_code,
				'strOptionCode' => $option_code,
				'strColorCode' => $color_code,
			));

		$pricesheet_id = $this->pricesheets->insert_id();
		//Grab accessories when needed from pricesheet-accessory table: Select * where pricesheet_id = $priceheetID

		$this->pricesheets->trans_complete();

		return $pricesheet_id;
	} 

	/***************************************
	 *	             SELECT                *
	 ***************************************/

	public function select_pricesheets($offset = 0, $limit = 1000){
	 	$this->pricesheets->select('*');
	 	$this->pricesheets->limit($limit, $offset);

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
	 		$this->features->order_by($this->session->flashdata('order'), $this->session->flashdata('dir'));
	 	}

	 	if (isset($_POST['search'])){
	 		if ($_POST['search'] != 'NULL'){
	 			$this->features->like('strFeatureName', $_POST['search']);
	 		}
	 	}

	 	if ($this->session->userdata('order') != FALSE && $this->session->userdata('dir') != FALSE){
	 		$this->pricesheets->order_by($this->session->userdata('order'), $this->session->userdata('dir'));
	 	}

	 	if (isset($_POST['search'])){
	 		if ($_POST['search'] != 'NULL'){
	 			$this->pricesheets->like('intPricesheetID', $_POST['search']);
	 			//$this->pricesheets->or_like('model_code', $_POST['search']);
	 			//$this->pricesheets->like('option_code', $_POST['search']);
	 			//$this->pricesheets->like('colour_code', $_POST['search']);
	 		}
	 	}


	 	$pricesheets = $this->pricesheets->get('tblPricesheet');

	 	return $pricesheets->result_array();
		
	}

	/***************************************
	 *	             UPDATE                *
	 ***************************************/

	public function update_pricesheet_byID($model_code, $option_code, $color_code, $pricesheet_id){
		$this->pricesheets->trans_start();

		$this->pricesheets->where('intPricesheetID', $pricesheet_id);
		$this->pricesheets->update('tblPricesheet', array(
			'strModelCode' => $model_code,
			'strOptionCode' => $option_code,
			'strColorCode' => $color_code
			));
		$this->pricesheets->trans_complete();
	}

	/***************************************
	 *	             DELETE                *
	 ***************************************/

	public function delete_pricesheet_byID($pricesheet_id){
		$this->pricesheets->trans_start();

		$this->pricesheets->where('intPricesheetID', $pricesheet_id);
		$this->pricesheets->delete('tblPricesheet');

		$this->pricesheets->trans_complete();
	}
}
?>