<?php
	echo validation_errors()."\n";
	echo form_open($this->router->class."/".$this->uri->segment(2)."/".$this->uri->segment(3), array('id' => 'metaForm', 'name' => 'metaForm', 'class' => 'hidden'))."\n";
	if ($this->session->flashdata('page') == $this->uri->segment(1)){
		echo form_input(array('id' => 'order', 'name' => 'order', 'value' => $this->session->flashdata('order')))."\n";
		echo form_input(array('id' => 'dir', 'name' => 'dir', 'value' => $this->session->flashdata('dir')))."\n";
	} else {
		echo form_input(array('id' => 'order', 'name' => 'order'))."\n";
		echo form_input(array('id' => 'dir', 'name' => 'dir'))."\n";
	}
	echo form_close()."\n";

echo '<div class="title">
	<span onclick="order(this);" id="strUserName" class="large">Username</span>
	<span onclick="order(this);" id="intDealershipID" class="large">Dealership</span>
	<span onclick="order(this);" id="intAccessRightsID" class="large">Permissions</span>
	<span class="tiny center">Edit</span>
	<span class="tiny center">Delete</span>
	</div>';
	
foreach($users as $user){
	$dealership = $this->parties->select_dealership_byID($user['intDealershipID']);
	$dealership_name = $dealership['strDealershipName'];
	$permissions = $this->users->select_accessRights_byID($user['intAccessRightsID']);
	$permissions_name = $permissions['strAccessRightsDescription'];
	echo '<div class="row">'."\n"."\n";
	echo '<span class="large">'.$user['strUserName'].'</span>'."\n";
	echo '<span class="large">'.$dealership_name.'</span>'."\n";
	if ($permissions_name == 'master_admin') {
		echo '<span class="large">Master Admin</span>'."\n";
	} elseif ($permissions_name == 'local_admin') {
		echo '<span class="large">Local Admin</span>'."\n";
	} else {
		echo '<span class="large">Dealer</span>'."\n";
	}
	
	echo '<span class="tiny center">'.anchor('users/update/'.$user['strUserName'], image_asset("edit.png")).'</span>'."\n";
	echo '<span class="tiny center">'.anchor('users/destroy/'.$user['strUserName'], image_asset("delete.png")).'</span>'."\n";
	echo '</div>';
}	
?>

<!--

echo validation_errors()."\n";
echo form_open($this->router->class, array('id' => 'metaForm', 'name' => 'metaForm', 'class' => 'hidden'))."\n";
if(isset($_SESSION['order']) && isset($_SESSION['dir'])){
	echo form_input(array('id' => 'order', 'name' => 'order', 'value' => $_SESSION['order']))."\n";
	echo form_input(array('id' => 'dir', 'name' => 'dir', 'value' => $_SESSION['dir']))."\n";
} else {
	echo form_input(array('id' => 'order', 'name' => 'order'))."\n";
	echo form_input(array('id' => 'dir', 'name' => 'dir'))."\n";
}
echo form_close()."\n";

echo '<div class="title">
	<span onclick="order(this);" id="strUserName" class="large">Username</span>
	<span onclick="order(this);" id="strDealershipName" class="large">Dealership</span>
	<span onclick="order(this);" id="intAccessRightsID" class="large">Permissions</span>
	<span class="tiny center">Edit</span>
	<span class="tiny center">Delete</span>
	</div>';
	
foreach($users as $user){
	echo '<div class="row">'."\n"."\n";
	foreach ($user as $value){
		echo '<span class="large">'.$value.'</span>'."\n";
	}
	echo '<span class="tiny center">'.anchor('users/update/'.$user['strUserName'], image_asset("edit.png")).'</span>'."\n";
	echo '<span class="tiny center">'.anchor('users/destroy/'.$user['strUserName'], image_asset("delete.png")).'</span>'."\n";
	echo '</div>';
}	

-->