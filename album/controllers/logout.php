<?php
class Logout extends Controller {
	function __construct() {
		parent::Controller();
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
