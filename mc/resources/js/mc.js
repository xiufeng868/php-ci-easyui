$(function() {
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
    $('#tabMenu-refresh').click(function() {
        $('#mainTab').tabs('getSelected').panel('refresh');
    });
    $('#tabMenu-close').click(function() {
        var tab = $('#mainTab').tabs('getSelected');
        if (tab) {
            var index = $('#mainTab').tabs('getTabIndex', tab);
            $('#mainTab').tabs('close', index);
        }
    });
    $('#tabMenu-closeAll').click(function() {
        $('.tabs-inner span').each(function(i, n) {
            if ($(this).parent().next().is('.tabs-close')) {
                var t = $(n).text();
                $('#mainTab').tabs('close', t);
            }
        });
    });
    $('#tabMenu-closeOther').click(function() {
        var currtab_title = $('.tabs-selected .tabs-inner span').text();
        $('.tabs-inner span').each(function(i, n) {
            if ($(this).parent().next().is('.tabs-close')) {
                var t = $(n).text();
                if (t != currtab_title) $('#mainTab').tabs('close', t);
            }
        });
    });
    //tab右键绑定选项卡
    $(".tabs").on('contextmenu', 'li', function(e) {
        var subtitle = $(this).text();
        $('#mainTab').tabs('select', subtitle);
        $('#tabMenu').menu('show', {
            left: e.pageX,
            top: e.pageY
        });
        return false;
    });
    $("#logout").click(function() {
        $.messager.confirm("提示", "确定要退出系统吗?", function(n) {
            if (n) {
                $.post("/center/logout", function(data) {
                    ReturnByWarn(data.message);
                    setTimeout('top.location.href="/login";', 1000);
                }, "json");
            }
        });
    });
    $("#themeMenu span").click(function() {
        var theme = $(this).attr("rel");
        $.messager.confirm('提示', '切换皮肤将重新加载系统', function(r) {
            if (r) {
                $.post("/center/setTheme", {
                    value: theme
                }, function(data) {
                    window.location.reload(true);
                }, "json");
            }
        });
    });
    $('#moduleTree').tree({
        url: '/center/getModuleTree',
        onClick: function(node) {
            $(this).tree('toggle', node.target);
            if (node.IsLast == 1) {
                AddTab(node.text, node.Url, node.iconCls);
            }
        },
        onLoadSuccess: function(node, data) {
            if (node === null) {
                $(this).tree('expandAll');
            }
        }
    });
    $("#full").click(function() {
        $("body").layout("remove", "north");
        $("body").layout("remove", "south");
    });
});
