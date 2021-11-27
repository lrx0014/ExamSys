
$(document).ready(function () {
    loadingData();
    var totalPages = 0;
    //页面加载数据

    Grade_Set_Dropdown();

    Test_Set_Dropdown();

    ///下拉菜单查看考试记录
    $("#choose_set_stu").change(function(){
        $('#currentPage').val(0);
        loadingData($(this).val());
        var totalPages = 0;
    });

    /// 选择题库
    $("#go_test").click(function(){
        var selected_set = $("#choose_set_test").children('option:selected').val()
        console.log("go_test..." + selected_set);
        if(selected_set=='-1')
        {
            alert("请先选择题库！！");
        }else{
            window.location="Test.php?setid=" + selected_set;
        }
    });
});

function Grade_Set_Dropdown()
{
    $.ajax({
        url: 'Support/action/QsetAdd.php',
        type: 'POST',
        data: {"operation":"ShowDropdown"},
        dataType: 'json',
        success: function (data) {

            var drop_html = "<option value='-1'>-all-</option>";

            for (var i = 0; i < data.length; i++)
            {
                /// <option value="0">aaa</option>

                drop_html += "<option value='" + data[i].sQid + "'>" + data[i].sName + "</option>";
            }

            $("#choose_set_stu").html(drop_html);

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(XMLHttpRequest.readyState);
            console.log(textStatus);
        }
    });
}

function Test_Set_Dropdown()
{
    $.ajax({
        url: 'Support/action/QsetAdd.php',
        type: 'POST',
        data: {"operation":"ShowDropdown"},
        dataType: 'json',
        success: function (data) {

            var drop_html = "<option value='-1'>请选择题库</option>";

            for (var i = 0; i < data.length; i++)
            {
                /// <option value="0">aaa</option>

                drop_html += "<option value='" + data[i].sQid + "'>" + data[i].sName + "</option>";
            }

            $("#choose_set_test").html(drop_html);

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(XMLHttpRequest.readyState);
            console.log(textStatus);
        }
    });
}

function loadingData(setid=$("#choose_set_stu").val()) {
    var currentPage = $('#currentPage').val();//当前页码
    var totalPages = $('#totalPages').val();//总页码
    
    $.ajax({
        url: 'Support/action/StuInfo.php',
        type: 'POST',
        data: { 'currentPage': currentPage,
                'setid'      : setid
             },
        dataType: 'json',
        success: function (data) {
            var info = data.datas, total = data.total;
            console.log(total);
            //调用ajaxSuccess处理函数
            ajaxSuccess(total, currentPage, info);

            var time = info[info.length-1].lastTime;
            var total = 0;
            if(info.length==1){
                total = 0;
            }else{
                total = info[info.length-1].total;
            }
            $('#totalscore').text("总分: "+total);
            $('#logintime').text(time);
            console.log(time);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(XMLHttpRequest.readyState);
            console.log(textStatus);
        }
    })

}

//给分页列表绑定事件的方法
function bindingEvent() {
    $("#first").click(function () {
        if ($("#currentPage").val() != 1 && $('#totalPages').val() != 0) {//第一页点击时无效
            $("#currentPage").val(1);//即第一页
            //加载数据
            loadingData();
        }
    })
    $("#last").click(function () {//最后一页点击时无效
        if ($("#currentPage").val() != $('#totalPages').val() && $('#totalPages').val() != 0) {
            var total = $('#totalPages').val();//把总页数存到隐藏框里   
            $("#currentPage").val(total);

            //加载数据
            loadingData();
        }
    })
    $("#down").click(function () {
        if ($('#totalPages').val() != 0) {//总页数为0时，不能点击无效，主要是考虑搜索没数据时的情况
            var n = $("#currentPage").val();
            if (n > 1) {
                n--;
            }
            else {
                n = 1;
            }
            $("#currentPage").val(n);
        }

        //加载数据
        loadingData();
    })
    $("#up").click(function () {
        if ($('#totalPages').val() != 0) {//总页数为0时，不能点击无效，主要是考虑搜索没数据时的情况
            var n = $("#currentPage").val();
            if (n < totalPages) {
                n++;
            }
            else {
                n = totalPages;
            }
            $("#currentPage").val(n);

            //加载数据
            loadingData();
        }
    })
    $(".center").click(function () {
        if ($('#totalPages').val() != 0) {//总页数为0时，不能点击无效，主要是考虑搜索没数据时的情况
            var n = $(this).text();
            if ($("#currentPage").val() != n) {
                $("#currentPage").val(n);//中间的页码，点击哪一页就去那一页

                //加载数据
                loadingData();
            }
        }
    })
}

