<?php
class Pages extends CI_Controller{

	public function view($page = 'home'){
		if ( ! file_exists('application/views/pages/'.$page.'.php')){
			// Whoops, we don't have a page for that!
			show_404();
		}
		$data['title'] = ucfirst($page); // Capitalize the first letter
		$data['view'] = 'pages/'.$page.'.php';
	
		$this->load->view('templates/standard', $data);
	}
}
?>