<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>index</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
	<form method="post">
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
            <option value="rain">雨天</option>
            <option value="TwoDays">未來兩天天氣</option>
        </select>
        
		<input type="submit" value="OK" /> 
	</form>
	<a  id = "debug" ></a>
	<script> 
	$(document).ready(function(){
		function setting(){	
            let selecterletter = $("#letter option:selected").val();
            let filename = $("#php option:selected").val();
			let serverurl = `${filename}.php?letter=${selecterletter}`;
			$.ajax({
				type: "get",
                url: serverurl
                
			}).then(function(e){
                $("#debug").html(e)
			})
		}
        $("#letter").change(setting); //觸發時重複呼叫
        $("#php").change(setting); 
        setting();
	})
	</script>
</body>
</html>