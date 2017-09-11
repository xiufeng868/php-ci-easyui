<div class="mvctool bgb">
    <?php echo setButton("btnSave", "icon-save", "保存", FALSE); ?>
    <?php echo setButton("btnReturn", "icon-return", "返回"); ?>
</div>
<form id="form1" class="easyui-form" method="post" data-options="novalidate:true">
    <input id="ID" name="ID" type="hidden" value="<?php echo $ID; ?>" />
    <table class="fromEditTable setTextWidth300">
        <tr>
            <td style="width: 110px; text-align: right;">
                模块名称：
            </td>
            <td>
                <input class="easyui-textbox" id="Name" name="Name" value="<?php echo $Name; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                模块说明：
            </td>
            <td>
                <input class="easyui-textbox" id="Remark" name="Remark" value="<?php echo $Remark; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                上级ID：
            </td>
            <td>
                <input class="easyui-numberbox" id="ParentID" name="ParentID" value="<?php echo $ParentID; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                链接：
            </td>
            <td>
                <input class="easyui-textbox" id="Url" name="Url" value="<?php echo $Url; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                模块码：
            </td>
            <td>
                <input class="easyui-textbox" id="Code" name="Code" value="<?php echo $Code; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                图标：
            </td>
            <td>
                <input class="easyui-textbox" id="Icon" name="Icon" value="<?php echo $Icon; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                排序：
            </td>
            <td>
                <input class="easyui-numberspinner" data-options="min:1,max:255" id="Sort" name="Sort" value="<?php echo $Sort; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                是否启用：
            </td>
            <td>
                <input id="IsEnable" name="IsEnable" value="false" type="hidden" />
                <input <?php echo $IsEnable==1 ? 'checked' : ''; ?> id="IsEnable" name="IsEnable" value="true" type="checkbox" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                是否最后一项：
            </td>
            <td>
                <input id="IsLast" name="IsLast" value="false" type="hidden" />
                <input <?php echo $IsLast==1 ? 'checked' : ''; ?> id="IsLast" name="IsLast" value="true" type="checkbox" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
$(function() {
    $("#btnSave").click(function() {
        $.ajax({
            url: '/mc/module/edit_post',
            type: "POST",
            data: $("form").serialize(),
            dataType: "json",
            beforeSend: Mask,
            success: function(data) {
                if (data.result > 0) {
                    ReturnByReloadTreeGrid("#moduleList", 0, data.value, 'Sort', 'asc');
                    ReturnByClose();
                }
                ReturnByMessage(data.message);
            }
        });
    });
});
</script>
