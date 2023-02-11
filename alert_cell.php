<?php 
$result=$dbConnect->query("select `Crop`.`name` AS `name`,`Crop`.`variety` AS `variety`,`Crop`.`grade` AS `grade`,`Crop`.`moisture` AS `moisture` from `Crop`");
$list_ = $result->fetchAll(PDO::FETCH_ASSOC);

$alert=[];

foreach ($list_ as $k => $v){
	if ($v['grade']==="Зіпсовано"){
		array_push($alert, "{$v['name']} {$v['variety']} Зіпсовано!");
	} elseif (($v['grade']==="Погано") && ($v['moisture']<0.16)) {
		array_push($alert, "{$v['name']} {$v['variety']} Терміново реалізувати!");
	} elseif (($v['grade']==="Погано")&& ($v['moisture']>0.16)){
		array_push($alert, "{$v['name']} {$v['variety']} Просушити або реалізувати!");
	}
}

?>