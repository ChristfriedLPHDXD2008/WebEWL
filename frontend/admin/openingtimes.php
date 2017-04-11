<?php

require_once __BACKEND__ . "/OpeningTimes.php";
$optim = new OpeningTimes();
$days = $optim->getOpeningTimes();

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
								<a href="#" onclick="editTime('d<?=$day["DID"]?>1'); return false;" id="d<?=$day["DID"]?>1" data-day="<?=$day["day"]?> von" data-before="<?=$time1?>" class="edit <?=$closed?"closed":null?>"><?=$time1?></a>
							</div>
						</td>
						<td class="short">bis</td>
						<td class="time">
							<div>
								<a href="#" onclick="editTime('d<?=$day["DID"]?>2'); return false;" id="d<?=$day["DID"]?>2" data-day="<?=$day["day"]?> bis" data-before="<?=$time2?>" class="edit <?=$closed?"closed":null?>"><?=$time2?></a>
							</div>
						</td>
						<td class="short">Uhr</td>
						<td class="text-center options">
							<a href="#" id="d<?=$day["DID"]?>3"
							   class="edit <?=empty(trim($day["manual"]))?null:"occupied"?>"
							   onclick="editManual('d<?=$day["DID"]?>3'); return false;"
							   data-value="<?=$day["manual"]?>"
							   data-day="<?=$day["day"]?>"><span
										class="glyphicon glyphicon-pencil"
										data-toggle="tooltip" data-placement="left"
										title="Manuelle Eingabe"></span></a>
							&nbsp;
							<a href="#"><span class="glyphicon glyphicon-eye-close" data-toggle="tooltip" data-placement="left" title="Tag für Kunden ausblenden"></span></a>
							&nbsp;
							<a href="#" class="edit"
							   onclick="setZero('d<?=$day["DID"]?>1', 'd<?=$day["DID"]?>2'); return false;"><span
										class="glyphicon glyphicon-off"
										data-toggle="tooltip" data-placement="left"
										title="An diesem Tag geschlossen"></span></a>
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
			<div class="status-bar">
				<button type="button" class="btn btn-danger" onclick="submitChanges();">Speichern</button>
				<span id="status"></span>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="modalTime" tabindex="-1" role="dialog" aria-labelledby="Zeiteingabe">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modalTitle">Zeit ändern</h4>
				</div>
				<div class="modal-body" id="modalTimeBody">
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

	<div class="modal fade" id="modalManual" tabindex="-1" role="dialog" aria-labelledby="Manuelle Eingabe">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modalTitle">Manuelle Eingabe</h4>
				</div>
				<div class="modal-body" id="modalManualBody">
					<div class="input-box">
						<span class="form-group">
							<label for="inpManual">Manuelle Eingabe</label>
							<input id="inpManual" class="form-control" minlength="1" maxlength="128" />
						</span>
					</div>
				</div>
				<div class="modal-footer" id="modalFooter">
					<button id="btnDiscardManual" type="button" class="btn btn-default" onclick="discardManual(0); return false;">Doch die Zeiten verwenden</button>
					<button id="btnSaveManual" type="button" class="btn btn-primary" onclick="saveManual(0); return false;">Übernehmen</button>
				</div>
			</div>
		</div>
	</div>
	
</div>

<div>

</div>
