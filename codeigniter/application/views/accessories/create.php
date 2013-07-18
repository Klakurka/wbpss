<?php
	echo validation_errors();
	echo form_open('accessories/create')."\n";
	
	echo form_label('Accessory Name', 'accessory_name');
	echo form_input(array('name' => 'accessory_name', 'class' => 'autocomplete', 'data-method' => 'accessories/ajax'))."<br />\n";

	echo form_label('Model Code', 'model_code');
	echo form_input(array('name' => 'model_code'))."<br />\n";

	echo form_label('Price', 'accessory_price');
	echo form_input(array('name' => 'accessory_price'))."<br />\n";

	echo form_submit('submit', 'Create Accessory');
	
	echo form_close()."\n";
?>