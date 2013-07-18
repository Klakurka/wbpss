<?php
	echo validation_errors();
	echo form_open('features/create')."\n";
	
	echo form_label('Feature Name', 'feature_name');
	echo form_input(array('name' => 'feature_name', 'class' => 'autocomplete', 'data-method' => 'features/ajax', 'required' => 'required'))."<br />\n";

	echo form_label('Model Code', 'model_code');
	echo form_input(array('name' => 'model_code', 'required' => 'required'))."<br />\n";

	echo form_submit('submit', 'Create Feature');
	
	echo form_close()."\n";
?>