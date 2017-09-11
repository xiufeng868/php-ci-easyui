<?php defined('BASEPATH') or exit('No direct script access allowed');

$config['mc_user_create'] = array(
    array('field' => 'UserName', 'label' => '用户名', 'rules' => 'trim|required|max_length[20]'),
    array('field' => 'Password', 'label' => '密码', 'rules' => 'trim|required|min_length[6]|alpha_numeric'),
    array('field' => 'DisplayName', 'label' => '真实姓名', 'rules' => 'trim|required|max_length[20]'),
);
$config['mc_user_edit'] = array(
    array('field' => 'ID', 'label' => '用户ID', 'rules' => 'required'),
    array('field' => 'Password', 'label' => '密码', 'rules' => 'trim|required|min_length[6]|alpha_numeric'),
    array('field' => 'DisplayName', 'label' => '真实姓名', 'rules' => 'trim|required|max_length[20]'),
);
$config['mc_user_allot'] = array(
    array('field' => 'UserID', 'label' => '用户ID', 'rules' => 'required'),
);
$config['mc_role_create'] = array(
    array('field' => 'Name', 'label' => '角色名称', 'rules' => 'trim|required|max_length[20]'),
    array('field' => 'Remark', 'label' => '角色说明', 'rules' => 'trim|max_length[50]'),
);
$config['mc_role_edit'] = array(
    array('field' => 'ID', 'label' => '角色ID', 'rules' => 'required'),
    array('field' => 'Name', 'label' => '角色名称', 'rules' => 'trim|required|max_length[20]'),
    array('field' => 'Remark', 'label' => '角色说明', 'rules' => 'trim|max_length[50]'),
);
$config['mc_role_allot'] = array(
    array('field' => 'RoleID', 'label' => '角色ID', 'rules' => 'required'),
);
$config['mc_dictionary_create'] = array(
    array('field' => 'ID', 'label' => '字典编码', 'rules' => 'trim|required|max_length[20]'),
    array('field' => 'Name', 'label' => '字典名称', 'rules' => 'trim|required|max_length[20]'),
    array('field' => 'Description', 'label' => '字典描述', 'rules' => 'trim|max_length[50]'),
    array('field' => 'ParentID', 'label' => '上级编码', 'rules' => 'trim|required|max_length[20]'),
);
$config['mc_dictionary_edit'] = array(
    array('field' => 'Name', 'label' => '字典名称', 'rules' => 'trim|required|max_length[20]'),
    array('field' => 'Description', 'label' => '字典描述', 'rules' => 'trim|max_length[50]'),
);
$config['mc_module_create'] = array(
    array('field' => 'Name', 'label' => '模块名称', 'rules' => 'trim|required|max_length[20]'),
    array('field' => 'ParentID', 'label' => '上级ID', 'rules' => 'required'),
    array('field' => 'Remark', 'label' => '模块说明', 'rules' => 'trim|max_length[50]'),
    array('field' => 'Url', 'label' => '模块链接', 'rules' => 'trim|max_length[50]'),
    array('field' => 'Code', 'label' => '模块码', 'rules' => 'trim|max_length[20]|alpha_numeric'),
    array('field' => 'Icon', 'label' => '模块图标', 'rules' => 'trim|max_length[50]|alpha_dash'),
    array('field' => 'Sort', 'label' => '排序', 'rules' => 'required|integer'),
);
$config['mc_module_edit'] = array(
    array('field' => 'ID', 'label' => '模块ID', 'rules' => 'required'),
    array('field' => 'Name', 'label' => '模块名称', 'rules' => 'trim|required|max_length[20]'),
    array('field' => 'ParentID', 'label' => '模块父ID', 'rules' => 'required'),
    array('field' => 'Remark', 'label' => '模块说明', 'rules' => 'trim|max_length[50]'),
    array('field' => 'Url', 'label' => '模块链接', 'rules' => 'trim|max_length[50]'),
    array('field' => 'Code', 'label' => '模块码', 'rules' => 'trim|max_length[20]|alpha_numeric'),
    array('field' => 'Icon', 'label' => '模块图标', 'rules' => 'trim|max_length[50]|alpha_dash'),
    array('field' => 'Sort', 'label' => '排序', 'rules' => 'required|integer'),
);
$config['mc_operate_create'] = array(
    array('field' => 'Name', 'label' => '操作名称', 'rules' => 'trim|required|max_length[20]'),
    array('field' => 'Code', 'label' => '操作码', 'rules' => 'trim|required|max_length[20]|alpha_numeric'),
    array('field' => 'ModuleID', 'label' => '模块ID', 'rules' => 'required'),
    array('field' => 'Sort', 'label' => '排序', 'rules' => 'required|integer'),
);
$config['mc_right_save'] = array(
    array('field' => 'ModuleID', 'label' => '模块ID', 'rules' => 'required'),
    array('field' => 'RoleID', 'label' => '角色ID', 'rules' => 'required'),
);
