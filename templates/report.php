<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."header.php";?>
<div class="container-lg text-center">
	<h1>Звітність</h1>
	<div class="row">
		<div class="col-10">
			<div class="row">
				<div class="col"><button type="button" class="btn btn-info m-2">Загальний стан зберігання зернових</button></div>
				<div class="col"><button type="button" class="btn btn-info m-2">Зерно в критичному стані</button></div>
				
			</div>

			<div class="row">
				<div class="col"><button type="button" class="btn btn-info m-2">Стандарти зберігання</button></div>
				<div class="col"><button type="button" class="btn btn-info m-2">Дані про постачальників</button></div>
				<div class="col"><button type="button" class="btn btn-info m-2">Заповнення складських приміщень</button></div>
			</div>
			
			<div class="row">
				<div class="col">
					<div class="input-group m-2">
						<span class="input-group-text" id="date_start">Початкова дата</span>
						<input type="date" lang="uk" class="form-control <?php if(!empty($error['date_start'])) echo 'is-invalid' ?>" placeholder="" name="date_start" aria-describedby="date_start" value="<?php if(!empty($date_start_ui)){echo $date_start_ui;}?>">
						<div class="invalid-feedback"><?php echo $error['date_start'] ?? '';?></div>
					</div>
				</div>
				<div class="col">
					<div class="input-group m-2">
						<span class="input-group-text" id="date_end">Кінцева дата</span>
						<input type="date" lang="uk" class="form-control <?php if(!empty($error['date_end'])) echo 'is-invalid' ?>" placeholder="" name="date_end" aria-describedby="date_end" value="<?php if(!empty($date_end_ui)){echo $date_end_ui;}?>">
						<div class="invalid-feedback"><?php echo $error['date_end'] ?? '';?></div>
					</div>
				</div>
				<div class="col">
					<div class="input-group m-2">
						<span class="input-group-text" id="select">Дані про</span>
						<select class="form-select <?php if(!empty($error['select'])) echo 'is-invalid' ?>" id="select" name="select">
							<option value="Crop">Прийом</option>
							<option value="Consignment_OUT">Відправку</option>
						</select>
						<div class="invalid-feedback"><?php echo $error['select'] ?? '';?></div>
					</div>
				</div>

				<div class="col">
					<button type="button" class="btn btn-warning m-2">Сформувати звіт</button>
				</div>
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