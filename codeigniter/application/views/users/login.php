<?php
echo validation_errors();
echo form_open('users/login')."\n";

echo form_label('User name', 'user_name');
echo form_input(array('name' => 'user_name', 'autofocus' => 'autofocus'))."\n";

echo form_label('Password','password');
echo form_password('password')."\n";

echo form_submit('submit', 'Login')."\n";

echo form_close()."\n";
?>