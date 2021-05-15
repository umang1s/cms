<?php
    //  cms/office/
    session_start();
    if(!isset($_SESSION['loggedIn']) && !isset($_SESSION['userId'])){
        header('Location: login.php') ;
        exit(0);
    }
    if(!isset($_GET['id'])){
        header('Location: login.php') ;
        exit(0);
    }
    $orderId=$_GET['id'];
    $loggedId=$_SESSION['loggedIn'];
    $userIdd=$_SESSION['userId'];
    include('connection.php');

    $query21="SELECT * FROM order_table where id='$orderId'";
    $data21=mysqli_query($conn,$query21);
    $rows=mysqli_num_rows($data21);
    if($rows==0){
        echo "<h2 align='center' style='color:red;'>Invalid Order ID</h2>";
        echo "<a href='login.php'>Back</a>";
        exit(0);
    }
    include('../php/localMethod.php');
    $result=mysqli_fetch_array($data21);

    $patharray=getPathResult($orderId);

?>
<html>
    <head>
        <title> Order Details</title>
        <link rel="stylesheet" type="text/css" href="../office/style.css">
    </head>
    <body>
    <a href='login.php'><font size=5px class="divLogin"> HOME</font></a>

        
        <div class="divLogin">

            <h2   >Order Details &nbsp;&nbsp;</h2>
            <h3> ID : <?php echo $orderId; ?></h3>
        </div>
        <div class="loginContainer">
            <h3> Order Details </h3>
            <table class="divLogin">
                <tr>
                    <th>ID</th>
                    <th>-</th>
                    <td><?php echo $result['id'];?></td>
                </tr>
                <tr>
                    <th>Starting Office</th><th>-</th>
                    <td><?php echo $result['initialOffice'];?></td>
                </tr>
                <tr>
                    <th>Current Office</th><th>-</th>
                    <td><?php echo $result['currentOffice'];?></td>
                </tr>
                <tr>
                    <th>Destination Office</th><th>-</th>
                    <td><?php echo $result['destinationOffice'];?></td>
                </tr>
                <tr>
                    <th>Weight</th><th>-</th>
                    <td><?php echo $result['itemweight'];?>KG</td>
                </tr>
                <tr>
                    <th>Amounts</th><th>-</th>
                    <td><?php echo $result['price'];?>Rs.</td>
                </tr>
                <tr>
                    <th>Order taken by</th><th>-</th>
                    <td><?php echo $result['orderTakenBy'];?></td>
                </tr>
                <tr>
                    <th>total Distance</th><th>-</th>
                    <td><?php echo $result['distance'];?>KM</td>
                </tr>
                <tr>
                    <th>Receiving Time</th><th>-</th>
                    <td><?php echo $result['receivingTime'];?></td>
                </tr>
                <tr>
                    <th>Delivering Time</th><th>-</th>
                    <td><?php echo $result['deliveringTime'];?></td>
                </tr>
                <tr>
                    <th>Status</th><th>-</th>
                    <td><?php echo $result['destinationOffice'];?></td>
                </tr>
                <tr>
                    <th>Delivered By</th><th>-</th>
                    <td><?php echo $result['deliverdBy'];?></td>
                </tr>
                <tr>
                    <th>Returning</th><th>-</th>
                    <td><?php if($result['isreturn']) echo "YES"; else echo "NO";?></td>
                </tr>
            </table>
            <h3>Sender Details</h3>
            <table class="divLogin">
                <tr>
                    <th>Name</th>
                    <th>-</th>
                    <td><?php echo $result['ownerName'];?></td>
                </tr>
                <tr>
                    <th>Pincode</th><th>-</th>
                    <td><?php echo $result['ownerPincode'];?></td>
                </tr>
                <tr>
                    <th>Address</th><th>-</th>
                    <td><?php echo $result['ownerAddress'];?></td>
                </tr>
                <tr>
                    <th>Mob-no.</th><th>-</th>
                    <td><?php echo $result['mobown'];?></td>
                </tr>
            </table><h3>Receiver  Details</h3><table class="divLogin">
                <tr>
                    <th>Name</th><th>-</th>
                    <td><?php echo $result['receiverName'];?></td>
                </tr>
                <tr>
                    <th>Pincode</th><th>-</th>
                    <td><?php echo $result['receiverPinCode'];?></td>
                </tr>
                <tr>
                    <th>Address</th><th>-</th>
                    <td><?php echo $result['receiverAddress'];?></td>
                </tr>
                <tr>
                    <th>Mob-no.</th><th>-</th>
                    <td><?php echo $result['mobrec'];?></td>
                </tr></table>
                <h4>
                <a href='<?php echo "../php/track_order.php?trackId=".$orderId; ?>' class='divLogin'>Track Status</a></h4>
        </div>



        <div class="divLogin">

            <h2   >Path details &nbsp;&nbsp;</h2>
        </div>
        <div class="loginContainer">
            <table class="divLogin">
                <thead>
                    <th>ID</th><th>Address</th>
                </thead>
                <tbody>
                <?php 
                    $starno=0;
                    $leng0=count($patharray);
                    while($starno<$leng0){
                        echo"<tr><td>".$patharray[$starno]."</td><td>".getOfficeAddressById($patharray[$starno])."</td></tr>";
                        $starno++;
                    }     
                ?>
                </tbody></table>
        </div>
    </body>
</html>