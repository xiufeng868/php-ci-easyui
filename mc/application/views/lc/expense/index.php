<div class="easyui-layout" data-options="fit:true">
    <div data-options="region:'west',border:false" style="width:100%;height:100%;padding:4px;">
        <div id="expenseListToolbar" class="mvctool">
            <?php echo setButton("btnDetailsExpense", "icon-details", "详细", $permission, "details", false); ?>
            <?php echo setButton("btnCreateExpense", "icon-add", "新增", $permission, "create"); ?>
            <?php echo setButton("btnEditExpense", "icon-edit", "编辑", $permission, "edit"); ?>
            <?php echo setButton("btnDeleteExpense", "icon-delete", "删除", $permission, "delete"); ?>
            <?php if (checkPermission($permission, 'query')) {?>
            <div class="search">
                <input class="easyui-searchbox" id="searchExpense" type="text" />
            </div>
            <?php }?>
        </div>
        <table id="expenseList"></table>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var ExpenseList = $('#expenseList');
        ExpenseList.datagrid({
            url: '/lc/expense/query',
            methord: 'POST',
            toolbar: '#expenseListToolbar',
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
                    field: 'ID',
                    title: 'ID',
                    width: 10,
                    align: 'center'
                }, {
                    field: 'PaymentTime',
                    title: '日期',
                    width: 20,
                    align: 'center'
                }, {
                    field: 'Name',
                    title: '名称',
                    width: 50
                }, {
                    field: 'Amount',
                    title: '金额',
                    width: 20,
                    align: 'center',
                    styler: function() {
                        return "color:red";
                    }
                }, {
                    field: 'Type1',
                    title: '类别',
                    width: 30
                }, {
                    field: 'Mode',
                    title: '支付方式',
                    width: 20,
                    align: 'center'
                }, {
                    field: 'Beneficiary',
                    title: '受益人',
                    width: 20,
                    align: 'center'
                }]
            ],
            onClickRow: function(rowIndex, rowData) {
                ReturnByMessage(rowData.Remark + '<p>' + rowData.CreateTime + ' - ' + rowData.UserID + '</p>', '详细', 5000);
            }
        });
        $('#searchExpense').searchbox({
            searcher: function(value, name) {
                ExpenseList.datagrid('load', {
                    queryStr: encodeURI(value)
                });
                $(this).textbox('clear');
            },
            prompt: '输入关键字'
        });
        $("#btnCreateExpense").click(function() {
            PopModalWindow('/lc/expense/create', '新增', 400, 400, 'icon-add');
        });
        $("#btnEditExpense").click(function() {
            var row = ExpenseList.datagrid('getSelected');
            if (row) {
                PopModalWindow('/lc/expense/edit/' + row.ID, '编辑', 400, 400, 'icon-edit');
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
        $("#btnDetailsExpense").click(function() {
            var row = ExpenseList.datagrid('getSelected');
            if (row) {
                PopModalWindow('/lc/expense/details/' + row.ID, '详细', 400, 450, 'icon-details');
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
        $("#btnDeleteExpense").click(function() {
            var row = ExpenseList.datagrid('getSelected');
            if (row) {
                $.messager.confirm('提示', '您确定要删除[' + row.Name + ']吗？', function(r) {
                    if (r) {
                        $.ajax({
                            url: '/lc/expense/delete/' + row.ID,
                            type: "POST",
                            dataType: "json",
                            beforeSend: Mask,
                            success: function(data) {
                                if (data.result > 0) {
                                    ReturnByReloadDataGrid('#expenseList', -1);
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
