<?php
header("content-type: text/html; charset=utf-8");
require("config.php");
// 1. 初始設定
$ch = curl_init();
// 2. 設定 / 調整參數
curl_setopt($ch, CURLOPT_URL, "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-EAD35A23-4827-4F86-85CF-E4898711F30C&format=JSON&elementName=MinT,MaxT,Wx");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
// 3. 執行，取回 response 結果
$pageContent = curl_exec($ch);

// 4. 關閉與釋放資源

//  echo htmlspecialchars($a);
$a = json_decode($pageContent,true);
// var_dump($a);

// foreach ($a['records']['locations'][0]['location']as $i) {
//     echo $cityName=  $i['locationName'];
//     $citySql = "select cityId from City where cityName = '$cityName';";
//     $cityresult = mysqli_fetch_assoc(mysqli_query($link,$citySql));
//     $cityId = $cityresult['cityId'];
    echo $startDate = $i['weatherElement'][1]['time'][13]['startTime'];
    echo $endDate = $i['weatherElement'][0]['time'][13]['endTime']  ."<br>";
//     // for($count=0;$count<14;$count++ ){
//     //     $startDate = $i['weatherElement'][1]['time'][$count]['startTime'];
//     //     $endDate = $i['weatherElement'][0]['time'][$count]['endTime'] ;
//     //     $temp = $i['weatherElement'][1]['time'][$count]['elementValue'][0]['value']."~".$i['weatherElement'][2]['time'][$count]['elementValue'][0]['value'] ."度 ";
//     //     $status = $i['weatherElement'][0]['time'][$count]['elementValue'][0]['value'];
        
//     //     // $weekSql = "insert into weekWeather(cityId, startDate, endDate, temp, status)values('$cityId','$startDate','$endDate','$temp','$status')";
//     //     // mysqli_query($link,$weekSql);
//     // }
//     // echo "<br>";
//     // echo "<br>";
//     // echo "<br>";
//     // echo "<br>";
//     // echo "<br>";
//     // echo "<br>";
//     // echo "<br>";
   
// }
if (date('Y-m-d H:i:s')>'2020-09-01 13:00:00'){
    echo "123";
}

?>
