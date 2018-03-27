<?php defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mc/UserModel');
    }

    public function index()
    {
        $data['permission'] = $this->getPermission('mc' . __CLASS__);
        $this->loadModuleView('mc/user/index', $data);
    }

    public function query()
    {
        $queryStr = $this->input->post('queryStr');
        $page = array(
            'totalRows' => 0,
            'rows' => $this->input->post('rows'),
            'page' => $this->input->post('page')
        );
        $result = $this->UserModel->getList($page, $queryStr);
        echo $this->setDataGridResponse($page, $result);
    }

    public function create()
    {
        $this->loadOperateView('mc/user/create');
    }

    public function create_post()
    {
        $this->validatePost('mc_user_create');
        $data = array(
            'UserName' => $this->input->post('UserName'),
            'Password' => md5($this->input->post('Password')),
            'DisplayName' => $this->input->post('DisplayName'),
            'IsEnable' => $this->input->post('IsEnable') === 'true' ? 1 : 0,
            'CreateTime' => date('Y-m-d H:i:s', time()),
            'UpdateTime' => date('Y-m-d H:i:s', time())
        );
        $result = $this->UserModel->create($this->errors, $data);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function edit($id)
    {
        $this->validateGet($id);
        $result = $this->UserModel->getById($id);
        $this->loadOperateView('mc/user/edit', $result);

    }

    public function edit_post()
    {
        $this->validatePost('mc_user_edit');
        $pwd = $this->input->post('PWD');
        $data = array(
            'ID' => $this->input->post('ID'),
            'Password' => empty($pwd) ? $this->input->post('Password') : md5($pwd),
            'DisplayName' => $this->input->post('DisplayName'),
            'IsEnable' => $this->input->post('IsEnable') === 'true' ? 1 : 0,
            'UpdateTime' => date('Y-m-d H:i:s', time())
        );
        $result = $this->UserModel->edit($this->errors, $data);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function details($id)
    {
        $this->validateGet($id);
        $result = $this->UserModel->getById($id);
        $this->loadOperateView('mc/user/details', $result);
    }

    public function delete($id)
    {
        $this->validateGet($id);
        $result = $this->UserModel->delete($this->errors, $id);
        echo $this->setAjaxResponse($result, $this->errors->getMessage());
    }

    public function allot($id)
    {
        $this->validateGet($id);
        $data = array('UserID' => $id);
        $this->loadOperateView('mc/user/allot', $data);
    }

    public function allot_get_role($id)
    {
        $this->validateGet($id);
        $result = $this->UserModel->getRoleListForAllot($id);
        echo $this->setDataGridResponse(NULL, $result);
    }

    public function allot_post()
    {
        $this->validatePost('mc_user_allot');
        $userId = $this->input->post('UserID');
        $roleId = explode(",", $this->input->post('RoleID'));
        $result = $this->UserModel->updateRoleUser($this->errors, $userId, $roleId);
        $data = array('Roles' => $roleId);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

}
