<?php
require_once '../config.php';

$grade_ranges = [0=>"Зіпсовано",5=>"Погано",10=>"Задовільно",15=>"Добре",20=>"Відмінно"];
$grade="Задовільно";

$result=$dbConnect->query("select `Crop`.`id` AS `id`,`Crop`.`moisture` AS `moisture`,`Standard`.`min_moisture` AS `min_moisture`,`Standard`.`max_moisture` AS `max_moisture`,`Crop`.`garbage` AS `garbage`,`Standard`.`min_garbage` AS `min_garbage`,`Standard`.`max_garbage` AS `max_garbage`,`Crop`.`minerals` AS `minerals`,`Standard`.`min_minerals` AS `min_minerals`,`Standard`.`max_minerals` AS `max_minerals`,`Crop`.`nature` AS `nature`,`Standard`.`min_nature` AS `min_nature`,`Standard`.`max_nature` AS `max_nature`,`Crop`.`date` AS `date`,`Standard`.`minor_risk` AS `minor_risk`,`Standard`.`major_risk` AS `major_risk`,`Crop`.`grade` AS `grade` from (`Crop` join `Standard` on((`Crop`.`Standard_id` = `Standard`.`id`))) order by `Crop`.`id`");

$list = $result->fetchAll(PDO::FETCH_NAMED);

$stmt = $dbConnect->prepare("UPDATE `Crop` set `grade` = :new_grade where `id`= :id");

foreach ($list as $value) {
	$final_grade=0;
	
	$moisture_ranges = [$value['min_moisture'],((3*$value['min_moisture']+$value['max_moisture'])/4),(($value['min_moisture']+$value['max_moisture'])/2),(($value['min_moisture']+$value['max_moisture']*3)/4),$value['max_moisture']];
	foreach($moisture_ranges as $v){
		if ($value['moisture']<$v){
			$final_grade++;
		}
	}
	
	$garbage_ranges = [ $value['min_garbage'], ((3*$value['min_garbage']+$value['max_garbage'])/4), (($value['min_garbage']+$value['max_garbage'])/2), (($value['min_garbage']+$value['max_garbage']*3)/4), $value['max_garbage']];
	foreach($garbage_ranges as $v){
		if ($value['garbage']<$v){
			$final_grade++;
		}
	}

	$minerals_ranges = [ $value['min_minerals'], ((3*$value['min_minerals']+$value['max_minerals'])/4), (($value['min_minerals']+$value['max_minerals'])/2), (($value['min_minerals']+$value['max_minerals']*3)/4), $value['max_minerals']];
	foreach($minerals_ranges as $v){
		if ($value['minerals']<$v){
			$final_grade++;
		}
	}
	

	$nature_ranges = [ $value['min_nature'], ((3*$value['min_nature']+$value['max_nature'])/4), (($value['min_nature']+$value['max_nature'])/2), (($value['min_nature']+$value['max_nature']*3)/4), $value['max_nature']];
	foreach($nature_ranges as $v){
		if ($value['nature']>$v){
			$final_grade++;
		}
	}

	$time_ranges = [ $value['minor_risk'], ((3*$value['minor_risk']+$value['major_risk'])/4), (($value['minor_risk']+$value['major_risk'])/2), (($value['minor_risk']+$value['major_risk']*3)/4), $value['major_risk']];
	foreach($time_ranges as $v){
		$cur_date = strtotime(date('Y/m/d', time()));
		$db_date = strtotime($value['date']);
			//diff in months
		$diff=floor((abs($cur_date-$db_date))/(30*60*60*24));
		if ($diff<$v){
			$final_grade++;
		}
	}

	if ($final_grade>20){
		$grade=$grade_ranges[20];
	}elseif ($final_grade>15){
		$grade=$grade_ranges[15];
	}elseif ($final_grade>10){
		$grade=$grade_ranges[10];
	}elseif ($final_grade>5){
		$grade=$grade_ranges[5];
	}else{
		$grade=$grade_ranges[0];
	}

	$stmt->execute(["new_grade"=>$grade,"id"=>$value['id']]);
}

?>