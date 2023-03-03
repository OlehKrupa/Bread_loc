<?php 
require_once "config.php";

if (isset($_POST['crop_report'])){
	$stmt = $dbConnect->query("SELECT
		Crop.id,
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
	print_r($result);
}

if (isset($_POST['crop_critical_report'])){

}

if (isset($_POST['standard_report'])){
	$stmt = $dbConnect->query("select * from Standard");
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	print_r($result);
}

if (isset($_POST['supplier_report'])){
	$stmt = $dbConnect->query("select * from Supplier");
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	print_r($result);
}

if (isset($_POST['warehouse_report'])){
	$stmt = $dbConnect->query("select * from Warehouse");
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	print_r($result);
}

if (isset($_POST['consignment_report'])){
	$date_start_ui= date('Y-m-d',strtotime('2000-01-01'));
	$date_end_ui=date('Y-m-d',strtotime('3000-01-01'));

	if (!empty($_POST['date_start'])){
		$date_start_ui=$_POST['date_start'];
	}
	if (!empty($_POST['date_end'])){
		$date_end_ui=$_POST['date_end'];
	}

	$select_consignment_ui=$_POST['select_consignment'];

	if($select_consignment_ui=="Crop"){
		$stmt = $dbConnect -> prepare("SELECT
			Crop.id,
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
		$result = $stmt->fetchAll();
		print_r($result);
	}else{
		$stmt = $dbConnect ->prepare("SELECT
			Consignment_OUT.id,
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
		$result = $stmt->fetchAll();
		print_r($result);
	}

	//Сделать вывод результа в excel

}

require_once TEMPLATES_PATH."report.php";
?>