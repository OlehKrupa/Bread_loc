<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."header.php";?>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">

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

	<table id="table" class="table">
		<thead>
			<tr class="table-info">
				<th>Код</th>
				<th>Назва</th>
				<th>Адреса</th>
				<th>Ємність</th>
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
			alert('Обрано склад з кодом: ' + data[0]);

			$.ajax({
				type: "POST",
				url: "/tables/warehouse.php",
				data: { warehouse_chose_id: data[0]},
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