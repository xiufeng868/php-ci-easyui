<div class="easyui-layout" data-options="fit:true">
    <div data-options="region:'west',border:false" style="width:70%;height:100%;padding:4px;">
        <div id="movieListToolbar" class="mvctool">
            <?php echo setButton("btnDetailsMovie", "icon-details", "详细", $permission, "details", false); ?>
            <?php echo setButton("btnCreateMovie", "icon-add", "新增", $permission, "create"); ?>
            <?php echo setButton("btnEditMovie", "icon-edit", "编辑", $permission, "edit"); ?>
            <?php echo setButton("btnDeleteMovie", "icon-delete", "删除", $permission, "delete"); ?>
            <?php echo setButton("btnCrawlMovie", "icon-crawl", "抓取", $permission, "crawl"); ?>
            <?php if (checkPermission($permission, 'query')) {?>
            <div class="search">
                <input class="easyui-searchbox" id="searchMovie" type="text" />
            </div>
            <?php }?>
        </div>
        <table id="movieList"></table>
    </div>
    <div data-options="region:'center',border:false" style="padding:4px 4px 4px 0px;">
        <div class="easyui-layout" data-options="fit:true">
            <div data-options="region:'north',border:false" style="height:50%;">
                <div id="movieCastListToolbar" class="mvctool">
                    <?php echo setButton("btnCreateMovieCast", "icon-add", "新增", $permission, "create", false); ?>
                    <?php echo setButton("btnEditMovieCast", "icon-edit", "编辑", $permission, "edit"); ?>
                    <?php echo setButton("btnDeleteMovieCast", "icon-delete", "删除", $permission, "delete"); ?>
                </div>
                <table id="movieCastList"></table>
            </div>
            <div data-options="region:'south',border:false" style="height:50%; padding-top:3px;">
                <div id="linkListToolbar" class="mvctool">
                    <?php echo setButton("btnDetailsLink", "icon-details", "详细", $permission, "details", false); ?>
                    <?php echo setButton("btnCreateLink", "icon-add", "新增", $permission, "create"); ?>
                    <?php echo setButton("btnEditLink", "icon-edit", "编辑", $permission, "edit"); ?>
                    <?php echo setButton("btnDeleteLink", "icon-delete", "删除", $permission, "delete"); ?>
                </div>
                <table id="linkList"></table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var MovieList = $('#movieList');
        var MovieCastList = $('#movieCastList');
        var LinkList = $('#linkList');
        MovieList.datagrid({
            url: '/mv/movie/query',
            methord: 'POST',
            toolbar: '#movieListToolbar',
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
            title: '电影列表',
            columns: [
                [{
                    field: 'ID',
                    title: 'ID',
                    width: 7,
                    align: 'center',
                    formatter: function(value, row, index) {
                        return '<a href="' + row.Url + '" target="_blank">' + value + '</a>';
                    }
                }, {
                    field: 'Title',
                    title: '片名',
                    width: 15,
                    align: 'center',
                    formatter: function(value, row, index) {
                        return '<span class="cover" title="<img src=' + row.CoverM + ' />">' + value + '</span>';
                    }
                }, {
                    field: 'TitleOrigin',
                    title: '原名',
                    width: 15,
                    align: 'center'
                }, {
                    field: 'IMDb',
                    title: 'IMDb',
                    width: 7,
                    align: 'center',
                    formatter: function(value, row, index) {
                        return '<a href="http://www.imdb.com/title/' + value + '" target="_blank">' + value + '</a>';
                    }
                }, {
                    field: 'Rating',
                    title: '评分',
                    width: 4,
                    align: 'center'
                }, {
                    field: 'Year',
                    title: '年代',
                    width: 4,
                    align: 'center'
                }, {
                    field: 'IsDelete',
                    title: '状态',
                    width: 3,
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
                    width: 12,
                    align: 'center'
                }]
            ],
            onClickRow: function(rowIndex, rowData) {

            },
            onDblClickRow: function(rowIndex, rowData) {
                MovieCastList.datagrid({
                    url: '/mv/movie/query_cast/' + rowData.ID
                });
                LinkList.datagrid({
                    url: '/mv/movie/query_link/' + rowData.ID
                });
            },
            onLoadSuccess: function(data) {
                $('.cover').tooltip({
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
        $('#searchMovie').searchbox({
            searcher: function(value, name) {
                MovieList.datagrid('load', {
                    queryStr: encodeURI(value)
                });
                $(this).textbox('clear');
            },
            prompt: '输入关键字'
        });
        $("#btnCrawlMovie").click(function() {
            PopModalWindow('/mv/movie/crawl', '抓取', 300, 150, 'icon-crawl');
        });
        $("#btnCreateMovie").click(function() {
            PopModalWindow('/mv/movie/create', '新增', 650, 450, 'icon-add');
        });
        $("#btnEditMovie").click(function() {
            var row = MovieList.datagrid('getSelected');
            if (row) {
                PopModalWindow('/mv/movie/edit/' + row.ID, '编辑', 650, 450, 'icon-edit');
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
        $("#btnDetailsMovie").click(function() {
            var row = MovieList.datagrid('getSelected');
            if (row) {
                PopModalWindow('/mv/movie/details/' + row.ID, '详细', 600, 450, 'icon-details');
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
        $("#btnDeleteMovie").click(function() {
            var row = MovieList.datagrid('getSelected');
            if (row) {
                if (row.IsDelete > 0) {
                    $.messager.confirm('提示', '您确定要还原[' + row.Title + ']吗？', function(r) {
                        if (r) {
                            $.ajax({
                                url: '/mv/movie/restore/' + row.ID,
                                type: "POST",
                                dataType: "json",
                                beforeSend: Mask,
                                success: function(data) {
                                    if (data.result > 0) {
                                        ReturnByReloadDataGrid('#movieList', 0, {
                                            "IsDelete": 0
                                        });
                                    }
                                    ReturnByMessage(data.message);
                                }
                            });
                        }
                    });
                } else {
                    $.messager.confirm('提示', '您确定要删除[' + row.Title + ']吗？', function(r) {
                        if (r) {
                            $.ajax({
                                url: '/mv/movie/delete/' + row.ID,
                                type: "POST",
                                dataType: "json",
                                beforeSend: Mask,
                                success: function(data) {
                                    if (data.result > 0) {
                                        ReturnByReloadDataGrid('#movieList', 0, {
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

        MovieCastList.datagrid({
            methord: 'POST',
            toolbar: '#movieCastListToolbar',
            height: '50%',
            fit: true,
            fitColumns: true,
            autoRowHeight: false,
            pageSize: 100,
            pagination: false,
            idField: 'ID',
            striped: true,
            singleSelect: true,
            rownumbers: true,
            remoteSort: false,
            title: '演员列表',
            columns: [
                [{
                    field: 'CastID',
                    title: 'ID',
                    width: 5,
                    align: 'center',
                    formatter: function(value, row, index) {
                        return '<a href="https://movie.douban.com/celebrity/' + row.CastID + '/" target="_blank">' + value + '</a>';
                    }
                }, {
                    field: 'Name',
                    title: '姓名',
                    width: 12,
                    align: 'center'
                }, {
                    field: 'IsDirector',
                    title: '导演',
                    width: 3,
                    align: 'center',
                    formatter: function(value) {
                        if (value > 0) {
                            return '<span class="icon-enable icon"></span>';
                        } else {
                            return '<span class="icon-disable icon"></span>';
                        }
                    }
                }, {
                    field: 'Sort',
                    title: '排序',
                    width: 3,
                    align: 'center',
                    sorter: NumberSort
                }]
            ],
            onClickRow: function(rowIndex, rowData) {
                // 单击事件
                // clearTimeout(TimeFn);
                // TimeFn = setTimeout(function(){
                //     alert(1);
                // },200);
            },
            onDblClickRow: function(rowIndex, rowData) {
                // 双击事件，不触发单击事件
                // clearTimeout(TimeFn);
                // alert(2);
            }
        });
        $("#btnCreateMovieCast").click(function() {
            var row = MovieList.datagrid('getSelected');
            if (row) {
                PopModalWindow('/mv/movie/create_cast', '新增', 350, 200, 'icon-add');
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
        $("#btnEditMovieCast").click(function() {
            var row = MovieCastList.datagrid('getSelected');
            if (row) {
                PopModalWindow('/mv/movie/edit_cast/' + row.ID, '编辑', 350, 150, 'icon-edit');
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
        $("#btnDeleteMovieCast").click(function() {
            var row = MovieCastList.datagrid('getSelected');
            if (row) {
                $.messager.confirm('提示', '您确定要删除[' + row.Name + ']吗？', function(r) {
                    if (r) {
                        $.ajax({
                            url: '/mv/movie/delete_cast/' + row.ID,
                            type: "POST",
                            dataType: "json",
                            beforeSend: Mask,
                            success: function(data) {
                                if (data.result > 0) {
                                    ReturnByReloadDataGrid('#movieCastList', -1);
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

        LinkList.datagrid({
            methord: 'POST',
            toolbar: '#linkListToolbar',
            height: '50%',
            fit: true,
            fitColumns: true,
            autoRowHeight: false,
            pageSize: 100,
            pagination: false,
            idField: 'ID',
            striped: true,
            singleSelect: true,
            remoteSort: false,
            title: '链接列表',
            columns: [
                [{
                    field: 'Title',
                    title: '标题',
                    width: 7,
                }, {
                    field: 'Sort',
                    title: '排序',
                    width: 1,
                    align: 'center',
                    sorter: NumberSort
                }]
            ]
        });
        $("#btnDetailsLink").click(function() {
            var row = LinkList.datagrid('getSelected');
            if (row) {
                PopModalWindow('/mv/movie/details_link/' + row.ID, '详细', 500, 300, 'icon-details');
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
        $("#btnCreateLink").click(function() {
            var row = MovieList.datagrid('getSelected');
            if (row) {
                PopModalWindow('/mv/movie/create_link', '新增', 350, 300, 'icon-add');
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
        $("#btnEditLink").click(function() {
            var row = LinkList.datagrid('getSelected');
            if (row) {
                PopModalWindow('/mv/movie/edit_link/' + row.ID, '编辑', 350, 300, 'icon-edit');
            } else {
                ReturnByWarn('请选择要操作的记录');
            }
        });
        $("#btnDeleteLink").click(function() {
            var row = LinkList.datagrid('getSelected');
            if (row) {
                $.messager.confirm('提示', '您确定要删除[' + row.Title + ']吗？', function(r) {
                    if (r) {
                        $.ajax({
                            url: '/mv/movie/delete_link/' + row.ID,
                            type: "POST",
                            dataType: "json",
                            beforeSend: Mask,
                            success: function(data) {
                                if (data.result > 0) {
                                    ReturnByReloadDataGrid('#linkList', -1);
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
