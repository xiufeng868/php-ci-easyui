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
            <?php echo $Title; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            原名：
        </td>
        <td>
            <?php echo $TitleOrigin; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            又名：
        </td>
        <td>
            <?php echo $Aka; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            豆瓣URL：
        </td>
        <td>
            <a href='<?php echo $Url; ?>' target='_blank'>
                <?php echo $Url; ?>
            </a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            豆瓣移动URL：
        </td>
        <td>
            <a href='<?php echo $UrlM; ?>' target='_blank'>
                <?php echo $UrlM; ?>
            </a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            评分：
        </td>
        <td>
            <?php echo $Rating; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            评分人数：
        </td>
        <td>
            <?php echo $RatingCount; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            标签：
        </td>
        <td>
            <?php echo $Tag; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            封面图片大：
        </td>
        <td>
            <a href='<?php echo $CoverL; ?>' target='_blank'>
                <?php echo $CoverL; ?>
            </a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            封面图片中：
        </td>
        <td>
            <a href='<?php echo $CoverM; ?>' target='_blank'>
                <?php echo $CoverM; ?>
            </a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            封面图片小：
        </td>
        <td>
            <a href='<?php echo $CoverS; ?>' target='_blank'>
                <?php echo $CoverS; ?>
            </a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            封面图片大(本地)：
        </td>
        <td>
            <a href='<?php echo $CoverLL; ?>' target='_blank'>
                <?php echo $CoverLL; ?>
            </a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            封面图片中(本地)：
        </td>
        <td>
            <a href='<?php echo $CoverML; ?>' target='_blank'>
                <?php echo $CoverML; ?>
            </a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            封面图片小(本地)：
        </td>
        <td>
            <a href='<?php echo $CoverSL; ?>' target='_blank'>
                <?php echo $CoverSL; ?>
            </a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            编剧：
        </td>
        <td>
            <?php echo $Writer; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            上映日期：
        </td>
        <td>
            <?php echo $Pubdate; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            年代：
        </td>
        <td>
            <?php echo $Year; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            语言：
        </td>
        <td>
            <?php echo $Language; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            片长：
        </td>
        <td>
            <?php echo $Duration; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            制片国家/地区：
        </td>
        <td>
            <?php echo $Country; ?>
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
            短评数量：
        </td>
        <td>
            <?php echo $CommentCount; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            影评数量：
        </td>
        <td>
            <?php echo $ReviewCount; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            总季数(剧集)：
        </td>
        <td>
            <?php echo $SeasonCount; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            当前季数(剧集)：
        </td>
        <td>
            <?php echo $CurrentSeason; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            当前季集数(剧集)：
        </td>
        <td>
            <?php echo $EpisodeCount; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            IMDb：
        </td>
        <td>
            <a href='http://www.imdb.com/title/<?php echo $IMDb; ?>' target='_blank'>
                <?php echo $IMDb; ?>
            </a>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            类别[mc]：
        </td>
        <td>
            <?php echo $Category; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            电影图片(本地)：
        </td>
        <td>
            <?php echo $Gallery; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            短评：
        </td>
        <td>
            <?php echo $Comment; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            影评：
        </td>
        <td>
            <?php echo $Review; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">
            是否删除：
        </td>
        <td>
            <input <?php echo $IsDelete==1 ? 'checked' : ''; ?> disabled="disabled" type="checkbox" />
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
