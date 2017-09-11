<div class="mvctool bgb">
    <?php echo setButton("btnSave", "icon-save", "保存", FALSE); ?>
    <?php echo setButton("btnReturn", "icon-return", "返回"); ?>
</div>
<form id="form1" class="easyui-form" method="post" data-options="novalidate:true">
    <input id="ModuleID" name="ModuleID" type="hidden" value="<?php echo $ModuleID; ?>">
    <table class="fromEditTable setTextWidth300">
        <tr>
            <td style="width: 100px; text-align: right;">
                操作名称：
            </td>
            <td>
                <input class="easyui-textbox" id="Name" name="Name" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                操作码：
            </td>
            <td>
                <input class="easyui-textbox" id="Code" name="Code" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                排序：
            </td>
            <td>
                <input class="easyui-numberspinner" data-options="min:1,max:255" id="Sort" name="Sort" value="1" type="text" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
$(function() {
    $("#btnSave").click(function() {
        $.ajax({
            url: '/mc/module/create_operate_post',
            type: "POST",
            data: $("form").serialize(),
            dataType: "json",
            beforeSend: Mask,
            success: function(data) {
                if (data.result > 0) {
                    ReturnByReloadDataGrid("#operateList", 1, data.value, 'Sort', 'asc');
                    ReturnByClose();
                }
                ReturnByMessage(data.message);
            }
        });
    });
});
</script>
