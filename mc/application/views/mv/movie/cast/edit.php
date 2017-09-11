<div class="mvctool bgb">
    <?php echo setButton("btnSave", "icon-save", "保存", false); ?>
    <?php echo setButton("btnReturn", "icon-return", "返回"); ?>
</div>
<form id="form1" class="easyui-form" method="post" data-options="novalidate:true">
    <input id="ID" name="ID" type="hidden" value="<?php echo $ID; ?>" />
    <table class="fromEditTable setTextWidth300">
        <tr>
            <td style="width: 100px; text-align: right;">
                排序：
            </td>
            <td>
                <input class="easyui-numberspinner" data-options="min:1,max:255" id="Sort" name="Sort" value="<?php echo $Sort; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                是否导演：
            </td>
            <td>
                <input id="IsDirector" name="IsDirector" value="false" type="hidden" />
                <input <?php echo $IsDirector==1 ? 'checked' : ''; ?> id="IsDirector" name="IsDirector" value="true" type="checkbox" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
$(function() {
    $("#btnSave").click(function() {
        $.ajax({
            url: '/mv/movie/edit_cast_post',
            type: "POST",
            data: $("form").serialize(),
            dataType: "json",
            beforeSend: Mask,
            success: function(data) {
                if (data.result > 0) {
                    ReturnByReloadDataGrid('#movieCastList', 0, data.value, 'Sort', 'asc');
                    ReturnByClose();
                }
                ReturnByMessage(data.message);
            }
        });
    });
});
</script>
