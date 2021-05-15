<?php
    include('../php/localMethod.php');
   // error_reporting(0);
   session_start(); //user id
   if(!isset($_SESSION['loggedIn'])){
    header('Location: login.php'); exit(0);
   }
   if($_SESSION['loggedIn']>2){
    header('Location: office.php');
    exit(0);
   }
   $waitstart=false;
   include('connection.php');
    $query='SELECT * from general';
    $data=mysqli_query($conn,$query);
    $result = mysqli_fetch_assoc($data);
    $tempctime=$result['ctime'];
    $tempotime=$result['otime'];
    $error='';
    $datareceived=false;
    $officetype=1;
    if(isset($_POST['submit'])){
        $datareceived=true;

        $type=$_POST['officetype'];
        $officetype=$type;
        if($type!=4) $headOffice=$_POST['headoffice'];
        else $headOffice='';
        $state=$_POST['state'];
        $district=$_POST['district'];
        $address=$_POST['address'];
        $pincode=$_POST['pincode'];
        $mobileno=$_POST['mobileno'];
        $selectedctime=$_POST['ctime'];
        $selectedotime=$_POST['otime'];

        $currectData=0;
        if($type!=4){
            if(validationOfOffice($headOffice)) $currectData++;
            else $error='head office is invalid';
        }else $currectData++;
        if($pincode>99999 && $pincode<1000000) $currectData++;
        if($currectData==2){
            $query = "INSERT INTO office(states ,district ,addrs ,typ  , headoffice,pincode ,addedTime 
            ,openingtime ,closingtime ,contact) VALUE('$state','$district','$address','$type'
            ,'$headOffice','$pincode',NOW(),'$selectedotime','$selectedctime','$mobileno')";
            $data=mysqli_query($conn,$query);
            if($data){   
                $waitstart=true;
            } else {
                $error='Failed';
            }

        }
        unset($_POST);
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
            <h2   > Add new Office</h2>
                <p>
                    Choose office type
                    <select name="officetype">
                    <option value="1">Sub Office</option>
                    <option value="2">Office</option>
                    <option value="3">Main office</option>
                    <option value="4">Head office</option>
                    </select>
                </p>
                <input type="text" placeholder="Enter State name" name="state" required>
                <input type="text" placeholder="Enter District name" name="district" required>
                <input type="text" placeholder="Enter local address" name="address" required>
                <input type="text" placeholder="Enter contact number" name="mobileno" required>
                <?php if($officetype!=4) echo "<input type='text' placeholder='Enter head Office id' name='headoffice'>";?>
                <input type="text" placeholder="Enter pin code" name="pincode" required>
                Opening time <input type="time" name="otime" value=<?php echo $tempotime; ?>  >
                Closing time <input type="time" name="ctime" value=<?php echo $tempctime; ?> ><br><br>
                <?php 
                    if($datareceived){
                        if(!$error=='') echo"<font color='red'>$error</font><br>";
                    }
                ?>
                <input type="submit" name="submit"><br>
                <a href="admin.php"> Back to Home</a>
                <br>
            </form>

        </div>
    </body>
</html>

<?php
    if($waitstart){
        session_start();
        $_SESSION['returnlocation']='admin.php';
        header('Location:successfully.php');
        exit(0);
    }
?>