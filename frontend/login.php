<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
		<?php if (@$_SESSION["login-error"]) {
			
			$_SESSION["login-error"] = false;
			unset($_SESSION["login-error"]);
			
			?>

			<div class="alert alert-warning alert-dismissible" role="alert" style="margin-top: 20px;">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Hoppla!</strong> Die Anmeldung war nicht erfolgreich.
			</div>
		<?php } ?>
			
			<div class="panel panel-default">
				<form method="post" action="" onsubmit="return validateInput();">
					<div class="panel-heading text-center">Pax et <b>Admin</b></div>
					<div class="panel-body">
						<p class="text-center">Melden Sie sich mit Ihren Anmeldedaten an.</p>
						<div class="form-group">
							<label for="inp_username">Benutzername</label>
							<input id="inp_username" class="form-control" name="username" placeholder="test" type="text" />
						</div>
						<div class="form-group">
							<label for="inp_password">Passwort</label>
							<input id="inp_password" class="form-control" name="password" placeholder="abc123" type="password" />
						</div>
					</div>
					<button class="btn btn-login panel-footer" type="submit" name="login">Anmelden</button>
				</form>
			</div>
			<a href="/" class="link-back"><small><i class="glyphicon glyphicon-arrow-left"></i></small>&nbsp; Zurück zu Pax et Bonum</a>
		</div>
	</div>
</div>
