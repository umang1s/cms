<?php

    //cms/office/
    include('../php/localMethod.php');
   // error_reporting(0);
   session_start(); //user id
   if(!isset($_SESSION['loggedIn'])){
    header('Location: login.php'); exit(0);
   }
   if($_SESSION['loggedIn']>3){
    echo "<h2 align='center' style='color:red;'>Permission Denied</h2>";
    header('Location: office.php');
    exit(0);
   }
   if(!isset($_GET['officeid'])){
       header('Location: get_office_id.php');
       exit(0);
   }
   $destinationOffice=$_GET['officeid'];
   include('connection.php');
   $pathresult=array();
   $gettedTrackingId=0;
   $price=0;
   $distance=0;
   $temppin=0;
   $empid=$_SESSION['userId'];
   if(!validationOfOffice($destinationOffice)){
        echo "<h2 align='center' style='color:red;'>Invalid office Id</h2>";
        header('Location: get_office_id.php');
        exit(0);
   }
   $query66="SELECT * FROM employee_table where id='$empid'";
    $res66=mysqli_query($conn,$query66);
    $dat66=mysqli_fetch_array($res66);
    $currentOfficeId=$dat66['officeId'];
    if($_SESSION['loggedIn']<3){
        if(isset($_SESSION['currentOffice'])){
            $currentOfficeId=$_SESSION['currentOffice'];
        }else {
            echo "<h2 align='center' style='color:red;'>Invalid office Id</h2>";
            header('Location: get_office_id.php');
            exit(0);
        }
    }
   //checking path ------------------------------------------------------------
    $pathfound=false;
    $distance=0;
    $run1path=0;
    $path2result=array();
    $run2path=0;

    include('connection.php');
    $f=$currentOfficeId;   //id
    $s=$destinationOffice;
    $fs=getOfficeType($f);  //type
    $ss=getOfficeType($s);

    $maxcontrol=0;
    while($maxcontrol<20){
        if($fs==4 && $ss==4) break;
        if($fs>$ss){
            if(checkAvailibility($f,$s)==0){
                $path2result[$run2path++]=$s;
                $tempF=detailsOffice($s);
                $distance+=checkAvailibility($s,$tempF[0]);
                $s=$tempF[0];
                 $ss=$tempF[1]; 
            }else{
                $path2result[$run2path++]=$f;
                $distance+= checkAvailibility($f,$s);
                $pathfound=true; break;
            }
            
        } else{
            if(checkAvailibility($f,$s)==0){
                $pathresult[$run1path++]=$f;
                $tempG=detailsOffice($f);
                $distance+=checkAvailibility($f,$tempG[0]);
                $f=$tempG[0];
                 $fs=$tempG[1]; 
            }else{
                $pathresult[$run1path++]=$f;
                $distance+= checkAvailibility($f,$s);
                $pathfound=true; break;
            }
        }
        $maxcontrol++;
    }
  
    if(!$pathfound ){
        if(checkAvailibility($f,$s)==0){
            $pathresult[$run1path++]=$f;
            $distance+= checkAvailibility($f,$s);
            $pathfound=false; 
        }else{
            $pathresult[$run1path++]=$f;
            $distance+= checkAvailibility($f,$s);
            $pathfound=true; 
        }
        //this function was made for search headoffice -headoffice  searching 
        //head to head not doing well so that we reduced
    }
    if($pathfound){
        $count11=count($path2result)-1;
        while($count11>-1) {$pathresult[$run1path++]=$path2result[$count11--];}
    }


    function checkAvailibility($to,$which){
        include('connection.php');
        $query29="SELECT * FROM pincode where offceI='$to'";
        $res29=mysqli_query($conn,$query29);
        while($row29=mysqli_fetch_assoc($res29)){
            if($row29['officeF']==$which)  return  $row29['distance'];
        } 
        return 0;
    }
    function detailsOffice($xx){
        $ret=array();
        include('connection.php');
            $query23="SELECT * from office where officeId='$xx'";
            $data=mysqli_query($conn,$query23);
            $rows23=mysqli_fetch_array($data);
            $ret[0]=$rows23['headoffice'];
            $ret[1]=$rows23['typ'];

            return $ret;
        //return array 0 is head,1 is pos
    }
    function getOfficeType($idddd){
        $retval90=detailsOffice($idddd);
        return $retval90[1];
    }





   //------------------------------------------------------------------------------
   
   if(!$pathfound){
        if(isset($_GET['pincode'])) {
            $temppin=$_GET['pincode'];
            header('Location: get_office_id.php?pin='.$temppin);
        }
        else header('Location: get_office_id.php');
        exit(0);
   }else $temppin=$_GET['pincode'];
    $error='';
    $waitstart=false;

    if(isset($_POST['submit'])){
        include('connection.php');
        $sname=$_POST['sname']; $rname=$_POST['rname'];
        $spin=$_POST['spin'];   $rpin=$_POST['rpin'];
        $sadd=$_POST['sadd'];   $radd=$_POST['radd'];
        $smob=$_POST['smob'];   $rmob=$_POST['rmob'];
        $iweight=$_POST['itw'];
        if(is_numeric($iweight)){
            $price=$iweight*getweightparam();
            $query65="SELECT * FROM office where officeId='$currentOfficeId'";
            $res65=mysqli_query($conn,$query65);
            $dat65=mysqli_fetch_array($res65);
            $currentUserId=$_SESSION['userId'];
            $blankstamp='0000-00-00 00:00:00';
            $pstatus=1;
            $p2=0;
            $nowvalue=date("Y-m-d h:i:s a",time()); //date
            $query67="INSERT INTO order_table(itemweight ,price ,initialOffice ,receivingTime ,
            deliveringTime ,destinationOffice ,currentOffice ,mobown ,progressStatus , isreturn ,ownerName ,
            ownerPincode ,ownerAddress ,mobrec ,receiverName ,receiverPinCode ,orderTakenBy ,deliverdBy ,distance,receiverAddress)
            value('$iweight','$price','$currentOfficeId','$nowvalue','$blankstamp','$destinationOffice','$currentOfficeId',
            '$smob','$pstatus','$p2','$sname','$spin','$sadd','$rmob','$rname','$rpin','$currentUserId','$pstatus','$distance','$radd')";
            $done67=mysqli_query($conn,$query67);

            if(!$done67) $error='failed<br>';
            else{
                $query70="SELECT * FROM order_table where  receivingTime='$nowvalue'";
                $done70=mysqli_query($conn,$query70);
                while($res70=mysqli_fetch_assoc($done70)){
                    if($res70['ownerName']==$sname && $res70['receiverName']==$rname && $res70['destinationOffice']==$destinationOffice && $res70['initialOffice']==$currentOfficeId){
                        $gettedTrackingId=$res70['id'];
                    }
                } 
                $res70=mysqli_fetch_array($done70);
                //---------
                $t=0;
                $p1=count($pathresult); 
                $arrayLength=count($pathresult);
                
                $temprry=array();
                while($t<20){
                    if($t<$p1) $temprry[$t]=$pathresult[$t];
                    else $temprry[$t]=0;
                    $t++;
                }
                $query68="INSERT INTO path_table(orderId ,pathLength  ,path1 ,path2 ,path3 ,path4 , path5 ,path6 ,
                path7 ,path8 ,path9 ,path10 ,path11 ,path12 ,path13 ,path14 ,path15 ,path16 ,path17 ,path18 ,path19 ,path20)
                value ('$gettedTrackingId','$p1','$temprry[0]','$temprry[1]','$temprry[2]','$temprry[3]','$temprry[4]','$temprry[5]',
                '$temprry[6]','$temprry[7]','$temprry[8]','$temprry[9]','$temprry[10]','$temprry[11]','$temprry[12]','$temprry[13]',
                '$temprry[14]','$temprry[15]','$temprry[16]','$temprry[17]','$temprry[18]','$temprry[19]')";

                $officeDetails=" ".$dat65['states'].",".$dat65['district'].",".$dat65['addrs'];//office state,office district,office ,add

                $query69="INSERT INTO order_status(orderId,updateTime ,progressStatus ,office)
                value ('$gettedTrackingId','$nowvalue','$pstatus','$officeDetails')";

                $done68=mysqli_query($conn,$query68);
                $done69=mysqli_query($conn,$query69);
                if($done68 && $done69){
                    $waitstart=true;
                }else{
                    if(!$done68) $error='Inserting path failed<br>';
                    if(!$done69) $error.='Failed to update order status';
                }
            }
        }else $error='Invalid weight'; 
    }
 ?>

