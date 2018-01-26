
$(document).ready(function () {
    ShowQTable();
    $("#go_create_set").click(function() {
        console.log("go_create_set_click...");
        Go_Create_Set();
    });

    Create_Set_Dropdown();
});

function Create_Set_Dropdown()
{
    $.ajax({
        url: 'Support/action/QsetAdd.php',
        type: 'POST',
        data: {"operation":"ShowDropdown"},
        dataType: 'json',
        success: function (data) {

            var drop_html = "<option value='-1'>全部</option>";

            for (var i = 0; i < data.length; i++)
            {
                /// <option value="0">aaa</option>

                drop_html += "<option value='" + data[i].sQid + "'>" + data[i].sName + "</option>";
            }

            $("#choose_set").html(drop_html);

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(XMLHttpRequest.readyState);
            console.log(textStatus);
        }
    });
}

function ShowQTable()
{
    $.ajax({
        url: 'Support/action/QsetAdd.php',
        type: 'POST',
        data: {"operation":"ShowTable"},
        dataType: 'json',
        success: function (data) {
            CreateTable(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(XMLHttpRequest.readyState);
            console.log(textStatus);
        }
    });
}

function CreateTable(info)
{
    var h = ''
    for (var i = 0; i < info.length; i++) {
        h += '<tr>';
        h += '<td>' + info[i].Qid + '</td>';
        h += '<td>' + info[i].QScore + '</td>';
        h += '<td>' + info[i].Qcontent + '</td>';
        h += "<td><input type='checkbox' name='options_add' id='Q" + info[i].Qid + "' value=" + ques_i + "> 添加本题" + " </span></td>";
        h += '</tr>';
    }
    $('#Ques_List_add').html(h);
}

function Go_Create_Set()
{
    var sQid  = "";
    var sName = "";
    sName  = $("#QsetName").val();
    $("input[name='options_add']").each(function(){
        if($(this).is(":checked")){
            sQid  += $(this).attr("id");
        }
    });
    console.log(sName+","+sQid);

    $.ajax({
        url: 'Support/action/QsetAdd.php',
        type: 'POST',
        data: { "operation":"CreateSet",
                "sName":sName,
                "sQid" :sQid
              },
        dataType: 'json',
        success: function (data) {
            /// 成功
            console.log("ajax成功...");
            if(data.success==1)
            {
                alert("SUCCESS!!");
            }else{
                alert("FAILED:"+data.message);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(XMLHttpRequest.readyState);
            console.log(textStatus);
        }
    });
}

