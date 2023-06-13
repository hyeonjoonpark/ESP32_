<!-- 2407 박현준 -->

<?php
  include 'db_info.php';
  //MYSQL연결한다
   //데이터를 읽어오는 쿼리를 작성한다
   $query = "select * from gas order by num desc limit 1;";
   //쿼리를 실행한다
   $conn = mysqli_connect('localhost', $db_id, $db_pw, $db_name);
   //결과를 출력한다
   $result = mysqli_query($conn, $query);
   $row = mysqli_fetch_assoc($result);

    echo json_encode($row);
?>