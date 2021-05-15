<?php
    include('connection.php');
    function validationOfOffice($id){
        include('connection.php');
            $query23="SELECT * from office where officeId='$id'";
            $data=mysqli_query($conn,$query23);
            $rows=mysqli_num_rows($data);
            if($rows==0) return false;
            return true;
    }
    function checkLogin(){
        session_start(); //user id
        if(isset($_SESSION['loggedIn'])){
            if($_SESSION['usertype']<3)    header('Location: http://localhost/cms/office/admin.php');
            else header('Location: http://localhost/cms/office/office.php');
            exit(0);
        }
        session_abort();
    }
    function validateInput($input,$operation){
        if($operation==0)return filter_var($input, FILTER_VALIDATE_EMAIL);//0 for email
        else if($operation==1)return preg_match("/^[a-zA-Z-' ]*$/",$input);
        if($input=='') return false;
        else return true;
    }
    function getweightparam(){
        include('connection.php');
        $query28="SELECT * from general";
        $datarets=mysqli_query($conn,$query28);
        $dam=mysqli_fetch_array($datarets);
        return $dam['weightperkm'];
    }
    function addOrderStatus($update ){
        $updateMessage='';
        switch ($update){
            case 1:  $updateMessage='Received'; break;
            case 2: $updateMessage='Dispatched'; break;
            case 3: $updateMessage='Out for delivery'; break;
            case 4: $updateMessage='Failed to Deliver'; break;
            case 5: $updateMessage='Returning'; break;
            case 6: $updateMessage='Delivered'; break;
            default:  break;
        }
        return $updateMessage;
    }
    function getOfficeAddressById($id){
        include('connection.php');
        $query23="SELECT * from office where officeId='$id'";
            $data=mysqli_query($conn,$query23);
            $rows=mysqli_fetch_array($data);
            $retres=$rows['addrs']." , ".$rows['district']." , ". $rows['states'];
            return $retres;
    }

    function getPathResult($orderid){
        include('connection.php');
        $query57="SELECT * FROM path_table where orderId='$orderid'";
        $search57=mysqli_query($conn,$query57);
        $res57=mysqli_fetch_array($search57);
        $arr57=array();
        $start57=1;
        while($start57<21){
            $laspathname="path$start57";
            if($res57[$laspathname]!=0) $arr57[$start57-1]=$res57[$laspathname];
            else break;
            $start57++;
        }
        return $arr57;
    }
    
    function getTotalOffice(){
        $result = mysqli_query($conn,"select * FROM office");
        $total = mysqli_num_rows($result);
        $row=$total;
        echo $row;
        if($total==true) return 0;
        return $total;
    }
    function getTotalOrderNumber(){
        $query = mysqli_query($conn,"select * FROM order_table");
        $total = mysqli_num_rows($query);
        if($total==null) return 0;
        $deliverd=0;
        while($result = mysqli_fetch_assoc($data)){
            if($result['deliveringTime']!=null) $deliverd++;
        }
        return $deliverd;
    }


    //0 for recieved
?>

