<?php
require_once '../config.php';

if (isset($_POST['standard_chose_id'])){
	$_SESSION['standard_chose_id']=$_POST['standard_chose_id'];
}

if (!empty($_SESSION['standard_chose_id'])){
	$chose_id=$_SESSION['standard_chose_id'];
}

$result = $dbConnect->query("select * from Standard");
$list = $result->fetchAll(PDO::FETCH_ASSOC);

$fields=["name","number","minor","major","min_moisture","max_moisture","min_garbage","max_garbage","min_minerals","max_minerals","min_nature","max_nature"];

if (isset($_POST['ok'])){
	if (!empty($_POST)){
		$name_ui=htmlspecialchars($_POST['name']);
		$minor_ui=htmlspecialchars($_POST['minor']);
		$major_ui=htmlspecialchars($_POST['major']);
		$min_moisture_ui=htmlspecialchars($_POST['min_moisture']);
		$max_moisture_ui=htmlspecialchars($_POST['max_moisture']);
		$min_garbage_ui=htmlspecialchars($_POST['min_garbage']);
		$max_garbage_ui=htmlspecialchars($_POST['max_garbage']);
		$min_minerals_ui=htmlspecialchars($_POST['min_minerals']);
		$max_minerals_ui=htmlspecialchars($_POST['max_minerals']);
		$min_nature_ui=htmlspecialchars($_POST['min_nature']);
		$max_nature_ui=htmlspecialchars($_POST['max_nature']);
		$error=[];
		foreach ($_POST as $k => $v) {
			if (in_array($k, $fields) && empty($v)){
				$error[$k]="Поле має бути заповнене!";
			}
		}

		if (!isValidDecimal($min_moisture_ui)){
			$error['min_moisture']="Формат дробів *.*!";
		}
		if (!isValidDecimal($max_moisture_ui)){
			$error['max_moisture']="Формат дробів *.*!";
		}
		if (!isValidDecimal($min_garbage_ui)){
			$error['min_garbage']="Формат дробів *.*!";
		}
		if (!isValidDecimal($max_garbage_ui)){
			$error['max_garbage']="Формат дробів *.*!";
		}
		if (!isValidDecimal($min_minerals_ui)){
			$error['min_minerals']="Формат дробів *.*!";
		}
		if (!isValidDecimal($max_minerals_ui)){
			$error['max_minerals']="Формат дробів *.*!";
		}
		if ($max_nature_ui>990){
			$error['max_nature']="Натура менша за 990!";
		}

		if (empty($error)){
			if (empty($chose_id)){
				$stmt = $dbConnect->prepare("INSERT INTO `Standard` (
					`name`,
					`minor_risk`,
					`major_risk`,
					`min_moisture`,
					`max_moisture`,
					`min_garbage`,
					`max_garbage`,
					`min_minerals`,
					`max_minerals`,
					`min_nature`,
					`max_nature`
					) 
				VALUES 
				( 
					:n,  
					:min,
					:max,
					:min_mo,
					:max_mo,
					:min_ga,
					:max_ga,
					:min_mi,
					:max_mi,
					:min_na,
					:max_na
				)"
			);
				$stmt->execute(["n"=>$name_ui,"min"=>$minor_ui,"max"=>$major_ui,"min_mo"=>$min_moisture_ui,"max_mo"=>$max_moisture_ui,"min_ga"=>$min_garbage_ui,"max_ga"=>$max_garbage_ui,"min_mi"=>$min_minerals_ui,"max_mi"=>$max_minerals_ui,"min_na"=>$min_nature_ui,"max_na"=>$max_nature_ui]);
				header("Refresh:0");
			}else{
				$stmt = $dbConnect->prepare("UPDATE `Standard`
					SET
					`name`=:n,
					`minor_risk`=:min,
					`major_risk`=:max,
					`min_moisture`=:min_mo,
					`max_moisture`=:max_mo,
					`min_garbage`=:min_ga,
					`max_garbage`=:max_ga,
					`min_minerals`=:min_mi,
					`max_minerals`=:max_mi,
					`min_nature`=:min_na,
					`max_nature`=:max_na
					where `id`=:id");
				$stmt->execute(["n"=>$name_ui,"min"=>$minor_ui,"max"=>$major_ui,"min_mo"=>$min_moisture_ui,"max_mo"=>$max_moisture_ui,"min_ga"=>$min_garbage_ui,"max_ga"=>$max_garbage_ui,"min_mi"=>$min_minerals_ui,"max_mi"=>$max_minerals_ui,"min_na"=>$min_nature_ui,"max_na"=>$max_nature_ui,"id"=>$chose_id]);
				header("Refresh:0");
			}
		}
	}
}

if (!empty($chose_id)){
	foreach ($list as $key => $value) {
		if ($value['id']==$chose_id){
			$name_ui=$value['name'];
			$minor_ui=$value['minor_risk'];
			$major_ui=$value['major_risk'];
			$min_moisture_ui=$value['min_moisture'];
			$max_moisture_ui=$value['max_moisture'];
			$min_garbage_ui=$value['min_garbage'];
			$max_garbage_ui=$value['max_garbage'];
			$min_minerals_ui=$value['min_minerals'];
			$max_minerals_ui=$value['max_minerals'];
			$min_nature_ui=$value['min_nature'];
			$max_nature_ui=$value['max_nature'];
		}
	}
}

if (isset($_POST['clear'])){
	$_SESSION['standard_chose_id']=null;
	$name_ui="";
	$minor_ui="";
	$major_ui="";
	$min_moisture_ui="";
	$max_moisture_ui="";
	$min_garbage_ui="";
	$max_garbage_ui="";
	$min_minerals_ui="";
	$max_minerals_ui="";
	$min_nature_ui="";
	$max_nature_ui="";
	header("Refresh:0");
}


if (isset($_POST['delete'])){
	if(!empty($chose_id)){
		$result = $dbConnect->query("select `Crop`.`Standard_id` AS `Standard_id` from (`Crop` join `Standard` on((`Crop`.`Standard_id` = `Standard`.`id`))) GROUP BY `Standard_id`");
		$list = $result->fetchAll(PDO::FETCH_ASSOC);

		foreach($list as $k => $v){
			if ($chose_id==$v['Standard_id']){
				echo '<script>alert("Не можна видалити, в поточний момент використовуєтсья як стандарт зберігання")</script>';
				break;
			} else {
				$delete = $dbConnect->prepare("DELETE from Standard where id = :id");
				$delete->execute(["id"=>$chose_id]);
			}
		}

	} else{
		echo "<script type='text/javascript'>alert('Помилка! Зерно на списання не обране!');</script>";
	}

	$_SESSION['standard_chose_id']=null;
	header("Refresh:0");
}

function isValidDecimal($decimal) {
	return preg_match('/^[0-9]+(\.[0-9]+)?$/', $decimal);
}

require_once TEMPLATES_PATH."standard.php";
?>