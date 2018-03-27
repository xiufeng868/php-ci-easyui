<?php defined('BASEPATH') or exit('No direct script access allowed');

class Role extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mc/RoleModel');
    }

    public function index()
    {
        $data['permission'] = $this->getPermission('mc' . __CLASS__);
        $this->loadModuleView('mc/role/index', $data);
    }

    public function query()
    {
        $queryStr = $this->input->post('queryStr');
        $page = array(
            'totalRows' => 0,
            'rows' => $this->input->post('rows'),
            'page' => $this->input->post('page')
        );
        $result = $this->RoleModel->getList($page, $queryStr);
        echo $this->setDataGridResponse($page, $result);
    }

    public function create()
    {
        $this->loadOperateView('mc/role/create');
    }

    public function create_post()
    {
        $this->validatePost('mc_role_create');
        $data = array(
            'Name' => $this->input->post('Name'),
            'Remark' => $this->input->post('Remark'),
            'CreateTime' => date('Y-m-d H:i:s', time()),
            'UpdateTime' => date('Y-m-d H:i:s', time())
        );
        $result = $this->RoleModel->create($this->errors, $data);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function edit($id)
    {
        $this->validateGet($id);
        $result = $this->RoleModel->getById($id);
        $this->loadOperateView('mc/role/edit', $result);

    }

    public function edit_post()
    {
        $this->validatePost('mc_role_edit');
        $data = array(
            'ID' => $this->input->post('ID'),
            'Name' => $this->input->post('Name'),
            'Remark' => $this->input->post('Remark'),
            'UpdateTime' => date('Y-m-d H:i:s', time())
        );
        $result = $this->RoleModel->edit($this->errors, $data);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function details($id)
    {
        $this->validateGet($id);
        $result = $this->RoleModel->getById($id);
        $this->loadOperateView('mc/role/details', $result);
    }

    public function delete($id)
    {
        $this->validateGet($id);
        $result = $this->RoleModel->delete($this->errors, $id);
        echo $this->setAjaxResponse($result, $this->errors->getMessage());
    }

    public function allot($id)
    {
        $this->validateGet($id);
        $data = array('RoleID' => $id);
        $this->loadOperateView('mc/role/allot', $data);
    }

    public function allot_get_user($id)
    {
        $this->validateGet($id);
        $result = $this->RoleModel->getUserListForAllot($id);
        echo $this->setDataGridResponse(NULL, $result);
    }

    public function allot_post()
    {
        $this->validatePost('mc_role_allot');
        $roleId = $this->input->post('RoleID');
        $userId = explode(",", $this->input->post('UserID'));
        $result = $this->RoleModel->updateRoleUser($this->errors, $roleId, $userId);
        $data = array('Users' => $userId);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

}
