<?php
    include "header.php";
    include "db_info.php";
    $temp = $_GET['t']; //*
    $humi = $_GET['h']; //*

    $conn = mysqli_connect('localhost', $db_id, $db_pw, $db_name);
    $query = "insert into exam_data(temp_data, humi_data) values(". $temp .", ". $humi .");";
    $result = mysqli_query($conn, $query);
    if($result){
        echo "성공";
    } else {
        echo "실패";
    }

    include "footer.php";
?>