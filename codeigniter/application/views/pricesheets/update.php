<?php
echo validation_errors();
echo form_open('pricesheets/update')."\n";

echo form_fieldset('Vehicle');
	echo form_label('Model Code', 'model_code');
	echo form_input('model_code')."<br />\n";

	echo form_label('Option Code', 'option_code');
	echo form_input('option_code')."<br />\n";
echo form_fieldset_close();

echo form_fieldset('Packages');
	echo '<div class="packages">';
		echo form_label('Packages', 'packages') . '<br>';
		echo form_label('That', 'That') . '<br>';
		echo form_label('Match', 'Match') . '<br>';
		echo form_label('The', 'The') . '<br>';
		echo form_label('Vehicle', 'Vehicle') . '<br>';
		echo form_label('Model Code', 'Model Code') . '<br>';
	echo '</div>';
echo form_fieldset_close();

// List all accessories that match the model code used in the vehicle.
// Each line will have a checkbox (to enable/disable) as well as a price field.
// Have it look like a mini version of the index pages.
echo form_fieldset('Accessories');
	echo '<div class="accessories">';
		echo form_label('Accessories', 'accessories');
		echo form_checkbox('package1' ) . '<br>';
		echo form_label('That', 'That');
		echo form_checkbox('package1') . '<br>';
		echo form_label('Match', 'Match');
		echo form_checkbox('package1' ) . '<br>';
		echo form_label('The', 'The');
		echo form_checkbox('package1') . '<br>';
		echo form_label('Vehicle', 'Vehicle');
		echo form_checkbox('package1' ) . '<br>';
		echo form_label('Model Code', 'Model Code');
		echo form_checkbox('package1' );
	echo '</div>';
echo form_fieldset_close();

// Auto-complete for colours
// Colours are deleted when all price-sheets containing it is deleted
echo form_fieldset('Colours');
	echo '<div class="colours">';
		
		// Partially C & P and converted from user create
		echo form_label('New External Colour', 'new_external_colour');
		echo form_checkbox('new_external_colour', 'new_external_colour', FALSE)."<br />\n";
		echo form_label('External Colour Code', 'external_colour_code');
		echo form_input('external_colour_code')."<br />\n";
		echo form_label('External Colour Name', 'external_colour_name');
		echo form_input(array('name' => 'external_colour', 'value' => '','disabled' => 'disabled'))."<br />\n";
		echo '<br>';
		
		echo form_label('New Internal Colour', 'new_internal_colour');
		echo form_checkbox('new_internal_colour', 'new_internal_colour', FALSE)."<br />\n";
		echo form_label('Internal Colour Code', 'internal_colour_code');
		echo form_input('internal_colour_code')."<br />\n";
		echo form_label('Internal Colour Name', 'internal_colour_name');
		echo form_input(array('name' => 'internal_colour', 'value' => '', 'disabled' => 'disabled'))."<br />\n";
	echo '</div>';
echo form_fieldset_close();

echo form_submit('submit', 'Create Price-Sheet');

echo form_close()."\n";
?>

<script>
	$(function(){
		$('[name=new_external_colour]').change(function(){
			if(this.checked){
				$('select[name=external_colour]').attr('disabled', 'disabled');
				$('[type=text][name=external_colour]').removeAttr('disabled');
			} else {
				$('[type=text][name=external_colour]').attr('disabled', 'disabled');
				$('select[name=external_colour]').removeAttr('disabled');
			}
		})
	});
	
	$(function(){
		$('[name=new_internal_colour]').change(function(){
			if(this.checked){
				$('select[name=internal_colour]').attr('disabled', 'disabled');
				$('[type=text][name=internal_colour]').removeAttr('disabled');
			} else {
				$('[type=text][name=internal_colour]').attr('disabled', 'disabled');
				$('select[name=internal_colour]').removeAttr('disabled');
			}
		})
	});
</script>