<?php 
//	global $cou;
//	$cou = 0;
	require_once 'connection.php';
	
	function connect(){
		global $mysqli;
		
		global $host;
		global $user;
		global $password;
		global $database;
		
		$mysqli = mysqli_connect($host, $user, $password, $database)or die("Не вдалось підключитись до БД! Помилка " . mysqli_error($link));
		$mysqli -> query("SET NAMES 'utf8'");
	}
	
	function deConect(){
		global $mysqli;
		$closeDB = mysqli_close($mysqli);	
	}
	
	function selestAll(){
		connect();
		global $mysqli;
		$query = ('SELECT * FROM `table_company`');
		global $result;
		$result = mysqli_query($mysqli, $query)or die('Помилка при виведені даних з БД');
		global $num_rows;
		$num_rows = mysqli_num_rows($result);
			
		deConect();
	}
	
	function selestForPrint(){
		connect();
		global $mysqli;
		$query = ('SELECT * FROM `table_company` WHERE `parent` = ""');
		$result = mysqli_query($mysqli, $query)or die('Помилка при виведені даних з БД');
		$num_rows = mysqli_num_rows($result);
		
		deConect();
		printBlock($num_rows, $result);
	}
	
	global $margin;
	$margin = 40;	
	
	function printBlock($num_rows, $result){
		
		for($i = 0; $i < $num_rows; $i++){

			$row = mysqli_fetch_assoc($result);
			
			$parent_name = $row['name_company'];
			
			$capital_family = sumCapitalFamily($parent_name);
			$capital_family = $capital_family + $row["Capital"];

			$level = $row["level"];

//			global $cou;
			global $margin;
			echo("<div class='company_block' style = 'margin-left: ".$margin*$level."px'>");
			
				echo("<div class='intro_block'><b>Name: </b>".$row["name_company"]."</div>");
				echo("<div class='intro_block'><b>Capital: </b>".$row["Capital"]."</div>");
				echo("<div class='intro_block'><b>Cap. fam.: </b>".$capital_family."</div>");
				if($row["parent"] !== ""){
					echo("<div class='intro_block'><b>Parent: </b>".$row["parent"]."</div>");
				}
			echo("".++$cou."</div>");
			
			findChildren($parent_name);
		}
	}
	
	function findChildren($parent_name){
		connect();
		global $mysqli;
		$query ="SELECT * FROM `table_company` WHERE `parent` = '$parent_name' ";
		$result = mysqli_query($mysqli, $query)or die('Помилка при виборі даних з БД');
		$num_rows = mysqli_num_rows($result);
		
		deConect();
		
		printBlock($num_rows, $result);
	}
	
	function delSelect(){
		if(isset($_POST['delSelect'])){
			$delCompany = $_POST['delSelect'];
			connect();
            global $mysqli;
            $query = "SELECT * FROM `table_company` WHERE `table_company`.`id` = $delCompany";
            $result = mysqli_query($mysqli, $query)or die("<p style = 'color: red; font-size: 130%;'>Помилка при видаленні даних в БД 1</p>");
            $num_rows = mysqli_num_rows($result);
			
			deConect();
			
            delChildren($result, $num_rows);
		}
	}
	
	function delChildren($result, $num_rows){

		for($i = 0; $i < $num_rows; $i++){

			$row = mysqli_fetch_assoc($result);
			$parent_name = $row['name_company'];
			$delCompany = $row['id'];
			
			$query = "DELETE FROM `table_company` WHERE `name_company` = '$parent_name'";
			connect();
			global $mysqli;
			$resultDel = mysqli_query($mysqli, $query)or die ("<p style = 'color: red; font-size: 130%;'>Помилка при видаленні даних в БД 2</p>");
			deConect();
			if($resultDel){
				echo("<p style = 'color: green; font-size: 110%;'>$parent_name видалено!</p>");
			}else{
				echo("<p style = 'color: red; font-size: 130%;'>Дані не видалено!</p>");
			}
			findChildrenForDel($parent_name);
		}
	}
	
	function findChildrenForDel($parent_name){
		connect();
		global $mysqli;
		$query ="SELECT * FROM `table_company` WHERE `parent` = '$parent_name' ";
		$result = mysqli_query($mysqli, $query)or die('Помилка при виборі даних з БД');
		$num_rows = mysqli_num_rows($result);
		
		deConect();
		
		delChildren($result, $num_rows);
	}
	
	function sumCapitalFamily($parent_name){
		
		connect();
		global $mysqli;
		$query ="SELECT * FROM `table_company` WHERE `parent` = '$parent_name' ";
		
		$result = mysqli_query($mysqli, $query)or die('Помилка при виборі даних з БД');
		$num_rows = mysqli_num_rows($result);
		
		deConect();
		
		$sum = 0;
		for($i = 0; $i < $num_rows; $i++){
			$row = mysqli_fetch_assoc($result);
			$name_company[$i] = $row["name_company"];
			$var = sumCapitalFamily($name_company[$i]);
			$a[$i] = $row["Capital"];
			$sum = $sum + $a[$i] + $var;
		}
		return $sum;
	}
	
	function insertInto(){
		
		if(isset($_POST['name_company'])&&isset($_POST['capital'])){
			
			global $mysqli;
			connect();
			
			$name_company = $_POST['name_company'];
			$capital = $_POST['capital'];
			
			if($_POST['addParent'] !== "noselected"){
				$parentId = $_POST['addParent'];
				// Вибірка для встановлення предка компанії
				$query ="SELECT * FROM `table_company` WHERE `id` = $parentId ";
				$result = mysqli_query($mysqli, $query)or die('Помилка при додаванні даних в БД 1');
				$parent_name = mysqli_fetch_assoc($result);
				$parent = $parent_name['name_company'];
				$level = $parent_name['level'];
				$level = $level + 1;
				$query ="INSERT INTO `table_company` (`id`, `name_company`, `Capital`, `parent`, `level`) VALUES (NULL, '$name_company', '$capital', '$parent', '$level')";
			}else{
				$query ="INSERT INTO `table_company` (`id`, `name_company`, `Capital`) VALUES (NULL, '$name_company', '$capital')";
			}
	
			$result = mysqli_query($mysqli, $query)or die('Помилка при додаванні даних в БД 2');
			
			if($result){
				echo("Дані додано!<br>");
			}else{
				echo("Дані не додано!<br>");
			}
		}	
	}
	
	function printSelect(){
		global $num_rows;
		global $result;
				
		for($i = 0; $i < $num_rows; $i++){
			$row = mysqli_fetch_assoc($result);
			echo("<option value = ".$row["id"]." >".$row["name_company"]."</option>");
		}
	}
	
	function changeCompany(){
		if(isset($_POST['changeSelect'])){
			
			$changeCompanyId = $_POST['changeSelect'];
			$changeCompanyNewName = $_POST['new_name_company'];
			$changeCompanyNewCapital = $_POST['new_capital'];
	
			global $mysqli;

			connect();
			if($_POST['changeParent'] !== "noselected"){
				// Вибірка для встановлення предка компанії
				$newParentId = $_POST['changeParent'];
				
				if($newParentId === $changeCompanyId){
					echo("<p style = 'color: red; font-size: 130%;'>Дані не змінено!<br>Компанія не може бути своїм же предком! Введіть вірні дані!</p>");
					return;
				}
				
				$query ="SELECT * FROM `table_company` WHERE `id` = '$newParentId' ";
				$result = mysqli_query($mysqli, $query)or die('Помилка при виборі даних з БД');
				$newParent = mysqli_fetch_assoc($result);
				$newNameParent = $newParent['name_company'];
				$changeLevelParent = $newParent['level'];
				$level = $changeLevelParent + 1;
				echo("newParent[level] = ". $changeLevelParent."<br>");
			}else{
				$newNameParent = "";
				$level = 0;
			}
			$query = "UPDATE `table_company` SET `name_company` = '$changeCompanyNewName', `Capital` = '$changeCompanyNewCapital', `parent` = '$newNameParent', `level` = '$level' WHERE `id` = $changeCompanyId";
			$result = mysqli_query($mysqli, $query)/*or die('Помилка при зміні даних в БД')*/;
			
			if($result){
				echo("Дані змінено!<br>");
			}else{
				echo("Дані не змінено!<br>");
			}			
			deConect();	
		}
	}
?>