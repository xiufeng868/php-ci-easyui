<?php

header("Content-Type: text/html;charset=utf-8");

include 'application/libraries/phpQuery.php';

$sub = 'test/movie';
$url = 'https://api.douban.com/v2/movie/subject/5327268';
$json = file_get_contents($url);
$obj = json_decode($json, true);
if (array_key_exists("code", $obj)) {
    echo '豆瓣API获取电影失败：' . $obj['msg'] . '[' . $obj['code'] . '] <br>';
} else {
    $data = array(
        'ID' => $obj['id'],
        'Title' => $obj['title'],
        'TitleOrigin' => $obj['original_title'],
        'Aka' => implode(' / ', $obj['aka']),
        'Url' => $obj['alt'],
        'UrlM' => $obj['mobile_url'],
        'Rating' => $obj['rating']['average'],
        'RatingCount' => $obj['ratings_count'],
        'CoverL' => $obj['images']['large'],
        'CoverM' => $obj['images']['medium'],
        'CoverS' => $obj['images']['small'],
        'CoverLL' => crawler_download($obj['id'], $obj['images']['large'], 'test_cl', $sub),
        'CoverML' => crawler_download($obj['id'], $obj['images']['medium'], 'test_cm', $sub),
        'CoverSL' => crawler_download($obj['id'], $obj['images']['small'], 'test_cs', $sub),
        'Year' => $obj['year'],
        'Country' => implode(' / ', $obj['countries']),
        'Summary' => $obj['summary'],
        'CommentCount' => $obj['comments_count'],
        'ReviewCount' => $obj['reviews_count'],
        'SeasonCount' => $obj['seasons_count'],
        'CurrentSeason' => $obj['current_season'],
        'EpisodeCount' => $obj['episodes_count'],
    );

    $director = '';
    foreach ($obj['directors'] as $dirt) {
        $director .= $dirt['name'] . '[' . $dirt['id'] . '] / ';
    }
    $data['Director'] = $director;
}

$url = 'https://api.douban.com/v2/movie/subject/3016187';
$json = file_get_contents($url);
$obj2 = json_decode($json, true);
if (array_key_exists("code", $obj2)) {
    echo '豆瓣API获取电影失败：' . $obj2['msg'] . '[' . $obj2['code'] . '] <br>';
} else {
    $data['SeasonCount'] = $obj2['seasons_count'];
    $data['CurrentSeason'] = $obj2['current_season'];
    $data['EpisodeCount'] = $obj2['episodes_count'];
}

phpQuery::newDocumentFile('https://movie.douban.com/subject/5327268/');
$MovieInfo = pq("#info");
$writer = pq($MovieInfo)->find("span:contains('编剧:')")->text();
$data['Writer'] = trim(str_replace('编剧:', '', $writer));

$data['Duration'] = crawler_substr(pq($MovieInfo)->text(), '片长:', '又名:');
$data['Language'] = crawler_substr(pq($MovieInfo)->text(), '语言:', '上映日期:');
$data['IMDb'] = trim(pq($MovieInfo)->find("span:contains('IMDb链接:') + a")->text());

$pubdates = pq($MovieInfo)->find("span[property='v:initialReleaseDate']");
$pubdate = '';
$index = 0;
foreach ($pubdates as $pubd) {
    if ($index > 0) {
        $pubdate .= ' / ' . pq($pubd)->text();
    } else {
        $pubdate .= pq($pubd)->text();
    }
    $index++;
}
$data['Pubdate'] = $pubdate;

$tags = pq($MovieInfo)->find("span[property='v:genre']");
$tag = '';
$index = 0;
foreach ($tags as $tg) {
    if ($index > 0) {
        $tag .= ' / ' . pq($tg)->text();
    } else {
        $tag .= pq($tg)->text();
    }
    $index++;
}
$data['Tag'] = $tag;

$photos = pq("#related-pic ul.related-pic-bd")->find("li");
$gallery = '';
$index = 0;
foreach ($photos as $photo) {
    $index++;
    $gallery .= '<li><a class="' . pq($photo)->find('a')->attr('class') . '" href="' . pq($photo)->find('a')->attr('href') . '"><img src="' . crawler_download($obj['id'], pq($photo)->find('img')->attr('src'), 'test_' . $index, $sub) . '"></a></li>';
}
$data['Gallery'] = $gallery;

$comments = pq("#hot-comments .comment");
$comment = '';
foreach ($comments as $cmt) {
    $comment .= '<div class="comment"><span class="comment-user">' . pq($cmt)->find('.comment-info a')->text() . '<span><span class="comment-date">' . pq($cmt)->find('.comment-time')->attr('title') . '</span><p class="comment-data">' . pq($cmt)->find('p')->text() . '</p></div>';
}
$data['Comment'] = $comment;

$reviews = pq(".review-list .main-hd");
$review = '';
foreach ($reviews as $rew) {
    $review .= '<div class="review"><div class="review-info"><span class="review-user">' . pq($rew)->find('span[property="v:reviewer"]')->text() . '</span><span class="review-date">' . pq($rew)->find('span[property="v:dtreviewed"]')->text() . '</span><div><div class="review-data"><a href="' . pq($rew)->find('.title-link')->attr('href') . '" target="_blank">' . pq($rew)->find('.title-link')->text() . '</a></div></div>';
}
$data['Review'] = $review;

$casts = pq($MovieInfo)->find(".actor")->find("a[rel='v:starring']");
$cast = '';
foreach ($casts as $cst) {
    $cast .= pq($cst)->text() . '[' . crawler_number(pq($cst)->attr('href')) . '] / ';
}
$data['Cast'] = $cast;

