<?php
    include "header.php";
    include "db_info.php";

    $conn = mysqli_connect('localhost', $db_id, $db_pw, $db_name);
    $query = "select * from exam_data order by record_num desc limit 25;"; //*

    $result = mysqli_query($conn, $query);

    echo "<table border=1 width=100%>"; 
    echo "<tr>";
    echo "<th>KEY 값</th>";
    echo "<th>온도</th>";
    echo "<th>습도</th>";
    echo "</tr>"; //*

    while($row = mysqli_fetch_assoc($result)) {
        // $row : 현재 주목된 레코드
        echo "<tr>";
        echo "<td>".$row['record_num']."</td>";
        echo "<td>".$row['temp_data']."</td>";
        echo "<td>".$row['humi_data']."</td>";
        echo "</tr>";
    }


    include "footer.php";
?>