<html>
    <head>
        <title>Add order</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        
        <div class="divLogin">
            <form action="" method="POST" class="loginContainer">
            <h1   > Add new Order</h1>
                <h3> Order Details</h3>
                <h5>Distance :&nbsp;&nbsp; <?php echo $distance; ?> KM <br>Destination Office : &nbsp;&nbsp;<?php echo $destinationOffice; ?></h5>
                <input type="text" placeholder="Enter order weight" name="itw" required>
                <h3> Sender Details</h3>
                <input type="text" placeholder="Enter Name" name="sname" required>
                <input type="text" placeholder="Enter pincode" name="spin" required>
                <input type="text" placeholder="Enter Address" name="sadd" required>
                <input type="text" placeholder="Enter mobile number" name="smob" required>
                <h3> Receiver Details</h3>
                <input type="text" placeholder="Enter Name" name="rname" required>
                <input type="text" placeholder="Enter pincode" name="rpin" required>
                <input type="text" placeholder="Enter Address" name="radd" required>
                <input type="text" placeholder="Enter mobile number" name="rmob" required>
                <?php 
                    if(!$error=='') echo"<font color='red'>$error</font><br>";
                ?>
                <input type="submit" name="submit"><br>
                <a href="admin.php"> Back to Home</a>&nbsp;&nbsp;<a href="<?php echo 'get_office_id.php?pin='.$temppin; ?>" > Change Office</a>
                <br>
            </form>

        </div>
    </body>
</html>

<?php
    if($waitstart){
        session_start();
        $_SESSION['returnlocation']='login.php';
        $_SESSION['message']='Tracking id is :'.$gettedTrackingId;
        header('Location:successfully.php');
        exit(0);
    }

    //0 for received
?>