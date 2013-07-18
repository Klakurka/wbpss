<?php
	echo validation_errors();
	echo form_fieldset('Print Price-Sheet');
	
	echo form_label('Stock Number', 'stock_number');
	echo form_input('stock_number')."<br />\n";
	
	echo form_label('Serial Number', 'serial_number');
	echo form_input('serial_number')."<br />\n";
	
	echo form_label('Number of Copies', 'number_of_copies');
	echo form_input('number_of_copies')."<br />\n";
	
	echo form_fieldset_close()."\n";
	echo form_submit('submit', 'Print');
	echo form_close()."\n";
?>