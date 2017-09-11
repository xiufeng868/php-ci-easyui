//IosSelect
function FormatYear(nowYear) {
    var arr = [];
    for (var i = nowYear - 1; i <= nowYear + 1; i++) {
        arr.push({
            ID: i + '',
            Name: i + '年'
        });
    }
    return arr;
}

function FormatMonth() {
    var arr = [];
    for (var i = 1; i <= 12; i++) {
        arr.push({
            ID: i + '',
            Name: i + '月'
        });
    }
    return arr;
}

function FormatDay(count) {
    var arr = [];
    for (var i = 1; i <= count; i++) {
        arr.push({
            ID: i + '',
            Name: i + '日'
        });
    }
    return arr;
}

function IosSelectDatePicker(selectId, hiddenId) {
    var datePicker = $(selectId);
    var hidden = $(hiddenId);
    // 初始化时间
    var now = new Date();
    var nowYear = now.getFullYear();
    var nowMonth = now.getMonth() + 1;
    var nowDay = now.getDate();
    datePicker.attr('date-year', nowYear);
    datePicker.attr('date-month', nowMonth);
    datePicker.attr('date-day', nowDay);
    // 初始化控件
    var yearData = FormatYear(nowYear);
    var monthData = FormatMonth();
    var dayData = function(year, month) {
        if (/^1|3|5|7|8|10|12$/.test(month)) {
            return FormatDay(31);
        } else if (/^4|6|9|11$/.test(month)) {
            return FormatDay(30);
        } else if (/^2$/.test(month)) {
            if (year % 4 === 0 && year % 100 !== 0 || year % 400 === 0) {
                return FormatDay(29);
            } else {
                return FormatDay(28);
            }
        } else {
            throw new Error('month is illegal');
        }
    };
    // 绑定控件
    datePicker.click(function() {
        var iosSelect = new IosSelect(3, [yearData, monthData, dayData], {
            title: '选择支付日期',
            oneLevelId: datePicker.attr('date-year'),
            twoLevelId: datePicker.attr('date-month'),
            threeLevelId: datePicker.attr('date-day'),
            callback: function(selectOneObj, selectTwoObj, selectThreeObj) {
                datePicker.attr('date-year', selectOneObj.id);
                datePicker.attr('date-month', selectTwoObj.id);
                datePicker.attr('date-day', selectThreeObj.id);
                datePicker.val(selectOneObj.id + '-' + selectTwoObj.id + '-' + selectThreeObj.id);
                datePicker.removeClass("c2").addClass("c1");
                hidden.val(datePicker.val());
            }
        });
    });
}

function IosSelectOneLevel(selectId, hiddenId, data, titleStr) {
    var select = $(selectId);
    var hidden = $(hiddenId);
    select.click(function() {
        new IosSelect(1, [data], {
            title: titleStr,
            oneLevelId: hidden.val(),
            callback: function(selectOneObj) {
                hidden.val(selectOneObj.id);
                select.val(selectOneObj.name);
                select.removeClass("c2").addClass("c1");
            }
        });
    });
}

