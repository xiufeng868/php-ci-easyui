<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>WildString's MC</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- <script src="/resources/js/jquery.min.js"></script> -->
    <script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
    <script src="/resources/js/jquery.easyui.min.js"></script>
    <script src="/resources/js/jquery.easyui.plus.js"></script>
    <script src="/resources/js/easyui-lang-zh_CN.js"></script>
    <script src="/resources/js/common.js"></script>
    <script src="/resources/js/mc.js"></script>
    <link href="/resources/themes/<?php echo $this->session->userdata('Theme'); ?>/easyui.css" rel="stylesheet" />
    <link href="/resources/themes/<?php echo $this->session->userdata('Theme'); ?>/easyui.plus.top.css" rel="stylesheet" />
    <link href="/resources/css/style.css" rel="stylesheet" />
    <link rel="shortcut icon" href="/resources/img/favicon.ico" />
</head>

<body class="easyui-layout">
    <div data-options="region:'north',border:false" style="height: 56px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr class="head-title">
                <td><span style="float:right;"><span class="icon-admin icon"><?php echo $this->session->userdata('DisplayName'); ?></span> | <a href="#" title="安全退出" id="logout">安全退出</a></span>LENACastle </td>
            </tr>
            <tr class="head-menu">
                <td>
                    <a href="#" class="easyui-linkbutton" data-options="plain:true">Home</a>
                    <?php echo $menu; ?>
                </td>
            </tr>
        </table>
    </div>
    <div data-options="region:'center',border:false">
        <div id="mainTab" class="easyui-tabs" data-options="fit:true">
            <div title="Home" data-options="closable:true" style="overflow: hidden;">
                <iframe scrolling="auto" frameborder="0" src="" style="width: 100%; height: 100%;"></iframe>
            </div>
        </div>
    </div>
    <div data-options="region:'south',border:false" style="height: 20px;">
        <div class="define-bottom">
            <table style="width: 100%">
                <tr>
                    <td style="width: 15%">
                        <ul id="themeMenu" class="ui-skin-nav">
                            <li class="li-skinitem" title="default">
                                <span class="default" rel="default"></span>
                            </li>
                            <li class="li-skinitem" title="gray">
                                <span class="gray" rel="gray"></span>
                            </li>
                            <li class="li-skinitem" title="metro">
                                <span class="metro" rel="metro"></span>
                            </li>
                            <li class="li-skinitem" title="bootstrap">
                                <span class="bootstrap" rel="bootstrap"></span>
                            </li>
                            <li class="li-skinitem" title="material">
                                <span class="material" rel="material"></span>
                            </li>
                            <li class="li-skinitem" title="black">
                                <span class="black" rel="black"></span>
                            </li>
                        </ul>
                    </td>
                    <td style="width: 70%; text-align: center">
                        &#169;
                        <?php echo date('Y'); ?> - LENACastle
                    </td>
                    <td style="width: 15%; text-align:right; line-height:20px; padding-right: 5px;">
                        <a id="full" class="icon-full icon"></a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div id="tabMenu" class="easyui-menu" style="width: 150px;">
        <div id="tabMenu-refresh">
            刷新
        </div>
        <div class="menu-sep"></div>
        <div id="tabMenu-close">
            关闭
        </div>
        <div id="tabMenu-closeAll">
            关闭所有
        </div>
        <div id="tabMenu-closeOther">
            关闭其他
        </div>
    </div>
    <div id="modalwindow" class="easyui-window" data-options="closed:true,modal:true,resizable:false,minimizable:false,collapsible:false,maximizable:false,closable:true,draggable:false"></div>
</body>

</html>
