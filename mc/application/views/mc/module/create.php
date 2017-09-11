<div class="mvctool bgb">
    <?php echo setButton("btnSave", "icon-save", "保存", false); ?>
    <?php echo setButton("btnReturn", "icon-return", "返回"); ?>
</div>
<form id="form1" class="easyui-form" method="post" data-options="novalidate:true">
    <table class="fromEditTable setTextWidth300">
        <tr>
            <td style="width: 110px; text-align: right;">
                模块名称：
            </td>
            <td>
                <input class="easyui-textbox" id="Name" name="Name" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                模块说明：
            </td>
            <td>
                <input class="easyui-textbox" id="Remark" name="Remark" type="text" />
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
                <input class="easyui-textbox" id="Url" name="Url" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                模块码：
            </td>
            <td>
                <input class="easyui-textbox" id="Code" name="Code" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                图标：
            </td>
            <td>
                <input class="easyui-textbox" id="Icon" name="Icon" type="text" />
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
        <tr>
            <td style="text-align: right;">
                是否启用：
            </td>
            <td>
                <input id="IsEnable" name="IsEnable" value="false" type="hidden" />
                <input checked="True" id="IsEnable" name="IsEnable" value="true" type="checkbox" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                是否最后一项：
            </td>
            <td>
                <input id="IsLast" name="IsLast" value="false" type="hidden" />
                <input id="IsLast" name="IsLast" value="true" type="checkbox" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
$(function() {
    $("#btnSave").click(function() {
        $.ajax({
            url: '/mc/module/create_post',
            type: "POST",
            data: $("form").serialize(),
            dataType: "json",
            beforeSend: Mask,
            success: function(data) {
                if (data.result > 0) {
                    ReturnByReloadTreeGrid("#moduleList", 1, data.value, 'Sort', 'asc');
                    ReturnByClose();
                }
                ReturnByMessage(data.message);
            }
        });
    });
});
</script>
