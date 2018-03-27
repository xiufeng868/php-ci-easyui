<!DOCTYPE html>
<html>

<head>
    <title>LENACastle</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no,minimal-ui" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="screen-orientation" content="portrait">
    <meta name="full-screen" content="yes">
    <meta name="browsermode" content="application">
    <meta name="x5-orientation" content="portrait">
    <meta name="x5-fullscreen" content="true">
    <meta name="x5-page-mode" content="app">
    <!-- <script src="/resources/js/iscroll-lite.js"></script> -->
    <!-- <script src="/resources/js/fastclick.min.js"></script> -->
    <!-- <script src="/resources/js/jquery.min.js"></script> -->
    <script src="//cdn.bootcss.com/iScroll/5.2.0/iscroll-lite.min.js"></script>
    <script src="//cdn.bootcss.com/fastclick/1.0.6/fastclick.min.js"></script>
    <script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
    <script src="/resources/js/jquery.easyui.min.js"></script>
    <script src="/resources/js/jquery.easyui.mobile.js"></script>
    <script src="/resources/js/iosSelect.js"></script>
    <script src="/resources/js/spin.min.js"></script>
    <script src="/resources/js/m.js?v=1.0"></script>
    <link href="/resources/themes/material/easyui.css" rel="stylesheet" />
    <link href="/resources/themes/mobile.css" rel="stylesheet" />
    <link href="/resources/themes/color.css" rel="stylesheet" />
    <link href="/resources/css/iosSelect.css" rel="stylesheet" />
    <link href="/resources/css/m.css?v=1.0" rel="stylesheet" />
    <link href="/resources/img/favicon_lc.ico" rel="shortcut icon" />
</head>

<body>
    <div id="pform" class="easyui-navpanel">
        <div class="m-toolbar">
            <div class="m-left">新增支出</div>
            <div class="m-right">LENACastle</div>
        </div>
        <form id="form_m" method="post">
            <input id="ID" name="ID" type="hidden" />
            <ul class="m-list">
                <li>
                    <input id="PaymentTimeSelect" class="c2" type="button" style="width:100%;height:32px;" value="支付日期" />
                    <input id="PaymentTime" name="PaymentTime" type="hidden" />
                </li>
                <li>
                    <input id="Name" name="Name" class="easyui-textbox" style="width:100%;" type="text" data-options="label:'支付名称',labelPosition:'top'" />
                </li>
                <li>
                    <input id="Amount" name="Amount" class="easyui-textbox" style="width:100%;" type="text" data-options="label:'支付金额',labelPosition:'top'" />
                </li>
                <li>
                    <input id="TypeSelect" class="c2" type="button" style="width:100%;height:32px;" value="支付类别" />
                    <input id="Type1" name="Type1" type="hidden" />
                    <input id="Type2" name="Type2" type="hidden" />
                </li>
                <li>
                    <input id="ModeSelect" class="c2" type="button" style="width:100%;height:32px;" value="支付方式" />
                    <input id="Mode" name="Mode" type="hidden" />
                </li>
                <li>
                    <input id="BeneficiarySelect" class="c2" type="button" style="width:100%;height:32px;" value="受益人" />
                    <input id="Beneficiary" name="Beneficiary" type="hidden" />
                </li>
                <li>
                    <input id="Remark" name="Remark" class="easyui-textbox" style="width:100%;" type="text" data-options="label:'备注',labelPosition:'top',width:'100%',multiline:true,height:100" />
                </li>
            </ul>
        </form>
        <footer>
            <button id="btn2List" class="c6" style="width:50%;float:left;height:40px;line-height:20px;">支付列表</button>
            <button id="btnCreate" class="c1" style="width:50%;float:left;height:40px;line-height:20px;">新 增</button>
            <button id="btnEdit" class="c7" style="width:50%;float:left;height:40px;line-height:20px;display:none;">修 改</button>
        </footer>
    </div>
    <div id="plist" class="easyui-navpanel">
        <div class="m-toolbar">
            <div class="m-left">支出列表</div>
            <div class="m-right">LENACastle</div>
        </div>
        <table id="expenseList"></table>
        <footer id="footer2">
            <input id="txtKeyword" class="easyui-textbox" style="width:65%;height:40px;line-height:20px;" data-options="prompt:'输入关键字',buttonText:'<span id=\'btnSearch\' class=\'c6\' style=\'padding:20px\'>搜 索</span>'">
            <button id="btn2Create" class="c1" style="width:35%;float:left;height:40px;line-height:20px;">新 增</button>
        </footer>
    </div>
    <div id="mask"></div>
    <script type="text/javascript">
        var array_type1 = [<?php echo $Type1 ?>];
        var array_type2 = [<?php echo $Type2 ?>];
        var array_mode = [<?php echo $Mode ?>];
        var array_beneficiary = [<?php echo $Beneficiary ?>];
        var ExpenseList = $('#expenseList');
        if ($.fn.pagination) {
            $.fn.pagination.defaults.beforePageText = '第';
            $.fn.pagination.defaults.afterPageText = '共{pages}页';
            $.fn.pagination.defaults.displayMsg = '从{from}到{to},共{total}条';
        }
        if ($.fn.datagrid) {
            $.fn.datagrid.defaults.loadMsg = 'Please Wait...&nbsp;&nbsp;&nbsp;';
        }
    </script>
</body>

</html>
