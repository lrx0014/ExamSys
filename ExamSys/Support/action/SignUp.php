<?php

    session_start();

    include_once("connect.php");

    $UserName = "";
    $UserId = "";
    $UserPassword = "";
    $UserLevel = -1;

    $arr = array();
    if(isset($_POST['UserName']) && isset($_POST['Password']) && isset($_POST['UserId'])){
        $UserName = $_POST['UserName'];
        $UserId = $_POST['UserId'];
        $UserPassword = $_POST['Password'];
        $UserLevel = $_POST['UserLevel'];

        $StuSignUp = "insert into student values($UserId,'$UserName','$UserPassword');";
        $TecherSignUp = "insert into teacher values($UserId,'$UserName','$UserPassword');";
        if($UserLevel==0)
        {
            $res = mysql_query($StuSignUp);
        }else if($UserLevel==1){
            $res = mysql_query($TecherSignUp);
        }
        
        if($res){
            $arr['success'] = 1;
            $arr['message'] = "注册成功！！".mysql_error();
            echo json_encode($arr);
            ///echo "YES";
        }else{
            $arr['success'] = 0;
            $arr['message'] = "注册失败\n 此ID可能已被注册\n"."ERROR: ".mysql_error();
            echo json_encode($arr);
            ///echo $StuSignUp;
        }
    }else{
        $arr['success'] = 0;
        $arr['message'] = "请求失败";
        echo json_encode($arr);
    }

    

