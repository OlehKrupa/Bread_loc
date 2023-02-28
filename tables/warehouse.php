<?php
require_once '../config.php';

if (isset($_POST['warehouse_chose_id'])){
	$_SESSION['warehouse_chose_id']=$_POST['warehouse_chose_id'];
}

if (!empty($_SESSION['warehouse_chose_id'])){
	$chose_id=$_SESSION['warehouse_chose_id'];
}

$result = $dbConnect->query("select * from Warehouse");
$list = $result->fetchAll(PDO::FETCH_ASSOC);

$fields=["name","address","capacity"];

if (isset($_POST['ok'])){
	if (!empty($_POST)){
		$name_ui=htmlspecialchars($_POST['name']);
		$address_ui=htmlspecialchars($_POST['address']);
		$capacity_ui=htmlspecialchars($_POST['capacity']);
		$error=[];
		foreach ($_POST as $k => $v) {
			if (in_array($k, $fields) && empty($v)){
				$error[$k]="Поле має бути заповнене!";
			}
		}
			//проверка на непустые поля
		if (empty($error)){
			if (empty($chose_id)){
				$stmt = $dbConnect->prepare("INSERT INTO `Warehouse` (
					`name`,
					`address`,
					`capacity`
					) 
				VALUES 
				( 
					:n,  
					:a,
					:c
				)"
			);
				$stmt->execute(["n"=>$name_ui,"a"=>$address_ui,"c"=>$capacity_ui]);
				header("Refresh:0");
			}else{
				$stmt = $dbConnect->prepare("UPDATE `Warehouse`
					SET
					`name`=:n,
					`address`=:a,
					`capacity`=:c
					where `id`=:id");
				$stmt->execute(["n"=>$name_ui,"a"=>$address_ui,"c"=>$capacity_ui,"id"=>$chose_id]);
				header("Refresh:0");
			}
		}
	}
}

if (!empty($chose_id)){
	foreach ($list as $key => $value) {
		if ($value['id']==$chose_id){
			$name_ui=$value['name'];
			$address_ui=$value['address'];
			$capacity_ui=$value['capacity'];
		}
	}
}

if (isset($_POST['clear'])){
	$_SESSION['warehouse_chose_id']=null;
	$name_ui="";
	$address_ui="";
	$capacity_ui="";
	header("Refresh:0");
}

if (isset($_POST['delete'])){
	$result = $dbConnect->query("select `Crop`.`Warehouse_id` AS `Warehouse_id` from (`Crop` join `Warehouse` on((`Crop`.`Warehouse_id` = `Warehouse`.`id`))) GROUP BY `Warehouse_id`");
	$list = $result->fetchAll(PDO::FETCH_ASSOC);

	foreach($list as $k => $v){
		if ($chose_id==$v['Warehouse_id']){
			echo '<script>alert("Не можна видалити, в поточний момент такий склад використовується для зберігання")</script>';
			break;
		} else {
			$delete = $dbConnect->prepare("DELETE from Warehouse where id = :id");
			$delete->execute(["id"=>$chose_id]);
		}
	}
	
	header("Refresh:0");
}

require_once TEMPLATES_PATH."warehouse.php";
?>