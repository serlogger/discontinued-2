
<?php
$current_lang = "fi";
//Including Database configuration file.
include "db.php";
//Getting value of "search" variable from "script.js".
if (isset($_POST['search'])) {
//Search box value assigning to $Name variable.
   $Name = $_POST['search'];
//Search query.
   $Query = "SELECT DISTINCT 
   cat1_industries.industry_en, 
   cat1_industries.industry_fi, 
   cat2_categories.category_en, 
   cat2_categories.category_fi,
   cat3_subcat.sub_category_en, 
   cat3_subcat.sub_category_fi 
   
   FROM 
   cat1_industries 
   INNER JOIN 
   cat2_categories
   INNER JOIN 
   cat3_subcat 
   
   ON (cat2_categories.parent_id = cat1_industries.ind_id AND cat3_subcat.parent_id = cat2_categories.cat_id)
   
   WHERE 
   industry_en LIKE '%$Name%' 
   OR industry_fi LIKE '%$Name%' 
   OR category_en LIKE '%$Name%' 
   OR category_fi LIKE '%$Name%' 
   OR sub_category_en LIKE '%$Name%' 
   OR sub_category_fi LIKE '%$Name%'
   
   LIMIT 50";
   $Query2 = "SELECT * FROM services WHERE url LIKE '%$Name%' OR service_email LIKE '%$Name%' OR location LIKE '%$Name%' OR title LIKE '%$Name%' OR description LIKE '%$Name%' LIMIT 15";
// 
//Query execution
   $ExecQuery = MySQLi_query($con, $Query);
//Creating unordered list to display result.
   echo '
   
   
<ul>
   ';
   //Fetching result from database.
   while ($Result = MySQLi_fetch_array($ExecQuery)) {
       ?>
   <!-- Creating unordered list items.
        Calling javascript function named as "fill" found in "script.js" file.
        By passing fetched result as parameter. -->
   <li onclick='fill("<?php echo $Result['industry_'.$current_lang]; ?>")'>
   <a>
   <!-- Assigning searched result in "Search box" in "search.php" file. -->
       <?php echo $Result['industry_'.$current_lang]." → ".$Result['category_'.$current_lang]." → ".$Result['sub_category_'.$current_lang]; ?>
   </li></a>
   <!-- Below php code is just for closing parenthesis. Don't be confused. -->
   <?php
}
?>
</ul>

<?php 
//Query execution
   $ExecQuery2 = MySQLi_query($con, $Query2);
echo '
<ul>
   ';
   //Fetching result from database.
   while ($Result2 = MySQLi_fetch_array($ExecQuery2)) {
       ?>
   <!-- Creating unordered list items.
        Calling javascript function named as "fill" found in "script.js" file.
        By passing fetched result as parameter. -->
   <li onclick='fill("<?php echo $Result2['industry_'.$current_lang]; ?>")'>
   <a>
   <!-- Assigning searched result in "Search box" in "search.php" file. -->
       <?php echo $Result2['title']; ?>
   </li></a>
   <!-- Below php code is just for closing parenthesis. Don't be confused. -->
   <?php
}}
?>
</ul>