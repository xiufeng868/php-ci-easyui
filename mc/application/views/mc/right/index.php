<div class="easyui-layout" data-options="fit:true">
    <div data-options="region:'west',border:false" style="width:50%;height:100%;padding:4px;">
        <table id="roleRightList"></table>
    </div>
    <div data-options="region:'center',border:false" style="width:25%;padding:4px 4px 4px 0px;">
        <table id="moduleRightList"></table>
    </div>
    <div data-options="region:'east',border:false" style="width:25%;padding:4px 4px 4px 0px;">
        <div id="operateRightListToolbar" class="mvctool">
            <?php echo setButton("btnSaveRight", "icon-save", "保存", $permission, "save", FALSE); ?>
        </div>
        <table id="operateRightList"></table>
    </div>
</div>
<script type="text/javascript">
$(function() {
    var curModuleId = null; //选中的模块ID
    var curRoleId = null; //选中的角色ID
    var curModuleIsLast = false;
    var OperateRightList = $('#operateRightList');
    $('#roleRightList').datagrid({
        url: '/mc/role/query',
        methord: 'POST',
        fit: true,
        fitColumns: true,
        autoRowHeight: false,
        pagination: true,
        pageSize: GridPageSize(),
        pageList: [GridPageSize()],
        striped: true,
        singleSelect: true,
        rownumbers: true,
        title: '角色列表',
        columns: [
            [{
                field: 'Name',
                title: '角色名称',
                width: 10,
                align: 'center'
            }, {
                field: 'Users',
                title: '下属管理员',
                width: 30,
                align: 'center'
            }]
        ],
        onClickRow: function(rowIndex, rowData) {
            curRoleId = rowData.ID;
            if (curModuleId && curModuleIsLast) {
                OperateRightList.datagrid({
                    url: "/mc/right/query/" + curRoleId + "/" + curModuleId
                });
            }
        }
    });
    $('#moduleRightList').treegrid({
        url: '/mc/module/query',
        methord: 'POST',
        fit: true,
        fitColumns: true,
        autoRowHeight: false,
        treeField: 'Name',
        idField: 'ID',
        pagination: false,
        striped: true,
        singleSelect: true,
        title: '模块列表',
        columns: [
            [{
                field: 'Name',
                title: '名称',
                width: 10
            }]
        ],
        onClickRow: function(row) {
            curModuleIsLast = row.IsLast;
            curModuleId = row.ID;
            if (curRoleId && curModuleIsLast) {
                OperateRightList.datagrid({
                    url: "/mc/right/query/" + curRoleId + "/" + curModuleId
                });
            }
        },
        onLoadSuccess: function(row, data) {
            if (!row) {
                $(this).treegrid('expandAll');
            }
        }
    });
    OperateRightList.datagrid({
        methord: 'POST',
        toolbar: '#operateRightListToolbar',
        fit: true,
        fitColumns: true,
        autoRowHeight: false,
        striped: true,
        singleSelect: true,
        title: '操作列表',
        columns: [
            [{
                field: 'Name',
                title: '名称',
                align: 'center',
                width: 20
            }, {
                field: 'Code',
                title: '操作码',
                align: 'center',
                width: 20
            }, {
                field: 'Alloted',
                title: "<a title='选择' onclick=\"SelAll();\" class='icon-select icon'></a>&nbsp;<a title='反选' onclick=\"UnSelAll();\" class='icon-unselect icon'></a>",
                align: 'center',
                width: 10,
                formatter: function(value) {
                    if (value == 1) {
                        return "<input type='checkbox' checked='checked' value=" + value + " />";
                    } else {
                        return "<input type='checkbox' value=" + value + " />";
                    }
                }
            }]
        ]
    });
    $("#btnSaveRight").click(function() {
        if (!curModuleId || !curRoleId) {
            ReturnByWarn("请选择角色和模块");
            return false;
        }
        var rows = OperateRightList.datagrid("getRows");
        var data = [];
        for (var i = 0; i < rows.length; i++) {
            var setFlag = $("td[field='Alloted'] input").eq(i).prop("checked");
            if (setFlag) //判断是否有作修改
            {
                data.push(rows[i].ID);
            }
        }
        var operateIds = data.join();
        $.ajax({
            url: '/mc/right/save',
            type: "POST",
            data: {
                OperateID: operateIds,
                ModuleID: curModuleId,
                RoleID: curRoleId
            },
            dataType: "json",
            beforeSend: Mask,
            success: function(data) {
                ReturnByMessage(data.message);
            }
        });
    });
});

function SelAll() {
    $("td[field='Alloted'] input").prop("checked", true);
}

function UnSelAll() {
    $("td[field='Alloted'] input").prop("checked", false);
}
</script>