phpQuery::$documents = array();

phpQuery::newDocumentFile('https://movie.douban.com/subject/3016187/');
$MovieInfo = pq("#info");
$pubdate = pq($MovieInfo)->find("span[property='v:initialReleaseDate']")->text();
$data['Pubdate2'] = trim($pubdate);
$data['Duration2'] = crawler_substr(pq($MovieInfo)->text(), '片长:', '又名:');
phpQuery::$documents = array();

$error = '<b style="color:red">ERROR</b>';
echo '<b>ID =></b>' . (empty($data['ID']) ? $error : $data['ID']);
echo '<br><b>中文名 =></b>' . (empty($data['Title']) ? $error : $data['Title']);
echo '<br><b>原名 =></b>' . (empty($data['TitleOrigin']) ? $error : $data['TitleOrigin']);
echo '<br><b>又名 =></b>' . (empty($data['Aka']) ? $error : $data['Aka']);
echo '<br><b>豆瓣URL =></b>' . (empty($data['Url']) ? $error : $data['Url']);
echo '<br><b>豆瓣移动URL =></b>' . (empty($data['UrlM']) ? $error : $data['UrlM']);
echo '<br><b>评分 =></b>' . (empty($data['Rating']) ? $error : $data['Rating']);
echo '<br><b>评分人数 =></b>' . (empty($data['RatingCount']) ? $error : $data['RatingCount']);
echo '<br><b>封面图片大 =></b>' . (empty($data['CoverL']) ? $error : $data['CoverL']);
echo '<br><b>封面图片中 =></b>' . (empty($data['CoverM']) ? $error : $data['CoverM']);
echo '<br><b>封面图片小 =></b>' . (empty($data['CoverS']) ? $error : $data['CoverS']);
echo '<br><b>封面图片大(本地) =></b>' . (empty($data['CoverLL']) ? $error : $data['CoverLL']);
echo '<br><b>封面图片中(本地) =></b>' . (empty($data['CoverML']) ? $error : $data['CoverML']);
echo '<br><b>封面图片小(本地) =></b>' . (empty($data['CoverSL']) ? $error : $data['CoverSL']);
echo '<br><b>年代 =></b>' . (empty($data['Year']) ? $error : $data['Year']);
echo '<br><b>制片国家/地区 =></b>' . (empty($data['Country']) ? $error : $data['Country']);
echo '<br><b>简介 =></b>' . (empty($data['Summary']) ? $error : $data['Summary']);
echo '<br><b>短评数量 =></b>' . (empty($data['CommentCount']) ? $error : $data['CommentCount']);
echo '<br><b>影评数量 =></b>' . (empty($data['ReviewCount']) ? $error : $data['ReviewCount']);
echo '<br><b>总季数(剧集) =></b>' . (empty($data['SeasonCount']) ? $error : $data['SeasonCount']);
echo '<br><b>当前季数(剧集) =></b>' . (empty($data['CurrentSeason']) ? $error : $data['CurrentSeason']);
echo '<br><b>当前季集数(剧集) =></b>' . (empty($data['EpisodeCount']) ? $error : $data['EpisodeCount']);
echo '<br><br>';
echo '<br><b>上映日期 =></b>' . (empty($data['Pubdate']) ? $error : $data['Pubdate']);
echo '<br><b>首播 =></b>' . (empty($data['Pubdate2']) ? $error : $data['Pubdate2']);
echo '<br><b>片长 =></b>' . (empty($data['Duration']) ? $error : $data['Duration']);
echo '<br><b>单集片长 =></b>' . (empty($data['Duration2']) ? $error : $data['Duration2']);
echo '<br><b>语言 =></b>' . (empty($data['Language']) ? $error : $data['Language']);
echo '<br><b>IMDb =></b>' . (empty($data['IMDb']) ? $error : $data['IMDb']);
echo '<br><b>标签TAG =></b>' . (empty($data['Tag']) ? $error : $data['Tag']);
echo '<br><b>电影图片(本地) =></b>' . (empty($data['Gallery']) ? $error : $data['Gallery']);
echo '<br><b>短评 =></b>' . (empty($data['Comment']) ? $error : $data['Comment']);
echo '<br><b>影评 =></b>' . (empty($data['Review']) ? $error : $data['Review']);
echo '<br><br>';
echo '<br><b>导演 =></b>' . (empty($data['Director']) ? $error : $data['Director']);
echo '<br><b>编剧 =></b>' . (empty($data['Writer']) ? $error : $data['Writer']);
echo '<br><b>主演 =></b>' . (empty($data['Cast']) ? $error : $data['Cast']);

function crawler_download($id, $url, $name, $sub)
{
    if (empty($url)) {
        return '';
    }
    $dir = dirname(__FILE__) . dir_gallery($id, $sub);
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    if (empty($name)) {
        $path = $dir . basename($url);
    } else {
        $path = $dir . $name . '.jpg'; // . pathinfo($url, PATHINFO_EXTENSION);
    }
    $data = file_get_contents($url);
    if (file_put_contents($path, $data)) {
        return str_replace(dirname(__FILE__), '', $path);
    } else {
        return '';
    }
}

function dir_gallery($id, $sub)
{
    if (empty($id)) {
        return '';
    } else {
        return '/resources/gallery/' . $sub . '/' . substr($id, 0, 2) . '/' . $id . '/';
    }
}

function crawler_number($str)
{
    return preg_replace('/\D/s', '', $str);
}

function crawler_substr($str, $left, $right)
{
    $start = stripos($str, $left) + strlen($left);
    $end = stripos($str, $right);
    return trim(substr($str, $start, $end - $start));
}
