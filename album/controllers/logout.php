<?php
class Logout extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function json() {
		$this->load->model('admin');
		$success = $this->admin->logout();
		$data['success'] = $success;
		$data['userinfo'] = array( 'groups' => array(), 'username' => '' );
		header("Content-type: application/json");
		print json_encode($data);
	}
}
