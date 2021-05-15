<?php

session_start();
$retlocation='http://localhost/cms';
$message='';
if(!isset($_SESSION['returnlocation'])){
    $retlocation=$_SESSION['returnlocation'];
    header('Location: http://localhost/cms');
    exit(0);
}
$retlocation=$_SESSION['returnlocation'];
if(isset($_SESSION['message'])) $message=$_SESSION['message'];



?>

<html>
    <head>
        <title>Success</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        
        <div class="divLogin">
            <div class="loginContainer">
                <br>
                <h1  > Successfully Completed</h1><br>
                <?php if($message!='') echo "<h1 >".$message."</h1>"; ?>
                <a href=<?php echo $retlocation; ?>> Back</a>
            </div>
            
        </div>
    </body>
</html>