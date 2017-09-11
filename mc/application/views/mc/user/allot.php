<div class="easyui-layout" data-options="fit:true">
    <div data-options="region:'west',border:false" style="padding:4px;">
        <div id="allotRoleListToolbar" class="mvctool bgb">
            <?php echo setButton("btnSave", "icon-save", "保存", FALSE); ?>
            <?php echo setButton("btnReturn", "icon-return", "返回"); ?>
        </div>
        <table id="allotRoleList"></table>
    </div>
</div>
<script type="text/javascript">
$(function() {
    var AllotRoleList = $('#allotRoleList');
    AllotRoleList.datagrid({
        url: '/mc/user/allot_get_role/<?php echo $UserID; ?>',
        methord: 'POST',
        toolbar: '#allotRoleListToolbar',
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
                field: 'Name',
                title: '角色名称',
                width: 120,
                align: 'center'
            }, {
                field: 'Remark',
                title: '说明',
                width: 80
            }, {
                field: 'Alloted',
                title: '是否分配',
                width: 80,
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
            var rows = AllotRoleList.datagrid("getRows");
            for (var i = 0; i < rows.length; i++) {
                AllotRoleList.datagrid('beginEdit', i);
            }
        }
    });
    $("#btnSave").click(function() {
        var rows = AllotRoleList.datagrid("getRows");
        var data = [];
        for (var i = 0; i < rows.length; i++) {
            var setFlag = $("td[field='Alloted'] input").eq(i).prop("checked");
            if (setFlag) //判断是否有作修改
            {
                data.push(rows[i].ID);
            }
        }
        var roleids = data.join();
        $.ajax({
            url: '/mc/user/allot_post',
            type: "POST",
            data: {
                UserID: '<?php echo $UserID; ?>',
                RoleID: roleids
            },
            dataType: "json",
            beforeSend: Mask,
            success: function(data) {
                if (data.result > 0) {
                    ReturnByReloadDataGrid('#userList', 0, data.value);
                    ReturnByClose();
                }
                ReturnByMessage(data.message);
            }
        });
    });
});
</script>
