<?php

error_reporting(E_ALL & ~E_DEPRECATED);

/// 此处可更改数据库用户
$IP      = "127.0.0.1";
$DB_USER = "Exam";
$DB_PWD  = "exam1234";

$con = mysql_connect($IP, $DB_USER, $DB_PWD);
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