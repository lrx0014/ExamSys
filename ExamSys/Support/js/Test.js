
var info;

$(document).ready(function () {

    AquireQuestion();

});

$('#next_ques').on('click', function () {
    $(this).hide();
    $('#tips').text("请认真审题");
    $('#choice-btn').empty();
    AquireQuestion();
});

function AquireQuestion() {
    console.log("AqureQues...");
    $.ajax({
        type: "POST",
        url: "Support/action/AquireQues.php",
        dataType: "JSON",
        data: {},
        success: function (data) {

            info = data;

            $('#probar').css('width', info.percent);
            $('#total').text("当前总分：" + info.total);
            $('#Rest').text("剩余题数: " + info.rest);
            $('#percent').text("题库完成进度：" + info.percent);

            if (data.success == 1) {

                $('#probar').css('width', info.percent);
                $('#total').text("当前总分：" + info.total);
                $('#Rest').text("剩余题数: " + info.rest);
                $('#percent').text("题库完成进度：" + info.percent);

                console.log("ajax");

                $('#QuesInfo').text('本题编号:' + data.Qid + '    ' + '本题分值:' + data.QScore)
                    .append("<button id='submit_ques' class='btn btn-primary btn-warning' type='button' style='margin-left:50%'> 提交 </button>" +
                    "<button id='next_ques' class='btn btn-primary btn-success' type='button' style='margin-left:50%;display:none'> 下一题 </button>");

                $('#submit_ques').on('click', function () {
                    var myAnswer = "";
                    console.log('click..');

                    $(this).hide();
                    $('#next_ques').show();
                    $("input[name='answers']").each(function () {
                        if ($(this).is(":checked")) {
                            myAnswer += $(this).val();
                            myAnswer += ',';
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "Support/action/Judge.php",
                        dataType: "JSON",
                        data: {
                            "myAnswer": myAnswer,
                            "thisId": $('#thisId').text()
                        },
                        success: function (data) {
                            if (data.success == 1) {
                                console.log('Insert success..');
                                var thisScore = data.score;
                                if (data.correct == 1) {
                                    $('#tips').text("回答正确 :) 得分：" + data.score);
                                } else {
                                    var c = data.answer.split(',');
                                    var cor = "";
                                    for (var i = 0; i < c.length - 1; i++) {
                                        cor += '(';
                                        cor += parseInt(c[i]) + 1;
                                        cor += ')';
                                    }
                                    $('#tips').text("答案错误 :( 正确答案是: " + cor);
                                }
                            } else {
                                alert(data.message);
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            console.log(XMLHttpRequest.status);
                            console.log(XMLHttpRequest.readyState);
                            console.log(textStatus);
                        }
                    });
                });

                $('#next_ques').on('click', function () {
                    $(this).hide();
                    $('#tips').text("请认真审题");
                    $('#choice-btn').empty();
                    AquireQuestion();
                });

                $('#QuesInfo').append(
                    "<p id='thisId' style='display:none'>" + data.Qid + "</p>"
                );
                $('#QuesContent').text(data.Qcontent);
                console.log(data.Qcontent);

                var choices = data.QChoice;
                var cho = choices.split("@");
                for (var j = 0; j < cho.length - 1; j++) {
                    $('#choice-btn').append(
                        "<label class='btn btn-default'>" +
                        "<input type='checkbox' name='answers' value=" + j + "> (" + (j + 1) + ')、' + cho[j] +
                        "</label>" +
                        "<br>"
                    );
                }

            } else if (data.success == 2) {
                $('#probar').css('width', info.percent);
                $('#total').text("当前总分：" + info.total);
                $('#Rest').text("剩余题数: " + info.rest);
                $('#percent').text("题库完成进度：" + info.percent);

                $('#QuesInfo').text('恭喜你，题库中目前已有的题目已全部完成！！');
                $('#QuesContent').text("再接再厉！！");
                $('#tips').text('请点击退出考试按钮');
                $('#probar').css('width', (info.done / info.all) * 100 + '%');
                $('#total').text("当前总分：" + info.total);
                $('#Rest').text("剩余题数: " + info.rest);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(XMLHttpRequest.readyState);
            console.log(textStatus);
        }
    });
}