<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>index</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
	<form method="post">
	<div class = "container">
		<select name="letter" id="letter">
			<option value="1">雲林</option>
			<option value="2">南投</option>
			<option value="3">連江</option>
            <option value="4">台東</option>
			<option value="5">金門</option>
			<option value="6">宜蘭</option>
            <option value="7">屏東</option>
			<option value="8">苗栗</option>
			<option value="9">澎湖</option>
            <option value="10">台北</option>
			<option value="11">新竹縣</option>
			<option value="12">花蓮</option>
            <option value="13">高雄</option>
            <option value="14">彰化</option>
			<option value="15">新竹市</option>
			<option value="16">新北</option>
            <option value="17">基隆</option>
			<option value="18">台中</option>
			<option value="19">台南</option>
            <option value="20">桃園</option>
            <option value="21">嘉義縣</option>
            <option value="22">嘉義市</option>
		</select>
        <select name="php" id="php">
            <option value="Week">一週天氣</option>
            <option value="current">當前天氣</option>
            <option value="rain">雨量累積</option>
            <option value="TwoDays">未來兩天天氣</option>
        </select>
	</div>

	</form>
	<a  id = "debug" ></a>
	<script> 
	var list = new Array();
	$(document).ready(function(){
		function setting(){	
            let selecterletter = $("#letter option:selected").val();
            let filename = $("#php option:selected").val();
			let serverurl = `${filename}.php?letter=${selecterletter}`;
			if(filename == "Week"){
				$.ajax({
					type: "get",
					url: serverurl,
				}).then(function(e){
					let obj = JSON.parse(e)
					$("#th").empty();
					$("#td").empty();
					$("#th").append(
						$("<th></th>").html("時間"),
						$("<th></th>").html("星期"),
						$("<th></th>").html("溫度"),
						$("<th></th>").html("狀態")
					)
					for(let i = 0;i<14;i++){
						$("#td").append(
							$('<tr></tr>').append(
								$('<td></td>').html(obj[i].startDate+"~"+obj[i].endDate),
								$('<td></td>').html(obj[i].weekday),
								$('<td></td>').html(obj[i].temp),
								$('<td></td>').html(obj[i].status)
							)
						);
					}
				})
			}
			if(filename == "current"){
				$.ajax({
					type: "get",
					url: serverurl,
				}).then(function(e){
					if(selecterletter == 15){
						$("#th").empty();
						$("#td").empty();
						$("<th></th>").html("哭").appendTo("#th");
					}else{
						let obj = JSON.parse(e)
						$("#th").empty();
						$("#td").empty();
						$("#th").append(
						$("<th></th>").html("最近更新時間"),
						$("<th></th>").html("溫度")
					)
						$("<td></td>").html(obj.date).appendTo("#td");
						$("<td></td>").html(obj.temp).appendTo("#td");
					}
					
				})
			}
			if(filename == "rain"){
				$.ajax({
					type: "get",
					url: serverurl,
				}).then(function(e){
					let obj = JSON.parse(e)
					$("#th").empty();
					$("#td").empty();
					$("#th").append(
						$("<th></th>").html("最近更新時間"),
						$("<th></th>").html("一小時累積雨量："),
						$("<th></th>").html("24小時累積雨量")
					)
					$("#td").append(
						$('<tr></tr>').append(
							$('<td></td>').html(obj[1].date),
							$('<td></td>').html(obj[0].rain),
							$('<td></td>').html(obj[1].rain)
						)
					);
				})
			}
			if(filename == "TwoDays"){
				$.ajax({
					type: "get",
					url: serverurl,
				}).then(function(e){
					let obj = JSON.parse(e)
					$("#th").empty();
					$("#td").empty();
					$("#th").append(
						$("<th></th>").html("時間"),
						$("<th></th>").html("星期"),
						$("<th></th>").html("溫度"),
						$("<th></th>").html("狀態")
					)
					for(let i = 0;i<24;i++){
						$("#td").append(
							$('<tr></tr>').append(
								$('<td></td>').html(obj[i].startDate),
								$('<td></td>').html(obj[i].weekday),
								$('<td></td>').html(obj[i].temp+"度"),
								$('<td></td>').html(obj[i].status)
							)
						);
					}
				})
			}
		}
        $("#letter").change(setting); 
        $("#php").change(setting); 
		setting();
	})
	</script>
	<div>
		<!-- <img src ="amy_jones.jpg"> -->
	</div>
	<div class="container">
	<table class="table table-striped">
    <thead>
      <tr id = "th">   
      </tr>
    </thead>
    <tbody  id = "td" >   
    </tbody>
  </table>
</div>
</body>
</html>