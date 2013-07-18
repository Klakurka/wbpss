<?php
$feature_name = $feature['strFeatureName'];
$model_code = '';
if(isset($feature['strModelCode'])){
	$model_code = $feature['strModelCode'];
	$feature_name .= " ({$model_code})";
}
echo form_open("features/destroy/{$feature['intFeatureID']}/{$model_code}");
echo form_label('Are you sure you want to delete '.$feature_name.'?', 'delete');
echo form_submit('delete', 'yes');
echo form_submit('delete', 'no');

echo form_close();
?>