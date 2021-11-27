<?php

error_reporting(E_ALL & ~E_ERROR);
include_once("connect.php");
session_start();

if(isset($_POST['operation']))
{
    if($_POST['operation']=="ShowTable")
    {
        echo json_encode(ReadTable());
    }

    if($_POST['operation']=="ShowDropdown")
    {
        echo json_encode(ShowDropdown());
    }

    if($_POST['operation']=="CreateSet")
    {
        $sAuthor = $_SESSION['UserName'];

        if(isset($_POST['sName']) && isset($_POST['sQid']))
        {
            $sQid  = $_POST['sQid'];
            $sName = $_POST['sName']; 
            $arr_res = array();
            if(CreateSet($sName,$sQid,$sAuthor))
            {
                $arr_res['success'] = 1;
            }else{
                $arr_res['success'] = 0;
                $arr_res['message'] = mysql_error();
            }
            echo json_encode($arr_res);
        }
    }

}

function ShowDropdown()
{
    $SQL = "SELECT QsetId AS sQid,QsetName AS sName FROM question_sets;";
    $res = mysql_query($SQL);
    $arr = array();
    while($row = mysql_fetch_array($res))
    {
        $arr[] = $row;
    }
    return $arr;
}

function ReadTable()
{
    $SQL = "SELECT * FROM question;";
    $res = mysql_query($SQL);
    $arr = array();
    while($row = mysql_fetch_array($res))
    {
        $arr[] = $row;
    }
    return $arr;
}

function CreateSet($Name,$Qid,$Author)
{
    $SQL = "insert into question_sets(QsetName,Qinclude,CreateTime,Author) VALUES('$Name','$Qid',NOW(),'$Author');";
    $CreateRes = mysql_query($SQL);
    if($CreateRes)
    {
        return true;
    }
    return false;
}
