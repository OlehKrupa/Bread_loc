<?php 
$alert=[];

$result=$dbConnect->query("select `Crop`.`name` AS `name`,`Crop`.`variety` AS `variety`,`Crop`.`grade` AS `grade`,`Crop`.`moisture` AS `moisture` from `Crop`");
$list_grades = $result->fetchAll(PDO::FETCH_ASSOC);

foreach ($list_grades as $k => $v){
	if ($v['grade']==="Зіпсовано"){
		array_push($alert, "{$v['name']} {$v['variety']} Зіпсовано!");
	} elseif (($v['grade']==="Погано") && ($v['moisture']<0.16)) {
		array_push($alert, "{$v['name']} {$v['variety']} Терміново реалізувати!");
	} elseif (($v['grade']==="Погано")&& ($v['moisture']>0.16)){
		array_push($alert, "{$v['name']} {$v['variety']} Просушити або реалізувати!");
	}
}

$capacity = $dbConnect->query("SELECT `Crop`.`Warehouse_id`, `Warehouse`.`name` as `name`, sum(`Crop`.`amount`) as `amount`, `Warehouse`.`capacity` as `capacity` FROM `Crop` INNER JOIN `Warehouse` ON `Crop`.`Warehouse_id` = `Warehouse`.`id` GROUP BY `Crop`.`Warehouse_id`");
$list_capacity = $capacity->fetchAll(PDO::FETCH_ASSOC);

foreach ($list_capacity as $key => $value){
	if ($value['amount']>$value['capacity']){
		$overload=$value['amount']-$value['capacity'];
		array_push($alert,"{$value['name']} Переповнено на {$overload} тон!");
	}
}

?>