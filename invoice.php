<?php 
    require "db_config/db.php";
    if ($_SERVER["REQUEST_METHOD"]==="POST"){
        $id = $_POST["id"];
        $company = $_POST["company"];
        $description = $_POST["description"];
        $vehicle = $_POST["vehicle"];
        $amount = $_POST["amount"];
        $sdate = $_POST["sdate"];
        $sql = "SELECT * FROM company WHERE name = '$company'";
        try{
            // Get DB Object
            $db = new db();
            // Connect
            $db = $db->connect();
    
            $stmt = $db->query($sql);
            $companyD = $stmt->fetch(PDO::FETCH_OBJ);
            $db = null;
            $comResult = $companyD;
        } catch(PDOException $e){
            $comResult = $e->getMessage();
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>INVOICE</title>
        <style>
            @media print {
                .container {-webkit-print-color-adjust:exact;}
            }

            body {
                margin: 0;
                padding: 0;
            }
            .container {
                width: 210mm;
                height: 297mm;
                background: #FFFFFF url('img/BG.jpg') no-repeat center;
                background-size: contain;
                font-size: 3.6mm;
            }

            .absol {
                position: absolute;
                left: 0;
                top: 0;            }
            
            .header #name {
                top: 63mm;
                left: 24mm;
            }

            .header #address1 {
                top: 67mm;
                left: 35mm;
            }

            .header #address2 {
                top: 71mm;
                left: 35mm;
            }

            .header #address3 {
                top: 75mm;
                left: 35mm;
                display: none;
            }

            .header #gstn {
                top: 77mm;
                left: 26mm;
                font-weight: 800;
            }

            .header #state {
                top: 81mm;
                left: 26mm;
            }

            .header #code {
                top: 81mm;
                left: 82mm;
            }

            .header #invoice_no {
                top: 60mm;
                left: 120mm;
            }

            .header #dated {
                top: 60mm;
                left: 172mm;
            }

            .footer #words {
                top: 252mm;
                left: 65mm;
            }

            .content .desc {
                box-sizing: border-box;
                padding: 0 5px;
            }

            .footer #total {
                top: 219.6mm;
                left: 185mm;
            }

            .footer #cgst {
                top: 224.3mm;
                left: 185mm;
            }

            .footer #sgst {
                top: 229.0mm;
                left: 185mm;
            }

            .footer #igst {
                top: 233.7mm;
                left: 185mm;
            }

            .footer #Gtotal {
                top: 243.2mm;
                left: 185mm;
            }

        </style>
    </head>
    <body>
        <div class="container absol">
            <div class="header">
                <?php
                echo '
                <p class="absol" id="name">THE MANAGER '.strtoupper($comResult->name).' TOURS</p>
                <p class="absol" id="address1">'.$comResult->address1.'</p>
                <p class="absol" id="address2">'.$comResult->address2.'</p>
                <p class="absol" id="gstn">'.$comResult->gstn.'</p>
                <p class="absol" id="state">'.$comResult->state.'</p>
                <p class="absol" id="code">'.$comResult->code.'</p>
                <p class="absol" id="invoice_no">GT/101'.$id.'/19-20</p>
                <p class="absol" id="dated">'.date("d-m-y").'</p>';
                ?>
            </div>
            <div class="contents">
                <div class="content">
                    <?php
                    echo '
                    <p class="absol slno">1</p>
                    <p class="absol desc">Hire charges of BUS:'.$vehicle.' used for '.$description.' on '.$sdate.' </p>
                    <p class="absol sac">996601</p>
                    <p class="absol gst">18%</p>
                    <p class="absol qty">1</p>
                    <p class="absol rate">RS.'.$amount.'.00</p>
                    <p class="absol to_amt">RS. '.$amount.'.00</p>
                    <p class="absol ta_amt">RS. '.$amount.'.00</p>';
                    ?>
                </div>
            </div>
            <div class="footer">
                <?php
                echo '
                <p class="absol" id="words">Rupees Eight thousand eight hundred and fifty only</p>
                <p class="absol" id="total">'.$amount.'.00</p>
                <p class="absol" id="cgst">'.(0.05*$amount).'.00</p>
                <p class="absol" id="sgst">'.(0.05*$amount).'.00</p>
                <p class="absol" id="igst">'.(0.05*$amount).'.00</p>
                <p class="absol" id="Gtotal">'.(1.15*$amount).'.00</p>';
                ?>
            </div>

        </div> 
        <script>
            let lineHeight = 20;

            window.onload = () => {
                let listItems = document.querySelectorAll(".content");

                listItems.forEach((el, i) => {
                    let subElems = {
                        slno: el.querySelector(".slno"),
                        desc: el.querySelector(".desc"),
                        sac: el.querySelector(".sac"),
                        gst: el.querySelector(".gst"),
                        qty: el.querySelector(".qty"),
                        rate: el.querySelector(".rate"),
                        toAmt: el.querySelector(".to_amt"),
                        taAmt: el.querySelector(".ta_amt")
                    };
                    subElems.desc.style.width = "57.3mm";
                    Object.values(subElems).forEach(elm => {
                        elm.style.top = `${100 + (lineHeight*i)}mm`;
                    })
                    subElems.slno.style.left = "14mm";
                    subElems.desc.style.left = "20mm";
                    subElems.sac.style.left = "80mm";
                    subElems.gst.style.left = "98mm";
                    subElems.qty.style.left = "112mm";
                    subElems.rate.style.left = "134mm";
                    subElems.toAmt.style.left = "156mm";
                    subElems.taAmt.style.left = "179mm";
                });
            }
        </script>
    </body>
</html>