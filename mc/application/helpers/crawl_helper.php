<?php defined('BASEPATH') or exit('No direct script access allowed');

error_reporting(0);

include APPPATH . 'libraries/phpQuery.php';

function crawler_douban_cast(&$error, $id, $canUpdate, &$data)
{
    $CI = &get_instance();
    $CI->load->model('mv/CastModel');
    if ($CI->CastModel->exists($id) <= 0 || $canUpdate) {
        $url = 'https://api.douban.com/v2/movie/celebrity/' . $id;
        $json = file_get_contents($url);
        if (strlen($json) == 0) {
            $error->add('抓取豆瓣API失败：' . $url);
            return false;
        } else {
            $obj = json_decode($json, true);
            $sub = 'cast';
            $data = array(
                'ID' => $id,
                'Name' => $obj['name'],
                'NameE' => $obj['name_en'],
                'Aka' => implode(' / ', $obj['aka']),
                'AkaE' => implode(' / ', $obj['aka_en']),
                'Url' => $obj['alt'],
                'UrlM' => $obj['mobile_url'],
                'AvatarL' => $obj['avatars']['large'],
                'AvatarLL' => crawler_download($id, $obj['avatars']['large'], 'al', $sub),
                'AvatarM' => $obj['avatars']['medium'],
                'AvatarML' => crawler_download($id, $obj['avatars']['medium'], 'am', $sub),
                'AvatarS' => $obj['avatars']['small'],
                'AvatarSL' => crawler_download($id, $obj['avatars']['small'], 'as', $sub),
                'Gender' => $obj['gender'],
                'BirthPlace' => $obj['born_place'],
                'IsDelete' => 0,
                'UpdateTime' => date('Y-m-d H:i:s', time()),
            );

            phpQuery::newDocumentFile('https://movie.douban.com/celebrity/' . $id);
            $summary = pq("#intro .all")->html();
            if ($summary == '') {
                $summary = pq("#intro .bd")->html();
            }
            $data['Summary'] = trim($summary);
            $birthday = pq("#headline li:contains('日期:')")->text();
            $data['Birthday'] = trim(str_replace('生卒日期:', '', str_replace('出生日期:', '', $birthday)));
            $professions = pq("#headline li:contains('职业:')")->text();
            $data['Professions'] = trim(str_replace('职业:', '', $professions));
            $constellation = pq("#headline li:contains('星座:')")->text();
            $data['Constellation'] = trim(str_replace('星座:', '', $constellation));
            $data['IMDb'] = trim(pq("#headline li:contains('imdb编号:') a")->text());
            $data['Website'] = trim(pq("#headline li:contains('官方网站:') a")->text());
            //下载演员图片
            $photos = pq("ul.pic-col5")->find("li");
            $gallery = '';
            $index = 0;
            foreach ($photos as $photo) {
                $index++;
                $gallery .= '<li><a href="' . pq($photo)->find('a')->attr('href') . '"><img src="' . crawler_download($id, pq($photo)->find('img')->attr('src'), $index, $sub) . '"></a></li>';
            }
            $data['Gallery'] = $gallery;

            phpQuery::$documents = null;
            return $CI->CastModel->crawl($error, $data);
        }
    } else {
        $error->addSuccess('豆瓣演员[' . $id . ']已存在');
        return true;
    }
}

