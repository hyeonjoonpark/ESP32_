<?php 
  include 'header.php';
?>


<form method=post action="ctr_input_process.php" style="display: block; margin: 30px auto;">
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
    </select><br>

  핀번호 : <input type=text name=pinnum style="margin: 10px auto"><br>
  제어명령 : OFF<input type=radio name=cmd value=0 checked> ON<input type=radio name=cmd value=1> <br>

  <input type=submit value=전송>
</form>



<?php
    include "footer.php";
?>