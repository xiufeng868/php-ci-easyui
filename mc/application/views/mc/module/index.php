<div class="easyui-layout" data-options="fit:true">
    <div data-options="region:'west',border:false" style="width:75%;height:100%;padding:4px;">
        <div id="moduleListToolbar" class="mvctool">
            <?php echo setButton("btnDetailsModule", "icon-details", "详细", $permission, "details", false); ?>
            <?php echo setButton("btnCreateModule", "icon-add", "新增", $permission, "create"); ?>
            <?php echo setButton("btnEditModule", "icon-edit", "编辑", $permission, "edit"); ?>
            <?php echo setButton("btnDeleteModule", "icon-delete", "删除", $permission, "delete"); ?>
        </div>
        <table id="moduleList"></table>
    </div>
    <div data-options="region:'center',border:false" style="padding:4px 4px 4px 0px;">
        <div id="operateListToolbar" class="mvctool">
            <?php echo setButton("btnCreateOperate", "icon-add", "新增", $permission, "create", false); ?>
            <?php echo setButton("btnDeleteOperate", "icon-delete", "删除", $permission, "delete"); ?>
        </div>
        <table id="operateList"></table>
    </div>
</div>
<script type="text/javascript">
$(function() {
    var ModuleList = $('#moduleList');
    var OperateList = $('#operateList');
    var ModuleSelected = 0;
    ModuleList.treegrid({
        url: '/mc/module/query',
        methord: 'POST',
        toolbar: '#moduleListToolbar',
        fit: true,
        fitColumns: true,
        autoRowHeight: false,
        treeField: 'Name',
        idField: 'ID',
        pagination: false,
        singleSelect: true,
        remoteSort: false,
        title: '模块列表',
        columns: [
            [{
                field: 'ID',
                title: 'ID',
                width: 10,
                align: 'center'
            }, {
                field: 'Name',
                title: '名称',
                width: 50,
            }, {
                field: 'Remark',
                title: '说明',
                width: 30,
            }, {
                field: 'Url',
                title: '链接地址',
                width: 30,
            }, {
                field: 'Code',
                title: '模块码',
                width: 30,
                align: 'center'
            }, {
                field: 'Sort',
                title: '排序',
                width: 15,
                align: 'center',
                sorter: NumberSort
            }, {
                field: 'IsEnable',
                title: '是否启用',
                width: 15,
                align: 'center',
                formatter: function(value) {
                    if (value == 1) {
                        return "<span class='icon-enable'></span>";
                    } else {
                        return "<span class='icon-disable'></span>";
                    }
                }
            }, {
                field: 'UpdateTime',
                title: '更新时间',
                width: 40,
                align: 'center'
            }]
        ],
        onClickRow: function(row) {
            if (row.ID == ModuleSelected) {
                ModuleList.treegrid('unselect', row.ID);
                ModuleSelected = 0;
                return false;
            }
            if (row.IsLast > 0) {
                OperateList.datagrid({
                    url: '/mc/module/query?moduleId=' + row.ID
                });
            } else {
                ModuleList.treegrid('expand', row.ID);
            }
            ModuleSelected = row.ID;
        },
        onLoadSuccess: function(row, data) {
            if (!row) {
                ModuleList.treegrid('expandAll');
            }
        },
        onBeforeExpand: function(row) {
            var rows = ModuleList.treegrid('getChildren', row.ID);
            if (rows.length <= 0) {
                return false;
            }
        },
        rowStyler: function(rowData) {
            if (rowData.IsEnable < 1) {
                return 'color:Silver;';
            }
            if (rowData.IsLast < 1) {
                return 'font-weight:bold;';
            }
        }
    });
    $("#btnCreateModule").click(function() {
        var row = ModuleList.treegrid('getSelected');
        if (row && row.IsLast == 1) {
            return false;
        }
        PopModalWindow('/mc/module/create/' + (row ? row.ID : '0'), '新增', 350, 400, 'icon-add');
    });
    $("#btnEditModule").click(function() {
        var row = ModuleList.treegrid('getSelected');
        if (row) {
            PopModalWindow('/mc/module/edit/' + row.ID, '编辑', 350, 400, 'icon-edit');
        } else {
            ReturnByWarn('请选择要操作的记录');
        }
    });
    $("#btnDetailsModule").click(function() {
        var row = ModuleList.treegrid('getSelected');
        if (row) {
            PopModalWindow('/mc/module/details/' + row.ID, '详细', 350, 450, 'icon-details');
        } else {
            ReturnByWarn('请选择要操作的记录');
        }
    });
    $("#btnDeleteModule").click(function() {
        var row = ModuleList.treegrid('getSelected');
        if (row) {
            var rows = ModuleList.treegrid('getChildren', row.ID);
            if (rows.length > 0) {
                ReturnByWarn('存在子模块');
                return false;
            }
            $.messager.confirm('提示', '您确定要删除[' + row.Name + ']吗？', function(r) {
                if (r) {
                    $.ajax({
                        url: '/mc/module/delete/' + row.ID,
                        type: "POST",
                        dataType: "json",
                        beforeSend: Mask,
                        success: function(data) {
                            if (data.result > 0) {
                                ReturnByReloadTreeGrid('#moduleList', -1);
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

    OperateList.datagrid({
        methord: 'POST',
        toolbar: '#operateListToolbar',
        fit: true,
        fitColumns: true,
        autoRowHeight: false,
        pageSize: 100,
        pagination: false,
        idField: 'ID',
        striped: true,
        singleSelect: true,
        remoteSort:false,
        title: '操作列表',
        columns: [
            [{
                field: 'Name',
                title: '名称',
                width: 20,
                align: 'center'
            }, {
                field: 'Code',
                title: '操作码',
                width: 20,
                align: 'center'
            }, {
                field: 'Sort',
                title: '排序',
                width: 10,
                align: 'center',
                sorter: NumberSort
            }]
        ]
    });
    $("#btnCreateOperate").click(function() {
        var row = ModuleList.treegrid('getSelected');
        if (row) {
            if (row.IsLast == 1) {
                PopModalWindow('/mc/module/create_operate/' + row.ID, '新增操作码', 350, 200, 'icon-add');
            } else {
                ReturnByWarn('请选择最后一项模块');
            }
        } else {
            ReturnByWarn('请选择要操作的模块');
        }
    });
    $("#btnDeleteOperate").click(function() {
        var row = OperateList.datagrid('getSelected');
        if (row) {
            $.messager.confirm('提示', '您确定要删除[' + row.Name + ']吗？', function(r) {
                if (r) {
                    $.ajax({
                        url: '/mc/module/delete_operate/' + row.ID,
                        type: "POST",
                        dataType: "json",
                        beforeSend: Mask,
                        success: function(data) {
                            if (data.result > 0) {
                                ReturnByReloadDataGrid("#operateList", -1);
                            }
                            ReturnByMessage(data.message);
                        }
                    });
                }
            });
        } else {
            ReturnByWarn('请选择要操作的模块');
        }
    });
});
</script>
