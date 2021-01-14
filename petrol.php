<?php
$serverip = file_get_contents('serverip.txt');
require "db_config/db.php";
if (($_SERVER["REQUEST_METHOD"]==="POST") && ($_POST["tagPost"] === "petrolDelete")){
    $id = $_POST["pid"];
    $sql = "DELETE FROM petrol WHERE id = $id";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        $delResult = "Petrol Bill Deleted";
    } catch(PDOException $e){
        $delResult = $e->getMessage();
        echo $e->getMessage();
    }
}
?>
<?php 
$result = null;
$num = 10000;
if (($_SERVER["REQUEST_METHOD"]==="POST") && ($_POST["tagPost"] === "petrolSearch")){
    $flag = 0;
    $vehicle = $_POST["vehicle"];
    $num = ($_POST["num"]) ? ($_POST["num"]) : 10000;
    if($vehicle != ""){ 
        if($flag == 0){
            $query = "vehicle = '$vehicle'";
        }else{
            $query .= " AND vehicle = '$vehicle'";
        }
        $flag = 1; 
        
    }
    $fdate = $_POST["fdate"];
    if($fdate != ""){ 
        if($flag == 0){
            $query = "fdate >= '$fdate'";
        }else{
            $query .= " AND fdate >= '$fdate'";
        }
        $flag = 1; 
    }
    if($flag == 0){
        $sql = "SELECT * FROM petrol ORDER BY fdate DESC";
    }else{
        $sql = "SELECT * FROM petrol WHERE $query ORDER BY fdate DESC";
    }
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $petrols = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $result = $petrols;
    } catch(PDOException $e){
        $result = $e->getMessage();
        echo $e->getMessage();
    }
}
?>
<?php 
    $sql = "SELECT DISTINCT(dValue) FROM dropdown WHERE dKey = 'vehicle' ORDER BY dValue";
    try{
        $db = new db();
        $db = $db->connect();    
        $stmt = $db->query($sql);
        $vehiNames = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
    } catch(PDOException $e){
        echo $e->getMessage();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>GANGA TRAVELS</title>
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <?php
            echo'
            <a href="http://'.$serverip.'/app/home.php">HOME</a>
            <a href="http://'.$serverip.'/app/trips.php">TRIPS</a>
            <a href="http://'.$serverip.'/app/petrol.php">PETROL</a>
            <a href="http://'.$serverip.'/app/settings.php">SETTINGS</a>';
            ?>
        </div>
        <header>
            <div class="header1">
                <span style="font-size:50px;cursor:pointer" onclick="openNav()">&#9776; </span>
                <div class="container">
                <h1><img src="img/logo.png" style="max-height:40; max-width:110px;"> GANGA TRAVELS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PETROLS </h1>
                </div>
            </div>
        </header>
        <div id="showcase" style="min-height: 500px;">
            <form id="tripsearch" method="POST" action="petrol.php">
                <div class="searchcase">
                    <select id="vehicle" name="vehicle">
                        <option value="">vehicle</option>
                        <?php
                        foreach($vehiNames as $vehi){
                        echo '
                        <option value="'.$vehi->dValue.'">'.$vehi->dValue.'</option>
                        ';
                        }
                        ?>
                    </select>
                    <input type="date" id="fdate" placeholder="starting date" name="fdate">
                    <input type="number" id="num" placeholder="number" name="num">
                    <input type="hidden" name="tagPost" value="petrolSearch">
                    <button type="submit">Search</button>
                </div>
            </form>
            <?php
            if($result){
            echo '
                <table class="darkTable">
                    <thead>
                        <tr>
                            <th>Petrol_id</th>
                            <th>Trip_id</th>
                            <th>vehicle</th>
                            <th>pump filled</th>
                            <th>filling date</th>
                            <th>kilometer Reading</th>
                            <th>litre filled</th>
                            <th>bill amount</th>
                            <th>DELETE</th>
                        </tr>
                    </thead>
                    <tbody>';
            $i = 0;
                        foreach($result as $rec){
                            if($i >= $num){
                                break;
                            }
                            $i = $i + 1;
                            echo '<tr>
                                    <td>'.$rec->id.'</td>
                                    <td>'.$rec->tripid.'</td>
                                    <td>'.$rec->vehicle.'</td>
                                    <td>'.$rec->pump.'</td>
                                    <td>'.$rec->fdate.'</td>
                                    <td>'.$rec->kmr.'</td>
                                    <td>'.$rec->litre.'</td>
                                    <td>'.$rec->price.'</td>
                                    <td>
                                        <form id="tripsearch" method="POST" action="petrol.php">
                                            <input type="hidden" name="pid" value="'.$rec->id.'">
                                            <input type="hidden" name="tagPost" value="petrolDelete">
                                            <button type="submit">DELETE</button>
                                        </form>
                                    </td>
                                </tr>';
                        }
                    echo '</tbody>
                </table>';
            }else if(($_SERVER["REQUEST_METHOD"]==="POST") && ($_POST["tagPost"] === "petrolSearch")){
                echo '<h3>No Results Found!</h3>';
            }else if(($_SERVER["REQUEST_METHOD"]==="POST") && ($_POST["tagPost"] === "petrolDelete")){
                echo '<h2>'.$delResult.'</h2>';
            }
            ?>
        </div> 
        <footer>
            <p>Developed by Allen John Binu</p>
        </footer>
        <script>
            function openNav() {
              document.getElementById("mySidenav").style.width = "250px";
            }
            
            function closeNav() {
              document.getElementById("mySidenav").style.width = "0";
            }
        </script>
    </body>
</html>