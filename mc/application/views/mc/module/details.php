<div class="mvctool bgb">
    <?php echo setButton("btnReturn", "icon-return", "返回", false); ?>
</div>
<table class="fromEditTable">
	<tr>
		<td style="width: 110px; text-align: right;">
			ID：
		</td>
		<td>
			<?php echo $ID; ?>
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
			模块名称：
		</td>
		<td>
			<?php echo $Name; ?>
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
			模块说明：
		</td>
		<td>
			<?php echo $Remark; ?>
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
			上级ID：
		</td>
		<td>
			<?php echo $ParentID; ?>
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
			链接：
		</td>
		<td>
			<?php echo $Url; ?>
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
			模块码：
		</td>
		<td>
			<?php echo $Code; ?>
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
			图标：
		</td>
		<td>
			<?php echo $Icon; ?>
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
			排序：
		</td>
		<td>
			<?php echo $Sort; ?>
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
			是否启用：
		</td>
		<td>
			<input <?php echo $IsEnable == 1 ? 'checked' : ''; ?> disabled="disabled" type="checkbox" />
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
			是否最后一项：
		</td>
		<td>
			<input <?php echo $IsLast == 1 ? 'checked' : ''; ?> disabled="disabled" type="checkbox" />
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
			创建时间：
		</td>
		<td>
			<?php echo $CreateTime; ?>
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
			更新时间：
		</td>
		<td>
			<?php echo $UpdateTime; ?>
		</td>
	</tr>
</table>
