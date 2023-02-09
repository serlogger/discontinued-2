<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'se_load.php');
$conn = new PDO("mysql:host=localhost;dbname=$se_db", $se_db_pass, "");
$cat_id = $_POST["cat_id"];
$stmt = $conn->prepare("SELECT * FROM `cat3_subcat` where parent_id = ?");
$stmt->execute([$cat_id]);
$result = $stmt->fetchAll();
$row_count = $stmt->rowCount();

if ($row_count > 0)
{
	?>
	<option value=""><?=$lang['select_subcat'].' ('.$row_count.')'?></option>
	<?php
	foreach($result as $row)
	{
		?>
		<option value="<?php echo $row["sc_id"]; ?>"><?php echo $row["sub_category_$current_lang"];?></option>
		<?php
	}
}