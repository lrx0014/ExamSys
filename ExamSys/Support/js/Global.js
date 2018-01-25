/// 自动时间
function current() {
    var d = new Date(), str = '当前时间：';
    str += d.getFullYear() + '年'; //获取当前年份
    str += d.getMonth() + 1 + '月'; //获取当前月份（0——11）
    str += d.getDate() + '日';
    str += d.getHours() + '时';
    str += d.getMinutes() + '分';
    str += d.getSeconds() + '秒';
    return str;
}
setInterval(function () { $("#nowTime").html(current) }, 1000);

/// 答题计时器
function two_char(n) {
    return n >= 10 ? n : "0" + n;
}
function time_fun() {
    var sec = 0;
    setInterval(function () {
        sec++;
        var date = new Date(0, 0)
        date.setSeconds(sec);
        var h = date.getHours(), m = date.getMinutes(), s = date.getSeconds();
        document.getElementById("mytime").innerText = "答题计时：" + two_char(h) + ":" + two_char(m) + ":" + two_char(s);
    }, 1000);
}