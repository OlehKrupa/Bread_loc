<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."header.php";?>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">

<div class="container-lg">
	<div class="row">
		<div class="col-10">
			<form action="index.php" method="post">
				<h1>Стан зберігання</h1>
				<div class="container-lg row g-0 text-center">
					<div class="col"><button class="btn btn-danger m-2" type="submit" id="write_off" name="write_off" >Списати</button></div>
					<div class="col"><button class="btn btn-info m-2" type="submit" id="dry" name="dry" >Сушити</button></div>
					<div class="col"><button class="btn btn-warning m-2" type="submit" id="sell" name="sell" >Продати</button></div>
				</div>
			</form>
			<table id="table" class="table">
				<thead>
					<tr class="table-info">
						<th>Код</th>
						<th>Культура</th>
						<th>Сорт</th>
						<th>Стан</th>
						<th>Стандарт</th>
						<th>Склад</th>
						<th>Кількість</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($list as $row): ?>
						<tr class="<?php if($row['grade'] === "Відмінно") echo "table-success"; elseif ($row['grade'] === "Задовільно") echo "table-warning"; elseif ($row['grade'] === "Добре") echo "table-primary"; elseif ($row['grade'] === "Погано") echo "table-danger"; else echo "table-dark"; ?>">
							<td><?php echo $row['id']; ?></td>
							<td><?php echo $row['name']; ?></td>
							<td><?php echo $row['variety']; ?></td>
							<td><?php echo $row['grade']; ?></td>
							<td><?php echo $row['standard_name']; ?></td>
							<td><?php echo $row['warehouse_name']; ?></td>
							<td><?php echo $row['amount']; ?> тон</td>
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
			alert('Обрано зерно з кодом: ' + data[0]);

			$.ajax({
				type: "POST",
				url: "index.php",
				data: { index_chose_id: data[0]},
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
		<div class="col-2">
			<?php require_once "alert_cell.php"; foreach ($alert as $k => $v):?>
			<h4><?php echo($v); ?></h4>
		<?php endforeach; ?> 
	</div>
</div>
</div>

<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."footer.php";?>