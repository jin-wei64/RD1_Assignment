<?php
session_start();
// 1. 初始設定
$ch = curl_init();
$url = $_SESSION["test"];
// 2. 設定 / 調整參數
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);

// 3. 執行，取回 response 結果
$pageContent = curl_exec($ch);

// 4. 關閉與釋放資源

//  echo htmlspecialchars($a);
$a = json_decode($pageContent,true);
unset($_SESSION["test"]);
// echo $_SESSION["test"]

?>