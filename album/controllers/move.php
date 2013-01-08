<?php
class Move extends CI_Controller {
        function __construct() {
                parent::__construct();
        }
		public function json() {
			$this->load->model('admin');
			$this->load->model('Album_model');
			$images = $this->input->post('images');
			$albums = $this->input->post('albums');
			$path = $this->input->post('path');
			header("Content-type: application/json");
			if( ! $this->admin->has_manager_access() ) {
				print json_encode(array());
				return;
			}
			if( $albums ) {
				$this->Album_model->move_albums( $albums, $path );
			}
			if( $images ) {
				$this->Album_model->move_images( $images, $path );
			}

			$data = array();
			print json_encode($data);
		}
}

