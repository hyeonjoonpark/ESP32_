<!-- 2407 박현준 -->


<?php
    include 'header.php';
?>

<script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js "></script> 
<script>


    $(document).ready(function() { 
		// 로드가 완벽히 되었을 떄
		setInterval(function() { 
			$.ajax({ 
				url:"gas_data.php", 
				method:"GET", 
				dataType:"text", 
				success: function(data) { 
				    var mydata = JSON.parse(data);
                    console.log(mydata);
                    $('#mytable').prepend('<tr>'+
                    '<td>'+mydata.num+'</td>'+
                    '<td>'+mydata.gas+'</td>'+
                    '<td>'+mydata.cds+'</td>'+
                    '<td>'+mydata.date+'</td>'+
                    '</tr>');
                    if($('#mytable > tbody tr').length > 10) {
                        $('#mytable > tbody tr:last').remove();
                    } // 행이 10개 이상이면 마지막 행 삭제
				} 
			}) 
		}, 1000); 
	}); 


    function test1() {
        $('#mytable').append('<tr>'+
        '<td>1</td>'+
        '<td>2</td>'+
        '<td>3</td>'+
        '<td>4</td>'+
        '</tr>');
    }

    function test2() {
        $('#mytable').prepend('<tr>'+
        '<td>5</td>'+
        '<td>6</td>'+
        '<td>7</td>'+
        '<td>8</td>'+
        '</tr>');
        if(($('#mytable > tbody tr').length) > 10) {
            $('#mytable > tbody tr:last').remove();
        } // 행이 10개 이상이면 마지막 행 삭제
    }

    function test3() {
        $('#mytable > tbody').empty();
    }

    function test4() {
        console.log($('#mytable > tbody tr').length);
    }

    function test5() {
        $('#mytable > tbody tr:last').remove();
    }

    function test6() {
        if(($('#mytable > tbody tr').length) > 10) {
            $('#mytable > tbody tr:last').remove();
        }
    }
</script>

<button style='margin-top: 20px' onclick=test1()>마지막 행에 출력</button>
<button style='margin-top: 20px' onclick=test2()>첫번째 행에 출력</button>
<button style='margin-top: 20px' onclick=test3()>전체 삭제</button>
<button style='margin-top: 20px' onclick=test4()>개수</button>
<button style='margin-top: 20px' onclick=test5()>마지막 1개 데이터 삭제</button>

<table style='margin-top: 20px' border=1 width=100% id=mytable>
    <thead>
        <tr>
            <td>번호</td>
            <td>가스</td>
            <td>조도</td>
            <td>시간</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
        </tr>
    </tbody>
</table>

<?php 
    include 'footer.php';
?>