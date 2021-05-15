<?php
    $tracking='';
    $resultFound=false;
    $result;
    
    if(isset($_POST['trackingId']) || isset($_GET['trackId'])){
        if(isset($_GET['trackId'])) $tracking=$_GET['trackId'];
        else $tracking=$_POST['trackingId'];
        $isnumber=is_numeric($tracking);
        if($isnumber){
            include('connection.php');
            $query = "SELECT * FROM order_status WHERE orderid='$tracking' ORDER BY updateTime DESC";
            $result=mysqli_query($conn,$query);
            if(mysqli_num_rows($result)>0) $resultFound=true;
        }
        unset($_POST);
    }
    $totalAttempt=0;
    include('localMethod.php');
?>

<html>
    <head>
        <title> Tracking</title>
        <link rel="stylesheet" type="text/css" href="../office/style.css">
        <link rel="stylesheet" type="text/css" href="../office/table.css">
    </head>
    <body>
        
        <div class="divLogin">
            <form action="" method="POST" class="loginContainer">
            <h2   > Track Your Order</h2>
                <input type="text" placeholder="Enter tracking Id" name="trackingId" required>
                <?php 
                    if($tracking!=''){
                        if(!is_numeric($tracking))echo "<font color='red'>Please Enter only number</font><br>";
                        else if(!$resultFound) echo "<font color='red'>No data found</font><br>";
                    } 
                ?>
                <input type="submit" name="submit"><br>
                <?php 
                    if(isset($_GET['trackId'])) echo "<a href='../office/order_details.php?id=$tracking'> Back to Home</a>";
                    else echo "<a href='../'> Back to Home</a>" ;
                ?>
                <br>
                
            </form>

        </div>

        <?php
            
            if($resultFound){
                $tableno=1;
                echo "<table class='styled-table'>
                    <thead>
                        <tr>
                            <th >S.No</th>
                            <th >Date and Time </th>
                            <th>Office Name </th>
                            <th>Status</th>
                        </tr>
                    </thead><tbody>";
                while($rowdata=mysqli_fetch_assoc($result)){
                    echo "
                        <tr>
                            <td >".$tableno."</td>
                            <td>".$rowdata['updateTime']."</td>
                            <td>".$rowdata['office']."</td>
                            <td>".addOrderStatus($rowdata['progressStatus'])."</td>
                      </tr>";
                    $tableno++;
                }
                echo "</tbody></table>";
            }
        ?>
    </body>
</html>