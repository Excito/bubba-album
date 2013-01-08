<?php
class Login extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function json() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$this->load->model('admin');
		$session_id = $this->admin->login($username,$password);
		$data['success'] = $session_id;
		if( $session_id ) {
			$data['userinfo'] = $this->admin->get_userinfo($session_id);
		}
		$data['has_access'] = $this->admin->has_album_access();
		header("Content-type: application/json");
		print json_encode($data);
	}
}
