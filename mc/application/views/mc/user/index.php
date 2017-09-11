<div class="easyui-layout" data-options="fit:true">
    <div data-options="region:'west',border:false" style="width:100%;height:100%;padding:4px;">
        <div id="userListToolbar" class="mvctool">
            <?php echo setButton("btnDetailsUser", "icon-details", "详细", $permission, "details", false); ?>
            <?php echo setButton("btnCreateUser", "icon-add", "新增", $permission, "create"); ?>
            <?php echo setButton("btnEditUser", "icon-edit", "编辑", $permission, "edit"); ?>
            <?php echo setButton("btnDeleteUser", "icon-delete", "删除", $permission, "delete"); ?>
            <?php echo setButton("btnAllotRole", "icon-share", "分配角色", $permission, "allot"); ?>
            <?php if (checkPermission($permission, 'query')) {?>
            <div class="search">
                <input class="easyui-searchbox" id="searchUser" type="text" />
            </div>
            <?php }?>
        </div>
        <table id="userList"></table>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var UserList = $('#userList');
        UserList.datagrid({
            url: '/mc/user/query',
            methord: 'POST',
            toolbar: '#userListToolbar',
            fit: true,
            fitColumns: true,
            autoRowHeight: false,
            pagination: true,
            pageSize: GridPageSize(),
            pageList: [GridPageSize()],
            idField: 'ID',
            striped: true,
            singleSelect: true,
            rownumbers: true,
            remoteSort: false,
            columns: [
                [{
                    field: 'UserName',
                    title: '用户名',
                    width: 20,
                    align: 'center'
                }, {
                    field: 'DisplayName',
                    title: '真实姓名',
                    width: 20,
                    align: 'center'
                }, {
                    field: 'IsEnable',
                    title: '是否启用',
                    width: 10,
                    align: 'center',
                    formatter: function(value) {
                        if (value == 1) {
                            return "<span class='icon-enable icon'></span>";
                        } else {
                            return "<span class='icon-disable icon'></span>";
                        }
                    }
                }, {
                    field: 'UpdateTime',
                    title: '更新时间',
                    width: 20,
                    align: 'center'
                }, {
                    field: 'Roles',
                    title: '拥有角色',
                    width: 50,
                    align: 'center'
                }]
            ]
        });
        $('#searchUser').searchbox({
            searcher: function(value, name) {
                UserList.datagrid('load', {
                    queryStr: encodeURI(value)
                });
                $(this).textbox('clear');
            },
            prompt: '输入关键字'
        });
        $("#btnCreateUser").click(function() {
            PopModalWindow('/mc/user/create', '新增', 350, 220, 'icon-add');
        });
        $("#btnEditUser").click(function() {
            var row = UserList.datagrid('getSelected');
            if (row) {
                PopModalWindow('/mc/user/edit/' + row.ID, '编辑', 350, 200, 'icon-edit');
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
        $("#btnDetailsUser").click(function() {
            var row = UserList.datagrid('getSelected');
            if (row) {
                PopModalWindow('/mc/user/details/' + row.ID, '详细', 350, 300, 'icon-details');
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
        $("#btnDeleteUser").click(function() {
            var row = UserList.datagrid('getSelected');
            if (row) {
                $.messager.confirm('提示', '您确定要删除[' + row.UserName + ']吗？', function(r) {
                    if (r) {
                        $.ajax({
                            url: '/mc/user/delete/' + row.ID,
                            type: "POST",
                            dataType: "json",
                            beforeSend: Mask,
                            success: function(data) {
                                if (data.result > 0) {
                                    ReturnByReloadDataGrid('#userList', -1);
                                }
                                ReturnByMessage(data.message);
                            }
                        });
                    }
                });
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
        $("#btnAllotRole").click(function() {
            var row = UserList.datagrid('getSelected');
            if (row) {
                PopModalWindow('/mc/user/allot/' + row.ID, '分配角色', 720, 400, 'icon-share');
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
    });
</script>
