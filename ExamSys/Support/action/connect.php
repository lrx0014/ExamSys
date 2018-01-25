<?php

error_reporting(E_ALL & ~E_DEPRECATED);

$con = mysql_connect("127.0.0.1", "Exam", "exam1234");
mysql_query("set names 'utf8'",$con);
$dbLink = mysql_select_db("Examdb",$con);


if (!$con) {
    die('Could not connect: ' . mysql_error());
    return;
}

if(!$dbLink){
    die('Could not use dbLink: ' . mysql_error());
    return;
}