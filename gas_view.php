<!-- 2407 박현준 -->

<?php
    include 'db_info.php';
    include 'header.php';
?>

<?php
  //MYSQL연결한다
   //데이터를 읽어오는 쿼리를 작성한다
   $query = "select * from gas order by num desc limit 1;";
   //쿼리를 실행한다
   $conn = mysqli_connect('localhost', $db_id, $db_pw, $db_name);
   //결과를 출력한다
   $result = mysqli_query($conn, $query);
   echo "<table border=1 style='font-size: 30px; background: #ECECEC' width=100% text-align=center>"; 
      echo "<tr>"; 
    echo "<th>번호</th>";
    echo "<th>가스</th>";
    echo "<th><a style='color: red'>가스농도 위험도</a></th>";
    echo "<th>조도</th>";
    echo "<th>낮 밤 구분</th>";
    echo "<th>업로드</th>";
    echo "</tr>";
   while($row = mysqli_fetch_assoc($result)){
    $gas_result = "";
    $cds_result = "";
    if($row['gas'] >=10) {
       $gas_result = '위험';
    } else {
      $gas_result = '정상';
    }

    if($row['cds'] >= 1000) {
      $cds_result = '밤';
    } else {
      $cds_result = '낮';
    }
    echo "<tr style='text-align: center'>";
    echo "<td>".$row['num']."</td>";
    echo "<td>".$row['gas']."</td>";
    echo "<td>" .$gas_result. "</td>";
    echo "<td>".$row['cds']."</td>";
    echo "<td>" .$cds_result. "</td>";
    echo "<td>".$row['date']."</td>";
    echo "</tr>";
  }

?>

<?php include 'footer.php'; ?>