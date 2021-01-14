<?php
$serverip = file_get_contents('serverip.txt');
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
                    <h1><img src="img/logo.png" style="max-height:40; max-width:110px;"> GANGA TRAVELS</h1>
                </div>
            </div>
        </header>
        <div id="showcase" style="min-height: 500px;">
            <div class="container">
                <h1>Success Is A Journey, Not A Destination</h1>
            </div>
            <div class="container">
                <div id="boxes">
                    <div class="box">
                        <?php
                        echo'
                        <a href="http://'.$serverip.'/app/trips.php"><img src="img/trip.png" class ="icon" alt="TRIP MANAGEMENT" ></a>';
                        ?>
                        <h3>TRIPS</h3>
                        <p>manages billing, payment and trip details</p>
                    </div>
                    <div class="box">
                        <?php
                        echo'
                        <a href="http://'.$serverip.'/app/petrol.php"><img src="img/petrol.png" class ="icon" alt="TRIP MANAGEMENT" ></a>';
                        ?>
                        <h3>PETROL</h3>
                        <p>manages petrol details and identify error cases</p>
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