<?php
//Шкала словесних оцінок та меж балів, з яких вони починаютсья
$grade_ranges = [0=>"Зіпсовано",5=>"Погано",10=>"Задовільно",15=>"Добре",20=>"Відмінно"];
//Початкове default значення оцінки
$grade="Задовільно";

//Запит на отрмиання всіх потрібних для обрахунку даних з БД
$result=$dbConnect->query("select `Crop`.`id` AS `id`,`Crop`.`moisture` AS `moisture`,`Standard`.`min_moisture` AS `min_moisture`,`Standard`.`max_moisture` AS `max_moisture`,`Crop`.`garbage` AS `garbage`,`Standard`.`min_garbage` AS `min_garbage`,`Standard`.`max_garbage` AS `max_garbage`,`Crop`.`minerals` AS `minerals`,`Standard`.`min_minerals` AS `min_minerals`,`Standard`.`max_minerals` AS `max_minerals`,`Crop`.`nature` AS `nature`,`Standard`.`min_nature` AS `min_nature`,`Standard`.`max_nature` AS `max_nature`,`Crop`.`date` AS `date`,`Standard`.`minor_risk` AS `minor_risk`,`Standard`.`major_risk` AS `major_risk`,`Crop`.`grade` AS `grade` from (`Crop` join `Standard` on((`Crop`.`Standard_id` = `Standard`.`id`))) order by `Crop`.`id`");
$list = $result->fetchAll(PDO::FETCH_ASSOC);

//підготовка запиту на оновлення словесної оцінки за обраним айді
$stmt = $dbConnect->prepare("UPDATE `Crop` set `grade` = :new_grade where `id`= :id");

foreach ($list as $value) {
	//Обнулення фінальної оцінки перед початком розрахунків
	$final_grade=0;
	
	//Визначення граничних меж вологості за описаною формулою поділу діапазону
	$moisture_ranges = [$value['min_moisture'],((3*$value['min_moisture']+$value['max_moisture'])/4),(($value['min_moisture']+$value['max_moisture'])/2),(($value['min_moisture']+$value['max_moisture']*3)/4),$value['max_moisture']];
	//перебір меж та визначення до якої саме межі відноситься критерій вологості
	foreach($moisture_ranges as $v){
		if ($value['moisture']<$v){
			//з кожною ітерацією оцінка збульшуєтсья на 1, це значить що критерії подолав межу для збільшення своєї оцінки
			$final_grade++;
		}
	}
	
	//Визначення граничних меж сміттєвих домішок за описаною формулою поділу діапазону
	$garbage_ranges = [ $value['min_garbage'], ((3*$value['min_garbage']+$value['max_garbage'])/4), (($value['min_garbage']+$value['max_garbage'])/2), (($value['min_garbage']+$value['max_garbage']*3)/4), $value['max_garbage']];
	//перебір меж та визначення до якої саме межі відноситься критерій сміттєвих домішок
	foreach($garbage_ranges as $v){
		if ($value['garbage']<$v){
			//з кожною ітерацією оцінка збульшуєтсья на 1, це значить що критерії подолав межу для збільшення своєї оцінки
			$final_grade++;
		}
	}

	//Визначення граничних меж мінеральних домішок за описаною формулою поділу діапазону
	$minerals_ranges = [ $value['min_minerals'], ((3*$value['min_minerals']+$value['max_minerals'])/4), (($value['min_minerals']+$value['max_minerals'])/2), (($value['min_minerals']+$value['max_minerals']*3)/4), $value['max_minerals']];
	//перебір меж та визначення до якої саме межі відноситься критерій мінеральних домішок
	foreach($minerals_ranges as $v){
		if ($value['minerals']<$v){
			//з кожною ітерацією оцінка збульшуєтсья на 1, це значить що критерії подолав межу для збільшення своєї оцінки
			$final_grade++;
		}
	}
	
	//Визначення граничних меж натури зерна за описаною формулою поділу діапазону
	$nature_ranges = [ $value['min_nature'], ((3*$value['min_nature']+$value['max_nature'])/4), (($value['min_nature']+$value['max_nature'])/2), (($value['min_nature']+$value['max_nature']*3)/4), $value['max_nature']];
	//перебір меж та визначення до якої саме межі відноситься критерій натури зерна
	foreach($nature_ranges as $v){
		//в if використано знак >, адже чим більша натура г/л зерна тим краще, навідміну від попередніх критеріїв
		if ($value['nature']>$v){
			//з кожною ітерацією оцінка збульшуєтсья на 1, це значить що критерії подолав межу для збільшення своєї оцінки
			$final_grade++;
		}
	}

	//Визначення граничних меж ризиків зберігання по часу в місяцях за описаною формулою поділу діапазону
	$time_ranges = [ $value['minor_risk'], ((3*$value['minor_risk']+$value['major_risk'])/4), (($value['minor_risk']+$value['major_risk'])/2), (($value['minor_risk']+$value['major_risk']*3)/4), $value['major_risk']];
	//перебір меж та визначення до якої саме межі відноситься критерій часових ризиків
	foreach($time_ranges as $v){
		//визначається теперішня дата
		$cur_date = strtotime(date('Y/m/d', time()));
		$db_date = strtotime($value['date']);
		//різниця між теперішньою датою та датою прибуття зерна у місяцях
		$diff=floor((abs($cur_date-$db_date))/(30*60*60*24));
		if ($diff<$v){
			$final_grade++;
		}
	}

	//Переклад балу якості зерна в словесний відповідник
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

	//Виконання запиту на оновлення оцінки зерна
	$stmt->execute(["new_grade"=>$grade,"id"=>$value['id']]);
	
}

?>