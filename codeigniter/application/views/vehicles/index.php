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

	if($limit == 0){
		echo 'well there is nothing to do here....';
	} else {
		echo '<div class="title">'."\n".
			// Will fix once test data is avaliable!
			'<span class="large">Model Name</span>'."\n".
			'<span class="large">Trim</span>'."\n".
			'<span class="large">Transmission</span>'."\n".
			'<span class="large">Model Code</span>'."\n".
			'<span class="large">Option Code</span>'."\n".
			'<span class="large">Colour Code</span>'."\n".
			'<span class="large">MSRP</span>'."\n".
			'<span class="tiny center">Edit</span>'."\n".
			'<span class="tiny center">Delete</span>'."\n".
		'</div>'."\n";
		foreach($vehicles as $vehicle){
			echo '<div class="row">'."\n";
				echo '<span class="large">'.$vehicle['strModelName'].'</span>'."\n";
				echo '<span class="large">'.$vehicle['strTrimName'].'</span>'."\n";
				echo '<span class="large">'.$vehicle['strTransmissionName'].'</span>'."\n";
				echo '<span class="large">'.$vehicle['strModelCode'].'</span>'."\n";
				echo '<span class="large">'.$vehicle['strOptionCode'].'</span>'."\n";
				echo '<span class="large">'./*$vehicle['strColourCode']*/''.'</span>'."\n";
				echo '<span class="large">'.$vehicle['intMSRP'].'</span>'."\n";
				echo '<span class="tiny center">'.anchor('vehicles/update/'.$vehicle['strModelCode'].'/'.$vehicle['strOptionCode'], image_asset("edit.png")).'</span>'."\n";
				echo '<span class="tiny center">'.anchor('vehicles/destroy/'.$vehicle['strModelCode'].'/'.$vehicle['strOptionCode'], image_asset("delete.png")).'</span>'."\n";
			echo '</div>';
		}	
		echo '<div class="paging">'."\n";
		echo 'Page #' . (1 + $offset/$limit);
		if($offset > 0){
			$back = $offset - $limit;
			if($back < 0){
				$back = 0;
			}
			echo anchor("features/{$back}/{$limit}", 'Back', 'class="back"');
		}
		if($more){
			$next = $offset + $limit;
			echo anchor("features/{$next}/{$limit}", 'Next', 'class="next"');
		}
		echo "</div>";
	}
?>