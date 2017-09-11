<?php defined('BASEPATH') or exit('No direct script access allowed');

function cache_dictionary_kv()
{
    $CI = &get_instance();
    $kv = $CI->mp_cache->get('dictionary/kv');
    if ($kv === false) {
        $CI->load->model('mc/DictionaryModel');
        $list = $CI->DictionaryModel->getSubList(null);
        $kv = array();
        foreach ($list as $dic) {
            $kv[$dic['ID']] = $dic['Name'];
        }
        $CI->mp_cache->write($kv, 'dictionary/kv', 3600);
    }
    return $kv;
}

function cache_dictionary_list($parentId)
{
    $CI = &get_instance();
    $path = 'dictionary/list/' . $parentId;
    $list = $CI->mp_cache->get($path);
    if ($list === false) {
        $CI->load->model('mc/DictionaryModel');
        $list = $CI->DictionaryModel->getSubList($parentId);
        $CI->mp_cache->write($list, $path, 3600);
    }
    return $list;
}

function cache_user_kv()
{
    $CI = &get_instance();
    $kv = $CI->mp_cache->get('user/kv');
    if ($kv === false) {
        $list = $CI->db->get('user')->result_array();
        $kv = array();
        foreach ($list as $user) {
            $kv[$user['ID']] = $user['DisplayName'];
        }
        $CI->mp_cache->write($kv, 'user/kv', 3600);
    }
    return $kv;
}

function cache_clear($path)
{
    $CI = &get_instance();
    $CI->mp_cache->delete_all($path);
}

function cache_m_dictionary_all()
{
    $CI = &get_instance();
    $kv = $CI->mp_cache->get('dictionary/m_all');
    if ($kv === false) {
        $CI->load->model('mc/DictionaryModel');
        $list = $CI->DictionaryModel->getSubList(null);
        $kv = array();
        $Type1 = array();
        $Type2 = array();
        $Mode = array();
        $Beneficiary = array();
        $ParentID = '';
        foreach ($list as $dic) {
            if ($dic['ParentID'] == '01') {
                $Beneficiary[] = $dic;
                continue;
            }
            if ($dic['ParentID'] == '02') {
                $Mode[] = $dic;
                continue;
            }
            if ($dic['ParentID'] == 'zc') {
                $Type1[] = $dic;
                $ParentID = $dic['ID'];
                continue;
            }
            if ($dic['ParentID'] == $ParentID) {
                $Type2[] = $dic;
                continue;
            }
        }
        $kv['Type1'] = $Type1;
        $kv['Type2'] = $Type2;
        $kv['Mode'] = $Mode;
        $kv['Beneficiary'] = $Beneficiary;
        $CI->mp_cache->write($kv, 'dictionary/m_all', 3600);
    }
    return $kv;
}
