<?php
// DB에서 데이터를 최대 7개 꺼내서 만든다
    $conn = mysqli_connect('localhost', 'root', '','bssm2_4');
    $query = "select * from sensor where did='".$_GET['did']."' order by num desc limit 15;";
    $result = mysqli_query($conn, $query);
    $i = 0;
    while($row = mysqli_fetch_assoc($result)){
        $dataset['label'][$i] = $row['date'];
        $dataset['temp'][$i]  = $row['temp'];
        $dataset['humi'][$i]  = $row['humi'];
        $i++;
    }
    // $dataset['label'] = ['a', 'b', 'c', 'd', 'e', 'f', 'g'];
    // $dataset['temp'] = [1, 2, 3, 4, 5, 6, 7];
    // $dataset['humi'] = [8, 9, 10, 11, 12, 13, 14];

    echo json_encode($dataset);
?>