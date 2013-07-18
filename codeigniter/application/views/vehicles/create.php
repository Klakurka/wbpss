<?php
echo validation_errors();
echo form_open('vehicles/create')."\n";

echo form_fieldset('Model Info');

if(count($makes) > 1){
	echo form_dropdown('make', $makes, array_shift($makes));
} else {
	echo form_input(array('name' => 'make', 'value' => array_shift($makes), 'hidden' => 'hidden'))."\n";
}

echo form_label('Model Code', 'model_code');
echo form_input(array('name' => 'model_code', 'class' => 'autocomplete', 'data-method' => 'vehicles/ajax', 'required' => 'required'))."<br />\n";

echo form_label('Model Name', 'model_name');
echo form_input(array('name' => 'model_name', 'required' => 'required'))."<br />\n";

echo form_label('Slogan', 'slogan');
echo form_input(array('name' => 'slogan', 'required' => 'required'))."<br />\n";

echo form_label('Year', 'year');
echo form_dropdown('year', $years, date("Y") )."<br />\n";

echo form_label('New Trim', 'new_trim');
echo form_checkbox('new_trim', 'new', FALSE)."<br />\n";
echo form_label('Trim', 'trim');
echo form_dropdown('trim', $trims)."\n";
echo form_input(array('name' => 'trim', 'value' => '', 'hidden' => 'hidden', 'disabled' => 'disabled'))."\n";

echo form_fieldset_close()."\n";

echo form_fieldset('Fuel');

echo form_label('City', 'city');
echo form_input(array('name' => 'city', 'required' => 'required'));
echo "Litres/100km" . "<br />\n";

echo form_label('Highway', 'highway');
echo form_input(array('name' => 'highway', 'required' => 'required'));
echo "Litres/100km" . "<br />\n";

echo form_label('Capacity', 'capacity');
echo form_input(array('name' => 'capacity', 'required' => 'required'));
echo "Litres" . "<br />\n";

echo form_fieldset_close()."\n";

echo form_fieldset('Engineering Info');

echo form_label('Engine Name', 'engine_name');
echo form_input(array('name' => 'engine_name', 'required' => 'required'))."<br />\n";

echo form_label('Horse Power', 'horse_power');
echo form_input(array('name' => 'horse_power', 'required' => 'required'));
echo "@";
echo form_input(array('name' => 'horse_rpm', 'required' => 'required'));
echo "RPM" . "<br />\n";

echo form_label('Torque', 'torque');
echo form_input(array('name' => 'torque', 'required' => 'required'));
echo "@";
echo form_input(array('name' => 'torque_rpm', 'required' => 'required'));
echo "RPM" . "<br />\n";

echo form_label('Transmission', 'transmission');
echo form_input(array('name' => 'transmission', 'required' => 'required'))."<br />\n";

echo form_label('Brakes', 'brakes');
echo form_input(array('name' => 'brakes', 'required' => 'required'))."<br />\n";

echo form_label('Steering', 'steering');
echo form_input(array('name' => 'steering', 'required' => 'required'))."<br />\n";

echo form_fieldset_close()."\n";

echo form_fieldset('Option Info');

echo form_label('Option Code', 'option_code');
echo '<div name="input-field">';
echo form_input('option_code[]');
echo '</div>';
echo form_button(array('name' => 'option_code[]',
		'content' => 'Add Option',
		'class' => 'array_push',
		'data-input' => '[name=input-field]',
		'data-output' => '[name=output-field]'))."<br />\n";
echo '<div name="output-field"></div>';

echo form_fieldset_close()."\n";

echo "<!--";
echo form_fieldset('Colours');

echo form_label('Exterior Colour', 'exterior_colour');
echo form_input('brakes')."<br />\n";

echo form_label('Interior Colour', 'interior_colour');
echo form_input('interior_colour')."<br />\n";

echo form_fieldset_close()."\n";
echo "-->";

echo form_submit('submit', 'Create Vehicle');

echo form_close()."\n";
?>
<script>
	$(function(){
		$('[name=new_trim]').change(function(){
			if(this.checked){
				$('select[name=trim]').attr('hidden', 'hidden');
				$('select[name=trim]').attr('disabled', 'disabled');
				$('[type=text][name=trim]').removeAttr('hidden');
				$('[type=text][name=trim]').removeAttr('disabled');
			} else {
				$('[type=text][name=trim]').attr('hidden', 'hidden');
				$('[type=text][name=trim]').attr('disabled', 'disabled');
				$('select[name=trim]').removeAttr('hidden');
				$('select[name=trim]').removeAttr('disabled');
			}
		})
	});
</script>