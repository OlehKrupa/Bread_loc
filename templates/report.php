<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."header.php";?>
<div class="container-lg text-center">
	<form action="report.php" method="post">
		<h1>Звітність</h1>
		<div class="row">
			<div class="col-10">
				<div class="row">
					<div class="col">
						<button type="submit" id="crop_report" name="crop_report" class="btn btn-info m-2">Загальний стан зберігання зернових</button>
					</div>
					<div class="col">
						<button type="submit" id="crop_critical_report" name="crop_critical_report" class="btn btn-info m-2">Зерно в критичному стані</button>
					</div>

				</div>

				<div class="row">
					<div class="col"><button type="submit" id="standard_report" name="standard_report" class="btn btn-info m-2">Стандарти зберігання</button></div>
					<div class="col"><button type="submit" id="supplier_report" name="supplier_report" class="btn btn-info m-2">Дані про постачальників</button></div>
					<div class="col"><button type="submit" id="warehouse_report" name="warehouse_report" class="btn btn-info m-2">Заповнення складських приміщень</button></div>
				</div>

				<div class="row">
					<div class="col">
						<div class="input-group m-2">
							<span class="input-group-text" id="date_start">Від</span>
							<input type="date" lang="uk" class="form-control <?php if(!empty($error['date_start'])) echo 'is-invalid' ?>" placeholder="" name="date_start" aria-describedby="date_start" value="<?php if(!empty($date_start_ui)){echo $date_start_ui;}?>">
							<div class="invalid-feedback"><?php echo $error['date_start'] ?? '';?></div>
						</div>
					</div>
					<div class="col">
						<div class="input-group m-2">
							<span class="input-group-text" id="date_end">До</span>
							<input type="date" lang="uk" class="form-control <?php if(!empty($error['date_end'])) echo 'is-invalid' ?>" placeholder="" name="date_end" aria-describedby="date_end" value="<?php if(!empty($date_end_ui)){echo $date_end_ui;}?>">
							<div class="invalid-feedback"><?php echo $error['date_end'] ?? '';?></div>
						</div>
					</div>
					<div class="col">
						<div class="input-group m-2">
							<span class="input-group-text" id="select_consignment">Дані про</span>
							<select class="form-select <?php if(!empty($error['select_consignment'])) echo 'is-invalid' ?>" id="select_consignment" name="select_consignment">
								<option <?php if($select_consignment_ui==="Crop") echo "selected" ?> value="Crop">Прийом</option>
								<option <?php if($select_consignment_ui==="Consignment_OUT") echo "selected" ?> value="Consignment_OUT">Відправку</option>
							</select>
							<div class="invalid-feedback"><?php echo $error['select_consignment'] ?? '';?></div>
						</div>
					</div>

					<div class="col">
						<button type="submit" id="consignment_report" name="consignment_report" class="btn btn-warning m-2">Сформувати звіт</button>
					</div>
				</div>
			</div>
		</form>
		<div class="col-2">
			<?php require_once "alert_cell.php"; foreach ($alert as $k => $v):?>
			<h4><?php echo($v); ?></h4>
		<?php endforeach; ?> 
	</div>
</div>
</div>

<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."footer.php";?>