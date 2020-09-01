<?php
header("content-type: text/html; charset=utf-8");

// 1. 初始設定
$ch = curl_init();

// 2. 設定 / 調整參數
curl_setopt($ch, CURLOPT_URL, "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-EAD35A23-4827-4F86-85CF-E4898711F30C&elementName=PoP12h,T,WeatherDescription");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);

// 3. 執行，取回 response 結果
$pageContent = curl_exec($ch);

// 4. 關閉與釋放資源

//  echo htmlspecialchars($a);
$a = json_decode($pageContent,true);
// var_dump($a);

foreach ($a['records']['locations'][0]['location']as $i) {
    echo $i['locationName']."      "."<br>";
    for($count=0;$count<24;$count++ ){
        echo $i['weatherElement'][2]['time'][$count]['startTime']." ~ ".$i['weatherElement'][2]['time'][$count]['endTime']."    ";
        // echo $i['weatherElement'][1]['time'][$count]['elementValue'][0]['value']. "~".$i['weatherElement'][2]['time'][$count]['elementValue'][0]['value'] ."度   ";
        // echo $i['weatherElement'][0]['time'][$count]['elementValue'][0]['value']. "  "."<br>";
        echo $i['weatherElement'][2]['time'][$count]['elementValue'][0]['value']."<br>";
    }
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
   
}
//SELECT * from time where db like"2020-09-01%"
?>
