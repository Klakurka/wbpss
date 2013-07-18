<?php
echo validation_errors();
echo form_open('vehicles/update')."\n";

echo form_fieldset('Model Info');

echo form_label('Model Code', 'model_code');
echo form_input('model_code', set_value('model_code', $vehicle['strModelCode']))."<br />\n";

echo form_label('Model Name', 'model_name');
echo form_input('model_name', set_value('model_name', $vehicle['strModelName']))."<br />\n";

echo form_label('Slogan', 'slogan');
echo form_input('slogan', set_value('slogan', $vehicle['strModelSlogan']))."<br />\n";

echo form_label('Year', 'year');
echo form_dropdown('year', $years, $vehicle['intYear'])."<br />\n";

echo form_label('Trim', 'trim');
echo form_dropdown('trim', $trims, $vehicle['trim']['strTrimName'])."<br />\n";

echo form_fieldset_close()."\n";

echo form_fieldset('Fuel Efficiency (litres/100km)');

echo form_label('City', 'city');
echo form_input('city', set_value('city', $vehicle['engineeringFeature']['numLitresPer100km_City']))."<br />\n";

echo form_label('Highway', 'highway');
echo form_input('highway', set_value('highway', $vehicle['engineeringFeature']['numLitresPer100km_Hwy']))."<br />\n";

echo form_fieldset_close()."\n";

echo form_fieldset('Engineering Info');

echo form_label('Engine', 'engine');
echo form_input('engine', set_value('engine', $vehicle['engineeringFeature']['engine']['strEngineName']))."<br />\n";

echo form_label('Horse Power', 'horse_power');
echo form_input('horse_power', set_value('horse_power', $vehicle['engineeringFeature']['engine']['intHorsePower']));
echo "@";
echo form_input('horse_power_rpm', set_value('rpm', $vehicle['engineeringFeature']['engine']['intHorsePowerRPM']));
echo "RPM" . "<br />\n";

echo form_label('Torque', 'torque');
echo form_input('torque', set_value('torque', $vehicle['engineeringFeature']['engine']['intTorque']));
echo "@";
echo form_input('torque_rpm', set_value('torque_rpm', $vehicle['engineeringFeature']['engine']['intTorqueRPM']));
echo "RPM" . "<br />\n";

echo form_label('Transmission', 'transmission');
echo form_input('transmission', set_value('transmission', $vehicle['engineeringFeature']['transmission']['strTransmissionName']))."<br />\n";

echo form_label('Brakes', 'brakes');
echo form_input('brakes', set_value('brakes', $vehicle['engineeringFeature']['brake']['strBrakeName']))."<br />\n";

echo form_label('Steering', 'steering');
echo form_input('steering', set_value('steering', $vehicle['engineeringFeature']['steering']['strSteeringName']))."<br />\n";

echo form_fieldset_close()."\n";

echo form_fieldset('Option Info');

echo form_label('Option Code', 'option_code');
echo form_input('option_code', set_value('option_code', $vehicle['strOptionCode']));
echo form_submit('add_option', 'Add Option')."<br />\n";

echo form_fieldset_close()."\n";

echo form_fieldset('Colours');

echo form_label('Exterior Colour', 'exterior_colour');
echo form_input('exterior_colour')."<br />\n";

echo form_label('Interior Colour', 'interior_colour');
echo form_input('interior_colour')."<br />\n";

echo form_fieldset_close()."\n";

echo form_submit('submit', 'Update Vehicle');

echo form_close()."\n";
?>