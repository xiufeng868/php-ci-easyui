<div class="mvctool bgb">
    <?php echo setButton("btnSave", "icon-save", "保存", false); ?>
    <?php echo setButton("btnReturn", "icon-return", "返回"); ?>
</div>
<form id="form1" class="easyui-form" method="post" data-options="novalidate:true">
    <table class="fromEditTable setTextWidth150">
        <tr>
            <td style="width: 70px; text-align: right;">
                演员ID：
            </td>
            <td>
                <input class="easyui-textbox" id="ID" name="ID" type="text" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
$(function() {
    $("#btnSave").click(function() {
        $.ajax({
            url: '/mv/cast/crawl_post',
            type: "POST",
            data: $("form").serialize(),
            dataType: "json",
            beforeSend: Mask,
            success: function(data) {
                if (data.result > 0) {
                    var CastID = $("#form1 #ID");
                    $("#castList").datagrid('selectRecord', CastID.val());
                    ReturnByReloadDataGrid('#castList', -1);
                    ReturnByReloadDataGrid('#castList', 1, data.value);
                    $('.avatar').tooltip({
                        position: 'bottom',
                        showDelay: '100',
                        hideDelay: '0'
                    });
                    CastID.textbox('clear');
                }
                ReturnByMessage(data.message);
            }
        });
    });
});
</script>
