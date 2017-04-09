<?php

require_once __BACKEND__ . "/dbOpeningTimes.php";
$ot = dbOpeningTimes::getInstance();
$days = $ot->getOpeningTimes();

?>
<div class="col-xs-12" id="opening-times">
	<div class="panel panel-default">
		<div class="panel-body">
			<table class="table">
				<thead style="cursor: default;">
				<tr>
					<th>Wochentag</th>
					<th colspan="5">Zeiten</th>
					<th class="text-center">Optionen</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($days as $day) { ?>
					<tr>
						<td><?=$day["day"]?></td>
						<td class="short">von</td>
						<td class="time">
							<div>
								<a href="//" onclick="editTime('d<?=$day["DID"]?>1');" id="d<?=$day["DID"]?>1" data-day="<?=$day["day"]?> von">
									<?=date("G:i", strtotime($day["opening"]))?>
								</a>
							</div>
						</td>
						<td class="short">bis</td>
						<td class="time">
							<div>
								<a href="//" onclick="editTime('d<?=$day["DID"]?>2');" id="d<?=$day["DID"]?>2" data-day="<?=$day["day"]?> bis">
								<?=date("G:i", strtotime($day["closing"]))?>
								</a>
							</div>
						</td>
						<td class="short">Uhr</td>
						<td class="text-center">
							<a href="//"><span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" title="Manuelle Eingabe"></span></a>
							&nbsp;
							<a href="//"><span class="glyphicon glyphicon-eye-close" data-toggle="tooltip" data-placement="left" title="Tag für Kunden ausblenden"></span></a>
							&nbsp;
							<a href="//" onclick="setZero('d<?=$day["DID"]?>1', 'd<?=$day["DID"]?>2')"><span class="glyphicon glyphicon-off" data-toggle="tooltip" data-placement="left" title="An diesem Tag geschlossen"></span></a>
						</td>
					</tr>
				<?php } ?>
				</tbody>
				<tfoot>
				<tr>
					<td colspan="7">
						<em>
							Zeiten durch Klicken bearbeiten.
							<br>Gleiche Zeiten an einem Tag wird als "geschlossen" angezeigt.
							<br>Manuelle Eingabe überschreibt die Zeiten.
							<noscript>
								<br><span class="text-danger">Javascript muss zum Bearbeiten aktiviert sein.</span>
							</noscript>
						</em>
					</td>
				</tr>
				</tfoot>
			</table>
			<button type="button" class="btn btn-danger" onclick="submitChanges();">Speichern</button>
		</div>
	</div>
	
	<div class="modal fade" id="modalTime" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modalTitle">Modal title</h4>
				</div>
				<div class="modal-body" id="modalBody">
					<div class="input-box">
						<label for="inpHour">Stunde</label><span class="divider"></span><label for="inpMin">Minute</label>
						<br>
						<span class="form-group"><input id="inpHour" class="form-control" minlength="1" maxlength="2" /></span><span class="divider">:</span><span class="form-group"><input id="inpMin" class="form-control" minlength="2" maxlength="2" /></span>
					</div>
				</div>
				<div class="modal-footer" id="modalFooter">
					<button id="btnSaveTime" type="button" class="btn btn-primary">Übernehmen</button>
				</div>
			</div>
		</div>
	</div>
	
	<script>
		var changed = [];
		function editTime(d) {
			var timeModal	= $("#modalTime"),
				selector	= $('#' + d);
			timeModal.find("#modalTitle").html("Geöffnet am " + selector.data("day"));
			timeModal.find("#inpHour").val(selector.html().split(":")[0].replace(/\s/g,''));
			timeModal.find("#inpMin").val(selector.html().split(":")[1].replace(/\s/g,''));
			timeModal.find("#btnSaveTime").attr("onclick", "saveTime('" + d + "');");
			timeModal.modal("show");
		}
		function saveTime(d) {
			var timeModal	= $("#modalTime"),
				selector	= $('#' + d),
				hour		= timeModal.find("#inpHour").val(),
				min			= timeModal.find("#inpMin").val();
			
			if (hour.length > 2 || hour.length < 1 || min.length !== 2) {
				if (hour.length > 2 || hour.length < 1)
					timeModal.find("#inpHour").parent().addClass("has-error");
				else timeModal.find("#inpHour").parent().removeClass("has-error");
				if (min.length !== 2)
					timeModal.find("#inpMin").parent().addClass("has-error");
				else timeModal.find("#inpMin").parent().removeClass("has-error");
				return;
			}

			timeModal.find("#inpHour").parent().removeClass("has-error");
			timeModal.find("#inpMin").parent().removeClass("has-error");

			timeModal.modal('hide');
			
			selector.html(hour + ":" + min);
			changed.push(d);
			console.log(changed);
		}
		function setZero(dn1, dn2) {
			$('#' + dn1 + ", #" + dn2).html("0:00");
			changed.push(dn1, dn2);
		}
		function submitChanges() {
			var json = JSON.stringify(changed);
			if (!(json.replace(/[\[\]]*/g, ''))) return;
			alert(json.replace(/[\[\]]*/g, ''));
		}
	</script>
</div>
