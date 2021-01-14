<?php 
$serverip = file_get_contents('serverip.txt');
require "db_config/db.php";
$sql = "SELECT * FROM trip";
try{
    $db = new db();
    $db = $db->connect();    
    $stmt = $db->query($sql);
    $tCount = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    $tCount = count($tCount);
} catch(PDOException $e){
    echo $e->getMessage();
}
$sql = "SELECT * FROM trip WHERE paid = 'np'";
try{
    $db = new db();
    $db = $db->connect();    
    $stmt = $db->query($sql);
    $npCount = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    $npCount = count($npCount);
} catch(PDOException $e){
    echo $e->getMessage();
}
$sql = "SELECT SUM(amount-advance) AS outstand FROM trip WHERE paid = 'np'";
try{
    $db = new db();
    $db = $db->connect();    
    $stmt = $db->query($sql);
    $outstand = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    $outstand = $outstand[0]->outstand;
} catch(PDOException $e){
    echo $e->getMessage();
}
$month = date("m");
$monthPlus = 
$sql = "SELECT SUM(price) AS pendBill FROM petrol WHERE (fdate > DATE('2020-$month-01') AND fdate < DATE_ADD('2020-$month-01', INTERVAL 1 MONTH))";
try{
    $db = new db();
    $db = $db->connect();    
    $stmt = $db->query($sql);
    $pendBill = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    $pendBill = $pendBill[0]->pendBill;
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
                <h1><img src="img/logo.png" style="max-height:40; max-width:110px;"> GANGA TRAVELS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TRIPS</h1>
                </div>
            </div>
        </header>
        <div id="showcase" style="min-height: 500px;">
            <div class="container">
                <div id="boxes">
                    <div class="box">
                        <?php
                        echo'
                        <a href="http://'.$serverip.'/app/tripAdd.php"><img src="img/tripA.png" alt="TRIP ADD" style="width: 90px; height: 90px;"></a>';
                        ?>
                        <h2>ADD</h2>
                    </div>
                    <div class="box">
                        <?php
                        echo'
                        <a href="http://'.$serverip.'/app/tripSearch.php"><img src="img/tripS.png" alt="TRIP SEARCH" style="width: 90px; height: 90px;"></a>';
                        ?>
                        <?php
                        echo'
                        <h2>SEARCH <br>'.$tCount.' Trips</h>';
                        ?>
                    </div>
                    <div class="box">
                        <form id="tripsearch" method="POST" action="tripSearch.php">
                            <input type="hidden" name="paid" value="np">
                            <input type="hidden" name="vehicle" value="">
                            <input type="hidden" name="company" value="">
                            <input type="hidden" name="driver" value="">
                            <input type="hidden" name="cleaner" value="">
                            <input type="hidden" name="sdate" value="">
                            <input type="hidden" name="tagPost" value="tripSearch">
                            <button type="submit" style="background-color: Transparent; border: none; cursor:pointer;"><img src="img/tripP.png" alt="TRIP SEARCH" style="width: 90px; height: 90px;"></button>
                        </form>
                        <?php
                        echo'
                        <h2>NOT PAID<br>'.$npCount.' Trips</h>';
                        ?>
                    </div><br>
                    <div class="box">
                        <img src="img/tripP.png" alt="TRIP SEARCH" style="width: 60px; height: 60px;">
                        <?php
                        echo'
                        <h2>Total Outstanding<br>Rs.'.$outstand.'</h>';
                        ?>
                    </div>
                    <div class="box">
                        <img src="img/tripP.png" alt="TRIP SEARCH" style="width: 60px; height: 60px;">
                        <?php
                        echo'
                        <h2>Pending fuel Bill<br>Rs.'.$pendBill.'</h>';
                        ?>
                    </div>
                </div>
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