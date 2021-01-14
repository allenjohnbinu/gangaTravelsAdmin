<?php
$serverip = file_get_contents('serverip.txt');
if ($_SERVER["REQUEST_METHOD"]==="GET"){
    if($_GET["id"]){
        $tripid = $_GET["id"];
        $vehicle = $_GET["vehicle"];
    }
}
?>
<?php
require "db_config/db.php";
$result = null;
if ($_SERVER["REQUEST_METHOD"]==="POST"){
    $tripid = $_POST["tripid"];
    $vehicle = $_POST["vehicle"];
    $pump = $_POST["pump"];
    $fdate = $_POST["fdate"];
    $kmr = $_POST["kmr"];
    $litre = $_POST["litre"];
    $price = $_POST["price"];

    $sql = "INSERT INTO petrol (tripid,vehicle,pump,fdate,kmr,litre,price) VALUES
    (:tripid,:vehicle,:pump,:fdate,:kmr,:litre,:price)";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':tripid', $tripid);
        $stmt->bindParam(':vehicle',  $vehicle);
        $stmt->bindParam(':pump',      $pump);
        $stmt->bindParam(':fdate',      $fdate);
        $stmt->bindParam(':kmr',  $kmr);
        $stmt->bindParam(':litre',      $litre);
        $stmt->bindParam(':price',      $price);

        $stmt->execute();

        $result = "****PETROL BILL DETAILS ADDED****";
        

    } catch(PDOException $e){
        $result = $e->getMessage();
        echo $e->getMessage();
    }
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
                <h1><img src="img/logo.png" style="max-height:40; max-width:110px;"> GANGA TRAVELS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PETROL ADD </h1>
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
                        echo 'ADD PETROL DETAILS';
                    }
                    ?>
                </div>
                <form id="tripA"  method="POST" action="petrolAdd.php">
                    <label for="tripid">tripid</label>
                    <?php
                        echo '<input type="text" id="tripid" name="tripid" value="'.$tripid.'" readonly>';
                    ?>
                    <label for="vehicle">vehicle</label>
                    <?php
                        echo '<input type="text" id="vehicle" name="vehicle" value="'.$vehicle.'" readonly>';
                    ?>
                    <label for="pump">pump</label>
                    <input type="text" id="pump" name="pump" required>
                    <label for="fdate">filling date</label>
                    <input type="date" id="fdate" name="fdate" required>
                    <label for="kmr">kilometer reading</label>
                    <input type="number" id="kmr" name="kmr" required>
                    <label for="litre">litre intake(L)</label>
                    <input type="number" id="litre" name="litre" required>
                    <label for="price">billing price(rs)</label>
                    <input type="number" id="price" name="price" required>
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