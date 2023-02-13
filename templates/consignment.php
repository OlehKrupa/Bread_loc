<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."header.php";?>
<div class="container-lg">
	<form action="/tables/consignment.php" method="post">
		
		<div class="container-lg text-center row g-0">
			<div class="col px-2">
				<div class="input-group m-2">
					<span class="input-group-text" id="crop_select">Зерно</span>
					<div class="invalid-feedback"><?php echo $error['crop_select'] ?? '';?></div>
					<input type="text" class="form-control <?php if(!empty($error['crop_select'])) echo 'is-invalid' ?>" placeholder="" name="crop_select" aria-describedby="crop_select" value="<?php echo $crop_ui ?>">
				</div>

				<div class="input-group m-2">
					<span class="input-group-text" id="amount">Кількість</span>
					<div class="invalid-feedback"><?php echo $error['amount'] ?? '';?></div>
					<input type="text" class="form-control <?php if(!empty($error['amount'])) echo 'is-invalid' ?>" placeholder="" name="amount" aria-describedby="amount" value="<?php echo $amount_ui ?>">
				</div>

				<div class="input-group m-2">
					<span class="input-group-text" id="date">Дата</span>
					<div class="invalid-feedback"><?php echo $error['date'] ?? '';?></div>
					<input type="text" class="form-control <?php if(!empty($error['date'])) echo 'is-invalid' ?>" placeholder="" name="date" aria-describedby="date" value="<?php echo $date_ui ?>">
				</div>

				<div class="input-group m-2">
					<span class="input-group-text" id="name">Назва</span>
					<div class="invalid-feedback"><?php echo $error['name'] ?? '';?></div>
					<input type="text" class="form-control <?php if(!empty($error['name'])) echo 'is-invalid' ?>" placeholder="" name="name" aria-describedby="name" value="<?php echo $name_ui ?>">
				</div>
				
				<div class="input-group m-2">
					<span class="input-group-text" id="number">Телефон</span>
					<div class="invalid-feedback"><?php echo $error['number'] ?? '';?></div>
					<input type="text" class="form-control <?php if(!empty($error['number'])) echo 'is-invalid' ?>" placeholder="" name="number" aria-describedby="number" value="<?php echo $number_ui ?>">
				</div>

				<div class="input-group m-2">
					<span class="input-group-text" id="moisture">Вологість</span>
					<div class="invalid-feedback"><?php echo $error['moisture'] ?? '';?></div>
					<input type="text" class="form-control <?php if(!empty($error['moisture'])) echo 'is-invalid' ?>" placeholder="" name="moisture" aria-describedby="moisture" value="<?php echo $moisture_ui ?>">
				</div>

				<div class="input-group m-2">
					<span class="input-group-text" id="garbage">Сміття</span>
					<div class="invalid-feedback"><?php echo $error['garbage'] ?? '';?></div>
					<input type="text" class="form-control <?php if(!empty($error['garbage'])) echo 'is-invalid' ?>" placeholder="" name="garbage" aria-describedby="garbage" value="<?php echo $garbage_ui ?>">
				</div>

				<div class="input-group m-2">
					<span class="input-group-text" id="minerals">PO₄</span>
					<div class="invalid-feedback"><?php echo $error['minerals'] ?? '';?></div>
					<input type="text" class="form-control <?php if(!empty($error['minerals'])) echo 'is-invalid' ?>" placeholder="" name="minerals" aria-describedby="minerals" value="<?php echo $minerals_ui ?>">
				</div>

				<div class="input-group m-2">
					<span class="input-group-text" id="nature">г/л</span>
					<div class="invalid-feedback"><?php echo $error['nature'] ?? '';?></div>
					<input type="text" class="form-control <?php if(!empty($error['nature'])) echo 'is-invalid' ?>" placeholder="" name="nature" aria-describedby="nature" value="<?php echo $nature_ui ?>">
				</div>
			</div>

		</div>

		<div class="container-lg text-center row g-0">
			<div class="col"><button class="btn btn-success mb-2" type="submit" name="ok" >ОК</button></div>
			<div class="col"><button class="btn btn-secondary mb-2" type="submit" name="clear" >Очистити</button></div>
			<div class="col"><button class="btn btn-danger mb-2" type="submit" name="delete" >Видалити</button></div>
		</div>

	</form>

	<table class="table">
		<script src="../JS/index.js"></script>
		<thead>
			<tr class="table-info">
				<th><?php echo sort_link_th('Айді','id_asc','id_desc'); ?></th>
				<th><?php echo sort_link_th('Зерно','crop_name_asc','crop_name_desc'); ?></th>
				<th><?php echo sort_link_th('Кількість','amount_asc','amount_desc'); ?></th>
				<th><?php echo sort_link_th('Дата','date_asc','date_desc'); ?></th>
				<th><?php echo sort_link_th('Назва','name_asc','name_desc'); ?></th>
				<th><?php echo sort_link_th('Телефон','number_asc','number_desc'); ?></th>
				<th><?php echo sort_link_th('Вологість','moisture_asc','moisture_desc'); ?></th>
				<th><?php echo sort_link_th('Сміття','garbage_asc','garbage_desc'); ?></th>
				<th><?php echo sort_link_th('PO₄','minerals_asc','minerals_desc'); ?></th>
				<th><?php echo sort_link_th('г/л','nature_asc','nature_desc'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $row): ?>
				<tr class="table-secondary" onclick="get_element_by_click(<?php echo $row['id']; ?>)" > 
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['crop_name']; ?></td>
					<td><?php echo $row['amount']; ?></td>
					<td><?php echo $row['date']; ?></td>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['number']; ?></td>
					<td><?php echo $row['moisture']; ?></td>
					<td><?php echo $row['garbage']; ?></td>
					<td><?php echo $row['minerals']; ?></td>
					<td><?php echo $row['nature']; ?></td>
				</tr >
			<?php endforeach; ?> 
		</tbody>
	</table>
</div>

<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."footer.php";?>