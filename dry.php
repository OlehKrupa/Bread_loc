<?php
$dry_id=1;
$max_dry = 0.15;

$result=$dbConnect->query("select `Crop`.`id` AS `id`,`Crop`.`amount` AS `amount`,`Crop`.`moisture` AS `moisture`,`Crop`.`garbage` AS `garbage` from `Crop`");
$dry_list = $result->fetchAll(PDO::FETCH_ASSOC);

foreach ($dry_list as $k => $v){
	if ($v['id']===$dry_id){
		if ($v['moisture']<=$max_dry){
			//echo "<script type='text/javascript'>alert('Сушка неможлива!');</script>";
			break;
		} else {
			$input_mouisture = $v['moisture']*100;
			$output_moisture = rand(11,16);
			$X1=100*($input_mouisture-$output_moisture)/(100-$output_moisture);

			$input_garbage = $v['garbage']*100;
			$output_garbage = 1;
			$X2=($input_garbage-1)*(100-$X1)/(100-$output_garbage);

			//in percents
			$wastage = $X1+$X2;

			$input_amount = $v['amount'];
			$output_amount = $input_amount - ($input_amount*$wastage/100);

			$stmt = $dbConnect->prepare("UPDATE `Crop` set `moisture` = :new_moisture, `amount` = :new_amount, `garbage` = :new_garbage where `id`= :id");
			$stmt->execute(["new_moisture"=>$output_moisture/100,"new_amount"=>$output_amount,"new_garbage"=>$output_garbage/100,"id"=>$dry_id]);
			//echo "<script type='text/javascript'>alert('Сушка успішна');</script>";
			break;
		}
	}
}

?>