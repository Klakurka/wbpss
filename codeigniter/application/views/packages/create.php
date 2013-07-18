<?php
	echo validation_errors();
	echo form_open('packages/create/'.$model_code.'/'.$option_code)."\n";

	echo form_fieldset('Features for ' . $model_code . ' ' . $option_code);
	foreach($features as $f){
		echo form_label($f['strFeatureName'], $f['strFeatureName']);
		echo form_checkbox($f['strFeatureName']) . '<br>';
	}
	echo form_fieldset_close()."\n";
	
	echo form_fieldset('Pricing for ' . $model_code . ' ' . $option_code);
	echo form_label('Dealer Net', 'dealer_net');
	echo form_input('dealer_net')."<br />\n";
	
	echo form_label('MSRP', 'msrp');
	echo form_input('msrp')."<br />\n";
	echo form_fieldset_close()."\n";
	
	echo form_submit('submit', 'Create Package');
	echo form_close()."\n";
?>