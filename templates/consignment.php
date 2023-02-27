<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."header.php";?>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">

<div class="container-lg">
	<form action="/tables/consignment.php" method="post">
		<h1>Відправні накладні</h1>
		<div class="container-lg text-center row g-0">
			<div class="col px-2">
				<div class="input-group m-2">

					<span class="input-group-text" id="crop_select">Зерно</span>
							<select class="form-select <?php if(!empty($error['crop_select'])) echo 'is-invalid' ?>" id="crop_select" name="crop_select">
								<option value="" selected ></option>
								<?php if(!empty($crops)) foreach($crops as $key=>$value): ?>
								<option value="<?php echo $value["id"];?>" <?php if ((!empty($crop_ui))&&($value["id"]===$crop_ui)){echo "selected";}?> ><?php echo "Код: ".$value["id"]." ".$value["name"]." ".$value["variety"];?></option>
							<?php endforeach; ?>
						</select>
				</div>

				<div class="row">
					<div class="col">
						<div class="input-group m-2">
							<span class="input-group-text" id="amount">Кількість</span>
							<div class="invalid-feedback"><?php echo $error['amount'] ?? '';?></div>
							<input type="text" class="form-control <?php if(!empty($error['amount'])) echo 'is-invalid' ?>" placeholder="" name="amount" aria-describedby="amount" value="<?php if (!empty($amount_ui)){echo $amount_ui;} ?>">
						</div>
					</div>
					<div class="col">
						<div class="input-group m-2">
							<span class="input-group-text" id="date">Дата</span>
							<div class="invalid-feedback"><?php echo $error['date'] ?? '';?></div>
							<input type="date" lang="uk" class="form-control <?php if(!empty($error['date'])) echo 'is-invalid' ?>" placeholder="" name="date" aria-describedby="date" value="<?php if(!empty($date_ui)){echo $date_ui;}?>">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col">
						<div class="input-group m-2">
							<span class="input-group-text" id="name">Назва</span>
							<div class="invalid-feedback"><?php echo $error['name'] ?? '';?></div>
							<textarea class="form-control <?php if(!empty($error['name'])) echo 'is-invalid' ?>" id="name" name="name" aria-describedby="name"><?php if (!empty($name_ui)){echo $name_ui;} ?></textarea>
						</div>
					</div>
					<div class="col">
						<div class="input-group m-2">
							<span class="input-group-text" id="number">Телефон</span>
							<div class="invalid-feedback"><?php echo $error['number'] ?? '';?></div>
							<input type="text" class="form-control <?php if(!empty($error['number'])) echo 'is-invalid' ?>" placeholder="" name="number" aria-describedby="number" value="<?php if(!empty($number_ui)){echo $number_ui;} ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="input-group m-2">
							<span class="input-group-text" id="moisture">Вологість</span>
							<div class="invalid-feedback"><?php echo $error['moisture'] ?? '';?></div>
							<input type="text" class="form-control <?php if(!empty($error['moisture'])) echo 'is-invalid' ?>" placeholder="" name="moisture" aria-describedby="moisture" value="<?php if(!empty($moisture_ui)){echo $moisture_ui;} ?>">
						</div>
					</div>
					<div class="col">
						<div class="input-group m-2">
							<span class="input-group-text" id="garbage">Сміття</span>
							<div class="invalid-feedback"><?php echo $error['garbage'] ?? '';?></div>
							<input type="text" class="form-control <?php if(!empty($error['garbage'])) echo 'is-invalid' ?>" placeholder="" name="garbage" aria-describedby="garbage" value="<?php if(!empty($garbage_ui)){echo $garbage_ui;} ?>">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col">
						<div class="input-group m-2">
							<span class="input-group-text" id="minerals">PO₄</span>
							<div class="invalid-feedback"><?php echo $error['minerals'] ?? '';?></div>
							<input type="text" class="form-control <?php if(!empty($error['minerals'])) echo 'is-invalid' ?>" placeholder="" name="minerals" aria-describedby="minerals" value="<?php if(!empty($minerals_ui)){echo $minerals_ui;} ?>">
						</div>
					</div>
					<div class="col">
						<div class="input-group m-2">
							<span class="input-group-text" id="nature">г/л</span>
							<div class="invalid-feedback"><?php echo $error['nature'] ?? '';?></div>
							<input type="text" class="form-control <?php if(!empty($error['nature'])) echo 'is-invalid' ?>" placeholder="" name="nature" aria-describedby="nature" value="<?php if(!empty($nature_ui)){echo $nature_ui;} ?>">
						</div>
					</div>
				</div>	
			</div>

		</div>

		<div class="container-lg text-center row g-0">
			<div class="col"><button class="btn btn-success mb-2" type="submit" name="ok" >ОК</button></div>
			<div class="col"><button class="btn btn-secondary mb-2" type="submit" name="clear" >Очистити</button></div>
			<div class="col"><button class="btn btn-danger mb-2" type="submit" name="delete" >Видалити</button></div>
		</div>

	</form>

	<table id="table" class="table">
		<thead>
			<tr class="table-info">
				<th>Код</th>
				<th>Зерно</th>
				<th>Кількість</th>
				<th>Дата</th>
				<th>Назва</th>
				<th>Телефон</th>
				<th>Вологість</th>
				<th>Сміття</th>
				<th>PO₄</th>
				<th>Натура</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $row): ?>
				<tr class="table-primary" onclick="get_element_by_click(<?php echo $row['id']; ?>)" > 
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

	<script>
		$(document).ready( function () {
			var table = $('#table').DataTable({
				scrollY: '500px',
				scrollCollapse: true,
				paging: false,
			});
			$('#table tbody').on('click', 'tr', function () {
				var data = table.row(this).data();
				alert('Обрано накладну з кодом: ' + data[0]);

				$.ajax({
					type: "POST",
					url: "/tables/consignment.php",
					data: { consignment_chose_id: data[0]},
					success: function(response) {
						location.reload();
					},
					error: function(xhr, status, error) {
						console.error(error);
					}
				});
			});

		} );
	</script>

</div>

<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."footer.php";?>