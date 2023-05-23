<?php
    include 'db_info.php';
    date_default_timezone_set('Asia/Seoul');
    $conn = mysqli_connect('localhost', $db_id, $db_pw, $db_name);
    $gas = $_GET['gas'];
    $cds = $_GET['cds'];
    $date = date("Y-m-d H:i:s",time());

    $query = "insert into gas(gas, cds, date) values(".$gas.",".$cds.",'".$date."');";
    //SQL쿼리를 실행
    $result = mysqli_query($conn, $query);
    //실행결과 확인
    if($result){
     echo "성공";
    }else{
     echo "실패";
    }
?>