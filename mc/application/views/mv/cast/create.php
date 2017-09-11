<div class="mvctool bgb">
    <?php echo setButton("btnSave", "icon-save", "保存", FALSE); ?>
    <?php echo setButton("btnReturn", "icon-return", "返回"); ?>
</div>
<form id="form1" class="easyui-form" method="post" data-options="novalidate:true">
    <table class="fromEditTable setTextWidth100">
        <tr>
            <td style="width: 100px; text-align: right;">
                ID：
            </td>
            <td style="width: 150px">
                <input class="easyui-textbox" id="ID" name="ID" type="text" />
            </td>
            <td style="width: 120px; text-align: right;">
                IMDb：
            </td>
            <td style="width: 150x">
                <input class="easyui-textbox" id="IMDb" name="IMDb" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                中文名：
            </td>
            <td>
                <input class="easyui-textbox" id="Name" name="Name" type="text" />
            </td>
            <td style="text-align: right;">
                英文名：
            </td>
            <td>
                <input class="easyui-textbox" id="NameE" name="NameE" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                更多中文名：
            </td>
            <td>
                <input class="easyui-textbox" id="Aka" name="Aka" type="text" />
            </td>
            <td style="text-align: right;">
                更多英文名：
            </td>
            <td>
                <input class="easyui-textbox" id="AkaE" name="AkaE" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                豆瓣URL：
            </td>
            <td>
                <input class="easyui-textbox" id="Url" name="Url" type="text" />
            </td>
            <td style="text-align: right;">
                豆瓣移动URL：
            </td>
            <td>
                <input class="easyui-textbox" id="UrlM" name="UrlM" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                演员头像大：
            </td>
            <td>
                <input class="easyui-textbox" id="AvatarL" name="AvatarL" type="text" />
            </td>
            <td style="text-align: right;">
                演员头像大(本地)：
            </td>
            <td>
                <input class="easyui-textbox" id="AvatarLL" name="AvatarLL" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                演员头像中：
            </td>
            <td>
                <input class="easyui-textbox" id="AvatarM" name="AvatarM" type="text" />
            </td>
            <td style="text-align: right;">
                演员头像中(本地)：
            </td>
            <td>
                <input class="easyui-textbox" id="AvatarML" name="AvatarML" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                演员头像小：
            </td>
            <td>
                <input class="easyui-textbox" id="AvatarS" name="AvatarS" type="text" />
            </td>
            <td style="text-align: right;">
                演员头像小(本地)：
            </td>
            <td>
                <input class="easyui-textbox" id="AvatarSL" name="AvatarSL" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                出生日期：
            </td>
            <td>
                <input class="easyui-textbox" id="Birthday" name="Birthday" type="text" />
            </td>
            <td style="text-align: right;">
                出生地：
            </td>
            <td>
                <input class="easyui-textbox" id="BirthPlace" name="BirthPlace" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                职业：
            </td>
            <td>
                <input class="easyui-textbox" id="Professions" name="Professions" type="text" />
            </td>
            <td style="text-align: right;">
                星座：
            </td>
            <td>
                <input class="easyui-textbox" id="Constellation" name="Constellation" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                性别：
            </td>
            <td>
                <input class="easyui-textbox" id="Gender" name="Gender" type="text" />
            </td>
            <td style="text-align: right;">
                官方网站：
            </td>
            <td>
                <input class="easyui-textbox" id="Website" name="Website" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right; vertical-align: top; padding: 5px 0;">
                简介：
            </td>
            <td colspan="3" style="padding: 5px;">
                <input class="easyui-textbox" data-options="width:477,multiline:true,height:150" id="Summary" name="Summary" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right; vertical-align: top; padding: 5px 0;">
                演员图片(本地)：
            </td>
            <td colspan="3" style="padding: 5px;">
                <input class="easyui-textbox" data-options="width:477,multiline:true,height:150" id="Gallery" name="Gallery" type="text" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
$(function() {
    $("#btnSave").click(function() {
        $.ajax({
            url: '/mv/cast/create_post',
            type: "POST",
            data: $("form").serialize(),
            dataType: "json",
            beforeSend: Mask,
            success: function(data) {
                if (data.result > 0) {
                    ReturnByReloadDataGrid('#castList', 1, data.value);
                    $('.avatar').tooltip({
                        position: 'bottom',
                        showDelay: '100',
                        hideDelay: '0'
                    });
                    ReturnByClose();
                }
                ReturnByMessage(data.message);
            }
        });
    });
});
</script>
