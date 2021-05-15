<?php
    include('../php/localMethod.php');
   // error_reporting(0);
   session_start(); //user id
   if(isset($_SESSION['loggedIn'])){
       if($_SESSION['usertype']<3)    header('Location: admin.php');
       else header('Location: office.php');
       exit(0);
   }
   session_abort();
    $emailCorrect=false;
    $paaswordCorrect=false;
    $error='';
    $datareceived=false;
    if(isset($_POST['submit'])){
        $datareceived=true;
        $email=$_POST['email'];
        $tempPass=$_POST['password'];
        if(validateInput($email,0)) $emailCorrect=true;
        else $emailCorrect=false;
        if(validateInput($tempPass,2)) $paaswordCorrect=true;
        else $paaswordCorrect=false;
        if($paaswordCorrect &&$emailCorrect){
            include('connection.php');
            $password=md5($tempPass);
            $query="SELECT * FROM employee_table WHERE emailid='$email'";
            $data = mysqli_query($conn,$query);
            $totalFound=mysqli_num_rows($data);
            if($totalFound==1){
                session_start();
                $result= mysqli_fetch_assoc($data);
                if($result['passwords']==$password){
                    $type=$result['employeetype'];
                    $_SESSION['loggedIn']=$type;
                    $_SESSION['userId']=$result['id'];
                    checkLogin();
                } else $error='Wrong password';
                
            } else {
                $error='NO such Email found !';
            }
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
            <h2   > Login</h2>
                <input type="text" placeholder="Enter your email" name="email" required>
                <?php 
                    if($datareceived){
                        if(!$emailCorrect) echo"<font color='red'>Wrong email<br>";
                    }
                ?>
                <input type="password" placeholder="password" name="password">
                <?php 
                    if($datareceived){
                        if(!$paaswordCorrect) echo"<font color='red'>Please enter password</font><br>";
                        if(!$error=='') echo"<font color='red'>$error</font><br>";
                    }
                ?>
                <input type="submit" name="submit"><br>
                <a href="../"> Back to Home</a>&nbsp; &nbsp;<a href="forgotPassword.php"> Forgot Password</a>
                <br>
                
            </form>

        </div>
    </body>
</html>