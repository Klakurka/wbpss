<?php
echo form_open("pricesheets/destroy/{$pricesheet['intPricesheetID']}");

echo form_label('Are you sure you want to delete '.$pricesheet['strPricesheetName'].'?', 'delete');
echo form_submit('delete', 'yes');
echo form_submit('delete', 'no');

echo form_close();
?>