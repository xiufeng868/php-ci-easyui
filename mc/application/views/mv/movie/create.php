<div class="mvctool bgb">
    <?php echo setButton("btnSave", "icon-save", "保存", false); ?>
    <?php echo setButton("btnReturn", "icon-return", "返回"); ?>
</div>
<form id="form1" class="easyui-form" method="post" data-options="novalidate:true">
    <table class="fromEditTable setTextWidth100">
        <tr>
            <td style="width: 120px; text-align: right;">
                ID：
            </td>
            <td style="width: 150px">
                <input class="easyui-textbox" id="ID" name="ID" type="text" />
            </td>
            <td style="width: 120px; text-align: right;">
                中文名：
            </td>
            <td style="width: 150x">
                <input class="easyui-textbox" id="Title" name="Title" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                原名：
            </td>
            <td>
                <input class="easyui-textbox" id="TitleOrigin" name="TitleOrigin" type="text" />
            </td>
            <td style="text-align: right;">
                又名：
            </td>
            <td>
                <input class="easyui-textbox" id="Aka" name="Aka" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                豆瓣URL：
            </td>
            <td>
                <input class="easyui-textbox" id="Url" name="Url" type="text" />
            </td>
            <td style="text-align: right;">
                豆瓣移动URL：
            </td>
            <td>
                <input class="easyui-textbox" id="UrlM" name="UrlM" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                评分：
            </td>
            <td>
                <input class="easyui-textbox" id="Rating" name="Rating" type="text" />
            </td>
            <td style="text-align: right;">
                评分人数：
            </td>
            <td>
                <input class="easyui-textbox" id="RatingCount" name="RatingCount" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                封面图片大：
            </td>
            <td>
                <input class="easyui-textbox" id="CoverL" name="CoverL" type="text" />
            </td>
            <td style="text-align: right;">
                封面图片大(本地)：
            </td>
            <td>
                <input class="easyui-textbox" id="CoverLL" name="CoverLL" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                封面图片中：
            </td>
            <td>
                <input class="easyui-textbox" id="CoverM" name="CoverM" type="text" />
            </td>
            <td style="text-align: right;">
                封面图片中(本地)：
            </td>
            <td>
                <input class="easyui-textbox" id="CoverML" name="CoverML" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                封面图片小：
            </td>
            <td>
                <input class="easyui-textbox" id="CoverS" name="CoverS" type="text" />
            </td>
            <td style="text-align: right;">
                封面图片小(本地)：
            </td>
            <td>
                <input class="easyui-textbox" id="CoverSL" name="CoverSL" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                编剧：
            </td>
            <td>
                <input class="easyui-textbox" id="Writer" name="Writer" type="text" />
            </td>
            <td style="text-align: right;">
                上映日期：
            </td>
            <td>
                <input class="easyui-textbox" id="Pubdate" name="Pubdate" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                年代：
            </td>
            <td>
                <input class="easyui-textbox" id="Year" name="Year" type="text" />
            </td>
            <td style="text-align: right;">
                语言：
            </td>
            <td>
                <input class="easyui-textbox" id="Language" name="Language" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                片长：
            </td>
            <td>
                <input class="easyui-textbox" id="Duration" name="Duration" type="text" />
            </td>
            <td style="text-align: right;">
                制片国家/地区：
            </td>
            <td>
                <input class="easyui-textbox" id="Country" name="Country" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                短评数量：
            </td>
            <td>
                <input class="easyui-textbox" id="CommentCount" name="CommentCount" type="text" />
            </td>
            <td style="text-align: right;">
                影评数量：
            </td>
            <td>
                <input class="easyui-textbox" id="ReviewCount" name="ReviewCount" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                总季数(剧集)：
            </td>
            <td>
                <input class="easyui-textbox" id="SeasonCount" name="SeasonCount" type="text" />
            </td>
            <td style="text-align: right;">
                当前季数(剧集)：
            </td>
            <td>
                <input class="easyui-textbox" id="CurrentSeason" name="CurrentSeason" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                当前季集数(剧集)：
            </td>
            <td>
                <input class="easyui-textbox" id="EpisodeCount" name="EpisodeCount" type="text" />
            </td>
            <td style="text-align: right;">
                类别[mc]：
            </td>
            <td>
                <input class="easyui-combobox" data-options="valueField:'ID',textField:'Name',url:'/center/getDictionaryList/mt',panelHeight:'auto',editable:false,width:163" id="Category" name="Category" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                IMDb：
            </td>
            <td>
                <input class="easyui-textbox" id="IMDb" name="IMDb" type="text" />
            </td>
            <td style="text-align: right;">
            </td>
            <td>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; vertical-align: top; padding: 5px 0;">
                简介：
            </td>
            <td colspan="3" style="padding: 5px;">
                <input class="easyui-textbox" data-options="width:477,multiline:true,height:150" id="Summary" name="Summary" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right; vertical-align: top; padding: 5px 0;">
                电影图片(本地)：
            </td>
            <td colspan="3" style="padding: 5px;">
                <input class="easyui-textbox" data-options="width:477,multiline:true,height:150" id="Gallery" name="Gallery" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right; vertical-align: top; padding: 5px 0;">
                短评：
            </td>
            <td colspan="3" style="padding: 5px;">
                <input class="easyui-textbox" data-options="width:477,multiline:true,height:150" id="Comment" name="Comment" type="text" />
            </td>
        </tr>
        <tr>
            <td style="text-align: right; vertical-align: top; padding: 5px 0;">
                影评：
            </td>
            <td colspan="3" style="padding: 5px;">
                <input class="easyui-textbox" data-options="width:477,multiline:true,height:150" id="Review" name="Review" type="text" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
$(function() {
    $("#btnSave").click(function() {
        $.ajax({
            url: '/mv/movie/create_post',
            type: "POST",
            data: $("form").serialize(),
            dataType: "json",
            beforeSend: Mask,
            success: function(data) {
                if (data.result > 0) {
                    ReturnByReloadDataGrid('#movieList', 1, data.value);
                    $('.cover').tooltip({
                        position: 'bottom',
                        showDelay: '100',
                        hideDelay: '0'
                    });
                    ReturnByClose();
                }
                ReturnByMessage(data.message);
            }
        });
    });
});
</script>
