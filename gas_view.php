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
   echo "<table border=1 style='font-size: 30px; background: #ECECEC' width=100%>"; 
      echo "<tr>";
    echo "<th>번호</th>";
    echo "<th>가스</th>";
    echo "<th>조도</th>";
    echo "<th>업로드</th>";
    echo "</tr>";
   while($row = mysqli_fetch_assoc($result)){
    echo "<tr>";
    echo "<td>".$row['num']."</td>";
    echo "<td>".$row['gas']."</td>";
    echo "<td>".$row['cds']."</td>";
    echo "<td>".$row['date']."</td>";
    echo "</tr>";
  }

?>

<?php include 'footer.php'; ?>