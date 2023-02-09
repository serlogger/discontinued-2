<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'se_load.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title><?=$lang['add_ICS'];?></title>
<style>

body {
  font-family: 'Courier New', monospace;
}
	.w {width:200px; display:inline-block; margin: 20px;}
	.v {width:150px; display:inline-block; margin: 20px;}
</style>

</head>
<body>


<?php



$count = 0;
if(isset($_POST['lerppa']))
{
	if($_POST['industries_dropdown'] !== "") {$count++;}
	if($_POST['categories_dropdown'] !== "") {$count++;}
	if($_POST['subcategories_dropdown'] !== "") {$count++;}

	if ($count > 1) 
	{
		echo "saiputtaa";
	} else {
		if($_POST['industries_dropdown'] !== "" && $_POST['hardon'] !== "") 
		{
			$id = strtok($_POST['industries_dropdown'], ',');
			$name = substr($_POST['industries_dropdown'], strpos($_POST['industries_dropdown'], ",") + 1);
			echo "Inserted category '" . $_POST['hardon'] ."' to '".$name."'";
			
			$stmt = $pdo->prepare('INSERT INTO `cat2_categories` VALUES (?, ?, ?, ?)');
			$stmt->execute(["", $id, $_POST['hardon'], ""]);
			
		} else {
			//No insertions done
		}
		
		if($_POST['categories_dropdown'] !== "" && $_POST['harder'] !== "") 
		{
			$id = strtok($_POST['categories_dropdown'], ',');
			$name = substr($_POST['categories_dropdown'], strpos($_POST['categories_dropdown'], ",") + 1);
			echo "Inserted subcategory '" . $_POST['harder'] ."' to '".$name."'";
			
			$stmt = $pdo->prepare('INSERT INTO `cat3_subcat` VALUES (?, ?, ?, ?)');
			$stmt->execute(["", $id, $_POST['harder'], ""]);
			
		} else {
			//No insertions done
		}
		
	}
}
/*
"SELECT 
			accounts.username,
			services.creator_id,
			services.private_email,
			services.phone,
			services.title,
			services.description,
			services.created,
			services.id,
			services.location,
			services.imagelink
			FROM accounts, services 
			WHERE accounts.id = services.creator_id LIMIT $start, $limit"
*/
?>

<form action="" method="post">
	<select class="w" name="industries_dropdown">
		<option value=""></option>
		<?php
		//$result = mysqli_query($pdo, "SELECT * FROM `cat1-industries`");
		
		$stmt = $pdo->prepare('SELECT * FROM `cat1_industries`');
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach ($result as $row) {
			?>
			<option value="<?php echo $row['ind_id'].",".$row["industry_$current_lang"]; ?>"><?php echo $row["industry_$current_lang"]; ?></option>
			<?php
		}
		?>
	</select> <div class="v"> gets category </div><input class="w" type="text" name="hardon">
	<br>
	<select class="w" name="categories_dropdown">
		<option value=""></option>
		<?php
		//$result = mysqli_query($pdo, "SELECT * FROM `cat1-industries`");
		
		$stmt = $pdo->prepare('SELECT * FROM `cat2_categories`');
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach ($result as $row) {
			?>
			<option value="<?php echo $row['cat_id'].",".$row["category_$current_lang"]; ?>"><?php echo $row["category_$current_lang"]; ?></option>
			<?php
		}
		?>
	</select> <div class="v"> gets sub-cat </div><input class="w" type="text" name="harder">
	<br>
	<select class="w" name="subcategories_dropdown">
		<option value=""></option>
		<?php
		//$result = mysqli_query($pdo, "SELECT * FROM `cat1-industries`");
		
		$stmt = $pdo->prepare('SELECT * FROM `cat3_subcat`');
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach ($result as $row) {
			?>
			<option value="<?php echo $row['sc_id']; ?>"><?php echo $row["sub_category_$current_lang"];?></option>
			<?php
		}
		?>
	</select>
	<br>

	<input class="v" type="submit" name="lerppa">
</form>
</body>
</html>
