var ques_i = 0;

$(document).ready(function () {
    $("#add_new_choose").click(function () {
        ques_i++;
        $("#chooses").append(
            " <div id='add_choose' class='input-group' style='width:60%;margin-left:20%'>" +
            " <span id='delete_choose' class='input-group-addon'>删除本项</span>" +
            " <input type='text' name='choices' class='form-control' placeholder='输入选项内容'>" +
            " <span class='input-group-addon'>" +
            " <input type='checkbox' name='options' id='option1' value=" + ques_i + "> 正确标记" +
            " </span>" +
            " </div>"
        ).find("span#delete_choose").click(function () {
            $(this).parent().remove();
        })
    });

    $('#submit_question').click(function () {
        var QContent = $('#this_content').val();
        var QScore = $('#this_score').val();
        var QChoice = "";
        var QCorrect = "";
        var QTemp = document.getElementsByName('choices');
        var QTempCho = document.getElementsByName('options');
        
        $("input[name='choices']").each(function(){
            QChoice += $(this).val();
            QChoice += "@";
        });
        console.log(QChoice);

        var ind = 0;
        $("input[name='options']").each(function(){
            if($(this).is(":checked")){
                QCorrect += ind;
                QCorrect += ',';

                //console.log(ind);
            }
            ind++;
        });
        console.log(QCorrect);


        $.ajax({
            type: "POST",
            url: "Support/action/RecordQues.php",
            dataType: "JSON",
            data: {
                "QContent" : QContent,
                "QScore"   : QScore,
                "QChoice"  : QChoice,
                "QCorrect" : QCorrect
            },
            success: function (data) {
                dialog.tip('录入成功','页面需要刷新以更新数据',function(){location.reload()});
            }
        });
    })

});