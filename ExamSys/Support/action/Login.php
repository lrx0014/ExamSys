<?php

error_reporting(E_ALL & ~E_DEPRECATED);
include_once("connect.php");
session_start();
$UserId = "";
$UserPassword = "";
$UserLevel = -1;
if(isset($_POST['UserId']) && isset($_POST['UserPassword']) && isset($_POST['UserLevel'])){
    $UserId       = $_POST['UserId'];
    $UserPassword = md5($_POST['UserPassword']);
    $UserLevel    = $_POST['UserLevel'];
}

$LoginStuSQL     = "SELECT StuName,StuPassword,StuId FROM Student WHERE StuId='".$UserId."';";
$LoginTeacherSQL = "SELECT TeacherName,TeacherId,TeacherPassword FROM Teacher WHERE TeacherId='".$UserId."';";
$check = "";
$name = "";
$path = "";
if($UserLevel==0){
    $res = mysql_query($LoginStuSQL);
    $check = "StuPassword";
    $name = "StuName";
    $path = "Student.php";
}else if($UserLevel==1){
    $res = mysql_query($LoginTeacherSQL);
    $check = "TeacherPassword";
    $name = "TeacherName";
    $path = "Teacher.php";
}

$LoginInfo = "INSERT INTO loginhistory VALUES($UserId,$UserLevel,NOW());";

if($res){
    $arr = mysql_fetch_array($res);
    if($arr[$check]==$UserPassword && $UserPassword!=""){
        $_SESSION['level'] = $UserLevel;
        $_SESSION['UserId'] = $UserId;
        $_SESSION['UserName'] = $arr[$name];
        $_SESSION['LoginTime'] = date('Y-m-d H:i:s');
        $r = mysql_query($LoginInfo);
        if($r){
            header("location: ../../$path"); 
        }else{
            echo "<script>alert('访问数据库时出现了问题，登录失败！！'".mysql_error().");</script>";
            echo "<script>window.location.href='../../index.php';</script>";
        }
        
    }else{
        echo "<script>alert('登录失败，请检查登录信息！！');</script>";
        echo "<script>window.location.href='../../index.php';</script>";
    }
}

mysql_close($con);