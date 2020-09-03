<?php
header("content-type: text/html; charset=utf-8");
require("config.php");
session_start();
$TimeSql = "select startDate,endDate from weekWeather where cityId = '1';";
$Time = mysqli_fetch_assoc(mysqli_query($link,$TimeSql)); // get oldest endDate 
if( date('Y-m-d H:i:s') > $Time['endDate']){
    $_SESSION["test"] ="https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-EAD35A23-4827-4F86-85CF-E4898711F30C&format=JSON&elementName=MinT,MaxT,Wx";
    require("curl.php");
}
$id =1; //weekWeather's id in mysql 
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
    $array = [];
    while($d = mysqli_fetch_assoc($ewo) ){
        $d['weekday'];
        switch($d['weekday']){
            case 0 : 
                $d['weekday'] = "星期一";
            break;
            case 1 : 
                $d['weekday']= "星期二";
            break;
            case 2 : 
                $d['weekday']= "星期三";
            break;
            case 3 : 
                $d['weekday']= "星期四";
            break;
            case 4 : 
                $d['weekday'] = "星期五";
            break;
            case 5 : 
                $d['weekday']= "星期六";
            break;
            case 6 : 
                $d['weekday']= "星期日";
            break;
        }
        
        // echo $week."\t".$d["startDate"]."~".$d["endDate"]."\t".$d['status']."\t".$d["temp"]."<br>"; 
        
        $array[] = $d;
    }  
    echo json_encode($array);
}
    
?>
