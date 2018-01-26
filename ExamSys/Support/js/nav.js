$(document).ready(function(){

    $("#click1").addClass("active");

    $("#click1").click(function(){
        setCookie('thisNav',1);
        $("#info1").show();
        $("#info2,#info3,#info4,#info5").hide();
        $("#click1,#click2,#click3,#click4,#click5").removeClass("active");
        $(this).addClass("active");
    });

    $("#click2").click(function(){
        setCookie('thisNav',2);
        $("#info2").show();
        $("#info1,#info3,#info4,#info5").hide();
        $("#click1,#click2,#click3,#click4,#click5").removeClass("active");
        $(this).addClass("active");
    });

    $("#click3").click(function(){
        setCookie('thisNav',3);
        $("#info3").show();
        $("#info1,#info2,#info4,#info5").hide();
        $("#click1,#click2,#click3,#click4,#click5").removeClass("active");
        $(this).addClass("active");
    });

    $("#click4").click(function(){
        setCookie('thisNav',4);
        $("#info4").show();
        $("#info1,#info2,#info3,#info5").hide();
        $("#click1,#click2,#click3,#click4,#click5").removeClass("active");
        $(this).addClass("active");
    });

    $("#click5").click(function(){
        setCookie('thisNav',5);
        $("#info5").show();
        $("#info1,#info2,#info3,#info4").hide();
        $("#click1,#click2,#click3,#click4,#click5").removeClass("active");
        $(this).addClass("active");
    });
});

//写cookies 

function setCookie(name,value) 
{ 
    var Days = 30; 
    var exp = new Date(); 
    exp.setTime(exp.getTime() + Days*24*60*60*1000); 
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString(); 
} 

//读取cookies 
function getCookie(name) 
{ 
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
 
    if(arr=document.cookie.match(reg))
 
        return unescape(arr[2]); 
    else 
        return null; 
} 

//删除cookies 
function delCookie(name) 
{ 
    var exp = new Date(); 
    exp.setTime(exp.getTime() - 1); 
    var cval=getCookie(name); 
    if(cval!=null) 
        document.cookie= name + "="+cval+";expires="+exp.toGMTString(); 
} 