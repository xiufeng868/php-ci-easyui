<div class="easyui-layout" data-options="fit:true">
    <div data-options="region:'west',border:false" style="width:100%;height:100%;padding:4px;">
        <div id="roleListToolbar" class="mvctool">
            <?php echo setButton("btnDetailsRole", "icon-details", "详细", $permission, "details", FALSE); ?>
            <?php echo setButton("btnCreateRole", "icon-add", "新增", $permission, "create"); ?>
            <?php echo setButton("btnEditRole", "icon-edit", "编辑", $permission, "edit"); ?>
            <?php echo setButton("btnDeleteRole", "icon-delete", "删除", $permission, "delete"); ?>
            <?php echo setButton("btnAllotUser", "icon-share", "分配管理员", $permission, "allot"); ?>
            <?php if (checkPermission($permission, 'query')) { ?>
            <div class="search">
                <input class="easyui-searchbox" id="searchRole" type="text" />
            </div>
            <?php } ?>
        </div>
        <table id="roleList"></table>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var RoleList = $('#roleList');
        RoleList.datagrid({
            url: '/mc/role/query',
            methord: 'POST',
            toolbar: '#roleListToolbar',
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
                    field: 'Name',
                    title: '角色名称',
                    width: 20,
                    align: 'center'
                }, {
                    field: 'Remark',
                    title: '说明',
                    width: 20,
                    align: 'center'
                }, {
                    field: 'UpdateTime',
                    title: '更新时间',
                    width: 20,
                    align: 'center'
                }, {
                    field: 'Users',
                    title: '下属管理员',
                    width: 30,
                    align: 'center'
                }]
            ]
        });
        $('#searchRole').searchbox({
            searcher: function(value, name) {
                RoleList.datagrid('load', {
                    queryStr: encodeURI(value)
                });
                $(this).textbox('clear');
            },
            prompt: '输入关键字'
        });
        $("#btnCreateRole").click(function() {
            PopModalWindow('/mc/role/create', '新增', 350, 150, 'icon-add');
        });
        $("#btnEditRole").click(function() {
            var row = RoleList.datagrid('getSelected');
            if (row) {
                PopModalWindow('/mc/role/edit/' + row.ID, '编辑', 350, 150, 'icon-edit');
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
        $("#btnDetailsRole").click(function() {
            var row = RoleList.datagrid('getSelected');
            if (row) {
                PopModalWindow('/mc/role/details/' + row.ID, '详细', 350, 250, 'icon-details');
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
        $("#btnDeleteRole").click(function() {
            var row = RoleList.datagrid('getSelected');
            if (row) {
                $.messager.confirm('提示', '您确定要删除[' + row.Name + ']吗？', function(r) {
                    if (r) {
                        $.ajax({
                            url: '/mc/role/delete/' + row.ID,
                            type: "POST",
                            dataType: "json",
                            beforeSend: Mask,
                            success: function(data) {
                                if (data.result > 0) {
                                    ReturnByReloadDataGrid('#roleList', -1);
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
        $("#btnAllotUser").click(function() {
            var row = RoleList.datagrid('getSelected');
            if (row) {
                PopModalWindow('/mc/role/allot/' + row.ID, '分配管理员', 720, 400, 'icon-share');
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
    });
</script>
