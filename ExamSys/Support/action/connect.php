<?php

error_reporting(E_ALL & ~E_ERROR);

/// db信息从环境变量获取
$IP      = getenv('DB_ADDR');     // 数据库IP端口
$DB_USER = getenv('DB_USER');     // 用户名
$DB_PWD  = getenv('DB_PWD');      // 密码
$DB_NAME = "examdb";              // 数据库名

$con = mysql_connect($IP, $DB_USER, $DB_PWD);
mysql_query("set names 'utf8'",$con);
$dbLink = mysql_select_db($DB_NAME,$con);


if (!$con) {
    die("Could not connect(db_addr=$IP,db_user=$DB_USER, db_name=$DB_NAME): " . mysql_error());
    return;
}

if(!$dbLink){
    die('Could not use dbLink: ' . mysql_error());
    return;
}