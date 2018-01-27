<?php

    include_once("connect.php");

    session_start();

    $js = array();

    if(isset($_SESSION['UserId']) && isset($_POST['myAnswer']) && isset($_POST['thisId'])){
        $ins = Judge($_POST['myAnswer'],$_POST['thisId']);

        $StuId = $_SESSION['UserId'];
        $Qid = $_POST['thisId'];
        $StuChoice = $_POST['myAnswer'];
        $StuScore = $ins['score'];

        $setid = $_SESSION['setid'];

        $historySQL = "INSERT INTO testhistory VALUES($StuId,$setid,$Qid,'$StuChoice',$StuScore,NOW());";

        $r = mysql_query($historySQL);
        if($r){
            $js['success'] = 1;
            $js['correct'] = $ins['correct'];
            $js['score'] = $ins['score'];
            $js['answer'] = $ins['answer'];
            echo json_encode($js);
        }else{
            $js['success'] = 0;
            $js['message'] = "数据库操作错误(".$historySQL."): ".mysql_error();
            echo json_encode($js);
        }
    }

    function Judge($answer,$id)
    {
        $arr = array();
        $JudgeSQL = "SELECT QAnswer,QScore FROM question WHERE Qid=$id;";
        $res = mysql_query($JudgeSQL);
        $Qcoreect = mysql_fetch_array($res);

        if($Qcoreect['QAnswer']==$answer){
            $arr['correct'] = 1;
            $arr['score'] = $Qcoreect['QScore'];
            $arr['answer'] = $Qcoreect['QAnswer'];
        }else{
            $arr['correct'] = 0;
            $arr['score'] = 0;
            $arr['answer'] = $Qcoreect['QAnswer'];
        }
        return $arr;
    }