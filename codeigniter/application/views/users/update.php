<?php

echo validation_errors();
echo form_open('users/update/'. $this->uri->segment(3))."\n";

echo form_fieldset('Contact Info');

echo form_label('First Name', 'first_name');
echo form_input('first_name', set_value('first_name', $user['person']['strFirstName']))."<br />\n";

echo form_label('Last Name', 'last_name');
echo form_input('last_name', set_value('last_name', $user['person']['strLastName']))."\n<br />";

echo form_label('Address 1', 'address_line1');
echo form_input('address_line1', set_value('address_line1', $user['contact']['strAddressLine1']))."\n<br />";

echo form_label('Address 2', 'address_line2');
echo form_input('address_line2', set_value('address_line2', $user['contact']['strAddressLine2']))."\n<br />";

echo form_label('Postal Code', 'postal_code');
echo form_input('postal_code', set_value('postal_code', $user['contact']['strPostalCode']))."\n<br />";

echo form_label('City', 'city_name');
echo form_input('city_name', set_value('city_name', $user['contact']['strCityName']))."\n<br />";

echo form_label('Province', 'prov_name');
echo form_input('prov_name', set_value('prov_name', $user['contact']['strProvName']))."\n<br />";

echo form_label('Country', 'country_name');
echo form_input('country_name', set_value('country_name', $user['contact']['strCountryName']))."\n<br />";

echo form_fieldset_close()."\n";

echo form_fieldset('Account Info');

echo form_label('User Name', 'user_name');
echo form_input(array('name' => 'user_name', 'value' => $user['strUserName'], 'readonly' => 'readonly'))."<br />\n";

echo form_label('Permissions', 'access_rights');
$tiers = array();
foreach($accessrights as $ar){
	$tiers[$ar['strAccessRightsDescription']] = ucfirst(str_replace('_', ' ', $ar['strAccessRightsDescription']));
}

//do not allow user escalation!
if($editor['accessrights']['strAccessRightsDescription'] != 'master_admin'){
	unset($tiers['master_admin']);
}
echo form_dropdown('access_rights', $tiers, $user['access_right']['strAccessRightsDescription'])."<br />\n";

//only allow user to create a new user at their dealership
if($editor['accessrights']['strAccessRightsDescription'] != 'master_admin'){
	echo form_hidden('dealership', $user['dealership']['strDealershipName']);
} else {
	echo form_label('New Dealership', 'new_dealership');
	echo form_checkbox('new_dealership', 'new', FALSE)."<br />\n";
	echo form_label('Dealership', 'dealership');
	$dealership_dropdown = array();
	foreach($dealerships as $d){
		$dealership_dropdown[$d['strDealershipName']] = $d['strDealershipName'];
	}
	echo form_dropdown('dealership', $dealership_dropdown, $user['dealership']['strDealershipName'])."\n";
	echo form_input(array('name' => 'dealership', 'value' => '', 'hidden' => 'hidden', 'disabled' => 'disabled'))."\n";
}

echo form_fieldset_close()."\n";

echo form_submit('submit', 'Update User');

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