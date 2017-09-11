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
            用户名：
        </td>
        <td>
            <?php echo $UserName; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            真实姓名：
        </td>
        <td>
            <?php echo $DisplayName; ?>
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
    <tr>
        <td style="text-align: right;">
            是否启用：
        </td>
        <td>
            <input <?php echo $IsEnable==1 ? 'checked' : ''; ?> disabled="disabled" type="checkbox" />
        </td>
    </tr>
</table>
