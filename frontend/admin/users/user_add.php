<?php

?>
<div class="col-xs-12" id="addUser">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="container-fluid">
				<br>
				<form onsubmit="return false;" id="addUserForm" class="row">
					<div class="col-md-3 avatar-select">
						<input type="hidden" class="tapatar">
					</div>
					<div class="col-md-9">
						<fieldset>
							<legend class="col-md-8 col-lg-6 col-lg-offset-3 col-md-offset-4">
								Allgemeine Informationen
							</legend>
							<div class="row"></div>
							<div class="form-group row">
								<label for="inpEmail" class="col-md-4 col-lg-3">Nutzername</label>
								<div class="col-md-8 col-lg-6">
									<input type="email" class="form-control" id="inpEmail" placeholder="Anmeldenamen vergeben">
								</div>
							</div>
							<div class="form-group row">
								<label for="inpEmail" class="col-md-4 col-lg-3">Vorname</label>
								<div class="col-md-8 col-lg-6">
									<input type="email" class="form-control" id="inpEmail" placeholder="Vornamen eingeben">
								</div>
							</div>
							<div class="form-group row">
								<label for="inpEmail" class="col-md-4 col-lg-3">Nachname</label>
								<div class="col-md-8 col-lg-6">
									<input type="email" class="form-control" id="inpEmail" placeholder="Nachnamen eingeben">
								</div>
							</div>
							<div class="form-group row">
								<label for="inpEmail" class="col-md-4 col-lg-3">Email</label>
								<div class="col-md-8 col-lg-6">
									<input type="email" class="form-control" id="inpEmail" placeholder="unregistrierte Email">
								</div>
							</div>
							<div class="form-group row">
								<label for="inputPassword3" class="col-md-4 col-lg-3">Passwort</label>
								<div class="col-md-8 col-lg-6">
									<input type="password" class="form-control" id="inpPw1" placeholder="Passwort eingeben">
								</div>
							</div>
							<div class="form-group row">
								<label for="inputPassword3" class="hidden">Passwort</label>
								<div class="col-md-8 col-lg-6 col-lg-offset-3 col-md-offset-4">
									<input type="password" class="form-control" id="inpPw1" placeholder="Passwort wiederholen">
								</div>
							</div>
						</fieldset>
						<br>
						<div class="form-group row">
							<fieldset class="col-md-8 col-lg-6 col-lg-offset-3 col-md-offset-4 ">
								<legend>Berechtigungen</legend>
								<label>
									<input type="checkbox">
									Öffnungszeiten bearbeiten
								</label>
								<br>
								<label>
									<input type="checkbox">
									Einstellungen bearbeiten
								</label>
								<br>
								<label>
									<input type="checkbox">
									Posts verfassen und eigene verwalten
								</label>
								<br>
								<label>
									<input type="checkbox">
									Alle Posts verwalten
								</label>
								<br>
								<label>
									<input type="checkbox">
									Benutzerkonten anlegen
								</label>
								<br>
								<label>
									<input type="checkbox">
									Alle Benutzerkonten verwalten
								</label>
							</fieldset>
						</div>
						<br>
						<div class="form-group row">
							<div class="col-md-3 col-lg-3 col-lg-offset-3 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Benutzer registrieren</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('input.tapatar').tapatar({
		default_image: "/content/default_avatar.png",
		image_url_prefix: "/content/tapatar/"
	});
</script>
