<div class="mvctool bgb">
    <?php echo setButton("btnSave", "icon-save", "保存", FALSE); ?>
    <?php echo setButton("btnReturn", "icon-return", "返回"); ?>
</div>
<form id="form1" class="easyui-form" method="post" data-options="novalidate:true">
    <input id="ID" name="ID" type="hidden" value="<?php echo $ID; ?>" />
    <input id="MovieID" name="MovieID" type="hidden" value="<?php echo $MovieID; ?>" />
    <table class="fromEditTable setTextWidth300">
        <tr>
            <td style="width: 100px; text-align: right;">
                标题：
            </td>
            <td>
                <input class="easyui-textbox" data-options="width:175" id="Title" name="Title" value="<?php echo $Title; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                下载地址：
            </td>
            <td>
                <input class="easyui-textbox" data-options="width:175" id="Url" name="Url" value="<?php echo $Url; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                备注：
            </td>
            <td>
                <input class="easyui-textbox" data-options="width:175" id="Remark" name="Remark" value="<?php echo $Remark; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                分辨率[mc]：
            </td>
            <td>
                <input class="easyui-combobox" data-options="valueField:'ID',textField:'Name',url:'/center/getDictionaryList/02',panelHeight:'auto',editable:false,width:175" id="Resolution" name="Resolution" value="<?php echo $Resolution; ?>" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                文件大小：
            </td>
            <td>
                <input class="easyui-textbox" data-options="width:175" id="Size" name="Size" value="<?php echo $Size; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                排序：
            </td>
            <td>
                <input class="easyui-numberspinner" data-options="min:1,max:255,width:175" id="Sort" name="Sort" value="<?php echo $Sort; ?>" type="text" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    $(function() {
        $("#btnSave").click(function() {
            $.ajax({
                url : '/mv/movie/edit_link_post',
                type : "POST",
                data : $("form").serialize(),
                dataType : "json",
                beforeSend: Mask,
                success : function(data) {
                    if (data.result > 0) {
                        ReturnByReloadDataGrid('#linkList', 0, data.value, 'Sort', 'asc');
                        ReturnByClose();
                    }
                    ReturnByMessage(data.message);
                }
            });
        });
    });
</script>
