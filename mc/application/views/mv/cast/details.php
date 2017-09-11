<div class="mvctool bgb">
    <?php echo setButton("btnReturn", "icon-return", "返回", false); ?>
</div>
<table class="fromEditTable">
    <tr>
        <td style="width: 150px; text-align: right;">
            ID：
        </td>
        <td>
            <?php echo $ID; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            中文名：
        </td>
        <td>
            <?php echo $Name; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            英文名：
        </td>
        <td>
            <?php echo $NameE; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            更多中文名：
        </td>
        <td>
            <?php echo $Aka; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            更多英文名：
        </td>
        <td>
            <?php echo $AkaE; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            豆瓣URL：
        </td>
        <td>
            <a href='<?php echo $Url; ?>' target='_blank'><?php echo $Url; ?></a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            豆瓣移动URL：
        </td>
        <td>
            <a href='<?php echo $UrlM; ?>' target='_blank'><?php echo $UrlM; ?></a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            演员头像大：
        </td>
        <td>
            <a href='<?php echo $AvatarL; ?>' target='_blank'><?php echo $AvatarL; ?></a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            演员头像中：
        </td>
        <td>
            <a href='<?php echo $AvatarM; ?>' target='_blank'><?php echo $AvatarM; ?></a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            演员头像小：
        </td>
        <td>
            <a href='<?php echo $AvatarS; ?>' target='_blank'><?php echo $AvatarS; ?></a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            演员头像大(本地)：
        </td>
        <td>
            <a href='<?php echo $AvatarLL; ?>' target='_blank'><?php echo $AvatarLL; ?></a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            演员头像中(本地)：
        </td>
        <td>
            <a href='<?php echo $AvatarML; ?>' target='_blank'><?php echo $AvatarML; ?></a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            演员头像小(本地)：
        </td>
        <td>
            <a href='<?php echo $AvatarSL; ?>' target='_blank'><?php echo $AvatarSL; ?></a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            性别：
        </td>
        <td>
            <?php echo $Gender; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            出生日期：
        </td>
        <td>
            <?php echo $Birthday; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            出生地：
        </td>
        <td>
            <?php echo $BirthPlace; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            职业：
        </td>
        <td>
            <?php echo $Professions; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            星座：
        </td>
        <td>
            <?php echo $Constellation; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            IMDb：
        </td>
        <td>
            <a href='http://www.imdb.com/name/<?php echo $IMDb; ?>' target='_blank'><?php echo $IMDb; ?></a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            官方网站：
        </td>
        <td>
            <a href='<?php echo $Website; ?>' target='_blank'><?php echo $Website; ?></a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            简介：
        </td>
        <td>
            <?php echo $Summary; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            演员图片(本地)：
        </td>
        <td>
            <?php echo $Gallery; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            是否删除：
        </td>
        <td>
            <input <?php echo $IsDelete == 1 ? 'checked' : ''; ?> disabled="disabled" type="checkbox" />
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
