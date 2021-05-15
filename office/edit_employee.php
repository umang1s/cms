<?php

    //cms/office/
    include('../php/localMethod.php');
   // error_reporting(0);
   session_start();
   if(!isset($_SESSION['loggedIn']) || !isset($_GET['id'])){
    header('Location: login.php'); exit(0);
   }
   $iddd=$_GET['id'];
   if($_SESSION['loggedIn']>2 && $iddd!=$_SESSION['userId']){
    echo "<h2 align='center' style='color:red;'>Permission Denied</h2>";
    header('Location: office.php');
    exit(0);
   }
   include('connection.php');
   $query58="SELECT * FROM employee_table WHERE id='$iddd'";
   $datarec=mysqli_query($conn,$query58);
   $rowData=mysqli_fetch_array($datarec);
    $error='';
    $datareceived=false;
    $waitstart=false;
    if(isset($_POST['submit'])){
        $datareceived=true;
        $type=$_POST['emptype'];
        $officeId=$_POST['officeid'];
        $name=$_POST['name'];
        $email=$_POST['email'];
        $address=$_POST['address'];
        $mobileno=$_POST['mobileno'];
        if($_SESSION['loggedIn']>2 && $_SESSION['loggedIn']!=$type) $error="you can't change your post yourself";
        else if(validationOfOffice($officeId) ){
            $query = "UPDATE employee_table SET emailid='$email',empName='$name',employeetype='$type',
            officeId='$officeId' ,mobileno ='$mobileno',addrs='$address' WHERE id='$iddd'";
                $data=mysqli_query($conn,$query);
                if($data){   
                    $waitstart=true;
                } else {
                    $error='Failed to Update';
                }
            
        }else $error='Invalid office id'; 
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
            <h2   > Add new Employee</h2>
                <p>
                    Choose Employee Type
                    <select name="emptype">
                    <option value="1"<?php echo (($rowData['employeetype']==1)?'selected="selected"':'')?>>Admin</option>
                    <option value="2"<?php echo (($rowData['employeetype']==2)?'selected="selected"':'')?>>Manager</option>
                    <option value="3"<?php echo (($rowData['employeetype']==3)?'selected="selected"':'')?>>Staff</option>
                    <option value="4"<?php echo (($rowData['employeetype']==4)?'selected="selected"':'')?>>Postman</option>
                    </select>
                </p>
                <input type="text" placeholder="Enter name" name="name" value=<?php echo $rowData['empName']; ?> required>
                <input type="text" placeholder="Enter email" name="email" value=<?php echo $rowData['emailid']; ?> required>
                <input type="text" placeholder="Enter Permanent address" value=<?php echo $rowData['addrs']; ?> name="address" required>
                <input type="text" placeholder="Enter office id" name="officeid" value=<?php echo $rowData['officeId']; ?> required>
                <input type="text" placeholder="Enter mobile no" name="mobileno" value=<?php echo $rowData['mobileno']; ?> required>
                <?php 
                    if($datareceived){
                        if(!$error=='') echo"<font color='red'>$error</font><br>";
                    }
                ?>
                <input type="submit" name="submit"><br>
                <a href=<?php if($_SESSION['loggedIn']<3) echo "view_employee.php"; else echo"login.php"; ?>> Back to Home</a>
                <br>
            </form>

        </div>
    </body>
</html>

<?php
    if($waitstart){
        session_start();
        if($_SESSION['loggedIn']<3) $_SESSION['returnlocation']="view_employee.php"; 
        else $_SESSION['returnlocation']='login.php';
        header('Location:successfully.php');
        exit(0);
    }
?>