<?php
    include('../php/localMethod.php');
    // error_reporting(0);
    session_start(); //user id
    if(!isset($_SESSION['loggedIn'])){
     header('Location: login.php'); exit(0);
    }
    if($_SESSION['loggedIn']>2){
     echo "<h2 align='center' style='color:red;'>Permission Denied</h2>";
     header('Location: office.php');
     exit(0);
    }
    include('connection.php');
     $error='';
     $newId=0;

     if(isset($_POST['submit'])){
        //check all data if correct
        $wpk=$_POST['wpk'];
        $c_time=$_POST['c_time'];
        $o_time=$_POST['o_time'];
        $query54="UPDATE general SET weightperkm='$wpk',otime='$o_time',ctime='$c_time'";
        $dataf=mysqli_query($conn,$query54);
        if(!$dataf){
            $error='Failed to update';
        }
    }
    $query56="SELECT * FROM general";
    $data=mysqli_query($conn,$query56);
    $rowdata=mysqli_fetch_array($data);
    $_GET=array();
    
 ?>

<html>
    <head>
        <title> General Page</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        
        <div class="divLogin">
            <form action="" method="POST" class="loginContainer">
            <h2   >Set Default Parameter</h2>
                Change Price weight/km
                <input type="number" placeholder="enter price weight/km" name="wpk" value=<?php echo $rowdata['weightperkm']; ?> required>
                Opening Time <input type="time"  name="c_time" value=<?php echo $rowdata['otime']; ?> required><br><br>
                Closing Time <input type="time" name="o_time" value=<?php echo $rowdata['ctime']; ?> required><br><br>
                <input type="submit" name="submit"><br>
                <?php 
                    if(!$error=='') echo"<font color='red'>$error</font><br>";
                ?>
                <a href='admin.php'>Go back to Home</a>
            </form>

        </div>
    </body>
</html>