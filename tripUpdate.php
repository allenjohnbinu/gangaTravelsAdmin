<?php
$serverip = file_get_contents('serverip.txt');
$flag = 0;
require "db_config/db.php";
if (($_SERVER["REQUEST_METHOD"]==="POST") && ($_POST["tagPost"] === "tripUpdate1")){
    $id = $_POST["id"];
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
}
?>
<?php
$result = null;
if (($_SERVER["REQUEST_METHOD"]==="POST") && ($_POST["tagPost"] === "tripUpdate2")){
    $flag = 1;
    $id = $_POST["id"];
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

    $sql = "UPDATE trip SET
				company 	    = :company,
				vehicle 	    = :vehicle,
                destination		= :destination,
                sdate		    = :sdate,
                advance 	    = :advance,
                amount 		    = :amount,
                driver		    = :driver,
                cleaner		    = :cleaner,
                description     = :description,
                paid 		    = :paid
			WHERE id = $id";

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

        $updResult = 'TRIP DETAILS UPDATED';

    } catch(PDOException $e){
        $updResult = $e->getMessage();
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
                <h1><img src="img/logo.png" style="max-height:40; max-width:110px;"> GANGA TRAVELS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TRIPS</h1>
                </div>
            </div>
        </header>
        <script>
            function openNav() {
              document.getElementById("mySidenav").style.width = "250px";
            }
            
            function closeNav() {
              document.getElementById("mySidenav").style.width = "0";
            }
        </script>
        <div id="showcase" style="min-height: 500px;">
            <div class="wrapper">
                <div class="title">
                    <?php 
                    if($flag === 0){
                        echo 'UPDATE TRIP DETAILS';
                    }else{
                        echo '<h2>'.$updResult.'</h2>
                </div>
            </div>
        </div> 
        <footer>
            <p>Developed by Allen John Binu</p>
        </footer>
    </body>
</html>';
exit;
                    }
                    ?>
                </div>
                <form id="tripA"  method="POST" action="tripUpdate.php">
                    <label for="id">Trip id</label>
                    <?php
                        echo '<input type="text" id="id" name="id" value="'.$id.'" readonly>';
                    ?>
                    <label for="company">company</label>
                    <select id="company" name="company">
                        <?php
                        echo '
                        <option value="'.$company.'" >'.$company.'</option>';
                        ?>
                        <?php
                        foreach($comNames as $com){
                        echo '
                        <option value="'.$com->name.'">'.$com->name.'</option>';
                        }
                        ?>
                    </select>
                    <label for="vehicle">vehicle</label>
                    <select id="vehicle" name="vehicle">
                        <?php
                            echo '<option value="'.$vehicle.'" >'.$vehicle.'</option>';
                        ?>
                        <?php
                        foreach($vehiNames as $vehi){
                        echo '
                        <option value="'.$vehi->dValue.'">'.$vehi->dValue.'</option>
                        ';
                        }
                        ?>
                    </select>
                    <label for="destination">destination</label>
                    <?php
                        echo '<input type="text" id="destination" name="destination" value = "'.$destination.'" required>';
                    ?>
                    <label for="sdate">Starting date</label>
                    <?php
                        echo '<input type="text" id="sdate" name="sdate" value = "'.$sdate.'" required>';
                    ?>
                    <label for="advance">Advance</label>
                    <?php
                        echo '<input type="text" id="advance" name="advance" value = "'.$advance.'" required>';
                    ?>
                    <label for="amount">Total amount</label>
                    <?php
                        echo '<input type="text" id="amount" name="amount" value = "'.$amount.'" required>';
                    ?>
                    <label for="driver">driver</label>
                    <select id="driver" name="driver">
                        <?php
                            echo '<option value="'.$driver.'" >'.$driver.'</option>';
                        ?>
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
                            echo '<option value="'.$cleaner.'" >'.$cleaner.'</option>';
                        ?>
                        <?php
                        foreach($clrNames as $clr){
                        echo '
                        <option value="'.$clr->dValue.'">'.$clr->dValue.'</option>
                        ';
                        }
                        ?>
                    </select>
                    <label for="description">description</label>
                    <?php
                        echo '<input type="text" id="description" name="description" value = "'.$description.'" required>';
                    ?>
                    <label for="paid">payment status</label>
                    <select id="paid" name="paid">
                        <?php
                            echo '<option value="'.$paid.'" >'.(($paid === "np") ? 'not paid' : 'paid').'</option>';
                        ?>
                        <option value="np">not paid</option>
                        <option value="p">paid</option>
                    </select>
                    <input type="hidden" name="tagPost" value="tripUpdate2">
                    <input type="submit" value="ADD" class="btn">
                </form>
            </div>
        </div> 
        <footer>
            <p>Developed by Allen John Binu</p>
        </footer>
    </body>
</html>