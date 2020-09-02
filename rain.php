<?php
header("content-type: text/html; charset=utf-8");
require("config.php");
// 1. 初始設定
$ch = curl_init();

// 2. 設定 / 調整參數
curl_setopt($ch, CURLOPT_URL, "https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0002-001?Authorization=CWB-EAD35A23-4827-4F86-85CF-E4898711F30C&elementName=RAIN,HOUR_24&parameterName=CITY");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);

// 3. 執行，取回 response 結果
$pageContent = curl_exec($ch);

// 4. 關閉與釋放資源

//  echo htmlspecialchars($a);
$a = json_decode($pageContent,true);
// var_dump($a);
$count = 1;
$sql = "select `date` from rain where id = '1'";
$sqlresult = mysqli_fetch_assoc(mysqli_query($link,$sql));
if ( $a['records']['location'][0]['time']['obsTime'] >  $sqlresult ['date']){
    echo 'update'."<br>";
    foreach ($a['records']['location']as $i) {
        $cityName=  $i['parameter'][0]['parameterValue'];
        $date = $i['time']['obsTime'];
        $hour = $i['weatherElement'][0]['elementValue'];
        $oneday = $i['weatherElement'][1]['elementValue'];
        $citySql = "select cityId from City where cityName = '$cityName';";
        $cityresult = mysqli_fetch_assoc(mysqli_query($link,$citySql));
        $cityId = $cityresult['cityId'];
        $currentSql = "update rain set `date` = '$date', hour = '$hour', `24hour` = '$oneday' where id = $count ";
        mysqli_query($link,$currentSql);
        $count++;
    }
}
if(isset($_GET["letter"])){
    $getid = $_GET["letter"];
    $twentyfour = "select cityId, round(avg(`24hour`),2) as `rain` FROM `rain` where cityId = $getid and `24hour`!=-999;";
    $onehour = "select cityId, round(avg(`hour`),2) as `rain`FROM `rain` where cityId = $getid and `hour`!=-998";
    $TF = mysqli_query($link,$twentyfour);
    $one = mysqli_query($link,$onehour);
    $oneRow= mysqli_fetch_assoc($one);
    $TFRow = mysqli_fetch_assoc($TF) ;
        echo "最近一小時雨量：".$oneRow['rain']."\t"."最近24小時雨量：".$TFRow['rain'];  
     
}
?>
