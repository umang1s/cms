<?php
    $pincode='';
    $resultFound=false;
    $result;
    $tempadd=array();
    $tempin=array();
    $tempdist=array();
    $tempstate=array();
    $tempopen=array();
    $tempclose=array();
    $tempmob=array();
    if(isset($_POST['pincode'])){
        $pincode=$_POST['pincode'];
        $isnumber=is_numeric($pincode);
        if($isnumber){
            include('connection.php');
            $query = "SELECT * FROM office";
            $result=mysqli_query($conn,$query);
            if(mysqli_num_rows($result)>0) $resultFound=true;
        }
        unset($_POST);
    }
?>

<html>
    <head>
        <title> Tracking</title>
        <link rel="stylesheet" type="text/css" href="../office/table.css">
        <link rel="stylesheet" type="text/css" href="../office/style.css">
    </head>
    <body>
        
        <div class="divLogin">
            <form action="" method="POST" class="loginContainer">
            <h2   >Find Nearest Office</h2>
                <input type="text" placeholder="Enter your pincode" name="pincode" required>
                <?php 
                    if($pincode!=''){
                        if(!$isnumber)echo "<font color='red'>Please Enter only number</font><br>";
                    } 
                ?>
                <input type="submit" name="submit"><br>
                <a href="../"> Back to Home</a>
                <br>
                
            </form>

        </div>

        <?php
            
            if($resultFound){
                $tableno=1;
                echo "<table class='styled-table'>
                        <thead>
                        <tr>
                            <th>S.No</th>
                            <th > address</th>
                            <th>Contact no</th>
                            <th>Opening Time</th>
                            <th>Closing Time</th>
                            <th> pincode</th>
                            <th> district</th>
                            <th>states</th>
                        </tr>
                        </thead><tbody>";
                    $exactfound=false;
                    $nearestFound=0;
                while($rowdata=mysqli_fetch_assoc($result)){
                    if($rowdata['pincode']==$pincode){
                        echo "<tr>
                            <td >".$tableno."</td>
                            <td>".$rowdata['addrs']."</td>
                            <td>".$rowdata['contact']."</td>
                            <td>".$rowdata['openingtime']."</td>
                            <td>".$rowdata['closingtime']."</td>
                            <td>".$rowdata['pincode']."</td>
                            <td>".$rowdata['district']."</td>
                            <td>".$rowdata['states']."</td>
                      </tr>";
                    $exactfound=true;
                    $tableno++;
                    } else{
                        $difference=$rowdata['pincode']-$pincode;
                        if($difference<3 && $difference>-3){
                            $tempadd[$nearestFound]=$rowdata['addrs'];
                            $tempdist[$nearestFound]=$rowdata['district'];
                            $tempin[$nearestFound]=$rowdata['pincode'];
                            $tempstate[$nearestFound]=$rowdata['states'];
                            $tempmob[$nearestFound]=$rowdata['contact'];
                            $tempclose[$nearestFound]=$rowdata['closingtime'];
                            $tempopen[$nearestFound]=$rowdata['openingtime'];
                            $nearestFound++;
                        }
                    }
                } 
                if(!$exactfound){
                    echo "<font color='red'>No Office found to your pincode</font><br> ";
                    if($nearestFound>0){
                        echo "<font color='green'> Outside Near your pincode ".$nearestFound." office found </font>";
                        $startno=0;
                        while($startno<$nearestFound){
                            echo "<tr>
                            <td >".($startno+1)."</td>
                            <td>".$tempadd[$startno]."</td>
                            <td>".$tempmob[$startno]."</td>
                            <td>".$tempopen[$startno]."</td>
                            <td>".$tempclose[$startno]."</td>
                            <td>".$tempin[$startno]."</td>
                            <td>".$tempdist[$startno]."</td>
                            <td>".$tempstate[$startno]."</td>
                      </tr>
                    ";
                            $startno++;
                        }

                    } else echo "<font color='red'>No Office found to near address</font><br> ";
                }
              echo '</tbody></table>';  
            } 
        ?>
    </body>
</html>