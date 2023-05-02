<?php 
  include 'header.php';
?>

<form method=post action=view.php style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
  <select name="did" > 
<?php
  //device table에 있는 디바이스명으로 드롭다운 메뉴를만든다
  $conn = mysqli_connect('localhost', 'root', '','bssm2_4');
  $query = "select * from device;";
  $result = mysqli_query($conn, $query);
  while($row = mysqli_fetch_assoc($result)){
    echo "<option value='".$row['did']."'>".$row['did']."</option>";
  }
?>
  </select>
  <!--갯수를 10개 20개 30개 중에 선택하고 기본값은 10으로한다!-->
  <ul>
    개수 선택
    <li style="list-style: none;"><input type=radio name=limit value=10 checked> 10개 <BR></li>
    <li style="list-style: none;"><input type=radio name=limit value=20> 20개 <BR></li>
    <li style="list-style: none;"><input type=radio name=limit value=30> 30개 <BR></li>
  </ul>
  <ul style="margin-right: 10px;">
  정렬
  <!--정렬은 오름차순 내림차순으로 하고 기본값은 오름차순이다!-->
  <li style="list-style: none;"><input type=radio name=order value=asc checked> 오름차순 <BR></li>
  <li style="list-style: none;"><input type=radio name=order value=desc> 내림차순 <BR></li>
</ul>
<BR>
<input type=submit value=확인>

</form>

<?php
  if(isset($_POST['did'])){
    //콤보박스에서 유저가 뭔가를 선택해서 submit했다!
  }else{
    //view.php를 유저가 웹브라우저에서 단순히 open
    include 'footer.php';
      exit;
  }

  //MYSQL연결한다
   
   //데이터를 읽어오는 쿼리를 작성한다
   $query = "select * from sensor where did='".$_POST['did']."' order by num ".$_POST['order']." limit ".$_POST['limit'].";";
   echo "<BR>" . $query . "<BR>";
   //쿼리를 실행한다
   $result = mysqli_query($conn, $query);
   //결과를 출력한다
 

   echo "<table border=1 width=100%>"; 
      echo "<tr>";
    echo "<th>번호</th>";
    echo "<th>디바이스아이디</th>";
    echo "<th>온도</th>";
    echo "<th>습도</th>";
    echo "<th>업로드시간</th>";
    echo "</tr>";

   $i = 0;
   while($row = mysqli_fetch_assoc($result)){
    $mylabel[$i] = $row['date'];
    $mytemp[$i] = $row['temp'];
    $myhumi[$i] = $row['humi'];
    if($i == 0){
      $mytemp2 = $row['temp'];
      $myhumi2 = $row['humi'];
    }

    $i++;

    echo "<tr>";
    echo "<td>".$row['num']."</td>";
    echo "<td>".$row['did']."</td>";
    echo "<td>".$row['temp']."</td>";
    echo "<td>".$row['humi']."</td>";
    echo "<td>".$row['date']."</td>";
    echo "</tr>";
  }

  echo "</table>";

   echo "<table border=1 width=100%>";
   echo "<tr align=center><td>";
   include 'temp.php';
   echo "</td><td>";
   include 'humi.php';
   echo "</td></tr>";
   echo "<tr><td colspan=2 width=100%>";
     include 'graph.php';
   echo "</td></tr>";
   echo "</table>";
   include 'footer.php';
?>