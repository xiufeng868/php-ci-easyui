<?php

header("Content-Type: text/html;charset=utf-8");

include 'application/libraries/phpQuery.php';

$sub = 'test/cast';
$url = 'https://api.douban.com/v2/movie/celebrity/1053618';
$json = file_get_contents($url);
$obj = json_decode($json, true);
if (array_key_exists("code", $obj)) {
    echo '豆瓣API获取演员失败：' . $obj['msg'] . '[' . $obj['code'] . '] <br>';
} else {
    $data = array(
        'ID' => $obj['id'],
        'Name' => $obj['name'],
        'NameE' => $obj['name_en'],
        'Aka' => implode(' / ', $obj['aka']),
        'AkaE' => implode(' / ', $obj['aka_en']),
        'Url' => $obj['alt'],
        'UrlM' => $obj['mobile_url'],
        'AvatarL' => $obj['avatars']['large'],
        'AvatarM' => $obj['avatars']['medium'],
        'AvatarS' => $obj['avatars']['small'],
        'AvatarLL' => crawler_download($obj['id'], $obj['avatars']['large'], 'test_al', $sub),
        'AvatarML' => crawler_download($obj['id'], $obj['avatars']['medium'], 'test_am', $sub),
        'AvatarSL' => crawler_download($obj['id'], $obj['avatars']['small'], 'test_as', $sub),
        'Gender' => $obj['gender'],
        'BirthPlace' => $obj['born_place'],
    );
}

phpQuery::newDocumentFile('https://movie.douban.com/celebrity/1053618/');
$summary = pq("#intro .all")->html();
if (empty($summary)) {
    $summary = pq("#intro .bd")->html();
}
$data['Summary1'] = trim($summary);
$birthday = pq("#headline li:contains('日期:')")->text();
$data['Birthday1'] = trim(str_replace('生卒日期:', '', str_replace('出生日期:', '', $birthday)));
$professions = pq("#headline li:contains('职业:')")->text();
$data['Professions'] = trim(str_replace('职业:', '', $professions));
$constellation = pq("#headline li:contains('星座:')")->text();
$data['Constellation'] = trim(str_replace('星座:', '', $constellation));
$data['IMDb'] = trim(pq("#headline li:contains('imdb编号:') a")->text());
$data['Website'] = trim(pq("#headline li:contains('官方网站:') a")->text());
$photos = pq("ul.pic-col5")->find("li");
$gallery = '';
$index = 0;
foreach ($photos as $photo) {
    $index++;
    $gallery .= '<li><a href="' . pq($photo)->find('a')->attr('href') . '"><img src="' . crawler_download($obj['id'], pq($photo)->find('img')->attr('src'), 'test_' . $index, $sub) . '"></a></li>';
}
$data['Gallery'] = $gallery;
phpQuery::$documents = array();

phpQuery::newDocumentFile('https://movie.douban.com/celebrity/1031239/');
$summary = pq("#intro .all")->html();
if (empty($summary)) {
    $summary = pq("#intro .bd")->html();
}
$data['Summary2'] = trim($summary);
$birthday = pq("#headline li:contains('日期:')")->text();
$data['Birthday2'] = trim(str_replace('生卒日期:', '', str_replace('出生日期:', '', $birthday)));
phpQuery::$documents = array();

$error = '<b style="color:red">ERROR</b>';
echo '<b>ID =></b>' . (empty($data['ID']) ? $error : $data['ID']);
echo '<br><b>中文名 =></b>' . (empty($data['Name']) ? $error : $data['Name']);
echo '<br><b>英文名 =></b>' . (empty($data['NameE']) ? $error : $data['NameE']);
echo '<br><b>更多中文名 =></b>' . (empty($data['Aka']) ? $error : $data['Aka']);
echo '<br><b>更多英文名 =></b>' . (empty($data['AkaE']) ? $error : $data['AkaE']);
echo '<br><b>豆瓣URL =></b>' . (empty($data['Url']) ? $error : $data['Url']);
echo '<br><b>豆瓣移动URL =></b>' . (empty($data['UrlM']) ? $error : $data['UrlM']);
echo '<br><b>演员头像大 =></b>' . (empty($data['AvatarL']) ? $error : $data['AvatarL']);
echo '<br><b>演员头像中 =></b>' . (empty($data['AvatarM']) ? $error : $data['AvatarM']);
echo '<br><b>演员头像小 =></b>' . (empty($data['AvatarS']) ? $error : $data['AvatarS']);
echo '<br><b>演员头像大(本地) =></b>' . (empty($data['AvatarLL']) ? $error : $data['AvatarLL']);
echo '<br><b>演员头像中(本地) =></b>' . (empty($data['AvatarML']) ? $error : $data['AvatarML']);
echo '<br><b>演员头像小(本地) =></b>' . (empty($data['AvatarSL']) ? $error : $data['AvatarSL']);
echo '<br><b>性别 =></b>' . (empty($data['Gender']) ? $error : $data['Gender']);
echo '<br><b>出生地 =></b>' . (empty($data['BirthPlace']) ? $error : $data['BirthPlace']);

echo '<br><b>简介(短) =></b>' . (empty($data['Summary1']) ? $error : $data['Summary1']);
echo '<br><b>简介(长) =></b>' . (empty($data['Summary2']) ? $error : $data['Summary2']);
echo '<br><b>出生日期 =></b>' . (empty($data['Birthday1']) ? $error : $data['Birthday1']);
echo '<br><b>生卒日期 =></b>' . (empty($data['Birthday2']) ? $error : $data['Birthday2']);
echo '<br><b>职业 =></b>' . (empty($data['Professions']) ? $error : $data['Professions']);
echo '<br><b>星座 =></b>' . (empty($data['Constellation']) ? $error : $data['Constellation']);
echo '<br><b>IMDb编号 =></b>' . (empty($data['IMDb']) ? $error : $data['IMDb']);
echo '<br><b>官方网站 =></b>' . (empty($data['Website']) ? $error : $data['Website']);
echo '<br><b>演员图片(本地) =></b>' . (empty($data['Gallery']) ? $error : $data['Gallery']);

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
