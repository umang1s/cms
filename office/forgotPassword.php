<?php
    include('../php/localMethod.php');
   // error_reporting(0);
    checkLogin();
    $error='';  
    if(isset($_POST['submit'])){
        $email=$_POST['email'];
        $mobileno=$_POST['m_no'];
        $id=$_POST['officeid'];
        include('connection.php');
        $query="SELECT * FROM employee_table WHERE id='$id'";
        $data = mysqli_query($conn,$query);
        if(mysqli_num_rows($data)==1){
            echo 'jj';
            session_start();
            $result= mysqli_fetch_assoc($data);
            if($result['mobileno']==$mobileno && $result['emailid']==$email){
                $_SESSION['temptype']=$result['employeetype'];
                $_SESSION['tempUser']=$id;
                header('Location: changePassword.php');
                exit(0);
            }else $error='Invalid mobile no or email';
        } else {
            $error='No record found';
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
            <h2   > Forgot Password</h2>
                <input type="text" placeholder="Enter your email" name="email" required>
                <input type="text" placeholder="Enter your mobile number" name="m_no" required>
                <input type="text" placeholder="Enter your id" name="officeid" required>
                <input type="submit" name="submit"><br>
                <?php 
                    if(!$error=='') echo"<font color='red'>$error</font><br>";
                ?>
                <a href="../"> Back to Home</a>&nbsp; &nbsp;<a href="login.php"> Back to Login</a>
            </form>

        </div>
    </body>
</html>