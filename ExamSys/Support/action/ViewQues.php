<?php

include_once("connect.php");

echo getQuesInfo();

function getQuesInfo()
{
    $QuesSQL = "SELECT question.*,teacher.TeacherName FROM question,teacher WHERE question.TeacherId=teacher.TeacherId;";

    $res = mysql_query($QuesSQL);

    $tab = "";

    if($res){
        while($a=mysql_fetch_array($res)){
            $QC = $a['Qcontent'];
            $QC = trim($QC);
            $cor = $a['QAnswer'];
            $cor = explode(',',$cor);
            $QA = "";
            for($i=0;$i<sizeof($cor)-1;$i++){
                $QA .= "(";
                $QA .= $cor[$i]+1;
                $QA .= ")";
            }
            $QCho = $a['QChoice'];
            $QCho = explode('@',$QCho);
            $QChoice = "";
            for($j=0;$j<sizeof($QCho)-1;$j++){
                $QChoice .= "(";
                $QChoice .= $j+1;
                $QChoice .= ")";
                $QChoice .= $QCho[$j];
                $QChoice .= " <br/>";
            }
            $btn_id = "q";
            $tab .= "<tr>";
            $tab .= "<td>".$a['Qid']."</td>";
            $tab .= "<td>".$a['CreateTime']."</td>";
            $tab .= "<td>".$a['TeacherName']."</td>";
            $tab .= "<td>".$a['QScore']."</td>";
            $tab .= "<td><button id='".$btn_id.$a['Qid']."' class='btn btn-primary btn-viewques'>查看<div class='view-ques' style='display:none'>".$QC."###".$QA."###".$QChoice."</div></button></td>";
            $tab .= "</tr>";
        }
    }

    return $tab;
}