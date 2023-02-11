<?php 
require_once "config.php";

$chose_id=$_SESSION['chose_id'];

if (empty($_SESSION['user'])){
	header("location: /login.php");
	die();
}

if (isset($_POST['write_off'])){
	$delete = $dbConnect->prepare("DELETE from Crop where id = :id");
	$delete->execute(["id"=>$chose_id]);
}

if (isset($_POST['dry'])){
	require_once 'dry.php';
}

if (isset($_POST['sell'])){
	header("location: /tables/consignment.php");
	die();
}

$sort_list = array(
	'id_asc'=>'`id`',
	'id_desc'=>'`id` DESC',
	'supplier_name_asc'=>'`supplier_name`',
	'supplier_name_desc'=>'`supplier_name` DESC',
	'date_asc'=>'`date`',
	'date_desc'=>'`date` DESC',
	'amount_asc'=>'`amount`',
	'amount_desc'=>'`amount` DESC',
	'standard_name_asc'=>'`standard_name`',
	'standard_name_desc'=>'`standard_name` DESC',
	'name_asc'=>'`name`',
	'name_desc'=>'`name` DESC',
	'variety_asc'=>'`variety`',
	'variety_desc'=>'`variety` DESC',
	'grade_asc'=>'`grade`',
	'grade_desc'=>'`grade` DESC',
	'moisture_asc'=>'`moisture`',
	'moisture_desc'=>'`moisture` DESC',
	'garbage_asc'=>'`garbage`',
	'garbage_desc'=>'`garbage` DESC',
	'minerals_asc'=>'`minerals`',
	'minerals_desc'=>'`minerals` DESC',
	'nature_asc'=>'`nature`',
	'nature_desc'=>'`nature` DESC',
);

$sort = @$_GET['sort'];

if (array_key_exists($sort, $sort_list)){
	$sort_sql = $sort_list[$sort];
} else {
	$sort_sql=reset($sort_list);
}

$result = $dbConnect->query("select `Crop`.`id` AS `id`,`Supplier`.`name` AS `supplier_name`,`Crop`.`date` AS `date`,`Warehouse`.`name` AS `warehouse_name`,`Crop`.`amount` AS `amount`,`Standard`.`name` AS `standard_name`,`Crop`.`name` AS `name`,`Crop`.`variety` AS `variety`,`Crop`.`grade` AS `grade`,`Crop`.`moisture` AS `moisture`,`Crop`.`garbage` AS `garbage`,`Crop`.`minerals` AS `minerals`,`Crop`.`nature` AS `nature` from (((`Crop` join `Warehouse` on((`Crop`.`Warehouse_id` = `Warehouse`.`id`))) join `Supplier` on((`Crop`.`Supplier_id` = `Supplier`.`id`))) join `Standard` on((`Crop`.`Standard_id` = `Standard`.`id`))) order by {$sort_sql}");
$list = $result->fetchAll(PDO::FETCH_ASSOC);

function sort_link_th($title, $a, $b) {
	$sort = @$_GET['sort'];
	if ($sort == $a) {
		return '<a class="active" href="?sort=' . $b . '">' . $title . ' <i></i></a>';
	} elseif ($sort == $b) {
		return '<a class="active" href="?sort=' . $a . '">' . $title . ' <i></i></a>';  
	} else {
		return '<a href="?sort=' . $a . '">' . $title . '</a>';  
	}
}

require_once TEMPLATES_PATH."index.php";
?>