<?php
require_once '../config.php';

if (isset($_POST['supplier_chose_id'])){
	$_SESSION['supplier_chose_id']=$_POST['supplier_chose_id'];
}

if (!empty($_SESSION['supplier_chose_id'])){
	$chose_id=$_SESSION['supplier_chose_id'];
}

$result = $dbConnect->query("select * from Supplier");
$list = $result->fetchAll(PDO::FETCH_ASSOC);

$fields=["name","number"];

if (isset($_POST['ok'])){
	if (!empty($_POST)){
		$name_ui=htmlspecialchars($_POST['name']);
		$number_ui=htmlspecialchars($_POST['number']);
		$error=[];
		foreach ($_POST as $k => $v) {
			if (in_array($k, $fields) && empty($v)){
				$error[$k]="Поле має бути заповнене!";
			}
		}
			//проверка на непустые поля
		if (empty($error)){
			if (empty($chose_id)){
				$stmt = $dbConnect->prepare("INSERT INTO `Supplier` (
					`name`,
					`number`
					) 
				VALUES 
				( 
					:n,  
					:nu
				)"
			);
				$stmt->execute(["n"=>$name_ui,"nu"=>$number_ui]);
				header("Refresh:0");
			}else{
				$stmt = $dbConnect->prepare("UPDATE `Supplier`
					SET
					`name`=:n,
					`number`=:nu
					where `id`=:id");
				$stmt->execute(["n"=>$name_ui,"nu"=>$number_ui,"id"=>$chose_id]);
header("Refresh:0");
			}
		}
	}
}

if (!empty($chose_id)){
	foreach ($list as $key => $value) {
		if ($value['id']==$chose_id){
			$name_ui=$value['name'];
			$number_ui=$value['number'];
		}
	}
}

if (isset($_POST['clear'])){
	$_SESSION['supplier_chose_id']=null;
	$name_ui="";
	$number_ui="";
	header("Refresh:0");
}

if (isset($_POST['delete'])){
	$result = $dbConnect->query("select `Crop`.`Supplier_id` AS `Supplier_id` from (`Crop` join `Supplier` on((`Crop`.`Standard_id` = `Supplier`.`id`))) GROUP BY `Supplier_id`");
	$list = $result->fetchAll(PDO::FETCH_ASSOC);

	foreach($list as $k => $v){
		if ($chose_id==$v['Supplier_id']){
			echo '<script>alert("Не можна видалити, в поточний момент такий постачальник наявний в таблиці зберігання")</script>';
			break;
		} else {
			$delete = $dbConnect->prepare("DELETE from Supplier where id = :id");
			$delete->execute(["id"=>$chose_id]);
		}
	}
	
	header("Refresh:0");
}

require_once TEMPLATES_PATH."supplier.php";
?>