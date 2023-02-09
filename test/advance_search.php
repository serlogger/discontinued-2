<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
  $connect = new PDO("mysql:host=$servername;dbname=se_m1p", $username, $password);
  // set the PDO error mode to exception
  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
if(isset($_POST["submit"]))
{
     if(!empty($_POST["search"]))
     {
          $query = str_replace(" ", "+", $_POST["search"]);
          header("location:advance_search.php?search=" . $query);
     }
}
?>
<!DOCTYPE html>
<html>
     <head>
          <title>Search multiple words</title>
          <style>
               * {
                    font-family: calibri;
                    font-size: 22px;
               }

               table {
                    margin-bottom: 35px;
                    border: 3px solid skyblue;
                    border-radius: 7px;
               }

               td {
                    border: 2px solid skyblue;
                    border-radius: 3px;
                    min-width: 300px;
                    max-width: 300px;
                    padding: 10px;
               }

               .wrapper {
                    display:flex;
                    align-items: center;
                    justify-content: center;
               }

               .object {
                    margin:auto;
               }
          </style>
     </head>
     <body>
          <br /><br />
          <div>
               <div class="wrapper">
                    <form method="post" class="object">
                         <h3>Search multiple words</h3><br />
                         <input type="text" name="search" class="" value="<?php if(isset($_GET["search"])) echo $_GET["search"]; ?>" />
                         <input type="submit" name="submit" class="" value="Search" />
                    </form>
               </div>
               <br><br>
               <div class="wrapper">
                    <div class="object">
                         <?php
                         if(isset($_GET["search"]))
                         {
                              $condition = '';
                              $all_ids = "";
                              $separator = ",";
                              $pre_query = explode(" ", $_GET["search"]);
                              $query = array_filter($pre_query);
                              $count_query = count($query);
                              foreach($query as $text)
                              {
                                   $stext = filter_var($text, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                                   $condition = "
                                   description LIKE '%$stext%' OR 
                                   id LIKE '%$stext%' OR 
                                   service_email LIKE '%$stext%' OR 
                                   title LIKE '%$stext%' OR 
                                   url LIKE '%$stext%' OR
                                   created LIKE '%$stext%'
                                   ";
                              
                                   // $condition = substr($condition, 0, -4);
                                   $sql_query = "SELECT * FROM services WHERE " . $condition;
                                   $stmt = $connect->prepare($sql_query);
                                   $stmt->execute();
                                   $result = $stmt->fetchAll();
                                   if($stmt->rowCount() > 0)
                                   {
                                        foreach($result as $row)
                                        {
                                             // echo '<tr><td>'.$row["description"].'</td><td>'.$row["id"].'</td></tr>';
                                             $all_ids .= $row["id"].$separator;
                                        }
                                   }
                                   else
                                   {
                                        // echo '<label>Data not Found</label>';
                                   }
                                   $stmt->closeCursor();
                              }
                              $all_ids_2 = rtrim($all_ids, $separator);
                              // echo $all_ids_2;
                              $all_ids_array = explode(",", $all_ids_2);

                              $vals = array_count_values($all_ids_array);
                              // echo "<pre>" . var_export($vals, true) . "</pre>";
                              // echo '<br>No. of NON Duplicate Items: '.count($vals).'<br><br>';
                              arsort($vals);
                              // echo "<pre>" . var_export($vals, true) . "</pre>";
                              // echo "<pre>" . var_export($count_query, true) . "</pre>";
                              // $notification = "";
                              foreach($vals as $key => $val) {
                                   // echo $key."<br>";
                                   if($key) {
                                        $sql_query = "SELECT * FROM `services` WHERE `id` = $key";
                                        $stmt = $connect->prepare($sql_query);
                                        $stmt->execute();
                                        $result = $stmt->fetchAll();
                                        if($stmt->rowCount() > 0)
                                        {
                                             foreach($result as $row)
                                             {
                                                  $relation = $val / $count_query;
                                                  $percent = round($relation * 100, 0);
                                                  // if ($percent < 100 && isset($notification)) {
                                                  //      if ($notification == "") {
                                                  //           $notification = "Featured results: ";
                                                  //      }
                                                  // }
                                                  $full_color = "rgb(34,139,34)";
                                                  $bg = "rgba(34,139,34,0.2)";
                                                  $relative_color = "rgba(34,139,34,$relation)";
                                                  $relevance = '<div style="border:1px solid '.$full_color.'"><div style="background:'.$bg.';border-right:1px solid '.$full_color.';height:24px;width:'.$percent.'%"><div style="background:'.$relative_color.';height:24px;"></div></div></div>';
                                                  echo '<table>';
                                                  // if ($percent < 100 && isset($notification)) { 
                                                  //      echo $notification;
                                                  //      unset($notification);
                                                  //      }
                                                  echo '<tr><td><b>'.$row["title"].'</b></td><td>'.$row["service_email"].'</td><td>'.$row['created'].'</td></tr>';
                                                  echo '<tr><td>'.$row["description"].'</td><td>'.$row["id"].'</td><td>Search relevance: '.$percent.'%'.$relevance.'</td></tr>';
                                                  echo '</table>';
                                                  $all_ids .= $row["id"].$separator;
                                             }
                                        }
                                        else
                                        {
                                             echo '<label>Data not Found</label>';
                                        }
                                        $stmt->closeCursor();
                                   } else {
                                        echo '<label>Data not Found</label>';
                                   }
                              }
                         }
                         ?>
                    </div>
               </div>
          </div>
     </body>
</html>  