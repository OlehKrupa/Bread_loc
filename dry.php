<?php
//Обране зерно на сушку
if (!empty($_SESSION['dry_id'])){
	$dry_id=$_SESSION['dry_id'];
} else {
	echo "<script type='text/javascript'>alert('Помилка! Зерно на сушку не обране!');</script>";
}
//Максимально можливий відсоток сушки зерна (15%)
$max_dry = 0.15;

//Запит на читання даних з бд
$result=$dbConnect->query("select `Crop`.`id` AS `id`,`Crop`.`amount` AS `amount`,`Crop`.`moisture` AS `moisture`,`Crop`.`garbage` AS `garbage` from `Crop`");
$dry_list = $result->fetchAll(PDO::FETCH_ASSOC);

//Перебір всього зерна на зберігання
foreach ($dry_list as $k => $v){
	//Пошук потрібного на сушку зерна
	if ($v['id']==$dry_id){
		//Якщо вологість <= максимально можливій після сушки то відповідно більше чим максимум зерно просушити та очистити не можна
		if ($v['moisture']<=$max_dry){
			echo "<script type='text/javascript'>alert('Сушка неможлива!');</script>";
			break;
		} else {
			//Математичне забезпечення
			//Початкова вологість
			$input_mouisture = $v['moisture']*100;
			//Вологість після сушки (імітується генерацією випадкового числа)
			$output_moisture = rand(11,16);
			//Підрахунок втрат зерна після сушки
			$X1=100*($input_mouisture-$output_moisture)/(100-$output_moisture);

			//Початкова засміченість
			$input_garbage = $v['garbage']*100;
			//Засміченість після очистки взято середній реалістичний 1% засміченості
			$output_garbage = 1;
			//Підрахунок втрат зерна післа очистки від сміття
			$X2=($input_garbage-1)*(100-$X1)/(100-$output_garbage);

			//Загальні втрати зерна після очистки та сушки
			$wastage = $X1+$X2;

			//Початкова кількість зерна
			$input_amount = $v['amount'];
			//Кількість зерна після сушки та очистки з урахуванням втрат
			$output_amount = $input_amount - ($input_amount*$wastage/100);

			//запит на зміну кількості, вологості та забрудненості зерна в бд
			$stmt = $dbConnect->prepare("UPDATE `Crop` set `moisture` = :new_moisture, `amount` = :new_amount, `garbage` = :new_garbage where `id`= :id");
			$stmt->execute(["new_moisture"=>$output_moisture/100,"new_amount"=>$output_amount,"new_garbage"=>$output_garbage/100,"id"=>$dry_id]);
			echo "<script type='text/javascript'>alert('Сушка успішна');</script>";
			break;
		}
	}
}

?>