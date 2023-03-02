<?php
require_once '../config.php';

$result = $dbConnect->query("select * FROM `Crop` where `amount` > 0");
$crops_all = $result->fetchAll(PDO::FETCH_ASSOC);

//приходить з індекса чи кропа
if (!empty($_SESSION['sell_id'])){
	$crop_ui=$_SESSION['sell_id'];
	foreach ($crops_all as $k => $v){
		if ($v['id']==$crop_ui){
			$amount_ui=$v['amount'];
		}
	}
}

//обрано на сторінці
if (isset($_POST['consignment_chose_id'])){
	$_SESSION['consignment_chose_id']=$_POST['consignment_chose_id'];
}

if (!empty($_SESSION['consignment_chose_id'])){
	$chose_id=$_SESSION['consignment_chose_id'];
}



$result = $dbConnect->query("select `Consignment_OUT`.`id` AS `id`,`Consignment_OUT`.`Crop_id` AS `Crop_id`,`Crop`.`name` AS `crop_name`,`Consignment_OUT`.`amount` AS `amount`,`Consignment_OUT`.`date` AS `date`,`Consignment_OUT`.`name` AS `name`,`Consignment_OUT`.`number` AS `number`,`Consignment_OUT`.`moisture` AS `moisture`,`Consignment_OUT`.`garbage` AS `garbage`,`Consignment_OUT`.`minerals` AS `minerals`,`Consignment_OUT`.`nature` AS `nature` from (`Consignment_OUT` join `Crop` on((`Consignment_OUT`.`Crop_id` = `Crop`.`id`)))");
$list = $result->fetchAll(PDO::FETCH_ASSOC);

$fields=["crop_name","amount","name","number","moisture","garbage","minerals","nature"];

if (isset($_POST['ok'])){
	if (!empty($_POST)){
		$crop_ui=htmlspecialchars($_POST['crop_select']);
		$amount_ui=htmlspecialchars($_POST['amount']);
		$name_ui=htmlspecialchars($_POST['name']);
		$number_ui=htmlspecialchars($_POST['number']);

		foreach ($crops_all as $key => $value) {
			if ($value['id']==$crop_ui){
				$moisture_ui=$value['moisture'];
				$garbage_ui=$value['garbage'];
				$minerals_ui=$value['minerals'];
				$nature_ui=$value['nature'];
			}
		}

		$error=[];
		foreach ($_POST as $k => $v) {
			if (in_array($k, $fields) && empty($v)){
				$error[$k]="Поле має бути заповнене!";
			}
		}

		foreach($crops_all as $k=>$v){
			if ($v['id']==$crop_ui){
				if ($v['amount']<$amount_ui){
					$error['amount']="Продати більше ніж зберігається не можна";
				}
			}
		}

		if (!isValidPhoneNumber($number_ui)){
			$error['number']="Формат номера телефону: 380*********";
		}


			//проверка на непустые поля
		if (empty($error)){
			$stmt = $dbConnect->prepare("INSERT INTO `Consignment_OUT` (
				`Crop_id`,
				`amount`,
				`name`,
				`number`,
				`moisture`,
				`garbage`,
				`minerals`,
				`nature`
				) 
			VALUES 
			( 
				:c_id,  
				:a,
				:n,
				:nu,
				:mo,
				:ga,
				:mi,
				:na
			)"
		);
			$stmt->execute(["c_id"=>$crop_ui,"a"=>$amount_ui,"n"=>$name_ui,"nu"=>$number_ui,"mo"=>$moisture_ui,"ga"=>$garbage_ui,"mi"=>$minerals_ui,"na"=>$nature_ui]);

			$update = $dbConnect->prepare("UPDATE `Crop` set `amount` = `amount` - :a WHERE `Crop`.`id` = :c_id");
			$update->execute(["c_id"=>$crop_ui,"a"=>$amount_ui]);
			header("Refresh:0");
		}
	}
}

if (isset($_POST['clear'])){
	$_SESSION['sell_id']="";
	$_SESSION['consignment_chose_id']="";
	$chose_id="";
	$crop_ui="";
	$amount_ui="";
	$name_ui="";
	$number_ui="";
	$moisture_ui="";
	$garbage_ui="";
	$minerals_ui="";
	$nature_ui="";
	header("Refresh:0");
}

if (isset($_POST['delete'])){
	if(!empty($chose_id)){
		foreach ($list as $k => $v){
			if ($v['id']==$chose_id){
				$update = $dbConnect->prepare("UPDATE `Crop` set `amount` = `amount` + :a WHERE `Crop`.`id` = :c_id");
				$update->execute(["c_id"=>$v['Crop_id'],"a"=>$v['amount']]);
				break;
			}
		}

		$delete = $dbConnect->prepare("DELETE from Consignment_OUT where id = :id");
		$delete->execute(["id"=>$chose_id]);

	} else{
		echo "<script type='text/javascript'>alert('Помилка! Накладна для видалення не обраний!');</script>";
	}
	$_SESSION['consignment_chose_id']="";
	header("Refresh:0");
}

function isValidPhoneNumber($phoneNumber) {
	return preg_match('/^380[0-9]{9}$/', $phoneNumber);
}

require_once TEMPLATES_PATH."consignment.php";
?>