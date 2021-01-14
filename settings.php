<?php 
$serverip = file_get_contents('serverip.txt');
require "db_config/db.php";
?>
<?php
    if (($_SERVER["REQUEST_METHOD"]==="POST") && ($_POST["tagPost"] === "dropAdd")){
        $dKey = $_POST["dKey"];
        $dValue = $_POST["dValue"];

        $sql = "INSERT INTO dropdown (dKey,dValue) VALUES (:dKey,:dValue)";
        try{
            $db = new db();
            $db = $db->connect();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':dKey', $dKey);
            $stmt->bindParam(':dValue',  $dValue);
            $stmt->execute();
            $resultD = "****DETAILS ADDED****";
        } catch(PDOException $e){
            echo $e->getMessage();
        }
    }
?>
<?php
if (($_SERVER["REQUEST_METHOD"]==="POST") && ($_POST["tagPost"] === "compAdd")){
    $name = $_POST["name"];
    $address1 = $_POST["address1"];
    $address2 = $_POST["address2"];
    $address3 = $_POST["address3"];
    $gstn = strtoupper($_POST["gstn"]);
    $state = strtoupper($_POST["state"]);
    $code = $_POST["code"];
    $sql = "INSERT INTO company (name,address1,address2,address3,gstn,state,code) VALUES (:name,:address1,:address2,:address3,:gstn,:state,:code)";
    try{
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address1',  $address1);
        $stmt->bindParam(':address2', $address2);
        $stmt->bindParam(':address3', $address3);
        $stmt->bindParam(':gstn',  $gstn);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':code',  $code);
        $stmt->execute();
        $resultD = "****DETAILS ADDED****";
    } catch(PDOException $e){
        echo $e->getMessage();
    }
}
?>
<?php
if (($_SERVER["REQUEST_METHOD"]==="POST") && ($_POST["tagPost"] === "deleteV")){
    $tagDelete = $_POST["tagDelete"];
    $dValue = $_POST["dValue"];
    if($tagDelete==="deleteDropVehi"){
        $sql = "DELETE FROM dropdown WHERE dValue = '$dValue'";
    }else if($tagDelete==="deleteCom"){
        $sql = "DELETE FROM company WHERE name = '$dValue'";
    }else if($tagDelete==="deleteDropDri"){
        $sql = "DELETE FROM dropdown WHERE dValue = '$dValue'";
    }else if($tagDelete==="deleteDropClr"){
        $sql = "DELETE FROM dropdown WHERE dValue = '$dValue'";
    }
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        $delResult = "Detail Deleted";
    } catch(PDOException $e){
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                    <h1><img src="img/logo.png" style="max-height:40; max-width:110px;"> GANGA TRAVELS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SETTINGS </h1>
                </div>
            </div>
        </header>
        <style>
            .flex-container {
                display: flex;
                flex-wrap: nowrap;
            }
            
            .flex-container > table {
                width: 25%;
                margin: 10px;
                text-align: center;
                font-size: 30px;
                border: 2px solid rgb(37, 164, 238);
            }

            /* The Modal (background) */
            .modal {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1; /* Sit on top */
                padding-top: 100px; /* Location of the box */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            }

            /* Modal Content */
            .modal-content {
                background-color: #fefefe;
                margin: auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
            }

            /* The Close Button */
            .close {
                color: #aaaaaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: #000;
                text-decoration: none;
                cursor: pointer;
            }
        </style>
        <div id="showcase" style="min-height: 500px;" class ="flex-container" >
                <table class="darkTable">
                    <thead>
                        <tr>
                            <th>VEHICLE</th>
                            <th><i class="fa fa-trash"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($vehiNames as $vehi){
                        echo '
                        <tr>
                            <td>'.$vehi->dValue.'</td>
                            <td>
                                <form id="tripsearch" method="POST" action="settings.php">
                                    <input type="hidden" name="tagPost" value="deleteV">
                                    <input type="hidden" name="tagDelete" value="deleteDropVehi">
                                    <input type="hidden" name="dValue" value="'.$vehi->dValue.'">
                                    <button type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        ';}
                        ?>
                        <tr>
                            <td><button id="myBtn1">ADD VALUE</button></td>
                        </tr>                        
                    </tbody>
                </table>
                <table class="darkTable">
                    <thead>
                        <tr>
                            <th>COMPANY</th>
                            <th><i class="fa fa-trash"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($comNames as $com){
                        echo '
                        <tr>
                            <td>'.$com->name.'</td>
                            <td>
                                <form id="tripsearch" method="POST" action="settings.php">
                                    <input type="hidden" name="tagPost" value="deleteV">
                                    <input type="hidden" name="tagDelete" value="deleteCom">
                                    <input type="hidden" name="dValue" value="'.$com->name.'">
                                    <button type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        ';}
                        ?>
                        <tr>
                            <td><button id="myBtn2">ADD VALUE</button></td>
                        </tr>                        
                    </tbody>
                </table>
                <table class="darkTable">
                    <thead>
                        <tr>
                            <th>DRIVER</th>
                            <th><i class="fa fa-trash"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($driNames as $dri){
                        echo '
                        <tr>
                            <td>'.$dri->dValue.'</td>
                            <td>
                                <form id="tripsearch" method="POST" action="settings.php">
                                    <input type="hidden" name="tagPost" value="deleteV">
                                    <input type="hidden" name="tagDelete" value="deleteDropDri">
                                    <input type="hidden" name="dValue" value="'.$dri->dValue.'">
                                    <button type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        ';}
                        ?>
                        <tr>
                            <td><button id="myBtn3">ADD VALUE</button></td>
                        </tr>
                    </tbody>
                </table>
                <table class="darkTable">
                    <thead>
                        <tr>
                            <th>CLEANER</th>
                            <th><i class="fa fa-trash"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($clrNames as $clr){
                        echo '
                        <tr>
                            <td>'.$clr->dValue.'</td>
                            <td>
                                <form id="tripsearch" method="POST" action="settings.php">
                                    <input type="hidden" name="tagPost" value="deleteV">
                                    <input type="hidden" name="tagDelete" value="deleteDropClr">
                                    <input type="hidden" name="dValue" value="'.$clr->dValue.'">
                                    <button type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        ';}
                        ?>
                        <tr>
                            <td><button id="myBtn4">ADD VALUE</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <footer>
            <p>Developed by Allen John Binu</p>
        </footer>
        <div id="myModal1" class="modal">
            <div class="modal-content">
                <span id="close1" class="close">&times;</span>
                <form id="tripsearch" method="POST" action="settings.php">
                    <div class="searchcase">
                        <label for="dKey">ENTITY:</label>
                        <select id="dKey" name="dKey">>
                            <option value="vehicle">vehicle</option>
                            <option value="driver">driver</option>
                            <option value="cleaner">cleaner</option>
                        </select>
                        <label for="dValue">VALUE:</label>
                        <input type="text" id="dValue" placeholder="Enter value" name="dValue">
                        <input type="hidden" name="tagPost" value="dropAdd">
                        <button type="submit">ADD</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="myModal2" class="modal">
            <div class="modal-content">
                <span id="close2" class="close" >&times;</span>
                <form id="tripsearch" method="POST" action="settings.php">
                    <div class="searchcase">
                        <label for="name">name:</label>
                        <input type="text" id="name" placeholder="Enter name" name="name">
                        <label for="address1">address1:</label>
                        <input type="text" id="address1" placeholder="Enter address1" name="address1">
                        <label for="address2">address2:</label>
                        <input type="text" id="address2" placeholder="Enter address2" name="address2">
                        <label for="gstn">gstn:</label>
                        <input type="text" id="gstn" placeholder="Enter gstn" name="gstn">
                        <label for="state">state:</label>
                        <input type="text" id="state" placeholder="Enter state" name="state">
                        <label for="code">code:</label>
                        <input type="number" id="code" placeholder="Enter code" name="code">
                        <input type="hidden" name="address3" value="nthin">
                        <input type="hidden" name="tagPost" value="compAdd">
                        <button type="submit">Submit2</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            var modal1 = document.getElementById("myModal1");
            var modal2 = document.getElementById("myModal2");

            var btn1 = document.getElementById("myBtn1");
            var btn2 = document.getElementById("myBtn2");
            var btn3 = document.getElementById("myBtn3");
            var btn4 = document.getElementById("myBtn4");

            var span1 = document.getElementById("close1");
            var span2 = document.getElementById("close2");

            btn1.onclick = function() {
                modal1.style.display = "block";
            }
            btn2.onclick = function() {
                modal2.style.display = "block";
            }
            btn3.onclick = function() {
                modal1.style.display = "block";
            }
            btn4.onclick = function() {
                modal1.style.display = "block";
            }

            span1.onclick = function() {
                modal1.style.display = "none";
            }
            span2.onclick = function() {
                modal2.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal1) {
                    modal1.style.display = "none";
                }
            }
            window.onclick = function(event) {
                if (event.target == modal2) {
                    modal2.style.display = "none";
                }
            }
        </script>
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