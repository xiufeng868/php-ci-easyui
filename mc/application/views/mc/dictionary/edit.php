<div class="mvctool bgb">
    <?php echo setButton("btnSave", "icon-save", "保存", FALSE); ?>
    <?php echo setButton("btnReturn", "icon-return", "返回"); ?>
</div>
<form id="form1" class="easyui-form" method="post" data-options="novalidate:true">
    <input id="ReturnBy" name="ReturnBy" type="hidden" value="<?php echo $ReturnBy; ?>" />
    <input id="OldID" name="OldID" type="hidden" value="<?php echo $ID; ?>" />
    <table class="fromEditTable setTextWidth300">
        <tr>
            <td style="width: 100px; text-align: right;">
                名称：
            </td>
            <td>
                <input class="easyui-textbox" id="Name" name="Name" value="<?php echo $Name; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                描述：
            </td>
            <td>
                <input class="easyui-textbox" id="Description" name="Description" value="<?php echo $Description; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                编码：
            </td>
            <td>
                <input class="easyui-textbox" id="ID" name="ID" value="<?php echo $ID; ?>" type="text" disabled="disabled" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                上级编码：
            </td>
            <td>
                <input class="easyui-textbox" id="ParentID" name="ParentID" type="text" value="<?php echo $ParentID; ?>" disabled="disabled" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                是否最后一项：
            </td>
            <td>
                <input id="IsLast" name="IsLast" value="false" type="hidden" />
                <input <?php echo $IsLast==1 ? 'checked' : ''; ?> id="IsLast" name="IsLast" value="true" type="checkbox" disabled="disabled" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
$(function() {
    $("#btnSave").click(function() {
        var returnBy = $("#ReturnBy").val();
        $.ajax({
            url: '/mc/dictionary/edit_post',
            type: "POST",
            data: $("form").serialize(),
            dataType: "json",
            beforeSend: Mask,
            success: function(data) {
                if (data.result > 0) {
                    if (returnBy == "list") {
                        ReturnByReloadDataGrid("#dictionaryList", 0, data.value, 'ID', 'asc');
                    } else {
                        ReturnByReloadTreeGrid("#dictionaryTree", 0, data.value, 'ID', 'asc');
                    }
                    ReturnByClose();
                }
                ReturnByMessage(data.message);
            }
        });
    });
});
</script>
