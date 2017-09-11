<?php defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Controller
{
    public function index()
    {
        $this->getTheme();
        $this->load->view('login', bingDailyPhoto());
    }

    public function login_post()
    {
        $this->load->model('mc/UserModel');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $user = $this->UserModel->login($username, md5($password));
        if (empty($user)) {
            echo $this->setAjaxResponse(false, '用户名或密码错误');
            exit;
        } else if ($user['IsEnable'] === 0) {
            echo $this->setAjaxResponse(false, '账户已禁用');
            exit;
        }

        $this->session->set_userdata('UserID', $user['ID']);
        $this->session->set_userdata('UserName', $user['UserName']);
        $this->session->set_userdata('DisplayName', $user['DisplayName']);
        if ($this->mobile_detect->isMobile()) {
            echo $this->setAjaxResponse(true, 'Mobile', true);
        } else {
            echo $this->setAjaxResponse(true, 'Web', false);
        }
    }

}
