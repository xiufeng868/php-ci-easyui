<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PermissionFilter
{
    public function __construct()
    {
        $this->object = &get_instance();
        $this->object->load->helper('url');
        header("Content-Type:text/html;charset=utf-8");
    }

    public function filter()
    {
        //目录
        $directory = strtolower(substr($this->object->router->fetch_directory(),0,-1));
        //控制器
        $controller = strtolower($this->object->router->fetch_class());
        //方法
        $method = strtolower($this->object->router->fetch_method());
        //不验证登录权限
        if (in_array($controller, array("login", "test")))
        {
            return;
        }
        //验证登录
        $userId = $this->object->session->userdata('UserID');
        if (!$userId)
        {
            $timeout = '登陆超时，即将返回登陆页面<script>setTimeout("top.location.href=\'/login\';",1000);</script>';
            returnByMessage($method, $timeout);
        }
        //不验证权限
        if (in_array($controller, array("center", "m")))
        {
            return;
        }
        //获得权限
        $controller = $directory . ucfirst($controller); //目录+首字母大写
        $permission = $this->object->session->userdata($controller);
        if ($permission === FALSE)
        {
            $this->object->load->model('mc/RightModel');
            $permission = $this->object->RightModel->getRightOperateByUserAndController($userId, $controller);
            $this->object->session->set_userdata($controller, $permission);
        }
        //验证权限
        if (strtolower($method) == 'index' || stripos($method, 'query') !== FALSE)
        {
            //最少具有一个操作权限，即可访问模块的index和query*操作
            if (count($permission) > 0)
            {
                return;
            }
        }
        if (checkPermission($permission, $method))
        {
            //create_post[_get]操作等同于create操作
            return;
        }
        else
        {
            $noPermission = '你没有操作权限，请联系管理员';
            returnByMessage($method, $noPermission);
        }
    }



}
