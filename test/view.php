<?php
    include "header.php";
    include "db_info.php";

    $conn = mysqli_connect('localhost', $db_id, $db_pw, $db_name); //*
    $query = "select * from test limit 20;"; //*

    $result = mysqli_query($conn, $query);

    echo "<table border=1 width=100%>"; 
    echo "<tr>";
    echo "<th>번호</th>";
    echo "<th>온도</th>";
    echo "<th>습도</th>";
    echo "</tr>"; //*

    while($row = mysqli_fetch_assoc($result)) {
        // $row : 현재 주목된 레코드
        echo "<tr>";
        echo "<td>".$row['num']."</td>";
        echo "<td>".$row['temp']."</td>";
        echo "<td>".$row['humi']."</td>";
        echo "</tr>";
    }



    include "footer.php";
?>