<?php

class Constructor
{
	private static $_instance = null;
	public $error;
	public $view;
	public $title;
	public $modfile;
	public $viewfile	= '.default';
	public $cssfiles	= [];
	public $jsfiles		= [];
	public $templates	= [];
	
	protected function __construct()
	{
		self::$_instance = $this;
	}
	
	public function build() {
		
		$admin = $_SESSION["admin"] ?? false;
		
		switch (@$_GET[0]) {
			case "upload":
				$this->jsfiles[]	= "fine-uploader.min.js";
				$this->viewfile		= "upload.php";
				$this->cssfiles[]	= "fine-uploader-new.min.css";
				$this->cssfiles[]	= "uploader.css";
				$this->templates["qq-template"]	= "rowbased.html";
				break;
			case "browse":
				$this->viewfile		= "browse.php";
				break;
		}
		
		switch ($this->view)
		{
			case "view" :
				$this->title	= ($admin ? "Admin - " : null) . BILDSERV;
				$this->modfile	= __FRONTEND__ . "/view.php";
				$this->cssfiles = array_merge(
					[CSS_Bootstrap, CSS_ionicons, "hamburgers.min.css"],
					$this->cssfiles,
					[CSS_styles]
				);
				$this->jsfiles	= array_merge(
					[JS_jQuery, JS_Tether, JS_Bootstrap],
					$this->jsfiles,
					[JS_javascript]
				);
				break;
			default :
				return false;
		}
		
		include_once __FRONTEND__ . "/blueprint.php";
		return true;
	}
	
	static public function getInstance() {
		if (self::$_instance === null)
			self::$_instance = new Constructor();
		return self::$_instance;
	}
}