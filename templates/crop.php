<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."header.php";?>

<div class="container-lg">

	<form action="/tables/crop.php" method="post">
		
		<div class="container-lg text-center row g-0">
			<div class="col mx-2">
				<div class="input-group m-2">
					<span class="input-group-text" id="supplier_select">Постачальник</span>
					
					<select class="form-select <?php if(!empty($error['supplier_select'])) echo 'is-invalid' ?>" id="supplier_select" name="supplier_select">
						<option value="" selected ></option>
						<?php foreach($supplier as $key=>$value): ?>
							<option value="<?php echo $value["id"];?>" <?php if ($value["id"]===$supplier_ui){echo "selected";}?> ><?php echo $value["name"];?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="input-group m-2">
					<span class="input-group-text" id="warehouse_select">Склад</span>
					<div class="invalid-feedback"><?php echo $error['warehouse_select'] ?? '';?></div>
					<select class="form-select <?php if(!empty($error['warehouse_select'])) echo 'is-invalid' ?>" id="warehouse_select" name="warehouse_select">
						<option value="" selected ></option>
						<?php foreach($warehouse as $key=>$value): ?>
							<option value="<?php echo $value["id"];?>" <?php if ($value["id"]===$warehouse_ui){echo "selected";}?> ><?php echo $value["name"];?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="input-group m-2">
					<span class="input-group-text" id="amount">Кількість тон</span>
					<div class="invalid-feedback"><?php echo $error['amount'] ?? '';?></div>
					<input type="text" class="form-control <?php if(!empty($error['amount'])) echo 'is-invalid' ?>" placeholder="" name="amount" aria-describedby="amount" value="<?php echo $amount_ui ?>">
				</div>

				<div class="input-group m-2">
					<span class="input-group-text" id="name">Культура</span>
					<div class="invalid-feedback"><?php echo $error['name'] ?? '';?></div>
					<input type="text" class="form-control <?php if(!empty($error['name'])) echo 'is-invalid' ?>" placeholder="" name="name" aria-describedby="name" value="<?php echo $name_ui ?>">
				</div>

				<div class="input-group m-2">
					<span class="input-group-text" id="variety">Сорт</span>
					<div class="invalid-feedback"><?php echo $error['variety'] ?? '';?></div>
					<input type="text" class="form-control <?php if(!empty($error['variety'])) echo 'is-invalid' ?>" placeholder="" name="variety" aria-describedby="variety" value="<?php echo $variety_ui ?>">
				</div>

			</div>
			<div class="col mx-2">
				<div class="input-group m-2">
					<span class="input-group-text" id="standard_select">Стандарт</span>
					<div class="invalid-feedback"><?php echo $error['standard_select'] ?? '';?></div>
					<select class="form-select <?php if(!empty($error['standard_select'])) echo 'is-invalid' ?>" id="standard_select" name="standard_select">
						<option value="" selected ></option>
						<?php foreach($standart as $key=>$value): ?>
							<option value="<?php echo $value["id"];?>" <?php if ($value["id"]===$standard_ui){echo "selected";}?> ><?php echo $value["name"];?></option>
						<?php endforeach; ?>
					</select>
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
			<div class="col"><button class="btn btn-primary mb-2" type="submit" name="refresh" >Оновити</button></div>
			<div class="col"><button class="btn btn-secondary mb-2" type="submit" name="clear" >Очистити</button></div>
			<div class="col"><button class="btn btn-danger mb-2" type="submit" name="write_off" >Списати</button></div>
			<div class="col"><button class="btn btn-info mb-2" type="submit" name="dry" >Сушити</button></div>
			<div class="col"><button class="btn btn-warning mb-2" type="submit" name="sell" >Продати</button></div>
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