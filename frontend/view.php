<?php

$constr = Constructor::getInstance();

$active = " class=\"active\"";
$items = [
	"Startseite"	=> "/",
	"Aktuell"		=> "/aktuell",
	"Über uns"		=> "/about",
	"Verein"		=> "/verein",
	"Laden"			=> "/laden",
	"Kontakt"		=> "/kontakt"
];

ob_start();

foreach ($items as $name => $page) {
	?> 	<li role="presentation"<?="/" . @$_GET[0] == $page ? $active : null ?>><a href="<?=$page?>"><?=$name?></a></li>
	<?php
}

$nav = ob_get_clean();

?>
<nav class="container">
	<div class="row">
		<div class="navbar navbar-custom">
			<div class="container-fluid">
				<div class="logo hidden-xs">
					<img src="/img/ewl-header-logo.png"/>
				</div>
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand hidden-sm hidden-md hidden-lg" href="/">
						<span class="headtitle">"Pax et bonum" - </span><span class="subtitle">Eine Welt Laden e.V.</span>
					</a>
				</div>
				<div class="collapse navbar-collapse" id="navbar-collapse">
					<div class="nav-straight-open-keeper"></div>
					<span class="hidden-sm hidden-md hidden-lg"><br><em>Navigation</em></span>
					<ul class="nav navbar-nav navbar-left hidden-sm hidden-md hidden-lg">
						<?=$nav?>
					</ul>
					<hr class="hidden-sm hidden-md hidden-lg">
					<span class="hidden-sm hidden-md hidden-lg"><em>Auf dieser Seite</em></span>
					<ul id="right-nav" class="nav navbar-nav navbar-right">
						<?php
						$i = 0;
						foreach ($constructor->subs as $name => $link) { ?>
							
							<li<?=$i==0?$active:null?>><a href="<?=$link?>"><?=$name?></a></li>
							<?php $i++; } ?>
					</ul>
					<div class="hidden-sm hidden-md hidden-lg"><span style="opacity: 0; visibility: hidden">-</span></div>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</div>
	</div>
</nav>
<main class="container">
	<aside id="sidebar">
		<div id="floater">
			<ul class="nav nav-pills nav-stacked">
				<?=$nav?>
			</ul>
		</div>
	</aside>
	<article id="content">
		<?php require_once __FRONTEND__ . "/views/" . "$constr->viewfile"; ?>
		<div style="height: 205px;"></div>
	</article>
</main>
