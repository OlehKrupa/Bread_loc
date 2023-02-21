<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."header.php";?>
<div class="container-lg">
	<form action="/tables/warehouse.php" method="post">
		<h1>Складські приміщення та елеватори</h1>
		<div class="container-lg text-center row g-0">
			<div class="col mx-2">
				<div class="input-group m-2">
					<span class="input-group-text" id="name">Назва</span>
					<div class="invalid-feedback"><?php echo $error['name'] ?? '';?></div>
					<textarea class="form-control <?php if(!empty($error['name'])) echo 'is-invalid' ?>" id="name" name="name" aria-describedby="name"><?php if (!empty($name_ui)){echo $name_ui;} ?></textarea>
				</div>
			</div>
			<div class="col mx-2">
				<div class="input-group m-2">
					<span class="input-group-text" id="address">Адреса</span>
					<div class="invalid-feedback"><?php echo $error['address'] ?? '';?></div>
					<textarea class="form-control <?php if(!empty($error['address'])) echo 'is-invalid' ?>" id="address" name="address" aria-describedby="address" ><?php if (!empty($address_ui)){echo $address_ui;} ?></textarea>
				</div>
			</div>
			<div class="col mx-2">
				<div class="input-group m-2">
					<span class="input-group-text" id="capacity">Ємність</span>
					<div class="invalid-feedback"><?php echo $error['capacity'] ?? '';?></div>
					<input type="text" class="form-control <?php if(!empty($error['capacity'])) echo 'is-invalid' ?>" placeholder="" name="capacity" aria-describedby="capacity" value="<?php if (!empty($capacity_ui)){echo $capacity_ui;} ?>">
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
				<th><?php echo sort_link_th('Код','id_asc','id_desc'); ?></th>
				<th><?php echo sort_link_th('Назва','name_asc','name_desc'); ?></th>
				<th><?php echo sort_link_th('Адреса','address_asc','address_desc'); ?></th>
				<th><?php echo sort_link_th('Ємність','capacity_asc','capacity_desc'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $row): ?>
				<tr class="table-primary" onclick="get_element_by_click(<?php echo $row['id']; ?>)" > 
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['address']; ?></td>
					<td><?php echo $row['capacity']; ?></td>
				</tr >
			<?php endforeach; ?> 
		</tbody>
	</table>
</div>

<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."footer.php";?>