<!--//if edit getted than edit otherwise add
//upto staff can handle this 
//if 1,2 than show add all vs employee only destination
//view order 
//path find in add order 
//add connected office--


//remove camed office from array and already attathed office array
-->

<?php
    include('../php/localMethod.php');
   // error_reporting(0);
   session_start(); //user id
   if(!isset($_SESSION['loggedIn'])){
    header('Location: login.php'); exit(0);
   }
   if($_SESSION['loggedIn']>3){
    header('Location: office.php');
    exit(0);
   }
   $userId=$_SESSION['userId'];
   include('connection.php');
   if(!isset($_GET['id'])){
    header('Location: login.php'); exit(0);
   }
   $officeID=$_GET['id'];
   if($_SESSION['loggedIn']==3){
        $query6="SELECT * FROM employee_table where id='$userId'";
        $data6=mysqli_query($conn,$query6);
        $res6=mysqli_fetch_array($data6);
        if($res6['officeId']!=$officeID){
            header('Location: office.php');
            exit(0);
        }
   }
   

   $officeLength=0;

   $pinarray=array();
   $headarray=array();
   $officearray=array();
   $addarray=array();

   $waitstart=false;
   //get all office list


   $query9="SELECT * FROM office order by officeId";
   $arr=mysqli_query($conn,$query9); 
   
   $totalfound=0;
   while($rows=mysqli_fetch_assoc($arr)){
       if($officeID==$rows['officeId']){
           $pinI=$rows['pincode']; $headOfficeI=$rows['headoffice'];
       }else if(checkOlderConnection($rows['officeId'])){ $jjj=0;}
       else {
        $pinarray[$totalfound]=$rows['pincode'];
        $headarray[$totalfound]=$rows['headoffice'];
        $officearray[$totalfound]=$rows['officeId'];
        $addarray[$totalfound] = $rows['addrs'].' , '.$rows['district'].' , '.$rows['states'];
          $totalfound++; 
       }
       
   }


    $error='';
    if(isset($_POST['submit'])){
        $soffice=$_POST['selectedOffice'];
        $distance=$_POST['distance'];
        if(is_numeric($distance)){
            $query8 = "INSERT INTO pincode( offceI ,officeF ,pinI,pinF ,distance ,headofficeI,headOfficeF )
        VALUE('$officeID','$officearray[$soffice]','$pinI','$pinarray[$soffice]','$distance','$headOfficeI','$headarray[$soffice]')";
            $data=mysqli_query($conn,$query8);
            $query82 = "INSERT INTO pincode( offceI ,officeF ,pinI,pinF ,distance ,headofficeI,headOfficeF )
        VALUE('$officearray[$soffice]','$officeID','$pinarray[$soffice]','$pinI','$distance','$headarray[$soffice]','$headOfficeI')";
            $data2=mysqli_query($conn,$query82);
            if($data && $data2){   
                $waitstart=true;
            } else {
                $error='Failed';
            }
        }else $error="Please enter correct distance";
        
        unset($_POST);
    }

    function checkOlderConnection($newOffice){
        include('connection.php');
        $offid=$_GET['id'];
        //if matched than 
        $query55="SELECT * FROM pincode WHERE offceI='$offid'";
        $arr55=mysqli_query($conn,$query55);
        $total55=mysqli_num_rows($arr55);
        $yes=false;
        while($reees=mysqli_fetch_assoc($arr55)){
            if($reees['officeF']==$newOffice) $yes=true;
        }
        return $yes;
    }
 ?>

<html>
    <head>
        <title>Admin</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        
        <div class="divLogin">
            <form action="" method="POST" class="loginContainer">
            <h2   > Connect Office</h2>

                <p>
                    Select Office 
                    <select name="selectedOffice">
                    <?php 
                    $tempx=0;
                    while($tempx<$totalfound){
                            echo "<option value='$tempx' >".$officearray[$tempx].'--'.$addarray[$tempx]."</option>";
                        $tempx++;
                    }
                    ?>
                    </select>
                </p>
                <input type="number" placeholder="Enter Distance in KM" name="distance" ' required>
                <?php 
                        if(!$error=='') echo"<font color='red'>$error</font><br>";
                ?>
                <input type="submit" name="submit"><br>
                <a href='<?php echo 'connected_office.php?id='.$officeID;  ?>'> Go Back</a>
                <br>
            </form>
        </div>
    </body>
</html>

<?php
    if($waitstart){
        session_start();
        $_SESSION['returnlocation']='connected_office.php?id='.$officeID;
        header('Location:successfully.php');
        exit(0);
    }
?>