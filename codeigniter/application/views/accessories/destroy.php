<?php
$accessory_name = $accessory['strAccessoryName'];
$model_code = '';
if(isset($accessory['strModelCode'])){
	$model_code = $accessory['strModelCode'];
	$accessory_name .= " ({$model_code})";
}
echo form_open("accessories/destroy/{$accessory['intAccessoryID']}/$model_code");
echo form_label('Are you sure you want to delete '.$accessory_name.'?', 'delete');
echo form_submit('delete', 'yes');
echo form_submit('delete', 'no');

echo form_close();
?>