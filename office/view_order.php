<?php
    //  cms/office/

    //this page will be seen every employee
    //if office id than they will perform operation 
    //if admin than 
    session_start();
    if(!isset($_SESSION['loggedIn']) || !isset($_SESSION['userId']) || !isset($_GET['officeId'])){
        header('Location: login.php') ;
        exit(0);
    }
    $loggedId=$_SESSION['loggedIn'];
    $userIdd=$_SESSION['userId'];
    $officeId=$_GET['officeId'];
    include('connection.php');
    include('../php/localmethod.php');
    if(!validationOfOffice($officeId)){
        header('Location: login.php') ;
        exit(0);
    }
    if($loggedId>2){
        $query71="SELECT * FROM employee_table where id='$userIdd'";
        $dat71=mysqli_query($conn,$query71);
        $fet71=mysqli_fetch_array($dat71);
        if($fet71['officeId']!=$officeId){
            header('Location: login.php') ;
            exit(0);
        }
    }

    $query34;
    if(isset($_GET['order_no'])  && isset($_GET['operation'])){
        $orderno=$_GET['order_no'];
        $oper=$_GET['operation'];
        $sucres=false;
        $sucres2=0;
        $query70;
        $res70;

        $query78="SELECT * FROM order_table where id='$orderno'";
        $sd78=mysqli_query($conn,$query78);
        $res78=mysqli_fetch_array($sd78);
        
        $prosta=$res78['progressStatus'];
        $isReturning=$res78['isreturn'];
        $destoff78=$res78['destinationOffice'];
        $pathresult= getPathResult($orderno);

        //check progress status
        if($loggedId==4){
            switch ($prosta){
                case 1: case 4:     $sucres=true; $sucres2=3; $query79="UPDATE order_table SET progressStatus='$sucres2' where id='$orderno'";  break; //update ->out for delivery
                case 3:  $sucres=true; if($oper==1){
                    $sucres2=6; $query79="UPDATE order_table SET deliveringTime=now(),progressStatus='$sucres2',deliverdBy='$userIdd' where id='$orderno'"; 
                }
              else { $sucres2=4; $query79="UPDATE order_table SET progressStatus='$sucres2' where id='$orderno'";} break;//check ->de
                default: echo "<h2 align='center' style='color:orange;'>Invalid Operation</h2>"; break;
            }
        } else { 
            $currOffPos=0;
            $nextOfficeId;
            while($currOffPos<count($pathresult)){if($pathresult[$currOffPos++]==$officeId) break; }
            $currOffPos-=1;
            if($isReturning ){
                if($currOffPos>1) $nextOfficeId=$pathresult[$currOffPos-1];
            }
            else{ if
                ($currOffPos+1<count($pathresult))
                $nextOfficeId=$pathresult[$currOffPos];
            }
            switch ($prosta){
                case 2: $sucres=true; $sucres2=1; $query79="UPDATE order_table SET progressStatus='$sucres2' where id='$orderno'";  break; 
                case 1: if($destoff78 !=$officeId){$sucres=true; $sucres2=2;
                    $query79="UPDATE order_table SET progressStatus='$sucres2', currentOffice='$nextOfficeId' where id='$orderno'";
                } break;  //received to update 
                case 4: $sucres=true; $flag=1; $sucres2=2; $query79="UPDATE order_table SET progressStatus='$sucres2', currentOffice='$nextOfficeId', isreturn='$flag' where id='$orderno'";  break; //return to 
                default: echo "<h2 align='center' style='color:orange;'>Invalid Operation</h2>"; break;
            }
        }


        if($sucres){
            $res79=mysqli_query($conn,$query79);
            if($res79){
                $offAdd=getOfficeAddressById($officeId);
                echo "<h2 align='center' style='color:orange;'>Updated</h2>";
                $query99="INSERT INTO order_status(orderId,updateTime ,progressStatus ,office)
                value ('$orderno',now(),'$sucres2','$offAdd')";
                $res99=mysqli_query($conn,$query99);
                if($res99) echo ":)";
                //update order status
            }   else echo "<h2 align='center' style='color:orange;'>Failed</h2>";
        }

           
    }


    $query34="SELECT * FROM order_table where currentOffice='$officeId'";
    $resu34=mysqli_query($conn,$query34);

    $orderarray=array();
    $destoffarry=array();
    $statusarray=array();
    $filled=0;

    while($res67=mysqli_fetch_assoc($resu34)){
        if($res67['progressStatus'] !=6){
            if($loggedId==4 ){
                if( $officeId==$res67['destinationOffice']){
                    $orderarray[$filled]=$res67['id'];
                    $destoffarry[$filled]=$res67['destinationOffice'];
                    $statusarry[$filled]=$res67['progressStatus'];
                    $filled++;
                }
            } else{
                $orderarray[$filled]=$res67['id'];
                $destoffarry[$filled]=$res67['destinationOffice'];
                $statusarry[$filled]=$res67['progressStatus'];
                $filled++;
            }
        }

    }
    $totalrows=mysqli_num_rows($resu34);
    //manage order for 
    if($totalrows==0){
        echo "<a href='login.php'>Home</a><br>
        <h1  style='color:green;' align='center'>Order List</h1>";
        echo "<br><br><h1 align='center' style='color:red;'>No Order Found</h1><br>";
        exit(0);
    }
    $_GET=array();

    function getOperationType($who,$num){
        if($who==4){
            if($num==1 || $num==4) return 'Pickup Order';
            if($num==0) return 'Comming';
            if($num==3) return 'Delivered';
        }
        if($num==2) return 'Received';
        if($num==1) return 'Forward to next office';
        if($num==3) return '-';
        if($num==4)  return 'Return';
    }

    


   
