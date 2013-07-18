<?php
echo '<div class="title">
		<span>Accessory Name</span>
		<span>Accessory ID</span>
		</div>';
foreach($accessories as $accessory){
	echo '<div class="row">';
	foreach ($accessory as $value){
		echo '<span>'.$value.'</span>';
	}
	echo '</div>';
}
?>