<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."header.php";?>

<div class="container-lg">

	<form action="/tables/crop.php" method="post">
		
		<div class="container-lg text-center row g-0">
			<div class="col mx-2">
				<div class="input-group m-2">
					<span class="input-group-text" id="basic-addon1">Постачальник</span>
					<select class="form-select" id="supplier_select">
						<?php foreach($supplier as $key=>$value): ?>
							<option value="<?php echo $value["id"];?>"><?php echo $value["name"];?></option>
						<?php endforeach; ?>
						<option selected=""> </option>
					</select>
				</div>
				<div class="input-group m-2">
					<span class="input-group-text" id="warehouse_select">Склад</span>
					<select class="form-select" id="warehouse_select">
						<?php foreach($warehouse as $key=>$value): ?>
							<option value="<?php echo $value["id"];?>"><?php echo $value["name"];?></option>
						<?php endforeach; ?>
						<option selected=""> </option>
					</select>
				</div>
				<div class="input-group m-2">
					<span class="input-group-text" id="amount">Кількість тон</span>
					<input type="text" class="form-control" placeholder="" aria-describedby="amount">
				</div>
				<div class="input-group m-2">
					<span class="input-group-text" id="name">Культура</span>
					<input type="text" class="form-control" placeholder="" aria-describedby="name">
				</div>
				<div class="input-group m-2">
					<span class="input-group-text" id="variety">Сорт</span>
					<input type="text" class="form-control" placeholder=""aria-describedby="variety">
				</div>
			</div>
			<div class="col mx-2">
				<div class="input-group m-2">
					<span class="input-group-text" id="standard">Стандарт</span>
					<select class="form-select" id="standard">
						<?php foreach($standart as $key=>$value): ?>
							<option value="<?php echo $value["id"];?>"><?php echo $value["name"];?></option>
						<?php endforeach; ?>
						<option selected=""> </option>
					</select>
				</div>
				<div class="input-group m-2">
					<span class="input-group-text" id="moisture">Вологість</span>
					<input type="text" class="form-control" placeholder="" aria-describedby="moisture">
				</div>
				<div class="input-group m-2">
					<span class="input-group-text" id="garbage">Сміття</span>
					<input type="text" class="form-control" placeholder="" aria-describedby="garbage">
				</div>
				<div class="input-group m-2">
					<span class="input-group-text" id="minerals">PO₄</span>
					<input type="text" class="form-control" placeholder="" aria-describedby="minerals">
				</div>
				<div class="input-group m-2">
					<span class="input-group-text" id="nature">г/л</span>
					<input type="text" class="form-control" placeholder="" aria-describedby="nature">
				</div>
			</div>
		</div>

		<div class="container-lg text-center row g-0">
			<div class="col"><button class="btn btn-primary mb-2" type="submit" name="add" >*Додати*</button></div>
			<div class="col"><button class="btn btn-secondary mb-2" type="submit" name="clear" >*Очистити*</button></div>
			<div class="col"><button class="btn btn-success mb-2" type="submit" name="approve" >*Підтвердити*</button></div>
			<div class="col"><button class="btn btn-danger mb-2" type="submit" name="write_off" >*Списати*</button></div>
			<div class="col"><button class="btn btn-info mb-2" type="submit" name="dry" >*Сушити*</button></div>
			<div class="col"><button class="btn btn-warning mb-2" type="submit" name="sell" >*Продати*</button></div>
		</div>

	</form>

	<table class="table">
		<script src="../JS/index.js"></script>
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
				<tr class="<?php if($row['grade'] === "Відмінно") echo "table-success"; elseif ($row['grade'] === "Задовільно") echo "table-secondary"; elseif ($row['grade'] === "Добре") echo "table-warning"; elseif ($row['grade'] === "Погано") echo "table-danger"; else echo "table-dark"; ?>" 

					onclick="get_element_by_click(<?php echo $row['id']; ?>)" >
					
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