<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."header.php";?>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">

<div class="container-lg">
	<form action="/tables/standard.php" method="post">
		<h1>Стандарти зберігання зерно-бобової продукції</h1>
		<div class="container-lg text-center row g-0">
			<div class="col-4 px-2">
				<div class="input-group m-2">
					<span class="input-group-text" id="name">Назва</span>
					<textarea class="form-control <?php if(!empty($error['name'])) echo 'is-invalid' ?>" placeholder="" id="name" name="name" aria-describedby="name"><?php if (!empty($name_ui)){echo $name_ui;} ?></textarea>
					<div class="invalid-feedback"><?php echo $error['name'] ?? '';?></div>
				</div>
				<div class="input-group m-2">
					<span class="input-group-text" id="minor">Мінімальний ризик</span>
					<input type="text" class="form-control <?php if(!empty($error['minor'])) echo 'is-invalid' ?>" placeholder="" name="minor" aria-describedby="minor" value="<?php if (!empty($minor_ui)){echo $minor_ui;} ?>">
					<div class="invalid-feedback"><?php echo $error['minor'] ?? '';?></div>
				</div>

				<div class="input-group m-2">
					<span class="input-group-text" id="major">Максимальний ризик</span>
					<input type="text" class="form-control <?php if(!empty($error['major'])) echo 'is-invalid' ?>" placeholder="" name="major" aria-describedby="major" value="<?php if (!empty($major_ui)){echo $major_ui;} ?>">
					<div class="invalid-feedback"><?php echo $error['major'] ?? '';?></div>
				</div>
			</div>

			<div class="col-8 px-2">
				<div class="row">
					<div class="col mt-1">
						<h5>Вологість</h5>
						<div class="row">
							<div class="col">
								<div class="input-group m-1">
									<span class="input-group-text" id="min_moisture">min</span>
									<input type="text" class="form-control <?php if(!empty($error['min_moisture'])) echo 'is-invalid' ?>" placeholder="" name="min_moisture" aria-describedby="min_moisture" value="<?php if (!empty($min_moisture_ui)){echo $min_moisture_ui;} ?>">
									<div class="invalid-feedback"><?php echo $error['min_moisture'] ?? '';?></div>
								</div>
							</div>
							<div class="col">
								<div class="input-group m-1">
									<span class="input-group-text" id="max_moisture">max</span>
									<input type="text" class="form-control <?php if(!empty($error['max_moisture'])) echo 'is-invalid' ?>" placeholder="" name="max_moisture" aria-describedby="max_moisture" value="<?php if (!empty($max_moisture_ui)){echo $max_moisture_ui;} ?>">
									<div class="invalid-feedback"><?php echo $error['max_moisture'] ?? '';?></div>
								</div>
							</div>
							
						</div>
						
						<h5>Засміченість</h5>
						<div class="row">
							<div class="col">
								<div class="input-group m-1">
									<span class="input-group-text" id="min_garbage">min</span>
									<input type="text" class="form-control <?php if(!empty($error['min_garbage'])) echo 'is-invalid' ?>" placeholder="" name="min_garbage" aria-describedby="min_garbage" value="<?php if (!empty($min_garbage_ui)){echo $min_garbage_ui;} ?>">
									<div class="invalid-feedback"><?php echo $error['min_garbage'] ?? '';?></div>
								</div>
							</div>
							<div class="col">
								<div class="input-group m-1">
									<span class="input-group-text" id="max_garbage">max</span>
									<input type="text" class="form-control <?php if(!empty($error['max_garbage'])) echo 'is-invalid' ?>" placeholder="" name="max_garbage" aria-describedby="max_garbage" value="<?php if (!empty($max_garbage_ui)){echo $max_garbage_ui;} ?>">
									<div class="invalid-feedback"><?php echo $error['max_garbage'] ?? '';?></div>
								</div>
							</div>
						</div>

						
					</div>

					<div class="col mt-1">
						<h5>Мінеральна домішка</h5>
						<div class="row">
							<div class="col">
								<div class="input-group m-1">
									<span class="input-group-text" id="min_minerals">min</span>
									<input type="text" class="form-control <?php if(!empty($error['min_minerals'])) echo 'is-invalid' ?>" placeholder="" name="min_minerals" aria-describedby="min_minerals" value="<?php if (!empty($min_minerals_ui)){echo $min_minerals_ui;} ?>">
									<div class="invalid-feedback"><?php echo $error['min_minerals'] ?? '';?></div>
								</div>
							</div>
							<div class="col">
								<div class="input-group m-1">
									<span class="input-group-text" id="max_minerals">max</span>
									<input type="text" class="form-control <?php if(!empty($error['max_minerals'])) echo 'is-invalid' ?>" placeholder="" name="max_minerals" aria-describedby="max_minerals" value="<?php if (!empty($max_minerals_ui)){echo $max_minerals_ui;} ?>">
									<div class="invalid-feedback"><?php echo $error['max_minerals'] ?? '';?></div>
								</div>
							</div>
						</div>
						
						
						<h5>Натура г/л</h5>
						<div class="row">
							<div class="col">
								<div class="input-group m-1">
									<span class="input-group-text" id="min_nature">min</span>
									<input type="text" class="form-control <?php if(!empty($error['min_nature'])) echo 'is-invalid' ?>" placeholder="" name="min_nature" aria-describedby="min_nature" value="<?php if (!empty($min_nature_ui)){echo $min_nature_ui;} ?>">
									<div class="invalid-feedback"><?php echo $error['min_nature'] ?? '';?></div>
								</div>
							</div>
							<div class="col">
								<div class="input-group m-1">
									<span class="input-group-text" id="max_nature">max</span>
									<input type="text" class="form-control <?php if(!empty($error['max_nature'])) echo 'is-invalid' ?>" placeholder="" name="max_nature" aria-describedby="max_nature" value="<?php if (!empty($max_nature_ui)){echo $max_nature_ui;} ?>">
									<div class="invalid-feedback"><?php echo $error['max_nature'] ?? '';?></div>
								</div>
							</div>
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
				<th>Назва</th>
				<th>Мін ризики</th>
				<th>Макс ризики</th>
				<th>Мін вологість</th>
				<th>Макс вологість</th>
				<th>Мін сміття</th>
				<th>Макс сміття</th>
				<th>Мін PO₄</th>
				<th>Макс PO₄</th>
				<th>Мін натура</th>
				<th>Макс натура</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $row): ?>
				<tr class="table-primary" onclick="get_element_by_click(<?php echo $row['id']; ?>)" > 
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['minor_risk']; ?></td>
					<td><?php echo $row['major_risk']; ?></td>
					<td><?php echo $row['min_moisture']; ?></td>
					<td><?php echo $row['max_moisture']; ?></td>
					<td><?php echo $row['min_garbage']; ?></td>
					<td><?php echo $row['max_garbage']; ?></td>
					<td><?php echo $row['min_minerals']; ?></td>
					<td><?php echo $row['max_minerals']; ?></td>
					<td><?php echo $row['min_nature']; ?></td>
					<td><?php echo $row['max_nature']; ?></td>
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
			//айдишник
			alert('Обрано стандарт з кодом: ' + data[0]);

			$.ajax({
				type: "POST",
				url: "/tables/standard.php",
				data: { standard_chose_id: data[0]},
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