//把ajax相同部分封装成函数调用
function ajaxSuccess(total, currentPage, info) {
    var html = ''
    for (var i = 0; i < info.length-1; i++) {
        console.log("aaa");
        html += '<tr>';
        html += '<td>' + info[i].Qid + '</td>';
        html += '<td>' + info[i].QScore + '</td>';
        html += '<td>' + info[i].StuScore + '</td>';
        html += '<td>' + info[i].TestTime + '</td>';
        html += "<td style='text-align:center'>" + "<button id='sq"+i+"' class='btn btn-primary btn-viewques'>查看<div class='view-ques' style='display:none'> "+ info[i].Qid+"###"+info[i].Qcontent+"###"+info[i].QChoice+"###"+info[i].StuChoise+"###"+info[i].QAnswer +" </div></button>" + '</td>';
        html += '</tr>';
    }
    console.log(html);
    $('#GradeView').html(html);

    $('.btn-viewques').on('click',function(){

        //"3###以下哪些是浏览器？？             ###Chrome@IE@VS@Firefox@###0,1,3,###0,1,3,";

        var Q = $(this).children('.view-ques').text();
        var Q_id = "Q" + Q.split("###")[0];
        var QC = Q.split("###")[1] + "<br>";

        var QCho = Q.split("###")[2];
        var QChoReal = QCho.split('@');
        var QputCho = "";
        for(var i=0;i<QChoReal.length-1;i++){
            QputCho += "(";
            QputCho += parseInt(i)+1;
            QputCho += ")";
            QputCho += QChoReal[i];
            QputCho += " <br>";
        }

        var QmyCho = Q.split("###")[3];
        var QmyChoReal = QmyCho.split(',');
        var QputMyCho = "我的答案：";
        for(var j=0;j<QmyChoReal.length-1;j++){
            QputMyCho += "(";
            QputMyCho += parseInt(QmyChoReal[j])+1;
            QputMyCho += ")";
        }
        QputMyCho += " <br>";

        var QAnswer = Q.split("###")[4];
        var QAnswerReal = QAnswer.split(',');
        var QputAnswer = "正确答案：";
        for(var k=0;k<QAnswerReal.length-1;k++){
            QputAnswer += "(";
            QputAnswer += parseInt(QAnswerReal[k])+1;
            QputAnswer += ")";
        }
        QputAnswer += " <br>";

        QAll = QC + QputCho + QputMyCho + QputAnswer;

        dialog.tip(Q_id,QAll);
    })

    var pages = Math.ceil(total / 5);
    totalPages = pages;
    $('#totalPages').val(totalPages);//把总页数存到隐藏框里   
    var dangqian = currentPage ? parseInt(currentPage) : 1; //当前页数   
    $('#currentPage').val(dangqian);//把当前页存放到隐藏框
    var j = 0;
    var s = '<nav class="page" aria-label="Page navigation"><ul class="pagination"><li><a id="first">首页</a></li>';
    if (dangqian != 1) {
        s += '<li><a id="down">上一页</a></li>';
    }
    for (var i = dangqian - 2; i <= dangqian + 2; i++) {
        if (j == 5) {//页码列表只显示3列，即只显示1、2、3或2、3、4这样的三列，以此类推。
            break;
        } else {
            j++;
        }
        if (i > 0 && i <= pages) {
            if (dangqian == i) {
                s += '<li class="thisclass"><a class="current center">' + i + '</a></li>';
            }
            else {
                s += '<li><a class="center">' + i + '</a></li>';
            }
        }
    }
    if (dangqian != totalPages) {
        s += '<li><a id="up">下一页</a></li>';
    }
    s += '<li><a id="last">末页</a></li>';
    s += '<li><span class="pageinfo">共 <strong>' + totalPages + '</strong>页<strong>' + total + '</strong>条</span></li></ul></nav>';
    $(".list-div").html(s);

    //给分页列表绑定事件
    bindingEvent();
}

//搜索封装成函数
function search() {
    
    var currentPage = 1;//搜索时默认就是第一页

    $.ajax({
        url: "Support/action/StuInfo.php",
        data: { 
            },
        type: "POST",
        dataType: "JSON",
        success: function (data) {
            var info = data.datas, total = data.total, html = '';
            if (!info) {
                $('#GradeView').empty();
                $('#tip').show().find('td').html('<center>暂无数据！</center>');
                $('#totalPages').val(0);//此时的总页数为0
                $(".list-div").html('<nav class="page" aria-label="Page navigation"><ul class="pagination"><li><a id="first">首页</a></li><li class="thisclass"><a class="current center">1</a></li><li><a id="up">下一页</a></li><li><a id="last">末页</a></li><li><span class="pageinfo">共 <strong>1</strong>页<strong>0</strong>条</span></li></ul></nav>');
                return false;
            }
            $('#tip').hide();

            //调用ajaxSuccess处理函数
            ajaxSuccess(total, currentPage, info);
        }
    })
}             