<?php

class Constructor
{
	private static $_instance = null;
	public $error;
	public $view;
	public $title;
	public $subs		= [];
	public $modfile;
	public $viewfile	= '.default';
	public $cssfiles	= [];
	public $jsfiles		= [];
	
	protected function __construct()
	{
		self::$_instance = $this;
	}
	
	public function build() {
		
		switch (@$_GET[0]) {
			default:
				$this->subs			=	array_merge($this->subs, [
					"Pax et bonum"	=> "#",
					"Fair Trade"	=> "#",
					"Impressum"		=> "#"
				]);
				$this->cssfiles[]	= "start.css";
				$this->viewfile		= "start.php";
				break;
			case "aktuell":
				$this->viewfile		= "news.php";
				break;
			case "about":
				$this->subs			=	array_merge($this->subs, [
					"Ursprung"				=> "#",
					"Anliegen des Vereins"	=> "#"
				]);
				$this->viewfile		= "about.php";
				break;
			case "verein":
				$this->subs			=	array_merge($this->subs, [
					"Vereinsleben"		=> "#",
					"Veranstaltungen"	=> "#",
					"Bildungsarbeit"	=> "#"
				]);
				$this->viewfile		= "verein.php";
				break;
			case "laden":
				$this->subs			=	array_merge($this->subs, [
					"Sortiment"		=> "#",
					"Fair Trade"	=> "#",
					"Bestellung"	=> "#",
					"Standort"		=> "#",
					"Mitarbeiter"	=> "#"
				]);
				$this->viewfile		= "store.php";
				break;
			case "kontakt":
				$this->subs			=	array_merge($this->subs, [
					"Kontakt"				=> "#",
					"Öffnungszeiten"		=> "#",
					"Anfahrt"				=> "#",
					"Schreiben Sie uns an"	=> "#"
				]);
				$this->viewfile		= "contact.php";
				break;
		}
		
		switch ($this->view)
		{
			case "view" :
				$this->title	= $this->title ?? TITLE;
				$this->modfile	= __FRONTEND__ . "/view.php";
				$this->cssfiles = array_merge(
					[CSS_Bootstrap],
					$this->cssfiles,
					[CSS_styles]
				);
				$this->jsfiles	= array_merge(
					[JS_jQuery, JS_Bootstrap],
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