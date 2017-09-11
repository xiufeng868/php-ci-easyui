<div class="mvctool bgb">
    <?php echo setButton("btnSave", "icon-save", "保存", FALSE); ?>
    <?php echo setButton("btnReturn", "icon-return", "返回"); ?>
</div>
<form id="form1" class="easyui-form" method="post" data-options="novalidate:true">
    <input id="ID" name="ID" type="hidden" value="<?php echo $ID; ?>" />
    <table class="fromEditTable setTextWidth300">
        <tr>
            <td style="width: 90px; text-align: right;">
                <label for="PaymentTime">支付日期</label>：
            </td>
            <td>
                <input class="easyui-datebox" data-options="width:254" id="PaymentTime" name="PaymentTime" value="<?php echo $PaymentTime; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <label for="Name">支出名称</label>：
            </td>
            <td>
                <input class="easyui-textbox" data-options="width:254" id="Name" name="Name" value="<?php echo $Name; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <label for="Amount">支付金额</label>：
            </td>
            <td>
                <input class="easyui-textbox" data-options="width:254" id="Amount" name="Amount" value="<?php echo $Amount; ?>" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <label for="Type1">支出类别</label>：
            </td>
            <td>
                <input class="easyui-combobox" id="Type1" name="Type1" data-options="
					valueField:'ID',
					textField:'Name',
					url:'/center/getDictionaryList/zc',
					panelHeight:'auto',
					panelMaxHeight:175,
					editable:false,
					width:125,
					onLoadSuccess:function(){
						$('#Type1').combobox('setValue','<?php echo $Type1; ?>');
						$('#Type2').combobox('reload','/center/getDictionaryList/<?php echo $Type1; ?>'); $('#Type2').combobox('setValue','<?php echo $Type2; ?>');
					},
					onSelect:function(data){
						$('#Type2').combobox('clear');
						$('#Type2').combobox('reload','/center/getDictionaryList/'+data.ID);
					}" />
                <input class="easyui-combobox" data-options="valueField:'ID',textField:'Name',panelHeight:'auto',panelMaxHeight:175,editable:false,width:125" id="Type2" name="Type2" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <label for="Mode">支付方式</label>：
            </td>
            <td>
                <input class="easyui-combobox" data-options="valueField:'ID',textField:'Name',url:'/center/getDictionaryList/02',panelHeight:'auto',panelMaxHeight:135,editable:false,width:254" id="Mode" name="Mode" value="<?php echo $Mode; ?>" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <label for="Beneficiary">受益人</label>：
            </td>
            <td>
                <input class="easyui-combobox" data-options="valueField:'ID',textField:'Name',url:'/center/getDictionaryList/01',panelHeight:'auto',panelMaxHeight:155,editable:false,width:254" id="Beneficiary" name="Beneficiary" value="<?php echo $Beneficiary; ?>" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right; vertical-align: top; padding: 5px 0;">
                <label for="Remark">备注</label>：
            </td>
            <td style="padding: 5px;">
                <input class="easyui-textbox" data-options="width:254,multiline:true,height:75" id="Remark" name="Remark" value="<?php echo $Remark; ?>" type="text" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
$(function() {
    $("#btnSave").click(function() {
        $.ajax({
            url: '/lc/expense/edit_post',
            type: "POST",
            data: $("form").serialize(),
            dataType: "json",
            beforeSend: Mask,
            success: function(data) {
                if (data.result > 0) {
                    ReturnByReloadDataGrid('#expenseList', 0, data.value, 'PaymentTime', 'desc');
                    ReturnByClose();
                }
                ReturnByMessage(data.message);
            }
        });
    });
});
</script>
