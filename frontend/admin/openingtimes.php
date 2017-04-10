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
				<?php foreach ($days as $day) {
					
					$time1 = date("G:i", strtotime($day["opening"]));
					$time2 = date("G:i", strtotime($day["closing"]));
					
					$closed = false;
					if ($time1 == $time2) $closed = true;
					
					?>
					<tr>
						<td><?=$day["day"]?></td>
						<td class="short">von</td>
						<td class="time">
							<div>
								<a href="#" onclick="editTime('d<?=$day["DID"]?>1'); return false;" id="d<?=$day["DID"]?>1" data-day="<?=$day["day"]?> von" data-before="<?=$time1?>" class="<?=$closed?"closed":null?>">
									<?=$time1?>
								</a>
							</div>
						</td>
						<td class="short">bis</td>
						<td class="time">
							<div>
								<a href="#" onclick="editTime('d<?=$day["DID"]?>2'); return false;" id="d<?=$day["DID"]?>2" data-day="<?=$day["day"]?> bis" data-before="<?=$time2?>">
									<?=$time2?>
								</a>
							</div>
						</td>
						<td class="short">Uhr</td>
						<td class="text-center">
							<a href="#"><span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" title="Manuelle Eingabe"></span></a>
							&nbsp;
							<a href="#"><span class="glyphicon glyphicon-eye-close" data-toggle="tooltip" data-placement="left" title="Tag für Kunden ausblenden"></span></a>
							&nbsp;
							<a href="#" onclick="setZero('d<?=$day["DID"]?>1', 'd<?=$day["DID"]?>2'); return false;"><span class="glyphicon glyphicon-off" data-toggle="tooltip" data-placement="left" title="An diesem Tag geschlossen"></span></a>
						</td>
					</tr>
				<?php } ?>
				</tbody>
				<tfoot>
				<tr>
					<td colspan="7">
						<em>
							Zeiten durch Klicken bearbeiten - Änderungen werden <span class="changed">markiert</span>.
							<br>Gleiche Zeiten an einem Tag werden als "<span class="closed">geschlossen</span>" angezeigt.
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
					<button id="btnSaveTime" type="button" class="btn btn-primary" onclick="saveTime(0);">Übernehmen</button>
				</div>
			</div>
		</div>
	</div>
</div>
