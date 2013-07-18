<?php
	echo form_open("vehicles/destroy/{$vehicle['intModelID']}/{$vehicle['intOptionID']}");
	
	echo form_label('Are you sure you want to delete '.$vehicle['strModelName' . ' ' . 'strOptionName'].'?', 'delete');
	echo form_submit('delete', 'yes');
	echo form_submit('delete', 'no');
	
	echo form_close();
?>