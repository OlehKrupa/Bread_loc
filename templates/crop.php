<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."header.php";?>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">

<div class="container-xxl">

	<form action="/tables/crop.php" method="post">
		<h1>Зберігання зерно-бобової продукції</h1>
		<div class="container-lg text-center row g-0">
			<div class="col mx-2">
				<div class="input-group m-2">
					<span class="input-group-text" id="supplier_select">Постачальник</span>
					<select class="form-select <?php if(!empty($error['supplier_select'])) echo 'is-invalid' ?>" id="supplier_select" name="supplier_select">
						<option value="" selected ></option>
						<?php if(!empty($supplier)) foreach($supplier as $key=>$value): ?>
						<option value="<?php echo $value["id"];?>" <?php if ((!empty($supplier_ui))&&($value["id"]===$supplier_ui)){echo "selected";}?> ><?php echo $value["name"];?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="input-group m-2">
				<span class="input-group-text" id="warehouse_select">Склад</span>
				<div class="invalid-feedback"><?php echo $error['warehouse_select'] ?? '';?></div>
				<select class="form-select <?php if(!empty($error['warehouse_select'])) echo 'is-invalid' ?>" id="warehouse_select" name="warehouse_select">
					<option value="" selected ></option>
					<?php if(!empty($warehouse)) foreach($warehouse as $key=>$value): ?>
					<option value="<?php echo $value["id"];?>" <?php if ((!empty($warehouse_ui))&&($value["id"]===$warehouse_ui)){echo "selected";}?> ><?php echo $value["name"];?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="input-group m-2">
			<span class="input-group-text" id="amount">Кількість тон</span>
			<div class="invalid-feedback"><?php echo $error['amount'] ?? '';?></div>
			<input type="text" class="form-control <?php if(!empty($error['amount'])) echo 'is-invalid' ?>" placeholder="" name="amount" aria-describedby="amount" value="<?php if(!empty($amount_ui)){echo $amount_ui;}?>">
		</div>

		<div class="input-group m-2">
			<span class="input-group-text" id="name">Культура</span>
			<div class="invalid-feedback"><?php echo $error['name'] ?? '';?></div>
			<input type="text" class="form-control <?php if(!empty($error['name'])) echo 'is-invalid' ?>" placeholder="" name="name" aria-describedby="name" value="<?php if(!empty($name_ui)){echo $name_ui;} ?>">
		</div>

		<div class="input-group m-2">
			<span class="input-group-text" id="variety">Сорт</span>
			<div class="invalid-feedback"><?php echo $error['variety'] ?? '';?></div>
			<input type="text" class="form-control <?php if(!empty($error['variety'])) echo 'is-invalid' ?>" placeholder="" name="variety" aria-describedby="variety" value="<?php if(!empty($variety_ui)){echo $variety_ui;} ?>">
		</div>

	</div>
	<div class="col mx-2">
		<div class="input-group m-2">
			<span class="input-group-text" id="standard_select">Стандарт</span>
			<div class="invalid-feedback"><?php echo $error['standard_select'] ?? '';?></div>
			<select class="form-select <?php if(!empty($error['standard_select'])) echo 'is-invalid' ?>" id="standard_select" name="standard_select">
				<option value="" selected ></option>
				<?php if(!empty($standart)) foreach($standart as $key=>$value): ?>
				<option value="<?php echo $value["id"];?>" <?php if ((!empty($standard_ui))&&($value["id"]===$standard_ui)){echo "selected";}?> ><?php echo $value["name"];?></option>
			<?php endforeach; ?>
		</select>
	</div>

	<div class="input-group m-2">
		<span class="input-group-text" id="moisture">Вологість</span>
		<div class="invalid-feedback"><?php echo $error['moisture'] ?? '';?></div>
		<input type="text" class="form-control <?php if(!empty($error['moisture'])) echo 'is-invalid' ?>" placeholder="" name="moisture" aria-describedby="moisture" value="<?php if(!empty($moisture_ui)){echo $moisture_ui;} ?>">
	</div>

	<div class="input-group m-2">
		<span class="input-group-text" id="garbage">Сміття</span>
		<div class="invalid-feedback"><?php echo $error['garbage'] ?? '';?></div>
		<input type="text" class="form-control <?php if(!empty($error['garbage'])) echo 'is-invalid' ?>" placeholder="" name="garbage" aria-describedby="garbage" value="<?php if(!empty($garbage_ui)){echo $garbage_ui;} ?>">
	</div>

	<div class="input-group m-2">
		<span class="input-group-text" id="minerals">PO₄</span>
		<div class="invalid-feedback"><?php echo $error['minerals'] ?? '';?></div>
		<input type="text" class="form-control <?php if(!empty($error['minerals'])) echo 'is-invalid' ?>" placeholder="" name="minerals" aria-describedby="minerals" value="<?php if(!empty($minerals_ui)){echo $minerals_ui;} ?>">
	</div>

	<div class="input-group m-2">
		<span class="input-group-text" id="nature">г/л</span>
		<div class="invalid-feedback"><?php echo $error['nature'] ?? '';?></div>
		<input type="text" class="form-control <?php if(!empty($error['nature'])) echo 'is-invalid' ?>" placeholder="" name="nature" aria-describedby="nature" value="<?php if(!empty($nature_ui)){echo $nature_ui;} ?>">
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

<table id="table" class="table">
	<thead>
		<tr class="table-info">
			<th>Код</th>
			<th>Постачальник</th>
			<th>Дата</th>
			<th>Склад</th>
			<th>Кількість</th>
			<th>Стандарт</th>
			<th>Культура</th>
			<th>Сорт</th>
			<th>Стан</th>
			<th>Вологість</th>
			<th>Сміття</th>
			<th>PO₄</th>
			<th>Натура</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($list as $row): ?>
			<tr class="<?php if($row['grade'] === "Відмінно") echo "table-success"; elseif ($row['grade'] === "Задовільно") echo "table-secondary"; elseif ($row['grade'] === "Добре") echo "table-warning"; elseif ($row['grade'] === "Погано") echo "table-danger"; else echo "table-dark"; ?>" 

				onclick="sendData(<?php echo $row['id']; ?>)" >
				
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

<script>
	$(document).ready( function () {
		var table = $('#table').DataTable({
			scrollY: '450px',
			scrollCollapse: true,
			paging: false,
			search: {
				return: true,
			},
		});
		$('#table tbody').on('click', 'tr', function () {
			var data = table.row(this).data();
			alert('You clicked on ' + data[0] + "'s row");
        //тут хреначить аякс запрос на перекид
		});

	} );
</script>

</div>

<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."footer.php";?>