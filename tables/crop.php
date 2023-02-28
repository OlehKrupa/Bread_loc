<?php
require_once '../config.php';

if (isset($_POST['crop_chose_id'])){
	$_SESSION['crop_chose_id']=$_POST['crop_chose_id'];
}

if (!empty($_SESSION['crop_chose_id'])){
$chose_id=$_SESSION['crop_chose_id'];
}

if (isset($_POST['refresh'])){
	require_once '../grade.php';
	header("Refresh:0");
}

$result = $dbConnect->query("select `Crop`.`id` AS `id`,`Supplier`.`name` AS `supplier_name`,`Crop`.`date` AS `date`,`Warehouse`.`name` AS `warehouse_name`,`Crop`.`amount` AS `amount`,`Standard`.`name` AS `standard_name`,`Crop`.`name` AS `name`,`Crop`.`variety` AS `variety`,`Crop`.`grade` AS `grade`,`Crop`.`moisture` AS `moisture`,`Crop`.`garbage` AS `garbage`,`Crop`.`minerals` AS `minerals`,`Crop`.`nature` AS `nature`, `Supplier_id`, `Warehouse_id`,`Standard_id` from (((`Crop` join `Warehouse` on((`Crop`.`Warehouse_id` = `Warehouse`.`id`))) join `Supplier` on((`Crop`.`Supplier_id` = `Supplier`.`id`))) join `Standard` on((`Crop`.`Standard_id` = `Standard`.`id`))) where `amount` > 0");
$list = $result->fetchAll(PDO::FETCH_ASSOC);

$fields=['supplier_select','warehouse_select','standard_select','date','amount','name','variety','moisture','garbage','minerals','nature'];

if (isset($_POST['ok'])){
	if (!empty($_POST)){
		$supplier_ui=$_POST['supplier_select'];
		$date_ui =$_POST['date'];
		$warehouse_ui=$_POST['warehouse_select'];
		$standard_ui=$_POST['standard_select'];
		$amount_ui=htmlspecialchars($_POST['amount']);
		$name_ui=htmlspecialchars($_POST['name']);
		$variety_ui=htmlspecialchars($_POST['variety']);
		$moisture_ui=htmlspecialchars($_POST['moisture']);
		$garbage_ui=htmlspecialchars($_POST['garbage']);
		$minerals_ui=htmlspecialchars($_POST['minerals']);
		$nature_ui=htmlspecialchars($_POST['nature']);

		$error=[];
		foreach ($_POST as $k => $v) {
			if (in_array($k, $fields) && empty($v)){
				$error[$k]="Поле має бути заповнене!";
			}
		}
			//проверка на непустые поля
		if (empty($error)){
			if (empty($chose_id)){
				$stmt = $dbConnect->prepare("INSERT INTO `Crop` (
					`Supplier_id`,
					`date`,
					`Warehouse_id`,
					`amount`,
					`Standard_id`,
					`name`,
					`variety`,
					`moisture`,
					`garbage`,
					`minerals`,
					`nature`
					) 
				VALUES 
				(
					:s_id,
					:dat,
					:w_id, 
					:a, 
					:s_id, 
					:n, 
					:v, 
					:m, 
					:g, 
					:mi, 
					:na
				)"
			);
				$stmt->execute(["s_id"=>$supplier_ui,"dat"=>$date_ui,"w_id"=>$warehouse_ui,"a"=>$amount_ui,"s_id"=>$standard_ui,"n"=>$name_ui,"v"=>$variety_ui,"m"=>$moisture_ui,"g"=>$garbage_ui,"mi"=>$minerals_ui,"na"=>$nature_ui]);
				header("Refresh:0");
			}else{
				$stmt = $dbConnect->prepare("UPDATE `Crop`
					SET
					`Supplier_id`=:s_id,
					`date`=:dat,
					`Warehouse_id`=:w_id,
					`amount`=:a,
					`Standard_id`=:s_id,
					`name`=:n,
					`variety`=:v,
					`moisture`=:m,
					`garbage`=:g,
					`minerals`=:mi,
					`nature`=:na
					where `id`=:id");
				$stmt->execute(["s_id"=>$supplier_ui,"dat"=>$date_ui,"w_id"=>$warehouse_ui,"a"=>$amount_ui,"s_id"=>$standard_ui,"n"=>$name_ui,"v"=>$variety_ui,"m"=>$moisture_ui,"g"=>$garbage_ui,"mi"=>$minerals_ui,"na"=>$nature_ui,"id"=>$chose_id]);
				header("Refresh:0");

			}
		}
	}
	require_once '../grade.php';
}

if (!empty($chose_id)){
	foreach ($list as $key => $value) {
		if ($value['id']==$chose_id){
			$supplier_ui=$value['Supplier_id'];
			$date_ui=$value['date'];
			$warehouse_ui=$value['Warehouse_id'];
			$standard_ui=$value['Standard_id'];
			$amount_ui=$value['amount'];
			$name_ui=$value['name'];
			$variety_ui=$value['variety'];
			$moisture_ui=$value['moisture'];
			$garbage_ui=$value['garbage'];
			$minerals_ui=$value['minerals'];
			$nature_ui=$value['nature'];
		}
	}
}

if (isset($_POST['clear'])){
	$_SESSION['crop_chose_id']=null;
	$supplier_ui="";
	$date_ui="";
	$warehouse_ui="";
	$standard_ui="";
	$amount_ui="";
	$name_ui="";
	$variety_ui="";
	$moisture_ui="";
	$garbage_ui="";
	$minerals_ui="";
	$nature_ui="";
	header("Refresh:0");
}

if (isset($_POST['write_off'])){
	$delete = $dbConnect->prepare("DELETE from Crop where id = :id");
	$delete->execute(["id"=>$chose_id]);
	header("Refresh:0");
}

if (isset($_POST['dry'])){
	$_SESSION['dry_id']=$chose_id;
	require_once '../dry.php';
	header("Refresh:0");
}

if (isset($_POST['sell'])){
	$_SESSION['sell_id']=$chose_id;
	header("location: /tables/consignment.php");
	die();
}

$result = $dbConnect->query("SELECT * FROM `Supplier`");
$supplier = $result->fetchAll(PDO::FETCH_ASSOC);

$result = $dbConnect->query("SELECT * FROM `Warehouse`");
$warehouse = $result->fetchAll(PDO::FETCH_ASSOC);

$result = $dbConnect->query("SELECT * FROM `Standard`");
$standart = $result->fetchAll(PDO::FETCH_ASSOC);


require_once TEMPLATES_PATH."crop.php";
?>