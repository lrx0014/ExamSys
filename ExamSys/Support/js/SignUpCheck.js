$('#sign').click(function () {
    var UserName = $('#UserName').val();
    var Password = $('#Password').val();
    var Confim = $('#Confirm').val();
    var UserId = $('#UserId').val();

    $.ajax({
        type: "POST",
        url: "Support/action/SignUp.php",
        dataType: "JSON",
        data: {
            "username": UserName,
            "password": Password,
            "userid": UserId
        },
        success: function (data) {
            if(data['success']==1){
                //alert(data['message']);
                dialog.tip("注册成功", data.message);
            }else{
                //alert(data['message']);
                dialog.tip("注册失败", data.message);
            }
        }
    })
});
