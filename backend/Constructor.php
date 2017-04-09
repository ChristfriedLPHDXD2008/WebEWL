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
		
		if (@$_GET[0] == "admin") switch (@$_GET[1]) {
			default:
			case "dashboard":
				$this->viewfile		= "dashboard.php";
				break;
		}
		else switch (@$_GET[0]) {
			default:
				$this->subs			=	array_merge($this->subs, [
					"Pax et bonum"	=> "#wortschnecke",
					"Fair Trade"	=> "/laden#fair-trade",
					"Impressum"		=> "/impressum"
				]);
				$this->cssfiles[]	= "start.css";
				$this->viewfile		= "start.php";
				break;
			case "aktuell":
				$this->viewfile		= "news.php";
				break;
			case "about":
				$this->subs			=	array_merge($this->subs, [
					"Verein und Weltladen"	=> "#verein-und-weltladen",
					"Fairer Handel"			=> "#was-ist-fairer-handel",
					"Was kann ich tun?"		=> "#was-kann-ich-tun"
				]);
				$this->jsfiles[]	= "jquery.magnific-popup.min.js";
				$this->jsfiles[]	= "views/about.js";
				$this->cssfiles[]	= "magnific-popup.css";
				$this->viewfile		= "about.php";
				break;
			case "verein":
				$this->subs			=	array_merge($this->subs, [
					"Vereinsleben"		=> "#vereinsleben",
					"Veranstaltungen"	=> "#veranstaltungen",
					"Bildungsarbeit"	=> "#bildungsarbeit"
				]);
				$this->viewfile		= "verein.php";
				break;
			case "laden":
				$this->subs			=	array_merge($this->subs, [
					"Sortiment"		=> "#sortiment",
					"Fair Trade"	=> "#fair-trade",
					"Bestellung"	=> "#bestellungen",
					"Standort"		=> "#standort",
					"Mitarbeiter"	=> "#mitarbeiter"
				]);
				$this->jsfiles[]	= "OpenLayers.js";
				$this->jsfiles[]	= "OpenStreetMap.js";
				$this->viewfile		= "store.php";
				break;
			case "kontakt":
				$this->subs			=	array_merge($this->subs, [
					"Kontakt"				=> "#kontakt",
					"Öffnungszeiten"		=> "#öffnungszeiten",
					"Anfahrt"				=> "#anfahrt",
					"Schreiben Sie uns an"	=> "#anschreiben"
				]);
				$this->viewfile		= "contact.php";
				break;
			case "impressum":
				$this->viewfile		= "impress.php";
				break;
		}
		
		switch ($this->view)
		{
			case "view":
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
			case "login":
				$this->title	= $this->title ?? TITLE_ADMIN;
				$this->modfile	= __FRONTEND__ . "/login.php";
				$this->cssfiles	= array_merge(
					[CSS_Bootstrap],
					$this->cssfiles,
					[CSS_login]
				);
				$this->jsfiles	= array_merge(
					[JS_jQuery, JS_Bootstrap, JS_fngrprnt],
					$this->jsfiles,
					[JS_login]
				);
				break;
			case "admin":
				$this->title	= $this->title == TITLE_ADMIN;
				$this->modfile	= __FRONTEND__ . "/admin.php";
				$this->cssfiles	= array_merge(
					[CSS_Bootstrap],
					$this->cssfiles,
					[CSS_admin]
				);
				$this->jsfiles	= array_merge(
					[JS_jQuery, JS_Bootstrap],
					$this->jsfiles,
					[JS_admin]
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