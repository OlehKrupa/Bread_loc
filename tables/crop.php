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

$sql=$dbConnect->query("select Crop.Warehouse_id as `id`, Warehouse.capacity, sum( Crop.amount ) as `all_amount` FROM Crop INNER JOIN Warehouse ON Crop.Warehouse_id = Warehouse.id GROUP BY Warehouse.id");
$capacity=$sql->fetchAll(PDO::FETCH_ASSOC);

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
		
		if (empty($chose_id)){
			foreach($capacity as $k=>$v){
				if($v['id']==$warehouse_ui){
					if (($v['all_amount']+$amount_ui)>($v['capacity']+$v['capacity']*0.1)){
						$error['warehouse_select']="Переповнення складу!";
					}
				}
			}
		}

		if (!isValidPositiveInteger($nature_ui)){
			$error['nature']="Має бути цілим додатнім!";
		}

		if (!isValidDecimal($moisture_ui)){
			$error['moisture']="Формат дробів *.*!";
		}
		if (!isValidDecimal($garbage_ui)){
			$error['garbage']="Формат дробів *.*!";
		}
		if (!isValidDecimal($minerals_ui)){
			$error['minerals']="Формат дробів *.*!";
		}
		if ($nature_ui>990){
			$error['nature']="Натура не більше за 990!";
		}

		foreach ($_POST as $k => $v) {
			if (in_array($k, $fields) && empty($v)){
				$error[$k]="Поле має бути заповнене!";
			}
		}

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
					:st_id, 
					:n, 
					:v, 
					:m, 
					:g, 
					:mi, 
					:na
				)"
			);
				$stmt->execute(["s_id"=>$supplier_ui,"dat"=>$date_ui,"w_id"=>$warehouse_ui,"a"=>$amount_ui,"st_id"=>$standard_ui,"n"=>$name_ui,"v"=>$variety_ui,"m"=>$moisture_ui,"g"=>$garbage_ui,"mi"=>$minerals_ui,"na"=>$nature_ui]);
				header("Refresh:0");
			}else{
				$stmt = $dbConnect->prepare("UPDATE `Crop`
					SET
					`Supplier_id`=:s_id,
					`date`=:dat,
					`Warehouse_id`=:w_id,
					`amount`=:a,
					`Standard_id`=:st_id,
					`name`=:n,
					`variety`=:v,
					`moisture`=:m,
					`garbage`=:g,
					`minerals`=:mi,
					`nature`=:na
					where `id`=:id");
				$stmt->execute(["s_id"=>$supplier_ui,"dat"=>$date_ui,"w_id"=>$warehouse_ui,"a"=>$amount_ui,"st_id"=>$standard_ui,"n"=>$name_ui,"v"=>$variety_ui,"m"=>$moisture_ui,"g"=>$garbage_ui,"mi"=>$minerals_ui,"na"=>$nature_ui,"id"=>$chose_id]);
				header("Refresh:0");
			}
		}
	}
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
	if(!empty($chose_id)){
		$delete = $dbConnect->prepare("DELETE from Crop where id = :id");
		$delete->execute(["id"=>$chose_id]);
		$_SESSION['crop_chose_id']=null;
	} else{
		echo "<script type='text/javascript'>alert('Помилка! Зерно на списання не обране!');</script>";
	}
	header("Refresh:0");
}

if (isset($_POST['dry'])){
	if(!empty($chose_id)){
		$_SESSION['dry_id']=$chose_id;
		require_once '../dry.php';
		require_once '../grade.php';
	} else {
		echo "<script type='text/javascript'>alert('Помилка! Зерно на сушку не обране!');</script>";
	}
	header("Refresh:0");
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

$result = $dbConnect->query("SELECT * FROM `Supplier`");
$supplier = $result->fetchAll(PDO::FETCH_ASSOC);

$result = $dbConnect->query("SELECT * FROM `Warehouse`");
$warehouse = $result->fetchAll(PDO::FETCH_ASSOC);

$result = $dbConnect->query("SELECT * FROM `Standard`");
$standart = $result->fetchAll(PDO::FETCH_ASSOC);

function isValidDecimal($decimal) {
	return preg_match('/^[0-9]+(\.[0-9]+)?$/', $decimal);
}

function isValidPositiveInteger($pInteger) {
	return preg_match('/^[1-9][0-9]*$/', $pInteger);
}

require_once TEMPLATES_PATH."crop.php";
?>