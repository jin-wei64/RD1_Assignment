<?php
require("config.php");
$id = $_GET['letter'];
$sql = "select cityImg from City where cityId = $id ;";
$row = mysqli_fetch_assoc(mysqli_query($link,$sql));
echo $row['cityImg']
?>