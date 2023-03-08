<?php 
require_once "config.php";

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();

function download_file($path_to_file){
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($path_to_file) . '"');
header('Content-Length: ' . filesize($path_to_file));
readfile($path_to_file);
}

if (isset($_POST['crop_report'])){
	$stmt = $dbConnect->query("SELECT
		Supplier.`name` as `supplier_name`,
		Crop.date,
		Warehouse.`name` as `warehouse_name`,
		Crop.amount,
		Standard.`name` as `standard_name`,
		Crop.`name`,
		Crop.variety,
		Crop.grade,
		Crop.moisture,
		Crop.garbage,
		Crop.minerals,
		Crop.nature 
		FROM
		Crop
		INNER JOIN Standard ON Crop.Standard_id = Standard.id
		INNER JOIN Warehouse ON Crop.Warehouse_id = Warehouse.id
		INNER JOIN Supplier ON Crop.Supplier_id = Supplier.id

		where amount>0");
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$worksheet = $spreadsheet->getActiveSheet();
	$worksheet->setTitle('Зберігання');

	$worksheet->setCellValue('A1', 'Постачальник');
	$worksheet->setCellValue('B1', 'Дата');
	$worksheet->setCellValue('C1', 'Склад');
	$worksheet->setCellValue('D1', 'Кількість');
	$worksheet->setCellValue('E1', 'Стандарт');
	$worksheet->setCellValue('F1', 'Назва');
	$worksheet->setCellValue('G1', 'Сорт');
	$worksheet->setCellValue('H1', 'Оцінка');
	$worksheet->setCellValue('I1', 'Вологість');
	$worksheet->setCellValue('J1', 'Забрудненість');
	$worksheet->setCellValue('K1', 'Мінералізація');
	$worksheet->setCellValue('L1', 'Натура');

	$row = 2;
	foreach ($result as $data) {
		$worksheet->setCellValue('A' . $row, htmlspecialchars_decode($data['supplier_name']));
		$worksheet->setCellValue('B' . $row, htmlspecialchars_decode($data['date']));
		$worksheet->setCellValue('C' . $row, htmlspecialchars_decode($data['warehouse_name']));
		$worksheet->setCellValue('D' . $row, htmlspecialchars_decode($data['amount']));
		$worksheet->setCellValue('E' . $row, htmlspecialchars_decode($data['standard_name']));
		$worksheet->setCellValue('F' . $row, htmlspecialchars_decode($data['name']));
		$worksheet->setCellValue('G' . $row, htmlspecialchars_decode($data['variety']));
		$worksheet->setCellValue('H' . $row, htmlspecialchars_decode($data['grade']));
		$worksheet->setCellValue('I' . $row, htmlspecialchars_decode($data['moisture']));
		$worksheet->setCellValue('J' . $row, htmlspecialchars_decode($data['garbage']));
		$worksheet->setCellValue('K' . $row, htmlspecialchars_decode($data['minerals']));
		$worksheet->setCellValue('L' . $row, htmlspecialchars_decode($data['nature']));
		$row++;
	}

	$writer = new Xlsx($spreadsheet);
	$writer->save('reports/звіт_зерно.xlsx');
	download_file('reports/звіт_зерно.xlsx');

}

if (isset($_POST['selled_crop'])){
	$stmt = $dbConnect->query("SELECT
		Supplier.`name` as `supplier_name`,
		Crop.date,
		Warehouse.`name` as `warehouse_name`,
		Crop.amount,
		Standard.`name` as `standard_name`,
		Crop.`name`,
		Crop.variety,
		Crop.grade,
		Crop.moisture,
		Crop.garbage,
		Crop.minerals,
		Crop.nature 
		FROM
		Crop
		INNER JOIN Standard ON Crop.Standard_id = Standard.id
		INNER JOIN Warehouse ON Crop.Warehouse_id = Warehouse.id
		INNER JOIN Supplier ON Crop.Supplier_id = Supplier.id
		where amount=0");
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$worksheet = $spreadsheet->getActiveSheet();
	$worksheet->setTitle('Продано');

	$worksheet->setCellValue('A1', 'Постачальник');
	$worksheet->setCellValue('B1', 'Дата');
	$worksheet->setCellValue('C1', 'Склад');
	$worksheet->setCellValue('D1', 'Стандарт');
	$worksheet->setCellValue('E1', 'Назва');
	$worksheet->setCellValue('F1', 'Сорт');
	$worksheet->setCellValue('G1', 'Оцінка');
	$worksheet->setCellValue('H1', 'Вологість');
	$worksheet->setCellValue('I1', 'Забрудненість');
	$worksheet->setCellValue('J1', 'Мінералізація');
	$worksheet->setCellValue('K1', 'Натура');

	$row = 2;
	foreach ($result as $data) {
		$worksheet->setCellValue('A' . $row, htmlspecialchars_decode($data['supplier_name']));
		$worksheet->setCellValue('B' . $row, htmlspecialchars_decode($data['date']));
		$worksheet->setCellValue('C' . $row, htmlspecialchars_decode($data['warehouse_name']));
		$worksheet->setCellValue('D' . $row, htmlspecialchars_decode($data['standard_name']));
		$worksheet->setCellValue('E' . $row, htmlspecialchars_decode($data['name']));
		$worksheet->setCellValue('F' . $row, htmlspecialchars_decode($data['variety']));
		$worksheet->setCellValue('G' . $row, htmlspecialchars_decode($data['grade']));
		$worksheet->setCellValue('H' . $row, htmlspecialchars_decode($data['moisture']));
		$worksheet->setCellValue('I' . $row, htmlspecialchars_decode($data['garbage']));
		$worksheet->setCellValue('J' . $row, htmlspecialchars_decode($data['minerals']));
		$worksheet->setCellValue('K' . $row, htmlspecialchars_decode($data['nature']));
		$row++;
	}

	$writer = new Xlsx($spreadsheet);
	$writer->save('reports/розпродане_зерно_звіт.xlsx');
	download_file('reports/розпродане_зерно_звіт.xlsx');

}

if (isset($_POST['crop_critical_report'])){
	require_once "alert_cell.php";

	$worksheet = $spreadsheet->getActiveSheet();
	$worksheet->setTitle('Критично!');

	$worksheet->setCellValue('A1', 'Звернути увагу!');

	$row = 2;
	foreach ($alert as $data) {
		$worksheet->setCellValue('A' . $row, htmlspecialchars_decode($data));
		$row++;
	}

	$writer = new Xlsx($spreadsheet);
	$writer->save('reports/критичні_місця_звіт.xlsx');
	download_file('reports/критичні_місця_звіт.xlsx');

}

if (isset($_POST['standard_report'])){
	$stmt = $dbConnect->query("SELECT
		Standard.`name`, 
		Standard.minor_risk, 
		Standard.major_risk, 
		Standard.min_moisture, 
		Standard.max_moisture, 
		Standard.min_garbage, 
		Standard.max_garbage, 
		Standard.min_minerals, 
		Standard.max_minerals, 
		Standard.min_nature, 
		Standard.max_nature
		FROM
		Standard");
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$worksheet = $spreadsheet->getActiveSheet();
	$worksheet->setTitle('Стандарти');

	$worksheet->setCellValue('A1', 'Назва');
	$worksheet->setCellValue('B1', 'Мін ризик');
	$worksheet->setCellValue('C1', 'Макс ризик');
	$worksheet->setCellValue('D1', 'Мін. Вологість');
	$worksheet->setCellValue('E1', 'Макс. Вологість');
	$worksheet->setCellValue('F1', 'Мін. Забрудненість');
	$worksheet->setCellValue('G1', 'Макс. Забрудненість');
	$worksheet->setCellValue('H1', 'Мін. Мінералізація');
	$worksheet->setCellValue('I1', 'Макс. Мінералізація');
	$worksheet->setCellValue('J1', 'Мін. Натура');
	$worksheet->setCellValue('K1', 'Макс. Натура');

	$row = 2;
	foreach ($result as $data) {
		$worksheet->setCellValue('A' . $row, htmlspecialchars_decode($data['name']));
		$worksheet->setCellValue('B' . $row, htmlspecialchars_decode($data['minor_risk']));
		$worksheet->setCellValue('C' . $row, htmlspecialchars_decode($data['major_risk']));
		$worksheet->setCellValue('D' . $row, htmlspecialchars_decode($data['min_moisture']));
		$worksheet->setCellValue('E' . $row, htmlspecialchars_decode($data['max_moisture']));
		$worksheet->setCellValue('F' . $row, htmlspecialchars_decode($data['min_garbage']));
		$worksheet->setCellValue('G' . $row, htmlspecialchars_decode($data['max_garbage']));
		$worksheet->setCellValue('H' . $row, htmlspecialchars_decode($data['min_minerals']));
		$worksheet->setCellValue('I' . $row, htmlspecialchars_decode($data['max_minerals']));
		$worksheet->setCellValue('J' . $row, htmlspecialchars_decode($data['min_nature']));
		$worksheet->setCellValue('K' . $row, htmlspecialchars_decode($data['max_nature']));
		$row++;
	}

	$writer = new Xlsx($spreadsheet);
	$writer->save('reports/стандарти_зберігання_звіт.xlsx');
	download_file('reports/стандарти_зберігання_звіт.xlsx');
}

if (isset($_POST['supplier_report'])){
	$stmt = $dbConnect->query("SELECT
		Supplier.`name`, 
		Supplier.number, 
		Crop.`name` AS crop_name, 
		Crop.variety, 
		Crop.amount + COALESCE(Consignment_OUT.amount,0) as `amount`
		FROM
		Supplier
		INNER JOIN
		Crop
		ON 
		Supplier.id = Crop.Supplier_id
		left JOIN
		Consignment_OUT
		ON 
		Crop.id = Consignment_OUT.Crop_id");
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$worksheet = $spreadsheet->getActiveSheet();
	$worksheet->setTitle('Постачальники');

	$worksheet->setCellValue('A1', 'Назва');
	$worksheet->setCellValue('B1', 'Мобільний');
	$worksheet->setCellValue('C1', 'Культура');
	$worksheet->setCellValue('D1', 'Сорт');
	$worksheet->setCellValue('E1', 'Кількість');

	$row = 2;
	foreach ($result as $data) {
		$worksheet->setCellValue('A' . $row, htmlspecialchars_decode($data['name']));
		$worksheet->setCellValue('B' . $row, htmlspecialchars_decode($data['number']));
		$worksheet->setCellValue('C' . $row, htmlspecialchars_decode($data['crop_name']));
		$worksheet->setCellValue('D' . $row, htmlspecialchars_decode($data['variety']));
		$worksheet->setCellValue('E' . $row, htmlspecialchars_decode($data['amount']));
		$row++;
	}

	$writer = new Xlsx($spreadsheet);
	$writer->save('reports/постачальники_звіт.xlsx');
	download_file('reports/постачальники_звіт.xlsx');

}

if (isset($_POST['warehouse_report'])){
	$stmt = $dbConnect->query("SELECT
		Warehouse.`name`,
		Warehouse.address,
		SUM(Crop.amount) AS `occupancy`,
		Warehouse.capacity,
		SUM(Crop.amount) / Warehouse.capacity * 100 AS `percent`,
		IF((Warehouse.capacity - SUM(Crop.amount)) > 0, 
			Warehouse.capacity - SUM(Crop.amount), 0) AS `available`
		FROM
		Warehouse
		INNER JOIN Crop ON Warehouse.id = Crop.Warehouse_id 
		GROUP BY
		Warehouse.id;
		");
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$worksheet = $spreadsheet->getActiveSheet();
	$worksheet->setTitle('Склади');

	$worksheet->setCellValue('A1', 'Назва');
	$worksheet->setCellValue('B1', 'Адреса');
	$worksheet->setCellValue('C1', 'Заповнено тон');
	$worksheet->setCellValue('D1', 'Місткість тон');
	$worksheet->setCellValue('E1', 'Заповненість %');
	$worksheet->setCellValue('F1', 'Доступно тон');

	$row = 2;
	foreach ($result as $data) {
		$worksheet->setCellValue('A' . $row, htmlspecialchars_decode($data['name']));
		$worksheet->setCellValue('B' . $row, htmlspecialchars_decode($data['address']));
		$worksheet->setCellValue('C' . $row, htmlspecialchars_decode($data['occupancy']));
		$worksheet->setCellValue('D' . $row, htmlspecialchars_decode($data['capacity']));
		$worksheet->setCellValue('E' . $row, htmlspecialchars_decode($data['percent']));
		$worksheet->setCellValue('F' . $row, htmlspecialchars_decode($data['available']));
		$row++;
	}

	$writer = new Xlsx($spreadsheet);
	$writer->save('reports/заповненість_складів_звіт.xlsx');
	download_file('reports/заповненість_складів_звіт.xlsx');

}

if (isset($_POST['consignment_report'])){
	$date_start_ui= date('Y-m-d',strtotime('2022-01-01'));
	$date_end_ui=date('Y-m-d');

	if (!empty($_POST['date_start'])){
		$date_start_ui=$_POST['date_start'];
	}
	if (!empty($_POST['date_end'])){
		$date_end_ui=$_POST['date_end'];
	}

	$select_consignment_ui=$_POST['select_consignment'];

	if($select_consignment_ui=="Crop"){
		$stmt = $dbConnect -> prepare("SELECT
			Supplier.`name` as `supplier_name`,
			Crop.date,
			Warehouse.`name` as `warehouse_name`,
			Crop.amount,
			Standard.`name` as `standard_name`,
			Crop.`name`,
			Crop.variety,
			Crop.grade,
			Crop.moisture,
			Crop.garbage,
			Crop.minerals,
			Crop.nature 
			FROM
			Crop
			INNER JOIN Standard ON Crop.Standard_id = Standard.id
			INNER JOIN Warehouse ON Crop.Warehouse_id = Warehouse.id
			INNER JOIN Supplier ON Crop.Supplier_id = Supplier.id

			where `Crop`.`date` BETWEEN :start_date and :end_date");

		$stmt -> execute(["start_date"=>$date_start_ui,"end_date"=>$date_end_ui]);
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$worksheet = $spreadsheet->getActiveSheet();
		$worksheet->setTitle('Надходження');

		$worksheet->setCellValue('A1', 'Постачальник');
		$worksheet->setCellValue('B1', 'Дата');
		$worksheet->setCellValue('C1', 'Склад');
		$worksheet->setCellValue('D1', 'Кількість');
		$worksheet->setCellValue('E1', 'Стандарт зберігання');
		$worksheet->setCellValue('F1', 'Назва');
		$worksheet->setCellValue('G1', 'Сорт');
		$worksheet->setCellValue('H1', 'Оцінка');
		$worksheet->setCellValue('I1', 'Вологість');
		$worksheet->setCellValue('J1', 'Забрудненість');
		$worksheet->setCellValue('K1', 'Мінералізація');
		$worksheet->setCellValue('L1', 'Натура');

		$row = 2;
		foreach ($result as $data) {
			$worksheet->setCellValue('A' . $row, htmlspecialchars_decode($data['supplier_name']));
			$worksheet->setCellValue('B' . $row, htmlspecialchars_decode($data['date']));
			$worksheet->setCellValue('C' . $row, htmlspecialchars_decode($data['warehouse_name']));
			$worksheet->setCellValue('D' . $row, htmlspecialchars_decode($data['amount']));
			$worksheet->setCellValue('E' . $row, htmlspecialchars_decode($data['standard_name']));
			$worksheet->setCellValue('F' . $row, htmlspecialchars_decode($data['name']));
			$worksheet->setCellValue('G' . $row, htmlspecialchars_decode($data['variety']));
			$worksheet->setCellValue('H' . $row, htmlspecialchars_decode($data['grade']));
			$worksheet->setCellValue('I' . $row, htmlspecialchars_decode($data['moisture']));
			$worksheet->setCellValue('J' . $row, htmlspecialchars_decode($data['garbage']));
			$worksheet->setCellValue('K' . $row, htmlspecialchars_decode($data['minerals']));
			$worksheet->setCellValue('L' . $row, htmlspecialchars_decode($data['nature']));
			$row++;
		}

		$writer = new Xlsx($spreadsheet);
		$writer->save('reports/надходження_'.$date_start_ui.'_'.$date_end_ui.'_звіт.xlsx');
		download_file('reports/надходження_'.$date_start_ui.'_'.$date_end_ui.'_звіт.xlsx');

	}else{
		$stmt = $dbConnect ->prepare("SELECT
			Crop.`name`,
			Crop.variety,
			Consignment_OUT.amount,
			Consignment_OUT.date,
			Consignment_OUT.`name` as `customer`,
			Consignment_OUT.moisture,
			Consignment_OUT.garbage,
			Consignment_OUT.minerals,
			Consignment_OUT.nature 
			FROM
			Consignment_OUT
			INNER JOIN Crop ON Consignment_OUT.Crop_id = Crop.id
			INNER JOIN Standard ON Crop.Standard_id = Standard.id
			INNER JOIN Supplier ON Crop.Supplier_id = Supplier.id
			INNER JOIN Warehouse ON Crop.Warehouse_id = Warehouse.id
			where `Consignment_OUT`.`date` BETWEEN :start_date and :end_date");

		$stmt -> execute(["start_date"=>$date_start_ui,"end_date"=>$date_end_ui]);
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$worksheet = $spreadsheet->getActiveSheet();
		$worksheet->setTitle('Відправки');

		$worksheet->setCellValue('A1', 'Назва');
		$worksheet->setCellValue('B1', 'Сорт');
		$worksheet->setCellValue('C1', 'Кількість');
		$worksheet->setCellValue('D1', 'Дата');
		$worksheet->setCellValue('E1', 'Покупець');
		$worksheet->setCellValue('F1', 'Вологість');
		$worksheet->setCellValue('G1', 'Забрудненість');
		$worksheet->setCellValue('H1', 'Мінералізація');
		$worksheet->setCellValue('I1', 'Натура');

		$row = 2;
		foreach ($result as $data) {
			$worksheet->setCellValue('A' . $row, htmlspecialchars_decode($data['name']));
			$worksheet->setCellValue('B' . $row, htmlspecialchars_decode($data['variety']));
			$worksheet->setCellValue('C' . $row, htmlspecialchars_decode($data['amount']));
			$worksheet->setCellValue('D' . $row, htmlspecialchars_decode($data['date']));
			$worksheet->setCellValue('E' . $row, htmlspecialchars_decode($data['customer']));
			$worksheet->setCellValue('F' . $row, htmlspecialchars_decode($data['moisture']));
			$worksheet->setCellValue('G' . $row, htmlspecialchars_decode($data['garbage']));
			$worksheet->setCellValue('H' . $row, htmlspecialchars_decode($data['minerals']));
			$worksheet->setCellValue('I' . $row, htmlspecialchars_decode($data['nature']));
			$row++;
		}

		$writer = new Xlsx($spreadsheet);
		$writer->save('reports/відправки_'.$date_start_ui.'_'.$date_end_ui.'_звіт.xlsx');
		download_file('reports/відправки_'.$date_start_ui.'_'.$date_end_ui.'_звіт.xlsx');
	}

}
require_once TEMPLATES_PATH."report.php";
?>