<div class="easyui-layout" data-options="fit:true">
    <div data-options="region:'west',border:false" style="width:100%;height:100%;padding:4px;">
        <div id="castListToolbar" class="mvctool">
            <?php echo setButton("btnDetailsCast", "icon-details", "详细", $permission, "details", false); ?>
            <?php echo setButton("btnCreateCast", "icon-add", "新增", $permission, "create"); ?>
            <?php echo setButton("btnEditCast", "icon-edit", "编辑", $permission, "edit"); ?>
            <?php echo setButton("btnDeleteCast", "icon-delete", "删除", $permission, "delete"); ?>
            <?php echo setButton("btnCrawlCast", "icon-crawl", "抓取", $permission, "crawl"); ?>
            <?php if (checkPermission($permission, 'query')) {?>
            <div class="search">
                <input class="easyui-searchbox" id="searchCast" type="text" />
            </div>
            <?php }?>
        </div>
        <table id="castList"></table>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var CastList = $('#castList');
        CastList.datagrid({
            url: '/mv/cast/query',
            methord: 'POST',
            toolbar: '#castListToolbar',
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
                    width: 6,
                    align: 'center',
                    formatter: function(value, row, index) {
                        return '<a href="' + row.Url + '" target="_blank">' + value + '</a>';
                    }
                }, {
                    field: 'Name',
                    title: '姓名',
                    width: 15,
                    align: 'center',
                    formatter: function(value, row, index) {
                        return '<span class="avatar" title="<img src=' + row.AvatarM + ' />">' + value + '</span>';
                    }
                }, {
                    field: 'NameE',
                    title: '英文名',
                    width: 15,
                    align: 'center'
                }, {
                    field: 'IMDb',
                    title: 'IMDb',
                    width: 6,
                    align: 'center',
                    formatter: function(value, row, index) {
                        return '<a href="http://www.imdb.com/name/' + value + '" target="_blank">' + value + '</a>';
                    }
                }, {
                    field: 'Gender',
                    title: '性别',
                    width: 4,
                    align: 'center'
                }, {
                    field: 'IsDelete',
                    title: '状态',
                    width: 4,
                    align: 'center',
                    formatter: function(value) {
                        if (value > 0) {
                            return '<span class="icon-disable icon"></span>';
                        } else {
                            return '<span class="icon-enable icon"></span>';
                        }
                    }
                }, {
                    field: 'UpdateTime',
                    title: '更新时间',
                    width: 10,
                    align: 'center'
                }]
            ],
            onLoadSuccess: function(data) {
                $('.avatar').tooltip({
                    position: 'bottom',
                    showDelay: '100',
                    hideDelay: '0'
                });
            },
            rowStyler: function(rowIndex, rowData) {
                if (rowData.IsDelete > 0) {
                    return 'color:Silver;';
                }
            }
        });
        $('#searchCast').searchbox({
            searcher: function(value, name) {
                CastList.datagrid('load', {
                    queryStr: encodeURI(value)
                });
                $(this).textbox('clear');
            },
            prompt: '输入关键字'
        });
        $("#btnCrawlCast").click(function() {
            PopModalWindow('/mv/cast/crawl', '抓取', 300, 120, 'icon-crawl');
        });
        $("#btnCreateCast").click(function() {
            PopModalWindow('/mv/cast/create', '新增', 650, 450, 'icon-add');
        });
        $("#btnEditCast").click(function() {
            var row = CastList.treegrid('getSelected');
            if (row) {
                PopModalWindow('/mv/cast/edit/' + row.ID, '编辑', 650, 450, 'icon-edit');
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
        $("#btnDetailsCast").click(function() {
            var row = CastList.datagrid('getSelected');
            if (row) {
                PopModalWindow('/mv/cast/details/' + row.ID, '详细', 600, 450, 'icon-details');
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
        $("#btnDeleteCast").click(function() {
            var row = CastList.treegrid('getSelected');
            if (row) {
                if (row.IsDelete > 0) {
                    $.messager.confirm('提示', '您确定要还原[' + row.Name + ']吗？', function(r) {
                        if (r) {
                            $.ajax({
                                url: '/mv/cast/restore/' + row.ID,
                                type: "POST",
                                dataType: "json",
                                beforeSend: Mask,
                                success: function(data) {
                                    if (data.result > 0) {
                                        ReturnByReloadDataGrid('#castList', 0, {
                                            "IsDelete": 0
                                        });
                                    }
                                    ReturnByMessage(data.message);
                                }
                            });
                        }
                    });
                } else {
                    $.messager.confirm('提示', '您确定要删除[' + row.Name + ']吗？', function(r) {
                        if (r) {
                            $.ajax({
                                url: '/mv/cast/delete/' + row.ID,
                                type: "POST",
                                dataType: "json",
                                beforeSend: Mask,
                                success: function(data) {
                                    if (data.result > 0) {
                                        ReturnByReloadDataGrid('#castList', 0, {
                                            "IsDelete": 1
                                        });
                                    }
                                    ReturnByMessage(data.message);
                                }
                            });
                        }
                    });
                }
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
    });
</script>
