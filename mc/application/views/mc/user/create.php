<div class="mvctool bgb">
    <?php echo setButton("btnSave", "icon-save", "保存", FALSE); ?>
    <?php echo setButton("btnReturn", "icon-return", "返回"); ?>
</div>
<form id="form1" class="easyui-form" method="post" data-options="novalidate:true">
    <table class="fromEditTable setTextWidth150">
        <tr>
            <td style="width: 100px; text-align: right;">
                <label for="UserName">用户名</label>：
            </td>
            <td>
                <input class="easyui-textbox" id="UserName" name="UserName" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <label for="Password">密码</label>：
            </td>
            <td>
                <input class="easyui-textbox" id="Password" name="Password" type="password" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <label for="DisplayName">真实姓名</label>：
            </td>
            <td>
                <input class="easyui-textbox" id="DisplayName" name="DisplayName" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <label for="IsEnable">是否启用</label>：
            </td>
            <td>
                <input id="IsEnable" name="IsEnable" value="false" type="hidden" />
                <input checked="True" id="IsEnable" name="IsEnable" value="true" type="checkbox" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
$(function() {
    $("#btnSave").click(function() {
        $.ajax({
            url: '/mc/user/create_post',
            type: "POST",
            data: $("form").serialize(),
            dataType: "json",
            beforeSend: Mask,
            success: function(data) {
                if (data.result > 0) {
                    ReturnByReloadDataGrid('#userList', 1, data.value);
                    ReturnByClose();
                }
                ReturnByMessage(data.message);
            }
        });
    });
});
</script>
