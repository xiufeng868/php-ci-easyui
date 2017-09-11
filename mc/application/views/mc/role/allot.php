<div class="easyui-layout" data-options="fit:true">
    <div data-options="region:'west',border:false" style="padding:4px;">
        <div id="allotUserListToolbar" class="mvctool bgb">
            <?php echo setButton("btnSave", "icon-save", "保存", FALSE); ?>
            <?php echo setButton("btnReturn", "icon-return", "返回"); ?>
        </div>
        <table id="allotUserList"></table>
    </div>
</div>
<script type="text/javascript">
$(function() {
    var AllotUserList = $('#allotUserList');
    AllotUserList.datagrid({
        url: '/mc/role/allot_get_user/<?php echo $RoleID; ?>',
        methord: 'POST',
        toolbar: '#allotUserListToolbar',
        fit: true,
        fitColumns: true,
        autoRowHeight: false,
        pagination: false,
        striped: true,
        singleSelect: true,
        columns: [
            [{
                field: 'ID',
                title: 'ID',
                hidden: true
            }, {
                field: 'UserName',
                title: '用户名',
                width: 20,
                align: 'center'
            }, {
                field: 'DisplayName',
                title: '真实姓名',
                width: 10,
                align: 'center'
            }, {
                field: 'Alloted',
                title: '是否分配',
                width: 10,
                align: 'center',
                editor: {
                    type: 'checkbox',
                    options: {
                        on: '1',
                        off: '0'
                    }
                }
            }]
        ],
        onLoadSuccess: function(data) {
            var rows = AllotUserList.datagrid("getRows");
            for (var i = 0; i < rows.length; i++) {
                AllotUserList.datagrid('beginEdit', i);
            }
        }
    });
    $("#btnSave").click(function() {
        var rows = AllotUserList.datagrid("getRows");
        var data = [];
        for (var i = 0; i < rows.length; i++) {
            var setFlag = $("td[field='Alloted'] input").eq(i).prop("checked");
            if (setFlag) //判断是否有作修改
            {
                data.push(rows[i].ID);
            }
        }
        var userids = data.join();
        $.ajax({
            url: '/mc/role/allot_post',
            type: "POST",
            data: {
                UserID: userids,
                RoleID: '<?php echo $RoleID; ?>'
            },
            dataType: "json",
            beforeSend: Mask,
            success: function(data) {
                if (data.result > 0) {
                    ReturnByReloadDataGrid('#roleList', 0, data.value);
                    ReturnByClose();
                }
                ReturnByMessage(data.message);
            }
        });
    });
});
</script>
