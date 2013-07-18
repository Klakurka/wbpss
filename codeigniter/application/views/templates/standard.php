<?php
if(isset($view_data)){
	$data = $view_data;
} else {
	$data = array();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<?php echo css_asset('reset.css', '', array('media' => 'all'))."\n"; ?>
		<?php echo css_asset('main.css', '', array('media' => 'all'))."\n"; ?>
		<?php echo js_asset('jquery.min.js')."\n"; ?>
		<?php echo js_asset('jquery-ui.min.js')."\n"; ?>
		<?php echo js_asset('form_tools.js')."\n"; ?>
		<?php echo js_asset('order.js')."\n"; ?>
		<title><?php echo $title; ?></title>
	</head>
	<body onload="load();" >
	<?php $this->load->view('templates/header'); ?>
	<div id="pageWrap">
		<?php if($warning = $this->session->flashdata('warning')): ?>
			<div id="warning"><?php echo $warning; ?></div>
		<?php endif; ?>
		<?php
			if(isset($view)){
				$this->load->view($view, $data);
			}
		?>
	</div>
	<?php $this->load->view('templates/footer'); ?>
</html>