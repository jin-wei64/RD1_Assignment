<?php 
    $link = mysqli_connect("localhost","root","root","weather","8889") or die ( mysqli_connect_error() );
	mysqli_query ( $link, "set names utf8");
?>