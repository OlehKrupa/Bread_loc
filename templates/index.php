<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."header.php";?>
<div class="container-lg text-center">
	<div class="row">
		<div class="col-10">
			<form action="index.php" method="post">
				<div class="container-lg row g-0">
					<div class="col"><button class="btn btn-danger m-2" type="submit" id="write_off" name="write_off" >Списати</button></div>
					<div class="col"><button class="btn btn-info m-2" type="submit" id="dry" name="dry" >Сушити</button></div>
					<div class="col"><button class="btn btn-warning m-2" type="submit" id="sell" name="sell" >Продати</button></div>
				</div>
			</form>
			<table class="table table-striped">
				<thead>
					<tr class="table-info">
						<th><?php echo sort_link_th('Культура','name_asc','name_desc'); ?></th>
						<th><?php echo sort_link_th('Сорт','variety_asc','variety_desc'); ?></th>
						<th><?php echo sort_link_th('Стан','grade_asc','grade_desc'); ?></th>
						<th><?php echo sort_link_th('Стандарт','standard_name_asc','standard_name_desc'); ?></th>
						<th><?php echo sort_link_th('Склад','warehouse_name_asc','warehouse_name_desc'); ?></th>
						<th><?php echo sort_link_th('Кількість','amount_asc','amount_desc'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($list as $row): ?>
						<tr class="<?php if($row['grade'] === "Відмінно") echo "table-success"; elseif ($row['grade'] === "Задовільно") echo "table-secondary"; elseif ($row['grade'] === "Добре") echo "table-warning"; elseif ($row['grade'] === "Погано") echo "table-danger"; else echo "table-dark"; ?>">
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
		</div>
		<div class="col-2">
			<?php require_once "alert_cell.php"; foreach ($alert as $k => $v):?>
				<h4><?php echo($v); ?></h4>
			<?php endforeach; ?> 
		</div>
	</div>
</div>

<?php include TEMPLATES_PATH."partials".DIRECTORY_SEPARATOR."footer.php";?>