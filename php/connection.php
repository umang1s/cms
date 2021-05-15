<?php
    $database='cms';
    $username='root';
    $password='';
    $host=$_SERVER['HTTP_HOST'];
    //error_reporting(0);
    $conn = mysqli_connect($host,$username,$password,$database);
    if(!$conn) die("<h2 align='center'>/!\  ERROR  in connecting to DATABASE :( </h2> <br>".mysqli_connect_error);
?>