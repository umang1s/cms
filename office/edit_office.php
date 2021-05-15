<?php
    //  cms/office/
    session_start();
    if(!isset($_SESSION['loggedIn']) || !isset($_SESSION['userId']) || !isset($_GET['id'])){
        header('Location: login.php') ;
        exit(0);
    }
    include('../php/localmethod.php');
    $waitstart=false;
    $loggedId=$_SESSION['loggedIn'];
    include('connection.php');
    $error='';
    $idd=$_GET['id'];
    if($loggedId>2){
        echo "<h2 align='center' style='color:red;'>Permission Denied</h2>";
        header('Locataion: office.php');
        exit(0);
    }
    if(isset($_POST['submit'])){
        //check all data if correct
        $addresss=$_POST['address'];
        $mobileno=$_POST['mobileno'];
        $headoffice=$_POST['headoffice'];
        $officetype=$_POST['officetype'];
        $pincodes=$_POST['pincode'];
        $otime=$_POST['otime'];
        $ctime=$_POST['ctime'];
        if($officetype!=4){
            if($headoffice=='') $error='Head office ID Required';
            if(!validationOfOffice($headoffice)) $error='Invalid Head Office ';
        }
        if($error==''){
            $query54="UPDATE office SET addrs='$addresss',contact='$mobileno',typ='$officetype',
            headoffice='$headoffice',pincode='$pincodes',openingtime='$otime',closingtime='$ctime'
             WHERE officeId='$idd'";
            $status=mysqli_query($conn,$query54);
            if($status) $waitstart=true;
            else $error='failed to update';
        }
    }
    if(!isset($_GET['id']) || $loggedId>3){
        echo "<h2 align='center' style='color:orange;'>Permission Denied</h2>";
        header('Location: login.php');
        exit(0);
    }
    $query55="SELECT * FROM office WHERE officeId='$idd'";
    $data=mysqli_query($conn,$query55);
    $totalRows=mysqli_num_rows($data);
    if($totalRows==0){
        "<br><br><h1 align='center' style='color:red;'>No Office found </h1><br>";
        header('Location: login.php');
       exit(0);
    }else{
        $rowdata=mysqli_fetch_array($data);
    }
    $_GET=array();
?>
<html>
    <head>
        <title>Edit Office</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        
        <div class="divLogin">
            <form action="" method="POST" class="loginContainer">
            <h2   > Edit Office</h2>
                <p>
                    change office type
                    <select name="officetype" >
                    <option value="1"<?php echo (($rowdata['typ']==1)?'selected="selected"':'')?>>Sub Office</option>
                    <option value="2"<?php echo (($rowdata['typ']==2)?'selected="selected"':'')?>>Office</option>
                    <option value="3"<?php echo (($rowdata['typ']==3)?'selected="selected"':'')?>>Main office</option>
                    <option value="4"<?php echo (($rowdata['typ']==4)?'selected="selected"':'')?>>Head office</option>
                    </select>
                </p>
                <input type="text" placeholder="Enter local address" name="address" value=<?php echo $rowdata['addrs'];?> required>
                <input type="text" placeholder="Enter contact number" name="mobileno" value=<?php echo $rowdata['contact'];?> required>
                <?php if($rowdata['typ']!=4) echo "<input type='text' placeholder='Enter head Office id' name='headoffice' value=$rowdata[headoffice]>";?>
                <input type="text" placeholder="Enter pin code" name="pincode" value=<?php echo $rowdata['pincode'];?> required>
                Opening time <input type="time" name="otime" value=<?php echo $rowdata['openingtime'];?> >
                Closing time <input type="time" name="ctime" value=<?php echo $rowdata['closingtime'];?> ><br><br>
                <?php 
                    if($error!='') echo"<font color='red' >$error<\font>";
                ?>
                <input type="submit" name="submit"><br>
                <a href="view_office.php"> Back</a>
                <br>
            </form>

        </div>
    </body>
</html>

<?php
    if($waitstart){
        session_start();
        $_SESSION['returnlocation']='view_office.php';
        header('Location:successfully.php');
        exit(0);
    }
?>