<?php
header("content-type: text/html; charset=utf-8");
require("config.php");
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
$id = 1 ;
$date = $a['records']['locations'][0]['location'][0]['weatherElement'][2]['time'][0]['startTime'];
$TimeSql = "select startDate from twoDays where id= '1';";
$Time = mysqli_fetch_assoc(mysqli_query($link,$TimeSql)); 
if($date > $Time['startDate']){
    echo 'update'."<br>";
    foreach ($a['records']['locations'][0]['location']as $i) {
        $cityName = $i['locationName'];
        $citySql = "select cityId from City where cityName = '$cityName';";
        $cityresult = mysqli_fetch_assoc(mysqli_query($link,$citySql));
        $cityId = $cityresult['cityId'];
        for($count=0;$count<24;$count++ ){
            $startTime = $i['weatherElement'][2]['time'][$count]['startTime'];
            $endTime = $i['weatherElement'][2]['time'][$count]['endTime'];
            $temp =$i['weatherElement'][1]['time'][$count]['elementValue'][0]['value'];
            $status = $i['weatherElement'][2]['time'][$count]['elementValue'][0]['value'];
            $updateSql = "update twoDays set `startDate` = '$startTime',`endDate` = '$endTime', `temp` = '$temp', `status` = '$status' where id = $id ;" ;
            mysqli_query($link,$updateSql);
            $id++;
        }
    }
}
//SELECT * from time where db like"2020-09-01%"
 // print_r(explode("。",$status));
 if(isset($_GET["letter"])){
    $getid = $_GET["letter"];
    $sql = "select * from twoDays where cityId = $getid";
    $ewo = mysqli_query($link,$sql);
    while($d = mysqli_fetch_assoc($ewo) ){
        echo $d["startDate"]."~".$d["endDate"]."\t".$d['status']."\t".$d["temp"]."<br>";  
    }  
}
?>
