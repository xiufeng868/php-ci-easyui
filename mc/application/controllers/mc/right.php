<?php defined('BASEPATH') or exit('No direct script access allowed');

class Right extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mc/RightModel');
    }

    public function index()
    {
        $data['permission'] = $this->getPermission('mc' . __CLASS__);
        $this->loadModuleView('mc/right/index', $data);
    }

    public function query($roleId, $moduleId)
    {
        $result = $this->RightModel->getRightOperateByRoleAndModule($roleId, $moduleId);
        echo json_encode($result);
    }

    public function save()
    {
        $this->validatePost('mc_right_save');
        $optArray = explode(",", $this->input->post('OperateID'));
        $moduleId = $this->input->post('ModuleID');
        $roleId = $this->input->post('RoleID');
        $result = $this->RightModel->updateRight($this->errors, $optArray, $moduleId, $roleId);
        echo $this->setAjaxResponse($result, $this->errors->getMessage());
    }
}
