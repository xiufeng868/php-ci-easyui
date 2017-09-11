<div class="mvctool bgb">
    <?php echo setButton("btnSave", "icon-save", "保存", FALSE); ?>
    <?php echo setButton("btnReturn", "icon-return", "返回"); ?>
</div>
<form id="form1" class="easyui-form" method="post" data-options="novalidate:true">
    <table class="fromEditTable setTextWidth150">
        <tr>
            <td style="width: 70px; text-align: right;">
                <label for="UserName">类别</label>：
            </td>
            <td>
                <input class="easyui-combobox" data-options="valueField:'ID',textField:'Name',url:'/center/getDictionaryList/mt',panelHeight:'auto',editable:false,width:175" id="Category" name="Category" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <label for="UserName">电影ID</label>：
            </td>
            <td>
                <input class="easyui-textbox" data-options="width:175" id="ID" name="ID" type="text" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
$(function() {
    $("#btnSave").click(function() {
        $.ajax({
            url: '/mv/movie/crawl_post',
            type: "POST",
            data: $("form").serialize(),
            dataType: "json",
            beforeSend: Mask,
            success: function(data) {
                if (data.result > 0) {
                    var MovieID = $("#form1 #ID");
                    $("#movieList").datagrid('unselectAll');
                    $("#movieList").datagrid('selectRecord', MovieID.val());
                    ReturnByReloadDataGrid('#movieList', -1);
                    ReturnByReloadDataGrid('#movieList', 1, data.value);
                    $('.cover').tooltip({
                        position: 'bottom',
                        showDelay: '100',
                        hideDelay: '0'
                    });
                    MovieID.textbox('clear');
                }
                ReturnByMessage(data.message, null, 10000);
            }
        });
    });
});
</script>
