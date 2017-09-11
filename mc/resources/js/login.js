function checkform() {
    var username = $("#UserName");
    if (!username.val()) {
        username.focus();
        myAlert("请输入账户");
        return false;
    }
    var password = $("#Password");
    if (!password.val()) {
        password.focus();
        myAlert("请输入密码");
        return false;
    }
    return true;
}

function myAlert(msg) {
    $("#alert span").html(msg);
    $("#alert").slideDown("fast");
    setTimeout('$("#alert").slideUp("fast");', 3000);
}

function signin() {
    if (!checkform()) return false;
    $.post("/login/login_post", {
        username: $("#UserName").val(),
        password: $("#Password").val()
    }, function(data) {
        if (data.result) {
            if (data.value) {
                window.location = "/m";
            } else {
                window.location = "/";
            }
        } else {
            myAlert(data.message);
        }
    }, "json");
}
$(function() {
    FastClick.attach(document.body);
    var WallpaperHidden = false;
    $(document).mousemove(function(e) {
        if (e.pageX <= 0) {
            WallpaperHidden = true;
            $(".form-signin").hide();
            $(".bg").css("opacity", "1");
        }
        if (WallpaperHidden && e.pageX > 0) {
            WallpaperHidden = false;
            $(".form-signin").show();
            $(".bg").css("opacity", "0.75");
        }
    });
    $("#btn_submit").click(function() {
        signin();
    });
    $("#UserName").bind('keyup', function(event) {
        if (event.keyCode == 13) {
            $("#Password").focus();
        }
    });
    $("#Password").bind('keyup', function(event) {
        if (event.keyCode == 13) {
            signin();
        }
    });
});
