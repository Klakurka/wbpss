<?php
echo validation_errors();
echo form_open();

echo form_label('Are you sure you wish to delete ' . $user['strUserName'] .'?', 'yes')."\n";

echo form_submit('delete', 'yes')."\n";
echo form_submit('delete', 'no')."\n";

echo form_close();
?>