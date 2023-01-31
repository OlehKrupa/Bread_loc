<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."header.php";?>

<div class="container-lg">
	<table class="table table-striped">
		<thead>
			<tr>
				<th><?php echo sort_link_th('Культура','name_asc','name_desc'); ?></th>
				<th><?php echo sort_link_th('Сорт','variety_asc','variety_desc'); ?></th>
				<th><?php echo sort_link_th('Стан','grade_asc','grade_desc'); ?></th>
				<th><?php echo sort_link_th('Кількість','amount_asc','amount_desc'); ?></th>
				<th><?php echo sort_link_th('Вологість','moisture_asc','moisture_desc'); ?></th>
				<th><?php echo sort_link_th('t °C','temperature_asc','temperature_desc'); ?></th>
				<th><?php echo sort_link_th('Склад','warehouse_asc','warehouse_desc'); ?></th>
				<th><?php echo sort_link_th('Адреса','address_asc','address_desc'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $row): ?>
				<tr class="<?php if ($row['grade'] === "Задовільно") echo "table-warning"; elseif ($row['grade'] === "Добре") echo "table-info"; ?>">
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['variety']; ?></td>
					<td><?php echo $row['grade']; ?></td>
					<td><?php echo $row['amount']; ?> тон</td>
					<td><?php echo $row['moisture']; ?></td>
					<td><?php echo $row['temperature']; ?></td>
					<td><?php echo $row['warehouse']; ?></td>
					<td><?php echo $row['address']; ?></td>
				</tr >
			<?php endforeach; ?>    
		</tbody>
	</table>
</div>

<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."footer.php";?>