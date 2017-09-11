<div class="mvctool bgb">
    <?php echo setButton("btnSave", "icon-save", "保存", false); ?>
    <?php echo setButton("btnReturn", "icon-return", "返回"); ?>
</div>
<form id="form1" class="easyui-form" method="post" data-options="novalidate:true">
    <input id="ID" name="ID" type="hidden" value="<?php echo $ID; ?>" />
    <input id="Password" name="Password" type="hidden" value="<?php echo $Password; ?>" />
    <table class="fromEditTable setTextWidth150">
        <tr>
            <td style="width: 100px; text-align: right;">
                <label for="PWD">密码</label>：
            </td>
            <td>
                <input class="easyui-textbox" id="PWD" name="PWD" type="password" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <label for="DisplayName">真实姓名</label>：
            </td>
            <td>
                <input class="easyui-textbox" id="DisplayName" name="DisplayName" value="<?php echo $DisplayName; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <label for="IsEnable">是否启用</label>：
            </td>
            <td>
                <input id="IsEnable" name="IsEnable" value="false" type="hidden" />
                <input <?php echo $IsEnable==1 ? 'checked' : ''; ?> id="IsEnable" name="IsEnable" value="true" type="checkbox" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
$(function() {
    $("#btnSave").click(function() {
        $.ajax({
            url: '/mc/user/edit_post',
            type: "POST",
            data: $("form").serialize(),
            dataType: "json",
            beforeSend: Mask,
            success: function(data) {
                if (data.result > 0) {
                    ReturnByReloadDataGrid('#userList', 0, data.value, 'UpdateTime', 'desc');
                    ReturnByClose();
                }
                ReturnByMessage(data.message);
            }
        });
    });
});
</script>
