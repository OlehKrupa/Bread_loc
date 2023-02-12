	<?php
	require_once '../config.php';
//!!!
	$chose_id=$_SESSION['chose_id'];

	$sort_list = array(
		'id_asc'=>'`id`',
		'id_desc'=>'`id` DESC',
		'name_asc'=>'`name`',
		'name_desc'=>'`name` DESC',
		'number_asc'=>'`number`',
		'number_desc'=>'`number` DESC',
	);
	$sort = @$_GET['sort'];
	if (array_key_exists($sort, $sort_list)){
		$sort_sql = $sort_list[$sort];
	} else {
		$sort_sql=reset($sort_list);
	}

	$result = $dbConnect->query("select * from Supplier order by {$sort_sql}");
	$list = $result->fetchAll(PDO::FETCH_ASSOC);

	$fields=["name","number"];

	if (isset($_POST['ok'])){
		if (!empty($_POST)){
			$name_ui=htmlspecialchars($_POST['name']);
			$number_ui=htmlspecialchars($_POST['number']);
			$error=[];
			foreach ($_POST as $k => $v) {
				if (in_array($k, $fields) && empty($v)){
					$error[$k]="field must be filled!";
				}
			}
			//проверка на непустые поля
			if (empty($error)){
				if (empty($chose_id)){
					$stmt = $dbConnect->prepare("INSERT INTO `Supplier` (
						`name`,
						`number`
						) 
					VALUES 
					( 
						:n,  
						:nu
					)"
				);
					$stmt->execute(["n"=>$name_ui,"nu"=>$number_ui]);
				}else{
					$stmt = $dbConnect->prepare("UPDATE `Supplier`
						SET
						`name`=:n,
						`number`=:nu
						where `id`=:id");
					$stmt->execute(["n"=>$name_ui,"nu"=>$number_ui,"id"=>$chose_id]);

				}
			}
		}
		require_once TEMPLATES_PATH."supplier.php";
	}

	if (empty($chose_id)){
		//add
	}else{
		//update
		foreach ($list as $key => $value) {
			if ($value['id']===$chose_id){
				$name_ui=$value['name'];
				$number_ui=$value['number'];
			}
		}
	}

	if (isset($_POST['clear'])){
	//Сделать реальную очистку chose_id
	//$chose_id="";
		$name_ui="";
		$number_ui="";
	}

	if (isset($_POST['delete'])){
		$delete = $dbConnect->prepare("DELETE from Supplier where id = :id");
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

	require_once TEMPLATES_PATH."supplier.php";
?>