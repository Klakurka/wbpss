<?php
class Feature_model extends CI_Model{
	private $features;

	public function __construct(){
		parent::__construct();
		$this->features = $this->load->database('vehicle', TRUE);
	}

	/***************************************
	 *	             CREATE                *
	 ***************************************/

	public function create_feature($feature_name){
		$this->features->trans_start();

		$this->features->insert('tblFeature', array(
				'strFeatureName' => $feature_name
			));

		$feature_id = $this->features->insert_id();

		$this->features->trans_complete();

		return $feature_id;
	}

	/***************************************
	 *	             SELECT                *
	 ***************************************/

	public function select_features($offset = 0, $limit = 1000){
		$this->features->select('intFeatureID, strFeatureName');
		$this->features->limit($limit, $offset);

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

	 	$features = $this->features->get('tblFeature');
		return $features->result_array();
	}

	public function select_feature_byName($feature_name){
		$this->features->select('intFeatureID, strFeatureName');
		$this->features->where('strFeatureName', $feature_name);
		$features = $this->features->get('tblFeature');

		return $features->row_array();
	}

	public function select_features_byNameLike($feature_name){
		$this->features->select('intFeatureID, strFeatureName');
		$this->features->like('strFeatureName', $feature_name);
		$features = $this->features->get('tblFeature');

		return $features->result_array();
	}

	public function select_feature_byID($feature_id){
		$this->features->select('intFeatureID, strFeatureName');
		$this->features->where('intFeatureID', $feature_id);
		$features = $this->features->get('tblFeature');

		return $features->row_array();
	}

	public function select_modelFeatures_byID($feature_id){
		$this->features->select('intFeatureID, strModelCode');
		$this->features->where('intFeatureID', $feature_id);
		$model_features = $this->features->get('tblModelFeature');

		return $model_features->result_array();
	}

	public function select_modelFeature_byIDandCode($feature_id, $model_code){
		$this->features->select('intFeatureID, strModelCode');
		$this->features->where('intFeatureID', $feature_id);
		$this->features->where('strModelCode', $model_code);
		$model_features = $this->features->get('tblModelFeature');

		return $model_features->row_array();
	}
	
	public function select_modelFeatures_byModelCode($model_code){
		$this->features->select('f.intFeatureID, f.strFeatureName');
		$this->features->where('strModelCode', $model_code);
		$this->features->join('tblFeature f', 'mf.intFeatureID = f.intFeatureID');
		$model_features = $this->features->get('tblModelFeature mf');

		return $model_features->result_array();
	}

	/***************************************
	 *	             UPDATE                *
	 ***************************************/

	public function update_feature_byID($feature_id, $feature_name){
		$this->features->trans_start();

		$this->features->where('intFeatureID', $feature_id);
		$this->features->update('tblFeature', array(
				'strFeatureName' => $feature_name
			));

		$this->features->trans_complete();
	}
	
	/***************************************
	 *	             DELETE                *
	 ***************************************/

	public function delete_feature_byID($feature_id){
		$this->features->trans_start();

		$this->features->where('intFeatureID', $feature_id);
		$this->features->delete('tblFeature');

		$this->features->trans_complete();
	}
}
?>