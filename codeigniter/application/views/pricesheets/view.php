<?php
echo '<div class="title">
		<span>Pricesheet Name</span>
		<span>Dealer ID</span>
		<span>User ID</span>
		</div>';
foreach($users as $user){
	echo '<div class="row">';
	foreach ($user as $value){
		echo '<span>'.$value.'</span>';
	}
	echo '</div>';
}
?>