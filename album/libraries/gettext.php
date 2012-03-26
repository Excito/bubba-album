<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Gettext class
 */
class Gettext {
	private $core, $path, $domain;
	private static $languages = null;
	public function __construct() {
		$this->core =& get_instance();
		$this->domain = $this->core->config->item('textdomain');
		$this->path = $this->core->config->item('lang_path');
		$this->core->load->model('admin');
		$locale = $this->core->admin->get_locale();
		setlocale(LC_MESSAGES, $locale);
		setlocale(LC_TIME, $locale);
		bindtextdomain($this->domain, $this->path);
		textdomain($this->domain);
		bind_textdomain_codeset($this->domain, 'UTF-8');
	}
}

