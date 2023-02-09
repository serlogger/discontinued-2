<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Google Maps JavaScript library -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyAh1VrZlMmz_yHpHCAbUPaWQ4EavsXRnpU"></script>

    <script>
    var searchInput = 'location';

    $(document).ready(function () {
        var autocomplete;
        autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
            types: ['geocode'],
        });
        
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var near_place = autocomplete.getPlace();
            document.getElementById('latitude').value = near_place.geometry.location.lat();
            document.getElementById('longitude').value = near_place.geometry.location.lng();
        });
    });

    $(document).on('change', '#'+searchInput, function () {
        document.getElementById('latitude').value = '';
        document.getElementById('longitude').value = '';
    });
    </script>

</head>
<body>
    <?php 
    // Include database configuration file 
    require_once 'dbConfig.php'; 
    
    // If search form is submitted 
    if(isset($_POST['searchSubmit'])){ 
        if(!empty($_POST['location'])){ 
            $location = $_POST['location']; 
        } 
        
        if(!empty($_POST['loc_latitude'])){ 
            $latitude = $_POST['loc_latitude']; 
        } 
        
        if(!empty($_POST['loc_longitude'])){ 
            $longitude = $_POST['loc_longitude']; 
        } 
        
        if(!empty($_POST['distance_km'])){ 
            $distance_km = $_POST['distance_km']; 
        } 
    } 
    
    // Calculate distance and filter records by radius 
    $sql_distance = $having = ''; 
    if(!empty($distance_km) && !empty($latitude) && !empty($longitude)){ 
        $radius_km = $distance_km; 
        $sql_distance = " ,(((acos(sin((".$latitude."*pi()/180)) * sin((`services`.`lat`*pi()/180))+cos((".$latitude."*pi()/180)) * cos((`services`.`lat`*pi()/180)) * cos(((".$longitude."-`services`.`lon`)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance ";
        
        $having = " HAVING (distance <= $radius_km) "; 
        }
    
    // Fetch places from the database 
    $sql = "SELECT services.*".$sql_distance." FROM services $having"; 
    $query = $db->query($sql); 
    ?>
    <form method="post" action="">
        <input type="text" name="location" id="location" value="<?php echo !empty($location)?$location:''; ?>" placeholder="Type location...">
        <input type="hidden" name="loc_latitude" id="latitude" value="<?php echo !empty($latitude)?$latitude:''; ?>">
        <input type="hidden" name="loc_longitude" id="longitude" value="<?php echo !empty($longitude)?$longitude:''; ?>">
        
        <select name="distance_km">
            <option value="">Distance</option>
            <option value="10" <?php echo (!empty($distance_km) && $distance_km == '10')?'selected':''; ?>>+10 KM</option>
            <option value="50" <?php echo (!empty($distance_km) && $distance_km == '50')?'selected':''; ?>>+50 KM</option>
            <option value="200" <?php echo (!empty($distance_km) && $distance_km == '200')?'selected':''; ?>>+200 KM</option>
            <option value="2000" <?php echo (!empty($distance_km) && $distance_km == '2000')?'selected':''; ?>>+2000 KM</option>
            <option value="20000" <?php echo (!empty($distance_km) && $distance_km == '20000')?'selected':''; ?>>+20000 KM</option>
        </select>
        <input type="submit" name="searchSubmit" value="Search" />
    </form>

    <?php 
    if($query->num_rows > 0){ 
        while($row = $query->fetch_assoc()){ 
    ?> 
        <div class="pbox"> 
            <h4><?php echo $row['title']; ?></h4> 
            <p><?php echo $row['location']; ?></p> 
            <?php if(!empty($row['distance'])){ ?> 
            <p>Distance: <?php echo round($row['distance'], 2); ?> KM<p> 
            <?php } ?> 
        </div> 
    <?php 
        } 
    }else{ 
        echo '<h5>Place(s) not found...</h5>'; 
    } 
    ?>
</body>
</html>