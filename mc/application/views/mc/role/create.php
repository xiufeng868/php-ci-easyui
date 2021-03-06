<div class="mvctool bgb">
	<?php echo setButton("btnSave", "icon-save", "保存", FALSE); ?>
	<?php echo setButton("btnReturn", "icon-return", "返回"); ?>
</div>
<form id="form1" class="easyui-form" method="post" data-options="novalidate:true">
	<table class="fromEditTable setTextWidth150">
		<tr>
			<td style="width: 100px; text-align: right;">
				<label for="Name">角色名称</label>：
			</td>
			<td>
				<input class="easyui-textbox" id="Name" name="Name" type="text" />
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">
				<label for="Remark">角色说明</label>：
			</td>
			<td>
				<input class="easyui-textbox" id="Remark" name="Remark" type="text" />
			</td>
		</tr>
	</table>
</form>
<script type="text/javascript">
	$(function() {
		$("#btnSave").click(function() {
			$.ajax({
				url : '/mc/role/create_post',
				type : "POST",
				data : $("form").serialize(),
				dataType : "json",
				beforeSend: Mask,
				success : function(data) {
					if (data.result > 0) {
						ReturnByReloadDataGrid('#roleList', 1, data.value);
						ReturnByClose();
					}
					ReturnByMessage(data.message);
				}
			});
		});
	});
</script>
