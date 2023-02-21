<?php
require_once '../config.php';

$chose_id=$_SESSION['chose_id'];

$sort_list = array(
	'id_asc'=>'`id`',
	'id_desc'=>'`id` DESC',
	'name_asc'=>'`name`',
	'name_desc'=>'`name` DESC',
	'minor_risk_asc'=>'`minor_risk`',
	'minor_risk_desc'=>'`minor_risk` DESC',
	'major_risk_asc'=>'`major_risk`',
	'major_risk_desc'=>'`major_risk` DESC',
	'min_moisture_asc'=>'`min_moisture`',
	'min_moisture_desc'=>'`min_moisture` DESC',
	'max_moisture_asc'=>'`max_moisture`',
	'max_moisture_desc'=>'`max_moisture` DESC',
	'min_garbage_asc'=>'`min_garbage`',
	'min_garbage_desc'=>'`min_garbage` DESC',
	'max_garbage_asc'=>'`max_garbage`',
	'max_garbage_desc'=>'`max_garbage` DESC',
	'min_minerals_asc'=>'`min_minerals`',
	'min_minerals_desc'=>'`min_minerals` DESC',
	'max_minerals_asc'=>'`max_minerals`',
	'max_minerals_desc'=>'`max_minerals` DESC',
	'min_nature_asc'=>'`min_nature`',
	'min_nature_desc'=>'`min_nature` DESC',
	'max_nature_asc'=>'`max_nature`',
	'max_nature_desc'=>'`max_nature` DESC',
);
$sort = @$_GET['sort'];
if (array_key_exists($sort, $sort_list)){
	$sort_sql = $sort_list[$sort];
} else {
	$sort_sql=reset($sort_list);
}

$result = $dbConnect->query("select * from Standard order by {$sort_sql}");
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
				$error[$k]="field must be filled!";
			}
		}
			//проверка на непустые поля
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
			}
		}
	}
	require_once TEMPLATES_PATH."standard.php";
}

if (!empty($chose_id)){
	foreach ($list as $key => $value) {
		if ($value['id']===$chose_id){
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
	//Сделать реальную очистку chose_id
	//$chose_id="";
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
}


if (isset($_POST['delete'])){
	/*
	//проверка на его не использование надо!!!
	$delete = $dbConnect->prepare("DELETE from Standard where id = :id");
	$delete->execute(["id"=>$chose_id]);
	*/
}

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

require_once TEMPLATES_PATH."standard.php";
?>