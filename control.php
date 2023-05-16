<?php
$conn = mysqli_connect('localhost', 'root',  '', 'bssm2_4');
$did = $_GET['did'];

$query = "select * from control where did='".$did."' and checked=0 order by num desc limit 1;";

$result = mysqli_query($conn, $query);
$count = mysqli_num_rows($result);

if($count == 0) {
    $data['pin'] = -1;
    $data['cmd'] = 0;
} else {
    $row = mysqli_fetch_assoc($result);
    $data['pin'] = $row['pin'];
    $data['cmd'] = $row['cmd'];
}

// $data['pin'] = 16;
// $data['cmd'] = 0;
    echo json_encode($data) . "\r\n";
?>