<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."header.php";?>
<div class="container-lg text-center">
	<div class="row">
		<div class="col-10">
			<div class="container-lg row g-0">
				<div class="col"><button type="button" class="btn btn-info m-2">*Звіт*</button></div>
				<div class="col"><button type="button" class="btn btn-info m-2">*Звіт*</button></div>
				<div class="col"><button type="button" class="btn btn-info m-2">*Звіт*</button></div>
			</div>

			<div class="container-lg row g-0">
				<div class="col"><button type="button" class="btn btn-warning m-2">*Зерносховища*</button></div>
				<div class="col"><button type="button" class="btn btn-warning m-2">*Стандарти*</button></div>
				<div class="col"><button type="button" class="btn btn-warning m-2">*Склади*</button></div>
				<div class="col"><button type="button" class="btn btn-warning m-2">*Відправки*</button></div>
				<div class="col"><button type="button" class="btn btn-warning m-2">*Постачальники*</button></div>
			</div>

		</div>

		<div class="col-2">
			<?php require_once "alert_cell.php"; foreach ($alert as $k => $v):?>
				<h4><?php echo($v); ?></h4>
			<?php endforeach; ?> 
		</div>
	</div>
</div>

<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."footer.php";?>