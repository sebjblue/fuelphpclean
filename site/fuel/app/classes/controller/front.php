<?php

use \Fuel\Core\Lang;
use \Fuel\Core\Config;
use \Fuel\Core\Crypt;
use \Fuel\Core\Router;

use \Libraries\JsVars;
use \Auth\Auth;

class Controller_Front extends \Fuel\Core\Controller_Template
{
	public $template  = "front_template";
	public $lang      = NULL;
	public $data      = array();

	public function __construct($request)
	{
		parent::__construct($request);

		// Using Native PHP Session. If there's ANY problem with those sessions (bug, security breach, etc), see Sébastien Juroszek.
		session_start();

		// Taking the lang frm the URL and removing it from the URL
		$this->lang = $request->method_params[0];

		unset($request->route->segments[2]);
		$request->route->segments = array_values($request->route->segments);

		unset($request->route->method_params[0]);
		$request->route->method_params = array_values($request->route->method_params);

		unset($request->method_params[0]);
		$request->method_params = array_values($request->method_params);

		// Setting the current language
		if(Lang::get_lang() != $this->lang){
			Config::set("language", $this->lang);
		}
	}

	public function before()
	{
		$parentReturn = parent::before();

		\Fuel\Core\Lang::load("global");
		\Fuel\Core\Lang::load("share");

		$this->template->jsVars = new JsVars();

		$this->template->jsVars->addVar("wsUrl", rtrim(Router::get("ws_" . $this->lang), "/") . "/");
		$this->template->jsVars->addVar("baseUrl", \Fuel\Core\Uri::base(FALSE));

		$this->template->css = array(
			"fonts.css",
			"normalize.css",
			"definitions.css",
			"template.css",
			"sprites/generic.css"
		);

		$this->template->js = array(
			"libs/jquery-2.1.3.min.js",
			"libs/jquery-ui.min.js",
			"libs/mustache.js",
			"template.js"
		);

		$this->template->header = "front_header";

		$this->template->set_global(array("menu_selected" => ""));
		$this->template->footer         = "front_footer";
		$this->template->footer_options = array();

		$fbShare = array(
			"share"       => FALSE,
			"siteName"    => '',
			"title"       => '',
			"description" => '',
			"image"       => ''
		);


		$this->template->fbShare = $fbShare;

		return $parentReturn;
	}
}
