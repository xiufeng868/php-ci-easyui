<?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('PRC');
    }

    protected function getUserID()
    {
        $userId = $this->session->userdata('UserID');
        if ($userId !== false) {
            return $userId;
        } else {
            return null;
        }
    }

    protected function getTheme()
    {
        $theme = $this->input->cookie('MC_Theme');
        if ($theme !== false) {
            $this->session->set_userdata('Theme', $theme);
        } else {
            $this->session->set_userdata('Theme', 'default');
        }
    }

    protected function getPermission($module)
    {
        $permission = $this->session->userdata($module);
        if ($permission !== false) {
            return $permission;
        } else {
            return null;
        }
    }

    protected function loadModuleView($view)
    {
        $this->load->view('layout/module_header');
        if (func_num_args() > 1) {
            $arg = func_get_arg(1);
            $this->load->view($view, $arg);
        } else {
            $this->load->view($view);
        }
        $this->load->view('layout/module_footer');
    }

    protected function loadOperateView($view)
    {
        $this->load->view('layout/operate_header');
        if (func_num_args() > 1) {
            $arg = func_get_arg(1);
            $this->load->view($view, $arg);
        } else {
            $this->load->view($view);
        }
        $this->load->view('layout/operate_footer');
    }

    protected function setAjaxResponse($result)
    {
        $array = array(
            'result' => $result ? 1 : 0,
            'message' => (func_num_args() > 1) ? func_get_arg(1) : '',
            'value' => (func_num_args() > 2) ? func_get_arg(2) : '',
        );
        return json_encode($array);
    }

    protected function setDataGridResponse($page, $result)
    {
        $array = array(
            'total' => $page['totalRows'],
            'rows' => $result,
        );
        return json_encode($array);
    }

    protected function validatePost($config)
    {
        if ($this->form_validation->run($config) == false) {
            die($this->setAjaxResponse(false, str_replace("<p>", "<p><span class='icon-error icon'></span>", validation_errors())));
        }
    }

    protected function validateGet($param)
    {
        if (empty($param)) {
            $method = strtolower($this->router->fetch_method());
            $error = '[' . $method . '] 参数错误';
            returnByMessage($method, $error);
        }
    }

}
