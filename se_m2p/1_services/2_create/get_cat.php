<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'se_load.php');

$conn = new PDO("mysql:host=localhost;dbname=$se_db", $se_db_pass, "");

$ind_id = $_POST["ind_id"];
$stmt = $conn->prepare("SELECT * FROM `cat2_categories` where parent_id = ?");
$stmt->execute([$ind_id]);
$result = $stmt->fetchAll();
$row_count = $stmt->rowCount();
$stmt->closeCursor();

if($row_count > 0)
{
	?>
	<option value=""><?=$lang['select_category'].' ('.$row_count.')';?></option>
	<?php
	foreach($result as $row)
	{
	?>
	<option value="<?php echo $row["cat_id"]; ?>"><?php echo $row["category_$current_lang"]; ?></option>
	<?php
	}
}