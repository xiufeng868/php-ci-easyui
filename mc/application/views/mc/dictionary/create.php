<div class="mvctool bgb">
	<?php echo setButton("btnSave", "icon-save", "保存", FALSE); ?>
	<?php echo setButton("btnReturn", "icon-return", "返回"); ?>
</div>
<form id="form1" class="easyui-form" method="post" data-options="novalidate:true">
	<input id="ReturnBy" name="ReturnBy" type="hidden" value="<?php echo $ReturnBy; ?>" />
	<table class="fromEditTable setTextWidth300">
		<tr>
			<td style="width: 100px; text-align: right;">
				名称：
			</td>
			<td>
				<input class="easyui-textbox" id="Name" name="Name" type="text" />
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">
				描述：
			</td>
			<td>
				<input class="easyui-textbox" id="Description" name="Description" type="text" />
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">
				编码：
			</td>
			<td>
				<input class="easyui-textbox" id="ID" name="ID" type="text" />
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">
				上级编码：
			</td>
			<td>
				<input class="easyui-textbox" id="ParentID" name="ParentID" value="<?php echo $ParentID; ?>" readonly="readonly" type="text" />
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">
				是否最后一项：
			</td>
			<td>
				<input id="IsLast" name="IsLast" value="false" type="hidden" />
				<input checked="True" id="IsLast" name="IsLast" value="true" type="checkbox" />
			</td>
		</tr>
	</table>
</form>
<script type="text/javascript">
	$(function() {
		$("#btnSave").click(function() {
			var returnBy = $("#ReturnBy").val();
			$.ajax({
				url : '/mc/dictionary/create_post',
				type : "POST",
				data : $("form").serialize(),
				dataType : "json",
				beforeSend: Mask,
				success : function(data) {
					if (data.result > 0) {
						if (returnBy == "list") {
							ReturnByReloadDataGrid("#dictionaryList", 1, data.value, 'ID', 'asc');
						} else {
							ReturnByReloadTreeGrid("#dictionaryTree", 1, data.value, 'ID', 'asc');
						}
						ReturnByClose();
					}
					ReturnByMessage(data.message);
				}
			});
		});
	});
</script>
