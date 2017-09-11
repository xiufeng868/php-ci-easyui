<?php defined('BASEPATH') or exit('No direct script access allowed');

//setButton($id, $icon, $text, $separator) OR
//setButton($id, $icon, $text, $permission, $operate, $separator)
function setButton($id, $icon, $text)
{
    $button = '';
    $onclick = '';
    $separator = true;
    $argsCount = func_num_args();
    if ($argsCount > 3) {
        $separator = func_get_arg(3);
        if ($argsCount > 4) {
            $permission = func_get_arg(3);
            $operate = func_get_arg(4);
            if (!checkPermission($permission, $operate)) {
                return $button;
            }
            if ($argsCount > 5) {
                $separator = func_get_arg(5);
            }
        }
    }

    if ($separator) {
        $button .= '<div class="datagrid-btn-separator"></div>';
    }
    if ($id == 'btnReturn') {
        $onclick = ' onclick="javascript:ReturnByClose();" ';
    }
    $button .= '<a id="' . $id . '" style="float: left;margin: 1px 1px;" class="easyui-linkbutton" iconCls="' . $icon . '"' . $onclick . ' plain="true">' . $text . '</a>';
    return $button;
}

function checkPermission($permission, $operate)
{
    $pos = strpos($operate, '_');
    if ($pos > 0) {
        $operate = substr($operate, 0, $pos);
    }
    if ($permission === null) {
        return false;
    } else if (!in_array(strtolower($operate), $permission, true)) {
        return false;
    } else {
        return true;
    }
}

function returnByMessage($method, $message)
{
    $isLoad = '/index|details|create|edit|crawl|allot/';
    if (IS_AJAX && !preg_match($isLoad, $method)) {
        die(json_encode(array(
            'result' => 0,
            'message' => '<span class="icon-error icon"></span>' . $message,
        )));
    } else {
        die($message);
    }
}

function  bingDailyPhoto()
{
    $url = 'http://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=zh-cn';
    $json = json_decode(file_get_contents($url));
    $photo = $json->{"images"}[0]->{"url"};
    if (strpos($photo, 'http://') === false) {
        $photo = 'http://www.bing.com/' . $photo;
    }
    $copyright = $json->{"images"}[0]->{"copyright"};
    $array = array(
        'bingPhote' => $photo,
        'bingDescription' => $copyright
    );
    return $array;
}
