<?php
header("content-type: text/html; charset=utf-8");
require("config.php");
session_start();
$TimeSql = "select startDate,endDate from twoDays where id= '2';";
$Time = mysqli_fetch_assoc(mysqli_query($link,$TimeSql)); 
if(date('Y-m-d H:i:s') > $Time['endDate']){
    $_SESSION["test"] ="https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-EAD35A23-4827-4F86-85CF-E4898711F30C&elementName=PoP12h,T,WeatherDescription";
    require("curl.php");
}
$id = 1 ;
$date = $a['records']['locations'][0]['location'][0]['weatherElement'][2]['time'][0]['startTime'];
if($date > $Time['startDate']){
    // echo 'update'."<br>";
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
    $sql = "select * ,WEEKDAY(startDate) as weekday from twoDays where cityId = $getid";
    $ewo = mysqli_query($link,$sql);
    $array = [];
    while($d = mysqli_fetch_assoc($ewo) ){
        // echo $d["startDate"]."~".$d["endDate"]."\t".$d['status']."\t".$d["temp"]."<br>"; 
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
        $array[] = $d;
    }  
    echo json_encode($array);
}
?>
