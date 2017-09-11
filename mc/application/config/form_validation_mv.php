<?php defined('BASEPATH') or exit('No direct script access allowed');

$config['mv_cast'] = array(
    array('field' => 'ID', 'label' => '演员ID', 'rules' => 'trim|required|max_length[10]'),
    array('field' => 'Name', 'label' => '中文名', 'rules' => 'trim|required|max_length[50]'),
    array('field' => 'Summary', 'label' => '简介', 'rules' => 'required|max_length[2000]'),
);
$config['mv_cast_crawl'] = array(
    array('field' => 'ID', 'label' => '演员ID', 'rules' => 'trim|required|max_length[10]'),
);
$config['mv_movie'] = array(
    array('field' => 'ID', 'label' => '电影ID', 'rules' => 'trim|required|max_length[10]'),
    array('field' => 'Title', 'label' => '中文名', 'rules' => 'trim|required|max_length[100]'),
    array('field' => 'Summary', 'label' => '简介', 'rules' => 'required|max_length[2000]'),
    array('field' => 'Year', 'label' => '年代', 'rules' => 'trim|required|max_length[50]'),
    array('field' => 'Category', 'label' => '类别[mc]', 'rules' => 'required|max_length[10]'),
);
$config['mv_movie_crawl'] = array(
    array('field' => 'ID', 'label' => '电影ID', 'rules' => 'trim|required|max_length[10]'),
    array('field' => 'Category', 'label' => '类别[mc]', 'rules' => 'required|max_length[10]'),
);
$config['mv_link_create'] = array(
    array('field' => 'Title', 'label' => '名称', 'rules' => 'trim|required|max_length[100]'),
    array('field' => 'Url', 'label' => '下载地址', 'rules' => 'trim|required|max_length[500]'),
    array('field' => 'Resolution', 'label' => '分辨率[mc]', 'rules' => 'required|max_length[10]'),
    array('field' => 'MovieID', 'label' => '电影ID', 'rules' => 'required|max_length[10]'),
);
$config['mv_link_edit'] = array(
    array('field' => 'ID', 'label' => 'ID', 'rules' => 'required'),
    array('field' => 'Title', 'label' => '名称', 'rules' => 'trim|required|max_length[100]'),
    array('field' => 'Url', 'label' => '下载地址', 'rules' => 'trim|required|max_length[500]'),
    array('field' => 'Resolution', 'label' => '分辨率[mc]', 'rules' => 'required|max_length[10]'),
    array('field' => 'MovieID', 'label' => '电影ID', 'rules' => 'required|max_length[10]'),
);
$config['mv_moviecast_create'] = array(
    array('field' => 'MovieID', 'label' => '电影ID', 'rules' => 'required|max_length[10]'),
    array('field' => 'CastID', 'label' => '演员ID', 'rules' => 'trim|required|max_length[10]'),
    array('field' => 'Sort', 'label' => '排序', 'rules' => 'required|integer'),
);
$config['mv_moviecast_edit'] = array(
    array('field' => 'ID', 'label' => 'ID', 'rules' => 'trim|required|max_length[10]'),
    array('field' => 'Sort', 'label' => '排序', 'rules' => 'required|integer'),
);
