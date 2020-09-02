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
$id =1; //weekWeather's id in mysql 
$TimeSql = "select startDate from weekWeather where cityId = '1';";
$Time = mysqli_fetch_assoc(mysqli_query($link,$TimeSql)); // get oldest endDate 
$Date = $a['records']['locations'][0]['location'][0]['weatherElement'][1]['time'][0]['startTime'];
if( $Date > $Time['startDate']){ //compare newTime and oldestTime 
    echo 'update'."<br>";
    foreach ($a['records']['locations'][0]['location']as $i) {
        $cityName=  $i['locationName']; //get cityName
        $citySql = "select cityId from City where cityName = '$cityName';";
        $cityresult = mysqli_fetch_assoc(mysqli_query($link,$citySql));
        $cityId = $cityresult['cityId']; //get cityId from cityDatabase if cityName = cityId
        for($count=0;$count<14;$count++ ){
            $startDate = $i['weatherElement'][1]['time'][$count]['startTime'];
            $endDate = $i['weatherElement'][0]['time'][$count]['endTime'];
            $temp = $i['weatherElement'][1]['time'][$count]['elementValue'][0]['value']."~".$i['weatherElement'][2]['time'][$count]['elementValue'][0]['value'] ."度 ";
            $status = $i['weatherElement'][0]['time'][$count]['elementValue'][0]['value'];
            mysqli_query($link,"update weekWeather set `startDate` = '$startDate',`endDate`='$endDate',temp = '$temp',`status`='$status' where id = $id ");
            $id++; 
        }        
    }   
}

if(isset($_GET["letter"])){
    $getid = $_GET["letter"];
    $sql = "select *,WEEKDAY(startDate) as weekday from weekWeather where cityId = $getid";
    $ewo = mysqli_query($link,$sql);
    while($d = mysqli_fetch_assoc($ewo) ){
        $numer = $d['weekday'];
        $week = "";
        switch($numer){
            case 0 : 
                $week = "星期一";
            break;
            case 1 : 
                $week = "星期二";
            break;
            case 2 : 
                $week = "星期三";
            break;
            case 3 : 
                $week = "星期四";
            break;
            case 4 : 
                $week = "星期五";
            break;
            case 5 : 
                $week = "星期六";
            break;
            case 6 : 
                $week = "星期日";
            break;
        }
        
        echo $week."\t".$d["startDate"]."~".$d["endDate"]."\t".$d['status']."\t".$d["temp"]."<br>";  
    }  
}


?>
