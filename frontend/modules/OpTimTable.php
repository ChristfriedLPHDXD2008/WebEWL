<?php

$times = null;
try {
	
	require_once __BACKEND__ . "/OpeningTimes.php";
	$optim = new OpeningTimes();
	$times = $optim->getOpeningTimes();
	
	?>
	
	<h3 class="optim-heading">Öffnungszeiten</h3>
	<table id="optim-table" class="table">
		<thead>
		<tr><th colspan="6" style="height: 0; margin: 0; padding: 0;"></th></tr>
		</thead>
		<tbody>
		<?php foreach ($times as $time) {
			if ($time["hidden"] == 1) continue; ?>
			
			<tr>
				<td><b><?=$time["day"]?></b></td>
			<?php if (!empty($time["manual"])) { ?>
				
				<td colspan="5" class="text-left"><?=$time["manual"]?></td>
			<?php } else if ($time["opening"] == $time["closing"]) { ?>
				
				<td colspan="5" class="text-center"><em>geschlossen</em></td>
			<?php } else { ?>
				
				<td>von</td>
				<td class="text-right" style="min-width: 80px;"><?=decodetime($time["opening"])?></td>
				<td class="text-right">bis</td>
				<td class="text-right" style="min-width: 80px;"><?=decodetime($time["closing"])?></td>
				<td class="text-right">Uhr</td>
			<?php } ?>
			
			</tr>
		<?php } ?>
		
		</tbody>
		<tfoot>
		<tr><td colspan="6" style="height: 0; margin: 0; padding: 0;"></td></tr>
		</tfoot>
	</table>
	
	<?php
	
} catch (Exception $e) {
	echo "<h3>Öffnungszeiten<br><small>konnten nicht geladen werden.</small></h3>";
	echo "<span class=\"font-alt\">Serverinterner Fehler:<br>" . $e->getMessage() . "</span>";
}
