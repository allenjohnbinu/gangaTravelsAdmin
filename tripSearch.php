<?php 
    $serverip = file_get_contents('serverip.txt');
    require "db_config/db.php";
    if (($_SERVER["REQUEST_METHOD"]==="POST") && ($_POST["tagPost"] === "paymentUpdate")){
        $id = $_POST["tid"];
        $sql = "UPDATE trip SET paid = 'p' WHERE id = $id";
        try{
            // Get DB Object
            $db = new db();
            // Connect
            $db = $db->connect();
    
            $stmt = $db->prepare($sql);
    
            $stmt->execute();
    
            $updResult = "Trip Payment Updated";
    
        } catch(PDOException $e){
            $updResult = $e->getMessage();
            echo $e->getMessage();
        }    
    }
?>
<?php
$vehicle = "";
$result = null;
if (($_SERVER["REQUEST_METHOD"]==="POST") && ($_POST["tagPost"] === "tripSearch")){
    $flag = 0;
    $vehicle = $_POST["vehicle"];
    if($vehicle != ""){ 
        if($flag == 0){
            $query = "vehicle = '$vehicle'";
        }else{
            $query .= " AND vehicle = '$vehicle'";
        }
        $flag = 1; 
        
    }
    $company = $_POST["company"];
    if($company != ""){
        if($flag == 0){
            $query = "company = '$company'";
        }else{
            $query .= " AND company = '$company'";
        } 
        $flag = 1; 
    }
    $driver = $_POST["driver"];
    if($driver != ""){ 
        if($flag == 0){
            $query = "driver = '$driver'";
        }else{
            $query .= " AND driver = '$driver'";
        }
        $flag = 1; 
    }
    $cleaner = $_POST["cleaner"];
    if($cleaner != ""){ 
        if($flag == 0){
            $query = "cleaner = '$cleaner'";
        }else{
            $query .= " AND cleaner = '$cleaner'";
        }
        $flag = 1; 
    }
    $paid = $_POST["paid"];
    if($paid != ""){ 
        if($flag == 0){
            $query = "paid = '$paid'";
        }else{
            $query .= " AND paid = '$paid'";
        }
        $flag = 1; 
    }
    $sdate = $_POST["sdate"];
    if($sdate != ""){ 
        if($flag == 0){
            $query = "sdate >= '$sdate'";
        }else{
            $query .= " AND sdate >= '$sdate'";
        }
        $flag = 1; 
    }
    if($flag == 0){
        $sql = "SELECT * FROM trip ORDER BY sdate DESC";
    }else{
        $sql = "SELECT * FROM trip WHERE $query ORDER BY sdate DESC";
    }
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $trips = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $result = $trips;
    } catch(PDOException $e){
        $result = $e->getMessage();
        echo $e->getMessage();
    }
}
?>
<?php    
    $sql = "SELECT DISTINCT(name) FROM company ORDER BY name";
    try{
        $db = new db();
        $db = $db->connect();    
        $stmt = $db->query($sql);
        $comNames = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
    } catch(PDOException $e){
        echo $e->getMessage();
    }
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
    $sql = "SELECT DISTINCT(dValue) FROM dropdown WHERE dKey = 'driver' ORDER BY dValue";
    try{
        $db = new db();
        $db = $db->connect();    
        $stmt = $db->query($sql);
        $driNames = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
    } catch(PDOException $e){
        echo $e->getMessage();
    }
    $sql = "SELECT DISTINCT(dValue) FROM dropdown WHERE dKey = 'cleaner' ORDER BY dValue";
    try{
        $db = new db();
        $db = $db->connect();    
        $stmt = $db->query($sql);
        $clrNames = $stmt->fetchAll(PDO::FETCH_OBJ);
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
                <h1><img src="img/logo.png" style="max-height:40; max-width:110px;"> GANGA TRAVELS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TRIP SEARCH</h1>
                </div>
            </div>
        </header>
        <div id="showcase" style="min-height: 500px;">
            <form id="tripsearch" method="POST" action="tripSearch.php">
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
                    <select id="company" name="company">
                        <option value="">company</option>
                        <?php
                        foreach($comNames as $com){
                        echo '
                        <option value="'.$com->name.'">'.$com->name.'</option>
                        ';
                        }
                        ?>
                    </select>
                    <select id="driver" name="driver">
                        <option value="">driver</option>
                        <?php
                        foreach($driNames as $dri){
                        echo '
                        <option value="'.$dri->dValue.'">'.$dri->dValue.'</option>
                        ';
                        }
                        ?>
                    </select>
                    <select id="cleaner" name="cleaner">
                        <option value="">cleaner</option>
                        <?php
                        foreach($clrNames as $clr){
                        echo '
                        <option value="'.$clr->dValue.'">'.$clr->dValue.'</option>
                        ';
                        }
                        ?>
                    </select>
                    <select id="paid" name="paid">
                        <option value="">payment status</option>
                        <option value="np">not paid</option>
                        <option value="p">paid</option>
                    </select>
                    <input type="date" id="sdate" placeholder="starting date" name="sdate">
                    <input type="hidden" name="tagPost" value="tripSearch">
                    <button type="submit">Search</button>
                </div>
            </form>
            <?php
            //  var_dump(is_array($result));
            // foreach($result as $rec){
            //     echo '<p>'.$rec->vehicle.'</p>';
            // }
            if($result){
            echo '
            <table class="darkTable">
                <thead>
                    <tr>
                        <th>TRIP_ID</th>
                        <th>COMPANY</th>
                        <th>VEHICLE</th>
                        <th>DESTINATION</th>
                        <th>START DATE</th>
                        <th>ADAVANCE</th>
                        <th>AMT</th>
                        <th>DRIVER</th>
                        <th>CLEANER</th>
                        <th>PAYMENT</th>
                        <th>DESC</th>
                        <th>PETROL</th>
                        <th>UPDATE</th>
                        <th>EDIT</th>
                        <th>INVOICE</th>
                    </tr>
                </thead>
                <tbody>';
                    foreach($result as $rec){
                        echo '<tr>
                                <td>'.$rec->id.'</td>
                                <td>'.$rec->company.'</td>
                                <td>'.$rec->vehicle.'</td>
                                <td>'.$rec->destination.'</td>
                                <td>'.$rec->sdate.'</td>
                                <td>'.$rec->advance.'</td>
                                <td>'.$rec->amount.'</td>
                                <td>'.$rec->driver.'</td>
                                <td>'.$rec->cleaner.'</td>
                                <td>'.(($rec->paid==="np") ? "not paid" : "paid").'</td>
                                <td>'.$rec->description.'</td>
                                <td>
                                    <form id="tripsearch" method="GET" action="petrolAdd.php">
                                        <input type="hidden" name="id" value="'.$rec->id.'">
                                        <input type="hidden" name="vehicle" value="'.$rec->vehicle.'">
                                        <button type="submit">Fuel In</button>
                                    </form>
                                </td>
                                <td>';
                                if($rec->paid === "np"){
                                echo    '<form id="tripsearch" method="POST" action="tripSearch.php">
                                        <input type="hidden" name="tid" value="'.$rec->id.'">
                                        <input type="hidden" name="tagPost" value="paymentUpdate">
                                        <button type="submit">PAYMENT DONE</button>
                                    </form>';
                                }else{
                                    echo 'paid';
                                }
                                echo '</td>
                                <td>
                                    <form id="tripsearch" method="POST" action="tripUpdate.php">
                                        <input type="hidden" name="id" value="'.$rec->id.'">
                                        <input type="hidden" name="company" value="'.$rec->company.'">
                                        <input type="hidden" name="vehicle" value="'.$rec->vehicle.'">
                                        <input type="hidden" name="destination" value="'.$rec->destination.'">
                                        <input type="hidden" name="sdate" value="'.$rec->sdate.'">
                                        <input type="hidden" name="advance" value="'.$rec->advance.'">
                                        <input type="hidden" name="amount" value="'.$rec->amount.'">
                                        <input type="hidden" name="driver" value="'.$rec->driver.'">
                                        <input type="hidden" name="cleaner" value="'.$rec->cleaner.'">
                                        <input type="hidden" name="paid" value="'.$rec->paid.'">
                                        <input type="hidden" name="description" value="'.$rec->description.'">
                                        <input type="hidden" name="tagPost" value="tripUpdate1">
                                        <button type="submit">EDIT</button>
                                    </form>
                                </td>';
                                if($rec->company != "local"){
                                echo'   <td>
                                            <form id="tripsearch" method="POST" action="invoice.php">
                                                <input type="hidden" name="id" value="'.$rec->id.'">
                                                <input type="hidden" name="company" value="'.$rec->company.'">
                                                <input type="hidden" name="description" value="'.$rec->description.'">
                                                <input type="hidden" name="vehicle" value="'.$rec->vehicle.'">
                                                <input type="hidden" name="amount" value="'.$rec->amount.'">
                                                <input type="hidden" name="sdate" value="'.$rec->sdate.'">
                                                <button type="submit">PRINT</button>
                                            </form>
                                        </td>
                                    </tr>';
                                }else{
                                    echo '
                                    <td>Local</td>
                                    ';
                                }
                    }
                   echo '</tbody>
            </table>';
            }else if(($_SERVER["REQUEST_METHOD"]==="POST") && ($_POST["tagPost"] === "paymentUpdate")){
                echo '<h2>'.$updResult.'</h2>';
            }else if(($_SERVER["REQUEST_METHOD"]==="POST") && ($_POST["tagPost"] === "tripSearch")){
                echo '<h2>No results found!</h2>';
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