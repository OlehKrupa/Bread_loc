<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."header.php";?>

<div class="container-lg">
	<table class="table table-striped">
		<thead>
			<tr>
				<th><?php echo sort_link_th('Айді','id_asc','id_desc'); ?></th>
				<th><?php echo sort_link_th('Склад','warehouse_name_asc','warehouse_name_desc'); ?></th>
				<th><?php echo sort_link_th('Культура','name_asc','name_desc'); ?></th>
				<th><?php echo sort_link_th('Сорт','variety_asc','variety_desc'); ?></th>
				<th><?php echo sort_link_th('Стан','grade_asc','grade_desc'); ?></th>
				<th><?php echo sort_link_th('Кількість','amount_asc','amount_desc'); ?></th>
				<th><?php echo sort_link_th('Вологість','moisture_asc','moisture_desc'); ?></th>
				<th><?php echo sort_link_th('t °C','temperature_asc','temperature_desc'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $row): ?>
				<tr class="<?php if($row['grade'] === "Відмінно") echo "table-success"; elseif ($row['grade'] === "Задовільно") echo "table-secondary"; elseif ($row['grade'] === "Добре") echo "table-warning"; elseif ($row['grade'] === "Погано") echo "table-danger"; else echo "table-dark"; ?>">
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['warehouse_name']; ?></td>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['variety']; ?></td>
					<td><?php echo $row['grade']; ?></td>
					<td><?php echo $row['amount']; ?> тон</td>
					<td><?php echo $row['moisture']; ?></td>
					<td><?php echo $row['temperature']; ?></td>
				</tr >
			<?php endforeach; ?>    
		</tbody>
	</table>
</div>

<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."footer.php";?>