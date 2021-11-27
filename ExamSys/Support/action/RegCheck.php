<?php

include_once("connect.php");

$arr = array();

if(isset($_POST['UserId'])){
    if(isRepeat($_POST['UserId'],$_POST['Level'])){
        $arr['success'] = 0;
    }else{
        $arr['success'] = 1;
    }
    echo json_encode($arr);
}

function isRepeat($UserId,$Level)
{
    $lv = "";
    $ky = "";
    if($Level==0){
        $lv = "student";
        $ky = "StuId";
    }else{
        $lv = "teacher";
        $ky = "TeacherId";
    }
    $SQL = "SELECT * FROM $lv WHERE $ky=$UserId;";
    $res = mysql_query($SQL);
    $cnt = mysql_num_rows($res);
    if($cnt==0){
        return 0;
    }else{
        return 1;
    }
}