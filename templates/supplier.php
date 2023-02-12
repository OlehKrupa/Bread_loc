<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."header.php";?>

<div class="container-lg">
	<form action="/tables/supplier.php" method="post">
		
		<div class="container-lg text-center row g-0">
			<div class="col mx-2">
				<div class="input-group m-2">
					<span class="input-group-text" id="name">Назва</span>
					<div class="invalid-feedback"><?php echo $error['name'] ?? '';?></div>
					<textarea class="form-control <?php if(!empty($error['name'])) echo 'is-invalid' ?>" placeholder="" id="name" name="name" aria-describedby="name"><?php if (!empty($name_ui)){echo $name_ui;} ?></textarea>
				</div>
			</div>
			<div class="col mx-2">
				<div class="input-group m-2">
					<span class="input-group-text" id="number">Номер телефону</span>
					<div class="invalid-feedback"><?php echo $error['number'] ?? '';?></div>
					<input type="text" class="form-control <?php if(!empty($error['number'])) echo 'is-invalid' ?>" placeholder="" name="number" aria-describedby="number" value="<?php if (!empty($number_ui)){echo $number_ui;} ?>">
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
				<th><?php echo sort_link_th('Назва','name_asc','name_desc'); ?></th>
				<th><?php echo sort_link_th('Номер телефону','number_asc','number_desc'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $row): ?>
				<tr class="table-primary" onclick="get_element_by_click(<?php echo $row['id']; ?>)" > 
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['number']; ?></td>
				</tr >
			<?php endforeach; ?> 
		</tbody>
	</table>
</div>

<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."footer.php";?>