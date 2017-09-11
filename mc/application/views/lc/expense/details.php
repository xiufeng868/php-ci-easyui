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
            支付日期：
        </td>
        <td>
            <?php echo $PaymentTime; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            支出名称：
        </td>
        <td>
            <?php echo $Name; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            支出金额：
        </td>
        <td>
            <?php echo $Amount; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            支出类别：
        </td>
        <td>
            <?php echo $Type1; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            支付方式：
        </td>
        <td>
            <?php echo $Mode; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            受益人：
        </td>
        <td>
            <?php echo $Beneficiary; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            备注：
        </td>
        <td>
            <?php echo $Remark; ?>
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
            创建人：
        </td>
        <td>
            <?php echo $UserID; ?>
        </td>
    </tr>
</table>
