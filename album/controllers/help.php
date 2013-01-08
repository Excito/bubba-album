<?php
class Help extends CI_Controller {
    /* A couple of pages contains the same content and/or the same help text */
    private $index_map = array(
    );

    function help(){
        parent::__construct();
        require_once(APPPATH."/legacy/defines.php");
    }

	function load($strip="",$uri="") {
		$this->load->model("admin");
		$language = $this->admin->get_language();
        if(isset($this->index_map[$uri])) {
            $uri = $this->index_map[$uri];
        }


        $path = "views/help/$language/$uri.html";

        /* The help text might not be translated, resort to English */
        if(!file_exists($path)) {
            $path = "views/help/en/$uri.html";
        }

        if(file_exists($path)) {
            if($strip == "html") {
                $data = $this->load->file($path, true);
				$userinfo = $this->admin->get_userinfo();
                $data = str_replace(
                    array(
                        '{PLATFORM}',
                    ),
                    array(
                        $this->admin->get_platform()
                    ),
                    $data
                );
                echo($data);
            }
        } else {
            printf(_("Error: No help text was found for entry %s"), $uri);
        }
    }

    function index () {
    }
	
}
