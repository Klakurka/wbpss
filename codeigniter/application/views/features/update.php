<?php
	echo validation_errors();
	echo form_open('features/update/'.$feature['intFeatureID'])."\n";
	
	echo form_label('Feature Name', 'feature_name');
	echo form_input('feature_name', set_value('feature_name', $feature['strFeatureName']))."<br />\n";
	
	foreach($models as $m){
		echo form_label($m['strModelCode'], $m['strModelCode']);
		echo anchor("/features/destroy/{$feature['intFeatureID']}/{$m['strModelCode']}", 'remove')."<br />\n";
	}
	echo form_submit('submit', 'Update Feature');
	
	echo form_close()."\n";
?>