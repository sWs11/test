<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>Сompanies tree</title>
	<link href="style.css" rel="stylesheet">
</head>
<body>
<div class="left_block">
	<?php
		require_once 'connection.php';
		require_once 'function.php';
		
		delSelect();// Видалення компанії	
		changeCompany();//Редагування компанії
		insertInto();//Додавання компанії
		selestForPrint();//Вибірка компаній
	?>
	<div class="clear"></div>
</div>	

<div class="right_block">
	<form method="post">
		<h3>Додати нову компанію</h3>
		<input type="text" placeholder="Назва компанії" name="name_company"/>
		<input type="number" placeholder="Капітал компанії" name="capital"/>
		<select name="addParent">
			<option selected value="noselected">Предок</option>
			<?php
				selestAll();
				printSelect();
			?>
		</select>
		
		<input type="submit" name="add" value="Добавити"/>
	</form>
	
	<form method="post">
		<h3>Видалити компанію</h3>
		<select name="delSelect">
			<option disabled selected value="noselected">Виберіть компанію</option>
			<?php
				selestAll();
				printSelect();
			?>
		</select>
		<input type="submit" name="add" value="Видалити"/>
	</form>
	
	<form method="post">
		<h3>Редагувати дані компанії</h3>
		<select name="changeSelect">
			<option selected value="noselected">Виберіть компанію</option>
			<?php
				selestAll();
				printSelect();
			?>
		</select>
		<input type="text" placeholder="Назва компанії" name="new_name_company"/>
		<input type="number" placeholder="Капітал компанії" name="new_capital"/>
		<select name="changeParent">
			<option selected value="noselected">Предок</option>
			<?php
				selestAll();
				printSelect();
			?>
		</select>
		<input type="submit" name="add" value="Обновити"/>
	</form>
		
</div>	
	
</body>
</html>