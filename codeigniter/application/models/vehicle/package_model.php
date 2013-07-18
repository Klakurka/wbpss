<?php
class Package_model extends CI_Model{
	private $packages;

	public function __construct(){
		parent::__construct();
		$this->packages = $this->load->database('vehicle', TRUE);
	}

	/***************************************
	 *	             CREATE                *
	 ***************************************/

	public function create_package($option_code, $model_id, $trim_id, $net = 0, $msrp = 0){
		$this->packages->trans_start();

		$this->packages->insert('tblOption', array(
				'strOptionCode' => $option_code,
				'intModelID' => $model_id,
				'intTrimID' => $trim_id,
				'intDealerNet' => $net,
				'intMSRP' => $msrp
			));

		$package_id = $this->packages->insert_id();

		$this->packages->trans_complete();

		return $package_id;
	}

	public function create_package_feature_connection($package_id, $feature_id){
		$this->packages->trans_start();

		$this->packages->insert('tblOptionFeature', array(
				'intOptionID' => $package_id,
				'intFeatureID' => $feature_id
			));

		$this->packages->trans_complete();
	}

	/***************************************
	 *	             SELECT                *
	 ***************************************/

	public function select_package_byID($package_id){
		$this->packages->where('intOptionID', $package_id);
		$package = $this->packages->get('tblOption');
		$package = $package->row_array();

		$this->packages->select('f.intFeatureID, f.strFeatureName');
		$this->packages->where('intOptionID', $package_id);
		$this->packages->join('tblFeature f', 'f.intFeatureID = of.intFeatureID');
		$features = $this->packages->get('tblOptionFeature');

		$package['features'] = $features->result_array();

		return $package;
	}
	
	public function select_packageID_byModelOption($model_code, $option_code){
		$this->packages->select('intOptionID');
		$this->packages->join('tblModel m', 'm.intModelID = o.intModelID');
		$this->packages->where('strModelCode', $model_code);
		$this->packages->where('strOptionCode', $option_code);
		$package = $this->packages->get('tblOption o');
		
		return $package->row_array();
	}
	
	public function select_packages_byModelIDTrimID($model_id, $trim_id){
		$this->packages->where('intModelID', $model_id);
		$this->packages->where('intTrimID', $trim_id);
		$packages = $this->packages->get('tblOption');
		$packages = $packages->result_array();

		return $packages;
	}

	/***************************************
	 *	             UPDATE                *
	 ***************************************/
	
	//write update functions for dealer-net & msrp
	
	/***************************************
	 *	             DELETE                *
	 ***************************************/

	public function delete_package_feature_connection($package_id, $feature_id){
		$this->packages->trans_start();

		$this->packages->where('intOptionID',$package_id);
		$this->packages->where('intFeatureID', $feature_id);
		$this->packages->delete('tblOptionFeature');

		$this->packages->trans_complete();
	}
}
?>
