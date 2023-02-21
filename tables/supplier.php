	<?php
	require_once '../config.php';
//!!!
	$chose_id=$_SESSION['chose_id'];

	$result = $dbConnect->query("select * from Supplier");
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

	if (!empty($chose_id)){
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

	require_once TEMPLATES_PATH."supplier.php";
?>