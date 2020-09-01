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
foreach ($a['records']['location']as $i) {
    $cityName=  $i['parameter'][0]['parameterValue'];
    $date = $i['time']['obsTime'];
    $hour = $i['weatherElement'][0]['elementValue'];
    $oneday = $i['weatherElement'][1]['elementValue'];
    $citySql = "select cityId from City where cityName = '$cityName';";
    $cityresult = mysqli_fetch_assoc(mysqli_query($link,$citySql));
    $cityId = $cityresult['cityId'];
    // $rainSql = "insert into rain(`date`,cityId,hour,`24hour`)value('$date','$cityId','$hour','$oneday')";
    // mysqli_query($link,$rainSql);
    $sql = "select `date` from rain where id = '$count'";
    $sqlresult = mysqli_fetch_assoc(mysqli_query($link,$sql));
    if (date('Y-m-d H:i:s',(time()-(10*60))) > $sqlresult ['date']){
        $currentSql = "update rain set `date` = '$date', hour = '$hour', `24hour` = '$oneday' where id = $count ";
        mysqli_query($link,$currentSql);
    }
    $count++;
}

?>
