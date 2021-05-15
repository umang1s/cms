<?php
    include('../php/localMethod.php');
   // error_reporting(0);

   session_start(); //user id
    $userid;
    $usertype;
    $olduser=false;
    if(isset($_SESSION['loggedIn'])) {$userid=$_SESSION['userId']; $olduser=true;}
    else if(isset($_SESSION['tempUser']) && isset($_SESSION['temptype'])) {
        $userid=$_SESSION['tempUser'];$usertype=$_SESSION['temptype'];}
    else {
        header('Location: login.php');
        exit(0);
    }
    $paaswordCorrect=false;
    $error='';
    $datareceived=false;
    $waitstart=false;
    if(isset($_POST['submit'])){
        $datareceived=true;
        $pass1=$_POST['password1'];
        $pass2=$_POST['password2'];
        if($pass1==$pass2){
            if(validateInput($pass1,2)) $paaswordCorrect=true;

        }else{
            $error='password did not matched';
            $paaswordCorrect=false;
        }
        if($paaswordCorrect ){
            include('../php/connection.php');
            $password=md5($pass1);
            $query="UPDATE employee_table SET passwords='$password' WHERE id='$userid'";
            $data = mysqli_query($conn,$query);
            if($data){
                $error='UPDATED Successfully';
                $waitstart=true;
                $type=$result['employeetype'];
                if(!$olduser){
                  $_SESSION['loggedIn']=$usertype;
                $_SESSION['userId']=$userid;  
                }
            }else $error='Failed';
        }
        unset($_POST);
    }
 ?>

<html>
    <head>
        <title> Login Page</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        
        <div class="divLogin">
            <form action="" method="POST" class="loginContainer">
            <h2   > Set new Password</h2>
                <input type="password" placeholder="Create new password" name="password1">
                <input type="password" placeholder="Confirm password" name="password2">
                <?php 
                    if($datareceived){
                        if(!$paaswordCorrect) echo"<font color='red'>Please enter password</font><br>";
                        if(!$error=='') echo"<font color='red'>$error</font><br>";
                    }
                ?>
                <input type="submit" name="submit"><br>
                <br>
                
            </form>

        </div>
    </body>
</html>

<?php
    if($waitstart){
        session_start();
        $_SESSION['returnlocation']='login.php';
        header('Location:successfully.php');
        exit(0);
    }
?>