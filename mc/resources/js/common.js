function AddTab(subtitle, url, icon) {
    if ($("#mainTab").tabs('exists', subtitle)) {
        $("#mainTab").tabs('select', subtitle);
    } else {
        $("#mainTab").tabs('add', {
            title: subtitle,
            href: url,
            closable: true,
            icon: icon
        });
    }
}

function PopModalWindow(src, title, width, height, icon) {
    $("#modalwindow").window({
        title: title,
        iconCls: icon,
        width: width,
        height: height,
        href: src
    }).window('open');
}

function ReturnByClose() {
    $("#modalwindow").window('close');
    $("#modalwindow").window('clear');
}

function ReturnByReloadDataGrid(jqueryid, action) { //jqueryid, action, rowData, sort, order
    var obj = $(jqueryid);
    // if (action == 'reload') {
    //     obj.datagrid('reload');
    //     obj.datagrid('clearSelections');
    //     return;
    // }
    var rowIndex = obj.datagrid('getRowIndex', obj.datagrid('getSelected'));
    if (action >= 0) {
        var rowData = arguments[2] || false;
        if (rowData) {
            if (action > 0) {
                action = 'insertRow';
                rowIndex = 0;
            } else {
                action = 'updateRow';
            }
            obj.datagrid(action, {
                index: rowIndex,
                row: rowData
            });
            var sort = arguments[3] || false;
            if (sort) {
                var order = arguments[4] || 'desc';
                obj.datagrid('sort', {
                    sortName: sort,
                    sortOrder: order
                });
            }
            obj.datagrid('selectRecord', rowData.ID);
        }
    } else {
        if (rowIndex > -1) {
            obj.datagrid('deleteRow', rowIndex);
        }
    }
}

function ReturnByReloadTreeGrid(jqueryid, action) { //jqueryid, action, rowData, sort, order
    var obj = $(jqueryid);
    var node = obj.treegrid('getSelected');
    // if (action == 'reload') {
    //     if (node && node.ParentID > 0) {
    //         obj.treegrid('reload', node.ParentID);
    //     } else {
    //         obj.treegrid('reload');
    //     }
    //     obj.treegrid('clearSelections');
    //     return;
    // }
    if (action >= 0) {
        var rowData = arguments[2] || false;
        if (rowData) {
            if (action > 0) {
                obj.treegrid('append', {
                    parent: node ? node.ID : null,
                    data: [rowData]
                });
            } else {
                if (node.ParentID != rowData.ParentID) {
                    obj.treegrid('remove', node.ID);
                    obj.treegrid('append', {
                        parent: rowData.ParentID,
                        data: [rowData]
                    });
                } else {
                    obj.treegrid('update', {
                        id: node.ID,
                        row: rowData
                    });
                }
            }
            var sort = arguments[3] || false;
            if (sort) {
                var order = arguments[4] || 'desc';
                obj.treegrid('sort', {
                    sortName: sort,
                    sortOrder: order
                });
            }
            obj.treegrid('select', rowData.ID);
        }
    } else {
        if (node) {
            obj.treegrid('remove', node.ID);
        }
    }
}

function ReturnByMessage(message) {
    $(".messager-body").window('close');
    var title = arguments[1] || '提示';
    var time = arguments[2] || 2000;
    $.messageBoxEx(title, message, time);
}

function ReturnByWarn(message) {
    ReturnByMessage('<span class="icon-warn icon"></span>' + message);
}

function GridPageSize() {
    return Math.floor(($(window).height()) / 30);
}

function Mask() {
    var toggle = arguments[0] || true;
    if (toggle) {
        $.messager.progress({
            text: 'Please Wait...',
            interval: 100
        });
        $('.messager-body:has(.messager-progress)').css({
            'width': '',
            'padding': '0px'
        });
        $('.window-shadow').hide();
    } else {
        $.messager.progress('close');
    }
}

function NumberSort(a, b) {
    if (parseFloat(a)) {
        a = parseFloat(a);
    }
    if (parseFloat(b)) {
        b = parseFloat(b);
    }
    return (a > b ? 1 : -1);
}
// var TimeFn = null; //datagrid区分单击双击计数器
