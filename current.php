<?php
session_start();
header("content-type: text/html; charset=utf-8");
require("config.php");
$sql = "select `date` from current where id = 1";
$sqlresult = mysqli_fetch_assoc(mysqli_query($link,$sql));
if( date('Y-m-d H:i:s',(time()-(15*60)))>$sqlresult ['date'] ){
    $_SESSION["test"] = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0003-001?Authorization=CWB-EAD35A23-4827-4F86-85CF-E4898711F30C&format=JSON&elementName=TEMP&parameterName=CITY";
    require("curl.php");
}
$count = 1;
if($a['records']['location'][0]['time']['obsTime'] > $sqlresult ['date'] ){  
    // echo 'update'."<br>";
    foreach ($a['records']['location']as $i) {
        $cityName= $i['parameter'][0]['parameterValue'];
        $citySql = "select cityId from City where cityName = '$cityName';";
        $cityresult = mysqli_fetch_assoc(mysqli_query($link,$citySql));
        $cityId = $cityresult['cityId'];
        $date = $i['time']['obsTime'];
        $temp = $i['weatherElement'][0]['elementValue'];
        $currentSql = "update current set `date` = '$date',temp = '$temp' where id = $count ";
        mysqli_query($link,$currentSql);
        $count++;
    }
}
if(isset($_GET['letter'])){
    $getid = $_GET['letter'];
    if($getid == 15 ){
        echo "新竹市哭哭";
    }
    else{
        $avgtemp = "select date_format(`date`,'%H:%i')as `date`, round(avg(temp)) as temp from `current` where cityId = $getid and temp !=-99 GROUP by `date`";
        $row = mysqli_fetch_assoc(mysqli_query($link,$avgtemp)) ;
        // echo "最後更新時間：".$row["date"]."\t"."當前溫度：".$row["temp"];
        echo json_encode($row);
    }
   
}
?>

