$(document).ready(function(){

    $.ajax({
        type: "POST",
        url: "Support/action/ViewQues.php",
        dataType: "text",
        data: "" ,
        success: function (data) {
            var table = data;
            //console.log(table);
            $('#QuesInfo').append(table);

            $('.btn-viewques').on('click',function(){
                var Q = $(this).children('.view-ques').text();
                var QC = Q.split("###")[0];
                var QA = Q.split("###")[1];
                var QCho = Q.split("###")[2];
                var Qid = $(this).attr("id");
                dialog.tip(Qid, QC+"<br>"+QCho+"<br>"+"本题答案是："+QA);
            })
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(XMLHttpRequest.readyState);
            console.log(textStatus);
        }
    });
})