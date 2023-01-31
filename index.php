<?php 
require_once "config.php";

if (empty($_SESSION['user'])){
	header("location: /login.php");
	die();
}

$sort_list = array(
'name_asc'=>'`name`',
'name_desc'=>'`name` DESC',
'variety_asc'=>'`variety`',
'variety_desc'=>'`variety` DESC',
'grade_asc'=>'`grade`',
'grade_desc'=>'`grade` DESC',
'amount_asc'=>'`amount`',
'amount_desc'=>'`amount` DESC',
'moisture_asc'=>'`moisture`',
'moisture_desc'=>'`moisture` DESC',
'temperature_asc'=>'`temperature`',
'temperature_desc'=>'`temperature` DESC',
'warehouse_asc'=>'`warehouse`',
'warehouse_desc'=>'`warehouse` DESC',
'address_asc'=>'`address`',
'address_desc'=>'`address` DESC',
);

$sort = @$_GET['sort'];

if (array_key_exists($sort, $sort_list)){
	$sort_sql = $sort_list[$sort];
} else {
	$sort_sql=reset($sort_list);
}

$result = $dbConnect->query("select `Crop`.`name` AS `name`,`Crop`.`variety` AS `variety`,`Crop`.`grade` AS `grade`,`Crop`.`amount` AS `amount`,`Crop`.`moisture` AS `moisture`,`Crop`.`temperature` AS `temperature`,`Warehouse`.`name` AS `warehouse`,`Warehouse`.`address` AS `address` from (`Crop` join `Warehouse` on((`Crop`.`Warehouse_id` = `Warehouse`.`id`))) order by {$sort_sql}");
$list = $result->fetchAll(PDO::FETCH_ASSOC);

function sort_link_th($title, $a, $b) {
	$sort = @$_GET['sort'];
	if ($sort == $a) {
		return '<a class="active" href="?sort=' . $b . '">' . $title . ' <i>▲</i></a>';
	} elseif ($sort == $b) {
		return '<a class="active" href="?sort=' . $a . '">' . $title . ' <i>▼</i></a>';  
	} else {
		return '<a href="?sort=' . $a . '">' . $title . '</a>';  
	}
}

require_once TEMPLATES_PATH."index.php";
?>