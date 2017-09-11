<div class="easyui-layout" data-options="fit:true">
    <div data-options="region:'west',border:false" style="width:50%;height:100%;padding:4px;">
        <div id="dictionaryListToolbar" class="mvctool">
            <?php echo setButton("btnCreateDictionary", "icon-add", "新增", $permission, "create", FALSE); ?>
            <?php echo setButton("btnEditDictionary", "icon-edit", "编辑", $permission, "edit"); ?>
            <?php echo setButton("btnDeleteDictionary", "icon-delete", "删除", $permission, "delete"); ?>
        </div>
        <table id="dictionaryList"></table>
    </div>
    <div data-options="region:'center',border:false" style="padding:4px 4px 4px 0px;">
        <div id="dictionaryTreeToolbar" class="mvctool">
            <?php echo setButton("btnCreateSubDictionary", "icon-add", "新增", $permission, "create", FALSE); ?>
            <?php echo setButton("btnEditSubDictionary", "icon-edit", "编辑", $permission, "edit"); ?>
            <?php echo setButton("btnDeleteSubDictionary", "icon-delete", "删除", $permission, "delete"); ?>
        </div>
        <table id="dictionaryTree"></table>
    </div>
</div>
<script type="text/javascript">
$(function() {
    var DictionaryList = $('#dictionaryList');
    var DictionaryTree = $('#dictionaryTree');
    var dictionaryListSelected = 0;
    var dictionaryTreeSelected = 0;
    DictionaryList.datagrid({
        url: '/mc/dictionary/query',
        methord: 'POST',
        toolbar: '#dictionaryListToolbar',
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
        title: '字典列表',
        columns: [
            [{
                field: 'Name',
                title: '名称',
                width: 20,
            }, {
                field: 'Description',
                title: '描述',
                width: 20,
            }, {
                field: 'ID',
                title: '编码',
                width: 10,
                align: 'center'
            }]
        ],
        onClickRow: function(rowIndex, rowData) {
            if (rowData.ID == dictionaryListSelected) {
                return false;
            }
            DictionaryTree.treegrid('options').url = '/mc/dictionary/query?id=' + rowData.ID;
            DictionaryTree.treegrid('unselectAll');
            DictionaryTree.treegrid('reload');
            dictionaryListSelected = rowData.ID;
        }
    });
    $("#btnCreateDictionary").click(function() {
        PopModalWindow('/mc/dictionary/create/list/0', '新增', 350, 250, 'icon-add');
    });
    $("#btnEditDictionary").click(function() {
        var row = DictionaryList.datagrid('getSelected');
        if (row) {
            PopModalWindow('/mc/dictionary/edit/list/' + row.ID, '编辑', 350, 250, 'icon-edit');
        } else {
            ReturnByWarn('请选择要操作的记录');
        }
    });
    $("#btnDeleteDictionary").click(function() {
        var row = DictionaryList.datagrid('getSelected');
        if (row) {
            $.messager.confirm('提示', '您确定要删除[' + row.Name + ']吗？', function(r) {
                if (r) {
                    $.ajax({
                        url: '/mc/dictionary/delete/' + row.ID,
                        type: "POST",
                        dataType: "json",
                        beforeSend: Mask,
                        success: function(data) {
                            if (data.result > 0) {
                                ReturnByReloadDataGrid("#dictionaryList", -1);
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

    DictionaryTree.treegrid({
        methord: 'POST',
        toolbar: '#dictionaryTreeToolbar',
        fit: true,
        fitColumns: true,
        autoRowHeight: false,
        treeField: 'Name',
        idField: 'ID',
        pagination: false,
        striped: true,
        singleSelect: true,
        remoteSort: false,
        title: '编码列表',
        columns: [
            [{
                field: 'Name',
                title: '名称',
                width: 20
            }, {
                field: 'Description',
                title: '描述',
                width: 20
            }, {
                field: 'ID',
                title: '编码',
                width: 10,
                align: 'center'
            }]
        ],
        onClickRow: function(row) {
            if (row.ID == dictionaryTreeSelected) {
                DictionaryTree.treegrid('unselect', row.ID);
                dictionaryTreeSelected = 0;
                return false;
            }
            if (row.IsLast <= 0) {
                DictionaryTree.treegrid('expand', row.ID);
            }
            dictionaryTreeSelected = row.ID;
        }
    });
    $("#btnCreateSubDictionary").click(function() {
        var row = DictionaryList.datagrid('getSelected');
        var row2 = DictionaryTree.treegrid('getSelected');
        var parentId = null;
        if (row) {
            if (row2) {
                if (row2.IsLast > 0) {
                    return false;
                } else {
                    parentId = row2.ID;
                }
            } else {
                parentId = row.ID;
            }
        }
        if (parentId) {
            PopModalWindow('/mc/dictionary/create/tree/' + parentId, '新增', 350, 250, 'icon-add');
        } else {
            ReturnByWarn('请选择要操作的记录');
        }
    });
    $("#btnEditSubDictionary").click(function() {
        var row = DictionaryTree.treegrid('getSelected');
        if (row) {
            PopModalWindow('/mc/dictionary/edit/tree/' + row.ID, '编辑', 350, 250, 'icon-edit');
        } else {
            ReturnByWarn('请选择要操作的记录');
        }
    });
    $("#btnDeleteSubDictionary").click(function() {
        var row = DictionaryTree.treegrid('getSelected');
        if (row) {
            $.messager.confirm('提示', '您确定要删除[' + row.Name + ']吗？', function(r) {
                if (r) {
                    $.ajax({
                        url: '/mc/dictionary/delete/' + row.ID,
                        type: "POST",
                        dataType: "json",
                        beforeSend: Mask,
                        success: function(data) {
                            if (data.result > 0) {
                                ReturnByReloadTreeGrid("#dictionaryTree", -1);
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
});
</script>
