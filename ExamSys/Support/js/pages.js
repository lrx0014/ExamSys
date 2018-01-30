
$(document).ready(function () {
    loadingData();
    var totalPages = 0;
    //页面加载数据
})

var s_name = "";
var s_id = "";
var s_score1 = "";
var s_score2 = "";

function loadingData() {
    var currentPage = $('#currentPage').val();//当前页码
    var totalPages = $('#totalPages').val();//总页码

    var search_id = $('#SearchId').val();//搜索内容
    s_id = search_id ? search_id : '';

    var search_name = $('#SearchName').val();//搜索内容
    s_name = search_name ? search_name : '';

    var search_score1 = $('#SearchScore1').val();//搜索内容
    s_score1 = search_score1 ? search_score1 : '';

    var search_score2 = $('#SearchScore2').val();//搜索内容
    s_score2 = search_score2 ? search_score2 : '';
    
    $.ajax({
        url: 'Support/action/Pages.php',
        type: 'POST',
        data: { 'currentPage': currentPage, 
                's_id': s_id,
                's_name':s_name,
                's_score1':s_score1,
                's_score2':s_score2
             },
        dataType: 'json',
        success: function (data) {
            var info = data.datas, total = data.total;
            console.log('ajax...');
            //调用ajaxSuccess处理函数
            ajaxSuccess(total, currentPage, info);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(XMLHttpRequest.readyState);
            console.log(textStatus);
        }
    })

    //点击按钮搜索
    $("#search").click(function () {
        console.log("search click...");
        // console.log(s_name);
        // console.log(s_id);
        // console.log(s_score1);
        // console.log(s_score2);
        search();
    });

    // //边输入边搜索
    // $("#content").keyup(function () {
    //     search();
    // });

    //回车键搜索(为了避免表单提交，已经禁止上面的表单提交了)
    $(document).keydown(function () {
        if (event.keyCode == 13) {//表示按的是回车键
            search();
        }
    });

    //PS:边输入边搜索和回车键搜索最好分开用，以免引起紊乱
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
    for (var i = 0; i < info.length; i++) {
        html += '<tr>';
        html += '<td>' + info[i].StuId + '</td>';
        html += '<td>' + info[i].StuName + '</td>';
        html += '<td>' + info[i].lastTime + '</td>';
        html += '<td>' + info[i].total + '</td>';
        html += '</tr>';
    }
    $('#GradeView').html(html);
    var pages = Math.ceil(total / 3);
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

    s_name = $('#SearchName').val();
    s_id = $('#SearchId').val();
    s_score1 = $('#SearchScore1').val();
    s_score2 = $('#SearchScore2').val();

    $('#search_id').val(s_id);//把搜索内容写到隐藏域
    $('#search_name').val(s_name);
    $('#search_score1').val(s_score1);
    $('#search_score2').val(s_score2);

    $.ajax({
        url: "Support/action/Pages.php",
        data: { 'currentPage': currentPage, 
                's_id': s_id,
                's_name':s_name,
                's_score1':s_score1,
                's_score2':s_score2
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
            //console.log("sear...");
            //调用ajaxSuccess处理函数
            ajaxSuccess(total, currentPage, info);
        }
    })
}             