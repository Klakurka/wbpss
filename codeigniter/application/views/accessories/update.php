<?php
	echo validation_errors();
	echo form_open('accessories/update/'.$accessory['intAccessoryID'])."\n";
	
	echo form_label('Accessory Name', 'accessory_name');
	echo form_input('accessory_name', set_value('accessory_name', $accessory['strAccessoryName']))."<br />\n";
	
	foreach($model_prices as $m){
		echo form_label($m['strModelCode'], $m['strModelCode']);
		echo form_input(array('name' => $m['strModelCode'], 'value' => $m['numAccessoryPrice']));
		echo anchor("/accessories/destroy/{$accessory['intAccessoryID']}/{$m['strModelCode']}", 'remove')."<br />\n";
	}

	echo form_submit('submit', 'Update Accessory');
	
	echo form_close()."\n";
?>