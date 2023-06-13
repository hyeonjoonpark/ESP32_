<!-- 2407 박현준 -->

<?php
	include 'header.php';
?>


<!DOCTYPE html>
<html>
<head>
<title>NOCKANDA EXAMPLE</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js"></script>
<script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js "></script> 
<script>
	$(document).ready(function() { 
		// 로드가 완벽히 되었을 떄
		setInterval(function() { 
			$.ajax({ 
				url:  "download.php?did=" + mydid, 
				method:  "GET", 
				dataType:  "text", 
				success: function(data) { 
					var mydata = JSON.parse(data);
					chart.data.datasets[0].data = mydata.temp;
					chart.data.datasets[1].data = mydata.humi;
					chart.data.labels = mydata.label;
					chart.update();
					// $( "#result ").html(data); 
				} 
			}) 
		},1000); 
	}); 
	function test1() {
		console.log('test1 호출됨')
		chart.data.datasets[0].data = [10, 0, 10, 0, 10, 0, 10];
		chart.data.datasets[1].data = [0, 10, 0, 10, 0, 10, 0];
		chart.update();
	}
	function test2() {
		console.log('test2 호출됨')
		chart.data.datasets[0].data = [0, 10, 0, 10, 0, 10, 0];
		chart.data.datasets[1].data = [10, 0, 10, 0, 10, 0, 10];
		chart.update();
	}
	function set_did(did) {
		mydid=did;
		console.log(did);
	}
</script>

</head>

<?php
include 'db_info.php';
  //device table에 있는 디바이스명으로 드롭다운 메뉴를만든다
  $conn = mysqli_connect('localhost', $db_id, $db_pw, $db_name);
  $query = "select * from device;";
  $result = mysqli_query($conn, $query);
  $i=0;
  while($row = mysqli_fetch_assoc($result)) {
	if($i==0) {
		$row['did'];
		echo "<script> var mydid = '".$row['did']."' </script>";
	}
    echo "<button style=\"width: 70px; height: 30px; background: aliceblue; border-radius: 10px\" onclick='set_did(\"".$row['did']."\")' >"
	.$row['did']."</button>". " ";
  }
?>


<body>
<button onClick="test1()" style="width: 70px; height: 30px; background: aliceblue; margin-top: 20px; border-radius: 10px;">test1</button>
<button onClick="test2()" style="width: 70px; height: 30px; background: aliceblue; margin-top: 20px; border-radius: 10px;">test2</button>
<div style="width:100%;">
<canvas id="line1"></canvas>
</div>


<script>
var ctx = document.getElementById('line1').getContext('2d');
var chart = new Chart(ctx, {
	type: 'line',
	data: {
		labels: ['N-6', 'N-5', 'N-4', 'N-3', 'N-2', 'N-1', 'N'],
		datasets: [
				{
					label: 'Temperature',
					backgroundColor: 'transparent',
					borderColor: "red",
					data: [10, 0, 10, 0, 10, 0, 10]
				},

				{
					label: 'Humidity',
					backgroundColor: 'transparent',
					borderColor: "black",
					data: [0, 10, 0, 10, 0, 10, 0]
				}
		]
	},
	options: {}
});

function nockanda_forever(){
	var recv  = window.AppInventor.getWebViewString();
	chart.data.datasets[0].data.shift();
	chart.data.datasets[0].data.push(recv);
	//chart.data.labels.shift();
	chart.update();
}
</script>
</body>
</html>

<?php
	include 'footer.php';
?>