<?php

$constr = Constructor::getInstance();

?>
<!--suppress HtmlUnknownTarget -->
<header>
	<h1 class="title">Pax et <strong>Admin</strong></h1>
	<div class="right">
		<form method="post" action="" class="element">
			<button class="btn-logout" type="submit" name="logout">
				<span class="glyphicon glyphicon-log-out"></span>
			</button>
		</form>
	</div>
</header>
<main>
	<div class="col-xs-12 hidden-sm hidden-md hidden-lg toggle-aside">
		<div class="panel panel-default">
			<div class="panel-body">
				<nav>
					<ul class="nav nav-pills nav-stacked">
						<li role="presentation">
							<a href="#" onclick="toogleAsideNav(); return false;">
								<span class="glyphicon glyphicon-menu-hamburger"></span> &nbsp;Navigation
							</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
	<aside class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
		<nav>
			<div class="panel panel-default">
				<div class="panel-heading">Allgemein</div>
				<div class="panel-body">
					<ul class="nav nav-pills nav-stacked">
						<li role="presentation">
							<a href="/admin/dashboard">Dashboard</a>
						</li>
						<li role="presentation">
							<a href="/admin/öffnungszeiten">Öffnungszeiten</a>
						</li>
						<li role="presentation">
							<a href="/admin/settings">Einstellungen</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Posts</div>
				<div class="panel-body">
					<ul class="nav nav-pills nav-stacked">
						<li role="presentation">
							<a href="/admin/posts/verfassen">Verfassen</a>
						</li>
						<li role="presentation">
							<a href="/admin/posts">Verwalten</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Benutzerkonten</div>
				<div class="panel-body">
					<ul class="nav nav-pills nav-stacked">
						<li role="presentation">
							<a href="/admin/benutzer/anlegen">Anlegen</a>
						</li>
						<li role="presentation">
							<a href="/admin/benutzer">Verwalten</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-body">
					<ul class="nav nav-pills nav-stacked">
						<li role="presentation">
							<a href="/admin/benutzer/ich">Mein Account</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</aside>
	<section class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
		<?php if (!empty($constr->headline)) { ?>
			
		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-body"><h1 class="headline"><?=$constr->headline?></h1></div>
				</div>
			</div>
		</div>
		<?php } ?>
		
		<div class="row">
			<?php include_once __FRONTEND__ . "/admin/" . "$constr->viewfile"; ?>
			
		</div>
	</section>
</main>