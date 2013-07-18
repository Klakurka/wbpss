<header>
	<h1>Price-Sheet System</h1>
	<nav>
		<ul>
			<?php 
			if ($this->session->userdata('accessrights') != NULL){
				if ($this->session->userdata('accessrights') == 1){
					echo "<li>".anchor('pricesheets', 'Price-Sheets')."</li>";
					echo "<li>".anchor('accessories', 'Accessories')."</li>";
					echo "<li>".anchor('vehicles', 'Vehicles')."</li>";
					echo "<li>".anchor('features', 'Features')."</li>";
					echo "<li>".anchor('users', 'Users')."</li>";
				} 
				else if ($this->session->userdata('accessrights') == 2){
					echo "<li>".anchor('pricesheets', 'Price-Sheets')."</li>";
					echo "<li>".anchor('accessories', 'Accessories')."</li>";
					echo "<li>".anchor('vehicles', 'Vehicles')."</li>";
				}
				else if ($this->session->userdata('accessrights') == 3){
					echo "<li>".anchor('vehicles', 'Vehicles')."</li>";
				} else {}
			} ?>
			<li class="help"><a href="http://fireproofjeans.com/mediawiki">Help</a></li>
		</ul>
		<?php if($this->uri->segment(1)): ?>
		<ul class="index">
			<?php if ($this->router->method != 'login'): ?>
				<li><?php echo anchor(base_url(). $this->uri->segment(1), 'List'); ?></li>
				<li><?php echo anchor(base_url(). $this->uri->segment(1).'/create', 'Add'); ?></li>
			<?php endif; ?>
			<?php if($this->router->method == 'index'): ?>
				<li class="search">
					<?php
					echo validation_errors()."\n";
					echo form_open($this->router->class, array('id' => 'mySearch'))."\n";
					echo form_label('Search', 'search')."\n";
					echo form_input('search')."\n";
					echo form_submit('submit', 'Search')."\n";
					echo form_close()."\n";	?>
				</li>
			<?php endif; ?>
		</ul>
		<?php endif ?>
		<ul class="login">
			<li><?php echo anchor(index_page(), 'Home'); ?></li>
			<li><?php echo ($logged_in = $this->session->userdata('logged_in'))? anchor('users/logout', 'Logout'):anchor('users/login', 'Login'); ?></li>
		</ul>
	</nav>
</header>