?>
<html>
    <head>
        <title>Offices</title>
        <meta name="viewport" content="width=device-width,initial-scalse=1.0">
        <link rel="stylesheet" href="table.css">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <a href='login.php'><font  size=5px class='divLogin'>Home</font></a><br>
        <h1  style='color:green;' align='center'>Order List</h1><br>
        <?php 
            $tableno=1;
            $showtable=0;

            echo "<table class='styled-table'>
                    <thead>
                    <tr>
                        <th >Sn.</th>
                        <th>Order Id</th>
                        <th>Destination Office</th>
                        <th>Status</th>
                        <th>Details</th>
                        <th colspan=2><font color='brown' >Operation</font></th></tr></thead><tbody>";
                while($showtable< $filled){
                    $tempvar=getOperationType($loggedId,$statusarry[$showtable]);
                    echo "<tr>
                            <td >".$tableno."</td>
                            <td >".$orderarray[$showtable]."</td>
                            <td>".$destoffarry[$showtable]."</td>
                            <td>".addOrderStatus($statusarry[$showtable])."</td>
                            <td><a href='order_details.php?id=$orderarray[$showtable]'><font color='green' >View Details</font></a></td>";
                            if($statusarry[$showtable]==1 && $destoffarry[$showtable]==$officeId && $loggedId!=4) echo "<td><button style='background-color:#5f5; width:100%; height:30px; font-size:20px; font-color:orange'>Waiting For Delivery</button></td> ";
                            else echo"<td><a href='view_order.php?officeId=$officeId&order_no=$orderarray[$showtable]&operation=1'><button style='background-color:#5f5; width:100%; height:30px; font-size:20px; font-color:orange'>$tempvar</button></a></td>";
                            if($statusarry[$showtable]==3 && $loggedId==4) echo"
                            <td><a href='view_order.php?officeId=$officeId&order_no=$orderarray[$showtable]&operation=2'><button style='background-color:#5f5; width:100%; height:30px; font-size:20px; font-color:orange'>Failed To Delivered</button></a></td></tr>";
                            else "</tr>";
                    $tableno++;
                    $showtable++;
                } 
                echo '</dbody></table>';   
        ?>
        
    </body>


</html>

