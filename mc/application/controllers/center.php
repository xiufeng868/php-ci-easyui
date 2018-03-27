<?php defined('BASEPATH') or exit('No direct script access allowed');

class Center extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mc/ModuleModel');
    }

    public function index()
    {
        $this->getTheme();
        $data['menu'] = $this->ModuleModel->getNavTop($this->getUserID());
        $this->load->view('center_nav_top', $data);
        // $this->load->view('center_nav_left', $data);
    }

    public function getModuleTree()
    {
        $result = $this->ModuleModel->getNavLeft($this->getUserID());
        echo json_encode($result);
    }

    public function logout()
    {
        $this->session->unset_userdata('UserID');
        $this->session->unset_userdata('UserName');
        $this->session->unset_userdata('DisplayName');
        $this->session->sess_destroy();
        echo $this->setAjaxResponse(true, '退出系统，即将返回登陆页面...');
    }

    public function setTheme()
    {
        $theme = $this->input->post('value');
        $this->session->set_userdata('Theme', $theme);
        $cookie = array(
            'name'   => 'MC_Theme',
            'value'  => $theme,
            'expire' => '315360000',
        );
        $this->input->set_cookie($cookie);
        echo $this->setAjaxResponse(true);
    }

    public function getDictionaryList($key)
    {
        echo json_encode(cache_dictionary_list($key));
    }

}