function IosSelectTwoLevel(selectId, hidden1Id, hidden2Id, data1, data2, titleStr) {
    var select = $(selectId);
    var hidden1 = $(hidden1Id);
    var hidden2 = $(hidden2Id);
    select.click(function() {
        new IosSelect(2, [data1, data2], {
            title: titleStr,
            oneTwoRelation: 1,
            oneLevelId: hidden1.val(),
            twoLevelId: hidden2.val(),
            callback: function(selectOneObj, selectTwoObj) {
                hidden1.val(selectOneObj.id);
                hidden2.val(selectTwoObj.id);
                select.val(selectOneObj.name + ' - ' + selectTwoObj.name);
                select.removeClass("c2").addClass("c1");
            }
        });
    });
}
//通用方法
function ReturnByReloadDataGrid(obj, action) { //jQueryObj, action, rowData, sort, order
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

var spinner = new Spinner({color: '#fff'});
var spined = false;
function Mask() {
    if (spined) {
        spinner.stop();
        $('#mask').hide();
    } else {
        $('#mask').show();
        spinner.spin(document.body);
    }
    spined = !spined;
}

function Messager(message, times, color) {
    $(".messager-body").window('close');
    $.messager.show({
        width: $(document).width(),
        height: 'auto',
        msg: message,
        timeout: times,
        showType: 'fade',
        style: {
            left: '',
            right: '',
            top: '',
            bottom: 40,
            padding: 0
        }
    });
    $('.messager-body').last().removeClass("c1 c5 c6").addClass(color);
}

function Error(message) {
    Messager(message, 1500, 'c5');
}

function Notice(message) {
    Messager(message, 50000, 'c6');
}

function Success(message) {
    Messager(message, 1500, 'c1');
}
//业务方法
function ToDelete() {
    $('#btn2Delete').hide();
    $('#btn2Edit').hide();
    $('#btnCancel').show();
    $('#btnDelete').show();
}

function Edit() {
    $(".messager-body").window('close');
    var row = ExpenseList.datagrid('getSelected');
    if (row) {
        $('#ID').val(row.ID);
        $('#PaymentTime').val(row.PaymentTime);
        $('#Type1').val(row.Type1);
        $('#Type2').val(row.Type2);
        $('#Mode').val(row.Mode);
        $('#Beneficiary').val(row.Beneficiary);
        $('#Name').textbox('setValue', row.Name);
        $('#Amount').textbox('setValue', row.Amount);
        $('#Remark').textbox('setValue', row.Remark);
        var TypeSelect = $('#TypeSelect');
        TypeSelect.val(row.TypeSelect);
        TypeSelect.removeClass("c2").addClass("c1");
        var ModeSelect = $('#ModeSelect');
        ModeSelect.val(row.ModeSelect);
        ModeSelect.removeClass("c2").addClass("c1");
        var BeneficiarySelect = $('#BeneficiarySelect');
        BeneficiarySelect.val(row.BeneficiarySelect);
        BeneficiarySelect.removeClass("c2").addClass("c1");
        var PaymentTimeSelect = $('#PaymentTimeSelect');
        PaymentTimeSelect.val(row.PaymentTime);
        var arr = row.PaymentTime.split('-');
        if (arr.length == 3) {
            PaymentTimeSelect.attr('date-year', parseInt(arr[0]));
            PaymentTimeSelect.attr('date-month', parseInt(arr[1]));
            PaymentTimeSelect.attr('date-day', parseInt(arr[2]));
            PaymentTimeSelect.removeClass("c2").addClass("c1");
        }
        $('#btnCreate').hide();
        $('#btnEdit').show();
        $.mobile.go('#pform','pop','');
    }
}

function Cancel() {
    $('#btnDelete').attr('disabled', true);
    $(".messager-body").window('close');
}

function Delete() {
    var row = ExpenseList.datagrid('getSelected');
    if (row) {
        $.ajax({
            url: '/lc/expense/delete/' + row.ID,
            type: "POST",
            dataType: "json",
            beforeSend: Mask,
            complete: Mask,
            success: function(data) {
                if (data.result > 0) {
                    ReturnByReloadDataGrid(ExpenseList, -1);
                    Success(data.message);
                } else {
                    Error(data.message);
                }
            }
        });
    }
}

function Reset() {
    $('#form_m :input').val('');
    var PaymentTimeSelect = $('#PaymentTimeSelect');
    PaymentTimeSelect.val('支付日期');
    PaymentTimeSelect.removeClass("c1").addClass("c2");
    var now = new Date();
    PaymentTimeSelect.attr('date-year', now.getFullYear());
    PaymentTimeSelect.attr('date-month', now.getMonth() + 1);
    PaymentTimeSelect.attr('date-day', now.getDate());
    var TypeSelect = $('#TypeSelect');
    TypeSelect.val('支付类别');
    TypeSelect.removeClass("c1").addClass("c2");
    var ModeSelect = $('#ModeSelect');
    ModeSelect.val('支付方式');
    ModeSelect.removeClass("c1").addClass("c2");
    var BeneficiarySelect = $('#BeneficiarySelect');
    BeneficiarySelect.val('受益人');
    BeneficiarySelect.removeClass("c1").addClass("c2");
    $('#Name').textbox('clear');
    $('#Amount').textbox('clear');
    $('#Remark').textbox('clear');
    $('#btnCreate').show();
    $('#btnEdit').hide();
}
//执行代码
$(function() {
    IosSelectDatePicker("#PaymentTimeSelect", "#PaymentTime");
    IosSelectTwoLevel("#TypeSelect", "#Type1", "#Type2", array_type1, array_type2);
    IosSelectOneLevel("#ModeSelect", "#Mode", array_mode, '选择支付方式');
    IosSelectOneLevel("#BeneficiarySelect", "#Beneficiary", array_beneficiary, '选择受益人');
    ExpenseList.datagrid({
        url: '/m/query',
        methord: 'POST',
        scrollbarSize: 0,
        idField: 'ID',
        pagination: true,
        pageSize: 10,
        striped: true,
        showHeader: false,
        border: false,
        singleSelect: true,
        remoteSort: false,
        columns: [
            [{
                field: 'ID',
                width: '100%',
                formatter: function(value, row, index) {
                    return '<div class="left date">' + row.PaymentTime + '</div>' + '<div class="center name">' + row.Name + '</div>' + '<div class="right amount">￥' + row.Amount + '</div>' + '<div style="height:5px;clear:both;"></div>' + '<div class="left ">' + row.BeneficiarySelect + '</div>' + '<div class="center ">' + row.TypeSelect + '</div>' + '<div class="right ">' + row.ModeSelect + '</div>';
                }
            }]
        ],
        queryParams: {
            queryStr: ''
        },
        onClickRow: function(index, row) {
            Notice('<div style="clear:both;">' + row.Remark + '</div>' + '<div style="height:5px;clear:both;"></div>' + '<div style="clear:both;">' + row.CreateTime + ' - ' + row.UserName + '</div>' + '<div style="height:15px;clear:both;"></div>' + '<div style="clear:both;"><button id="btn2Delete" class="easyui-linkbutton c5" style="width:49%;" onclick="ToDelete();">删 除</button><button id="btn2Edit" class="easyui-linkbutton c7" style="width:49%;float:right;" onclick="Edit();">修 改</button><button id="btnCancel" class="easyui-linkbutton c2" style="width:40%;display:none;" onclick="Cancel();">取 消</button><button id="btnDelete" class="easyui-linkbutton c5" style="width:40%;float:right;display:none;" onclick="Delete();">确 认</button></div>');
        }
    });
    ExpenseList.datagrid('getPager').pagination({
        layout: ['prev', 'sep', 'manual', 'sep', 'next']
    });
    $("#btnCreate").click(function() {
        $.ajax({
            url: '/m/create_post',
            type: "POST",
            data: $("#form_m").serialize(),
            dataType: "json",
            beforeSend: Mask,
            complete: Mask,
            success: function(data) {
                if (data.result > 0) {
                    $("#Name").textbox('clear');
                    $("#Amount").textbox('clear');
                    $("#Remark").textbox('clear');
                    ReturnByReloadDataGrid(ExpenseList, 1, data.value);
                    Success(data.message);
                } else {
                    Error(data.message);
                }
            }
        });
    });
    $("#btnEdit").click(function() {
        $.ajax({
            url: '/m/edit_post',
            type: "POST",
            data: $("form").serialize(),
            dataType: "json",
            beforeSend: Mask,
            complete: Mask,
            success: function(data) {
                if (data.result > 0) {
                    ReturnByReloadDataGrid(ExpenseList, 0, data.value);
                    Success(data.message);
                    $.mobile.go('#plist','pop','');
                } else {
                    Error(data.message);
                }
            }
        });
    });
    $("#btn2List").click(function() {
        $(".messager-body").window('close');
        $.mobile.go('#plist','pop','');
    });
    $("#btn2Create").click(function() {
        $(".messager-body").window('close');
        Reset();
        $.mobile.go('#pform','pop','');
    });
    $('#btnSearch').click(function() {
        keyword = $('#txtKeyword');
        ExpenseList.datagrid('load', {
            queryStr: keyword.val()
        });
        keyword.textbox('clear');
    });
    $('.datagrid-mask-msg').css('margin-left', '-63.5px');
    FastClick.attach(document.body);
    if (/iP(hone|ad)/.test(window.navigator.userAgent)) {
        document.getElementById("plist").addEventListener('touchstart', function() {
            $(".messager-body").window('close');
        }, false);
        document.body.addEventListener('touchstart', function() {}, false);
    }
});