function crawler_douban_movie(&$error, $id, $category, &$data)
{
    $onlyUpdate = false;
    $CI = &get_instance();
    $CI->load->model('mv/MovieModel');
    $url = 'https://api.douban.com/v2/movie/subject/' . $id;
    $json = file_get_contents($url);
    if (strlen($json) == 0) {
        $error->add('抓取豆瓣API失败：' . $url);
        return false;
    } else {
        if ($CI->MovieModel->exists($id) > 0) {
            $onlyUpdate = true;
        }
        $obj = json_decode($json, true);
        $sub = 'movie';
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
            'CoverLL' => crawler_download($obj['id'], $obj['images']['large'], 'cl', $sub),
            'CoverML' => crawler_download($obj['id'], $obj['images']['medium'], 'cm', $sub),
            'CoverSL' => crawler_download($obj['id'], $obj['images']['small'], 'cs', $sub),
            'Year' => $obj['year'],
            'Country' => implode(' / ', $obj['countries']),
            'Summary' => $obj['summary'],
            'CommentCount' => $obj['comments_count'],
            'ReviewCount' => $obj['reviews_count'],
            'SeasonCount' => $obj['seasons_count'],
            'CurrentSeason' => $obj['current_season'],
            'EpisodeCount' => $obj['episodes_count'],
            'Category' => $category,
            'IsDelete' => 0,
            'UpdateTime' => date('Y-m-d H:i:s', time()),
        );
        $directors = $obj['directors'];

        phpQuery::newDocumentFile('https://movie.douban.com/subject/' . $id);
        $MI = pq("#info");
        //$MITxt = pq($MI)->text();
        $writer = pq($MI)->find("span:contains('编剧:')")->text();
        $data['Writer'] = trim(str_replace('编剧:', '', $writer));
        $data['Duration'] = crawler_substr(pq($MI)->text(), '片长:', '又名:');
        $data['Language'] = crawler_substr(pq($MI)->text(), '语言:', '上映日期:');
        $data['IMDb'] = trim(pq($MI)->find("span:contains('IMDb链接:') + a")->text());

        $pubdates = pq($MI)->find("span[property='v:initialReleaseDate']"); //上映日期&首播
        $temp = '';
        $index = 0;
        foreach ($pubdates as $pubdate) {
            if ($index > 0) {
                $temp .= ' / ' . pq($pubdate)->text();
            } else {
                $temp .= pq($pubdate)->text();
            }
            $index++;
        }
        $data['Pubdate'] = $temp;

        $photos = pq("#related-pic ul.related-pic-bd")->find("li"); //照片
        $temp = '';
        $index = 0;
        foreach ($photos as $photo) {
            $index++;
            $temp .= '<li><a class="' . pq($photo)->find('a')->attr('class') . '" href="' . pq($photo)->find('a')->attr('href') . '"><img src="' . crawler_download($obj['id'], pq($photo)->find('img')->attr('src'), 'test_' . $index, $sub) . '"></a></li>';
        }
        $data['Gallery'] = $temp;

        $comments = pq("#hot-comments .comment"); //短评
        $temp = '';
        foreach ($comments as $comment) {
            $temp .= '<div class="comment"><span class="comment-user">' . pq($comment)->find('.comment-info a')->text() . '</span><span class="comment-date">' . pq($comment)->find('.comment-time')->attr('title') . '</span><p class="comment-data">' . pq($comment)->find('p')->text() . '</p></div>';
        }
        $data['Comment'] = $temp;

        $reviews = pq(".review-list .main-hd"); //影评
        $temp = '';
        foreach ($reviews as $review) {
            $temp .= '<div class="review"><div class="review-info"><span class="review-user">' . pq($review)->find('span[property="v:reviewer"]')->text() . '</span><span class="review-date">' . pq($review)->find('span[property="v:dtreviewed"]')->text() . '</span><div><div class="review-data"><a href="' . pq($review)->find('.title-link')->attr('href') . '" target="_blank">' . pq($review)->find('.title-link')->text() . '</a></div></div>';
        }
        $data['Review'] = $temp;

        $movieId = $data['ID'];
        $result = $CI->MovieModel->crawl($error, $data);

        if ($result && !$onlyUpdate) {
            $movieCastData = array();
            $index = 0;
            foreach ($directors as $director) { //导演
                $movieCastData[] = array(
                    'MovieID' => $movieId,
                    'CastID' => $director['id'],
                    'Sort' => $index,
                    'IsDirector' => 1,
                );
                $index++;
            }
            $index = 0;
            $casts = pq($MI)->find(".actor")->find("a[rel='v:starring']"); //主演
            foreach ($casts as $cast) {
                $movieCastData[] = array(
                    'MovieID' => $movieId,
                    'CastID' => crawler_number(pq($cast)->attr('href')),
                    'Sort' => $index,
                    'IsDirector' => 0,
                );
                $index++;
            }

            $tagData = array();
            $tags = pq($MI)->find("span[property='v:genre']"); //类型TAG
            foreach ($tags as $tag) {
                $tagData[] = array(
                    'Name' => pq($tag)->text(),
                    'MovieID' => $movieId,
                );
            }

            phpQuery::$documents = null;

            foreach ($movieCastData as $mcData) {
                if (crawler_douban_cast($error, $mcData['CastID'], false, $linshi)) {
                    $CI->MovieModel->createMovieCast($error, $mcData);
                }
            }
            $CI->load->model('mv/TagModel');
            foreach ($tagData as $tData) {
                $CI->TagModel->create($error, $tData);
            }
        }

        phpQuery::$documents = null;

        return $result;
    }
}

function crawler_download($id, $url, $name, $sub)
{
    if (empty($url)) {
        return '';
    }
    $dir = FCPATH . dir_gallery($id, $sub);
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
        return str_replace(FCPATH, '', $path);
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
