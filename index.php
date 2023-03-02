<?php 
require_once "config.php";

if (isset($_POST['index_chose_id'])){
	$_SESSION['index_chose_id']=$_POST['index_chose_id'];
}

if (!empty($_SESSION['index_chose_id'])){
	$chose_id=$_SESSION['index_chose_id'];
}

if (empty($_SESSION['user'])){
	header("location: /login.php");
	die();
}

if (isset($_POST['write_off'])){
	if(!empty($chose_id)){
		$delete = $dbConnect->prepare("DELETE from Crop where id = :id");
		$delete->execute(["id"=>$chose_id]);
		header("Refresh:0");
	} else{
		echo "<script type='text/javascript'>alert('Помилка! Зерно на списання не обране!');</script>";
		header("Refresh:0");
	}
}

if (isset($_POST['dry'])){
	if(!empty($chose_id)){
		$_SESSION['dry_id']=$chose_id;
		require_once 'dry.php';
		require_once 'grade.php';
		header("Refresh:0");
	} else {
		echo "<script type='text/javascript'>alert('Помилка! Зерно на сушку не обране!');</script>";
		header("Refresh:0");
	}
}

if (isset($_POST['sell'])){
	if(!empty($chose_id)){
		$_SESSION['sell_id']=$chose_id;
		header("location: /tables/consignment.php");
		die();
	} else {
		echo "<script type='text/javascript'>alert('Помилка! Зерно на продаж не обрано!');</script>";
		header("Refresh:0");
	}
}

$result = $dbConnect->query("select `Crop`.`id` AS `id`,`Supplier`.`name` AS `supplier_name`,`Crop`.`date` AS `date`,`Warehouse`.`name` AS `warehouse_name`,`Crop`.`amount` AS `amount`,`Standard`.`name` AS `standard_name`,`Crop`.`name` AS `name`,`Crop`.`variety` AS `variety`,`Crop`.`grade` AS `grade`,`Crop`.`moisture` AS `moisture`,`Crop`.`garbage` AS `garbage`,`Crop`.`minerals` AS `minerals`,`Crop`.`nature` AS `nature` from (((`Crop` join `Warehouse` on((`Crop`.`Warehouse_id` = `Warehouse`.`id`))) join `Supplier` on((`Crop`.`Supplier_id` = `Supplier`.`id`))) join `Standard` on((`Crop`.`Standard_id` = `Standard`.`id`))) where `amount` > 0");
$list = $result->fetchAll(PDO::FETCH_ASSOC);

require_once TEMPLATES_PATH."index.php";
?>