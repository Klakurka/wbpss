<?php
echo validation_errors();
echo form_open('users/create')."\n";

echo form_fieldset('Contact Info');

echo form_label('First Name', 'first_name');
echo form_input(array('name' => 'first_name', 'required' => 'required'))."<br />\n";

echo form_label('Last Name', 'last_name');
echo form_input(array('name' => 'last_name', 'required' => 'required'))."\n<br />";

echo form_fieldset_close()."\n";

echo form_fieldset('Account Info');

echo form_label('User Name', 'user_name');
echo form_input(array('name' => 'user_name', 'required' => 'required'))."<br />\n";

echo form_label('Password', 'password');
echo form_password(array('name' => 'password', 'value' => '', 'autocomplete' => 'false', 'required' => 'required' ))."<br />\n";

echo form_label('Password', 'password_conf');
echo form_password(array('name' => 'password_conf', 'value' => '', 'autocomplete' => 'false', 'required' => 'required' ))."<br />\n";

echo form_label('Permissions', 'access_rights');
$tiers = array();
foreach($accessrights as $ar){
	$tiers[$ar['strAccessRightsDescription']] = ucfirst(str_replace('_', ' ', $ar['strAccessRightsDescription']));
}

//do not allow user escalation!
if($creator['accessrights']['strAccessRightsDescription'] != 'master_admin'){
	unset($tiers['master_admin']);
}
echo form_dropdown('access_rights', $tiers, $creator['accessrights']['strAccessRightsDescription'])."<br />\n";

//only allow user to create a new user at their dealership
if($creator['accessrights']['strAccessRightsDescription'] != 'master_admin'){
	echo form_hidden('dealership', $creator['dealership']['strDealershipName']);
} else {
	echo form_label('New Dealership', 'new_dealership');
	echo form_checkbox('new_dealership', 'new', FALSE)."<br />\n";
	echo form_label('Dealership', 'dealership');
	$dealership_dropdown = array();
	foreach($dealerships as $d){
		$dealership_dropdown[$d['strDealershipName']] = $d['strDealershipName'];
	}
	echo form_dropdown('dealership', $dealership_dropdown, $creator['dealership']['strDealershipName'])."\n";
	echo form_input(array('name' => 'dealership', 'value' => '', 'hidden' => 'hidden', 'disabled' => 'disabled'))."\n";
}

echo form_fieldset_close()."\n";

echo form_submit('submit', 'Create User');

echo form_close()."\n";
?>
<script>
	$(function(){
		$('[name=new_dealership]').change(function(){
			if(this.checked){
				$('select[name=dealership]').attr('hidden', 'hidden');
				$('select[name=dealership]').attr('disabled', 'disabled');
				$('[type=text][name=dealership]').removeAttr('hidden');
				$('[type=text][name=dealership]').removeAttr('disabled');
			} else {
				$('[type=text][name=dealership]').attr('hidden', 'hidden');
				$('[type=text][name=dealership]').attr('disabled', 'disabled');
				$('select[name=dealership]').removeAttr('hidden');
				$('select[name=dealership]').removeAttr('disabled');
			}
		})
	});
</script>