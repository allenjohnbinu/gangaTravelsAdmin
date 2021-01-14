<?php
$serverip = file_get_contents('serverip.txt');
require "db_config/db.php";
$result = null;
if ($_SERVER["REQUEST_METHOD"]==="POST"){
    $company = $_POST["company"];
    $vehicle = $_POST["vehicle"];
    $destination = $_POST["destination"];
    $sdate = $_POST["sdate"];
    $advance = $_POST["advance"];
    $amount = $_POST["amount"];
    $driver = $_POST["driver"];
    $cleaner = $_POST["cleaner"];
    $description = $_POST["description"];
    $paid = $_POST["paid"];

    $sql = "INSERT INTO trip (company,vehicle,destination,sdate,advance,amount,driver,cleaner,description,paid) VALUES
    (:company,:vehicle,:destination,:sdate,:advance,:amount,:driver,:cleaner,:description,:paid)";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':company', $company);
        $stmt->bindParam(':vehicle',  $vehicle);
        $stmt->bindParam(':destination',      $destination);
        $stmt->bindParam(':sdate',      $sdate);
        $stmt->bindParam(':advance',    $advance);
        $stmt->bindParam(':amount',  $amount);
        $stmt->bindParam(':driver',      $driver);
        $stmt->bindParam(':cleaner',      $cleaner);
        $stmt->bindParam(':description',    $description);
        $stmt->bindParam(':paid',    $paid);

        $stmt->execute();

        $result = "****TRIP DETAILS ADDED****";
        

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
                <h1><img src="img/logo.png" style="max-height:40; max-width:110px;"> GANGA TRAVELS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TRIP ADD</h1>
                </div>
            </div>
        </header>
        <div id="showcase" style="min-height: 500px;">
            <div class="wrapper">
                <div class="title">
                    <?php
                    if($result){
                        echo $result;
                    }
                    else{
                        echo 'ADD TRIP DETAILS';
                    }
                    ?>
                </div>
                <form id="tripA"  method="POST" action="tripAdd.php">
                    <label for="company">company</label>
                    <select id="company" name="company">
                        <?php
                        foreach($comNames as $com){
                        echo '
                        <option value="'.$com->name.'">'.$com->name.'</option>
                        ';
                        }
                        ?>
                    </select>
                    <label for="vehicle">vehicle</label>
                    <select id="vehicle" name="vehicle">
                        <?php
                        foreach($vehiNames as $vehi){
                        echo '
                        <option value="'.$vehi->dValue.'">'.$vehi->dValue.'</option>
                        ';
                        }
                        ?>
                    </select>
                    <label for="destination">destination</label>
                    <input type="text" id="destination" name="destination" required>
                    <label for="sdate">Starting date</label>
                    <input type="date" id="sdate" name="sdate" required>
                    <label for="advance">Advance</label>
                    <input type="number" id="advance" name="advance" required>
                    <label for="amount">Total amount</label>
                    <input type="number" id="amount" name="amount" required>
                    <label for="driver">driver</label>
                    <select id="driver" name="driver">
                        <?php
                        foreach($driNames as $dri){
                        echo '
                        <option value="'.$dri->dValue.'">'.$dri->dValue.'</option>
                        ';
                        }
                        ?>
                    </select>
                    <label for="cleaner">cleaner</label>
                    <select id="cleaner" name="cleaner">
                        <?php
                        foreach($clrNames as $clr){
                        echo '
                        <option value="'.$clr->dValue.'">'.$clr->dValue.'</option>
                        ';
                        }
                        ?>
                    </select>
                    <label for="description">description</label>
                    <input type="text" id="description" name="description" required>
                    <label for="paid">payment status</label>
                    <select id="paid" name="paid">
                        <option value="np">not paid</option>
                        <option value="p">paid</option>
                    </select>
                    <input type="submit" value="ADD" class="btn">
                </form>
            </div>
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