<?php
	require_once '../config.php';

	$chose_id=$_SESSION['chose_id'];

	if (isset($_POST['refresh'])){
		require_once '../grade.php';
	}

	$sort_list = array(
		'id_asc'=>'`id`',
		'id_desc'=>'`id` DESC',
		'supplier_name_asc'=>'`supplier_name`',
		'supplier_name_desc'=>'`supplier_name` DESC',
		'date_asc'=>'`date`',
		'date_desc'=>'`date` DESC',
		'warehouse_name_asc'=>'`warehouse_name`',
		'warehouse_name_desc'=>'`warehouse_name` DESC',
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

	$result = $dbConnect->query("select `Crop`.`id` AS `id`,`Supplier`.`name` AS `supplier_name`,`Crop`.`date` AS `date`,`Warehouse`.`name` AS `warehouse_name`,`Crop`.`amount` AS `amount`,`Standard`.`name` AS `standard_name`,`Crop`.`name` AS `name`,`Crop`.`variety` AS `variety`,`Crop`.`grade` AS `grade`,`Crop`.`moisture` AS `moisture`,`Crop`.`garbage` AS `garbage`,`Crop`.`minerals` AS `minerals`,`Crop`.`nature` AS `nature`, `Supplier_id`, `Warehouse_id`,`Standard_id` from (((`Crop` join `Warehouse` on((`Crop`.`Warehouse_id` = `Warehouse`.`id`))) join `Supplier` on((`Crop`.`Supplier_id` = `Supplier`.`id`))) join `Standard` on((`Crop`.`Standard_id` = `Standard`.`id`))) order by {$sort_sql}");
	$list = $result->fetchAll(PDO::FETCH_ASSOC);

	$fields=['supplier_select','warehouse_select','standard_select','amount','name','variety','moisture','garbage','minerals','nature'];

	if (isset($_POST['ok'])){
		if (!empty($_POST)){

			$supplier_ui=$_POST['supplier_select'];
			$warehouse_ui=$_POST['warehouse_select'];
			$standard_ui=$_POST['standard_select'];
			$amount_ui=htmlspecialchars($_POST['amount']);
			$name_ui=htmlspecialchars($_POST['name']);
			$variety_ui=htmlspecialchars($_POST['variety']);
			$moisture_ui=htmlspecialchars($_POST['moisture']);
			$garbage_ui=htmlspecialchars($_POST['garbage']);
			$minerals_ui=htmlspecialchars($_POST['minerals']);
			$nature_ui=htmlspecialchars($_POST['nature']);

			$error=[];
			foreach ($_POST as $k => $v) {
				if (in_array($k, $fields) && empty($v)){
					$error[$k]="field must be filled!";
				}
			}
			//проверка на непустые поля
			if (empty($error)){
				if (empty($chose_id)){
					$stmt = $dbConnect->prepare("INSERT INTO `Crop` (
						`Supplier_id`,
						`Warehouse_id`,
						`amount`,
						`Standard_id`,
						`name`,
						`variety`,
						`moisture`,
						`garbage`,
						`minerals`,
						`nature`
						) 
					VALUES 
					(
						:s_id, 
						:w_id, 
						:a, 
						:s_id, 
						:n, 
						:v, 
						:m, 
						:g, 
						:mi, 
						:na
					)"
				);
					$stmt->execute(["s_id"=>$supplier_ui,"w_id"=>$warehouse_ui,"a"=>$amount_ui,"s_id"=>$standard_ui,"n"=>$name_ui,"v"=>$variety_ui,"m"=>$moisture_ui,"g"=>$garbage_ui,"mi"=>$minerals_ui,"na"=>$nature_ui]);
				}else{
					$stmt = $dbConnect->prepare("UPDATE `Crop`
						SET
						`Supplier_id`=:s_id,
						`Warehouse_id`=:w_id,
						`amount`=:a,
						`Standard_id`=:s_id,
						`name`=:n,
						`variety`=:v,
						`moisture`=:m,
						`garbage`=:g,
						`minerals`=:mi,
						`nature`=:na
						where `id`=:id");
					$stmt->execute(["s_id"=>$supplier_ui,"w_id"=>$warehouse_ui,"a"=>$amount_ui,"s_id"=>$standard_ui,"n"=>$name_ui,"v"=>$variety_ui,"m"=>$moisture_ui,"g"=>$garbage_ui,"mi"=>$minerals_ui,"na"=>$nature_ui,"id"=>$chose_id]);

				}
			}
		}
		require_once TEMPLATES_PATH."crop.php";
	}

	if (empty($chose_id)){
		//add
	}else{
		//update
		foreach ($list as $key => $value) {
			if ($value['id']===$chose_id){
				$supplier_ui=$value['Supplier_id'];
				$warehouse_ui=$value['Warehouse_id'];
				$standard_ui=$value['Standard_id'];
				$amount_ui=$value['amount'];
				$name_ui=$value['name'];
				$variety_ui=$value['variety'];
				$moisture_ui=$value['moisture'];
				$garbage_ui=$value['garbage'];
				$minerals_ui=$value['minerals'];
				$nature_ui=$value['nature'];
			}
		}
	}

	if (isset($_POST['clear'])){
		//Сделать реальную очистку chose_id
	//$chose_id="";
		$supplier_ui="";
		$warehouse_ui="";
		$standard_ui="";
		$amount_ui="";
		$name_ui="";
		$variety_ui="";
		$moisture_ui="";
		$garbage_ui="";
		$minerals_ui="";
		$nature_ui="";
	}

	if (isset($_POST['write_off'])){
		$delete = $dbConnect->prepare("DELETE from Crop where id = :id");
		$delete->execute(["id"=>$chose_id]);
	}

	if (isset($_POST['dry'])){
		require_once '../dry.php';
	}

	if (isset($_POST['sell'])){
		$_SESSION['sell_id']=$chose_id;
		require_once 'consignment.php';
		die();
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

	$result = $dbConnect->query("SELECT * FROM `Supplier`");
	$supplier = $result->fetchAll(PDO::FETCH_ASSOC);

	$result = $dbConnect->query("SELECT * FROM `Warehouse`");
	$warehouse = $result->fetchAll(PDO::FETCH_ASSOC);

	$result = $dbConnect->query("SELECT * FROM `Standard`");
	$standart = $result->fetchAll(PDO::FETCH_ASSOC);


	require_once TEMPLATES_PATH."crop.php";
?>