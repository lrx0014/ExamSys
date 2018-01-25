<?php

    include_once('connect.php');

    session_start();

    $QContent = $_POST['QContent'];
    $QChoice = $_POST['QChoice'];
    $QCorrect = $_POST['QCorrect'];
    $QScore = $_POST['QScore'];
    $TeacherId = $_SESSION['UserId'];

    $RecordSQL = "INSERT INTO Question VALUES(null,'$QContent','$QCorrect',$QScore,$TeacherId,NOW(),'$QChoice');";

    $res = mysql_query($RecordSQL);

    $arr = array();

    if($res){
        $arr['success'] = 1;
        $arr['message'] = "试题录入成功";
        echo json_encode($arr);
    }else{
        $arr['success'] = 0;
        $arr['message'] = '数据库操作失败: '.mysql_error();
        echo json_encode($arr);
    }