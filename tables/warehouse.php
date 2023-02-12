	<?php
	require_once '../config.php';
//!!!
	$chose_id=$_SESSION['chose_id'];

	$sort_list = array(
		'id_asc'=>'`id`',
		'id_desc'=>'`id` DESC',
		'name_asc'=>'`name`',
		'name_desc'=>'`name` DESC',
		'address_asc'=>'`address`',
		'address_desc'=>'`address` DESC',
	);
	$sort = @$_GET['sort'];
	if (array_key_exists($sort, $sort_list)){
		$sort_sql = $sort_list[$sort];
	} else {
		$sort_sql=reset($sort_list);
	}

	$result = $dbConnect->query("select * from Warehouse order by {$sort_sql}");
	$list = $result->fetchAll(PDO::FETCH_ASSOC);

	$fields=["name","address","capacity"];

	if (isset($_POST['ok'])){
		if (!empty($_POST)){
			$name_ui=htmlspecialchars($_POST['name']);
			$address_ui=htmlspecialchars($_POST['address']);
			$capacity_ui=htmlspecialchars($_POST['capacity']);
			$error=[];
			foreach ($_POST as $k => $v) {
				if (in_array($k, $fields) && empty($v)){
					$error[$k]="field must be filled!";
				}
			}
			//проверка на непустые поля
			if (empty($error)){
				if (empty($chose_id)){
					$stmt = $dbConnect->prepare("INSERT INTO `Warehouse` (
						`name`,
						`address`,
						`capacity`
						) 
					VALUES 
					( 
						:n,  
						:a,
						:c
					)"
				);
					$stmt->execute(["n"=>$name_ui,"a"=>$address_ui,"c"=>$capacity_ui]);
				}else{
					$stmt = $dbConnect->prepare("UPDATE `Warehouse`
						SET
						`name`=:n,
						`address`=:a,
						`capacity`=:c
						where `id`=:id");
					$stmt->execute(["n"=>$name_ui,"a"=>$address_ui,"c"=>$capacity_ui,"id"=>$chose_id]);
				}
			}
		}
		require_once TEMPLATES_PATH."warehouse.php";
	}

	if (empty($chose_id)){
		//add
	}else{
		//update
		foreach ($list as $key => $value) {
			if ($value['id']===$chose_id){
				$name_ui=$value['name'];
				$address_ui=$value['address'];
				$capacity_ui=$value['capacity'];
			}
		}
	}

	if (isset($_POST['clear'])){
	//Сделать реальную очистку chose_id
	//$chose_id="";
		$name_ui="";
		$address_ui="";
		$capacity_ui="";
	}

	if (isset($_POST['delete'])){
		$delete = $dbConnect->prepare("DELETE from Warehouse where id = :id");
		$delete->execute(["id"=>$chose_id]);
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
	require_once TEMPLATES_PATH."warehouse.php";
?>