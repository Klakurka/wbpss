<?php
class Accessory_model extends CI_Model{
	private $accessories;

	public function __construct(){
		parent::__construct();
		$dealership = str_replace(' ', '', strtolower($this->session->userdata('dealership')));
		$this->accessories = $this->load->database('accessory_'.$dealership, TRUE);
	}

	/***************************************
	 *	             CREATE                *
	 ***************************************/

	public function create_accessory($accessory_name){
		$this->accessories->trans_start();

		$this->accessories->insert('tblAccessory', array(
				'strAccessoryName' => $accessory_name
			));

		$accessory_id = $this->accessories->insert_id();

		$this->accessories->trans_complete();

		return $accessory_id;
	}

	public function create_accessory_model_connection($accessory_id, $model_code, $price){
		$this->accessories->trans_start();

		$this->accessories->insert('tblModelAccessory', array(
				'intAccessoryID' => $accessory_id,
				'strModelCode' => $model_code,
				'numAccessoryPrice' => $price
			));

		$this->accessories->trans_complete();
	}

	/***************************************
	 *	             SELECT                *
	 ***************************************/

	public function select_accessories($offset = 0, $limit = 1000){
	 	$this->accessories->select('intAccessoryID, strAccessoryName');
	 	$this->accessories->limit($limit, $offset);

	 	$order = $search = $dir = NULL;

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
	 		$this->accessories->order_by($this->session->flashdata('order'), $this->session->flashdata('dir'));
	 	}

	 	if (isset($_POST['search'])){
	 		if ($_POST['search'] != 'NULL'){
	 			$this->accessories->like('strAccessoryName', $_POST['search']);
	 		}
	 	}

	 	$accessories = $this->accessories->get('tblAccessory');

	 	return $accessories->result_array();
	}

	public function select_accessory_byName($accessory_name){
		$this->accessories->select('intAccessoryID, strAccessoryName');
		$this->accessories->like('strAccessoryName', $accessory_name);
		$accessories = $this->accessories->get('tblAccessory');

		return $accessories->row_array();
	}

	public function select_modelAccessories_byID($accessory_id){
		$this->accessories->select('a.intAccessoryID, a.strAccessoryName, ma.strModelCode, ma.numAccessoryPrice');
		$this->accessories->join('tblAccessory a', 'a.intAccessoryID = ma.intAccessoryID');
		$this->accessories->where('a.intAccessoryID', $accessory_id);
		$accessories = $this->accessories->get('tblModelAccessory ma');

		return $accessories->result_array();
	}

	public function select_accessory_byID($accessory_id){
		$this->accessories->select('intAccessoryID, strAccessoryName');
		$this->accessories->where('intAccessoryID', $accessory_id);
		$accessory = $this->accessories->get('tblAccessory');

		return $accessory->row_array();
	}

	public function select_accessories_byModelCode($model_code){
		$this->accessories->select('a.intAccessoryID, a.strAccessoryName, ma.strModelCode, ma.numAccessoryPrice');
		$this->accessories->join('tblAccessory a', 'a.intAccessoryID = ma.intAccessoryID');
		$this->accessories->where('ma.strModelCode', $model_code);
		$accessories = $this->accessories->get('tblModelAccessory ma');

		return $accessories->result_array();
	}

	/***************************************
	 *	             UPDATE                *
	 ***************************************/
	
	public function update_accessory_byID($accessory_id, $accessory_name){
		$this->accessories->trans_start();

		$this->accessories->where('intAccessoryID', $accessory_id);
		$this->accessories->update('tblAccessory', array(
				'strAccessoryName' => $accessory_name
			));

		$this->accessories->trans_complete();
	}
	
	/***************************************
	 *	             DELETE                *
	 ***************************************/

	public function delete_accessory_byID($accessory_id){
		$this->accessories->trans_start();

		$this->accessories->where('intAccessoryID', $accessory_id);
		$this->accessories->delete('tblAccessory');

		$this->accessories->trans_complete();
	}

	public function delete_accessory_model_connection($accessory_id, $model_code){
		$this->vehicles->where('strModelCode', $model_code);
		$this->vehicles->where('intAccessoryID', $accessory_id);
		$this->vehicles->delete('tblModelAccessory');
	}
}
?>