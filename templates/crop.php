<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."header.php";?>

<div class="container-lg">

	<form action="crop.php" method="post">
		
		<div class="container-lg text-center row g-0">
			<div class="col mx-2">
				<div class="input-group m-2">
					<span class="input-group-text" id="basic-addon1">Постачальник</span>
					<select class="form-select" id="supplier_select">
						<?php foreach($supplier as $key=>$value): ?>
							<option value="<?php echo $value["id"];?>"><?php echo $value["name"];?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="input-group m-2">
					<span class="input-group-text" id="basic-addon1">Склад</span>
					<select class="form-select" id="warehouse_select">
						<?php foreach($warehouse as $key=>$value): ?>
							<option value="<?php echo $value["id"];?>"><?php echo $value["name"];?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="input-group m-2">
					<span class="input-group-text" id="basic-addon1">Кількість тон</span>
					<input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
				</div>
				<div class="input-group m-2">
					<span class="input-group-text" id="basic-addon1">Культура</span>
					<input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
				</div>
				<div class="input-group m-2">
					<span class="input-group-text" id="basic-addon1">Сорт</span>
					<input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
				</div>
			</div>
			<div class="col mx-2">
				<div class="input-group m-2">
					<span class="input-group-text" id="basic-addon1">Стандарт</span>
					<select class="form-select" id="standard_select">
						<?php foreach($standart as $key=>$value): ?>
							<option value="<?php echo $value["id"];?>"><?php echo $value["name"];?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="input-group m-2">
					<span class="input-group-text" id="basic-addon1">Вологість</span>
					<input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
				</div>
				<div class="input-group m-2">
					<span class="input-group-text" id="basic-addon1">Сміття</span>
					<input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
				</div>
				<div class="input-group m-2">
					<span class="input-group-text" id="basic-addon1">PO₄</span>
					<input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
				</div>
				<div class="input-group m-2">
					<span class="input-group-text" id="basic-addon1">г/л</span>
					<input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
				</div>
			</div>
		</div>

		<div class="container-lg text-center row g-0">
			<div class="col"><button type="button" class="btn btn-success mb-2" type="submit" id="approve" name="approve" >*Підтвердити*</button></div>
			<div class="col"><button type="button" class="btn btn-danger mb-2" type="submit" id="write_off" name="write_off" >*Списати*</button></div>
			<div class="col"><button type="button" class="btn btn-info mb-2" type="submit" id="dry" name="dry" >*Сушити*</button></div>
			<div class="col"><button type="button" class="btn btn-warning mb-2" type="submit" id="sell" name="sell" >*Продати*</button></div>
		</div>
	</form>

	<table class="table table-striped">
		<thead>
			<tr class="table-info">
				<th><?php echo sort_link_th('Айді','id_asc','id_desc'); ?></th>
				<th><?php echo sort_link_th('Постачальник','supplier_name_asc','supplier_name_desc'); ?></th>
				<th><?php echo sort_link_th('Дата','date_asc','date_desc'); ?></th>
				<th><?php echo sort_link_th('Склад','warehouse_name_asc','warehouse_name_desc'); ?></th>
				<th><?php echo sort_link_th('Кількість','amount_asc','amount_desc'); ?></th>
				<th><?php echo sort_link_th('Стандарт','standard_name_asc','standard_name_desc'); ?></th>
				<th><?php echo sort_link_th('Культура','name_asc','name_desc'); ?></th>
				<th><?php echo sort_link_th('Сорт','variety_asc','variety_desc'); ?></th>
				<th><?php echo sort_link_th('Стан','grade_asc','grade_desc'); ?></th>
				<th><?php echo sort_link_th('Вологість','moisture_asc','moisture_desc'); ?></th>
				<th><?php echo sort_link_th('Сміття','garbage_asc','garbage_desc'); ?></th>
				<th><?php echo sort_link_th('PO₄','minerals_asc','minerals_desc'); ?></th>
				<th><?php echo sort_link_th('г/л','nature_asc','nature_desc'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $row): ?>
				<tr class="<?php if($row['grade'] === "Відмінно") echo "table-success"; elseif ($row['grade'] === "Задовільно") echo "table-secondary"; elseif ($row['grade'] === "Добре") echo "table-warning"; elseif ($row['grade'] === "Погано") echo "table-danger"; else echo "table-dark"; ?>">
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['supplier_name']; ?></td>
					<td><?php echo $row['date']; ?></td>
					<td><?php echo $row['warehouse_name']; ?></td>
					<td><?php echo $row['amount']; ?> тон</td>
					<td><?php echo $row['standard_name']; ?></td>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['variety']; ?></td>
					<td><?php echo $row['grade']; ?></td>
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