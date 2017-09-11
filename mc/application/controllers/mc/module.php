<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Module extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mc/ModuleModel');
    }

    public function index()
    {
        $data['permission'] = $this->getPermission('mc' . __CLASS__);
        $this->loadModuleView('mc/module/index', $data);
    }

    public function query()
    {
        $moduleId = $this->input->get('moduleId');
        if (empty($moduleId))//模块列表
        {
            $result = $this->ModuleModel->getList();
            $result = array(
                'total' => count($result),
                'rows' => $result,
            );
            echo json_encode($result);
        }
        else//操作码列表
        {
            $result = $this->ModuleModel->getOperateList($moduleId);
            echo json_encode($result);
        }
    }

    public function create($parentId)
    {
        $data = array('ParentID' => empty($parentId) ? '0' : $parentId);
        $this->loadOperateView('mc/module/create', $data);
    }

    public function create_post()
    {
        $this->validatePost('mc_module_create');
        $data = array(
            'Name' => $this->input->post('Name'),
            'Remark' => $this->input->post('Remark'),
            'ParentID' => $this->input->post('ParentID'),
            'Url' => $this->input->post('Url'),
            'Code' => $this->input->post('Code'),
            'Icon' => $this->input->post('Icon'),
            'Sort' => $this->input->post('Sort'),
            'IsEnable' => $this->input->post('IsEnable') === 'true' ? 1 : 0,
            'IsLast' => $this->input->post('IsLast') === 'true' ? 1 : 0,
            'CreateTime' => date('Y-m-d H:i:s', time()),
            'UpdateTime' => date('Y-m-d H:i:s', time())
        );
        $result = $this->ModuleModel->create($this->errors, $data);
        $data['iconCls'] = $data['Icon'];
        $data['state'] = $data['IsLast'] == 1 ? 'open' : 'closed';
        $data['_parentId'] = $data['ParentID'];
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function edit($id)
    {
        $this->validateGet($id);
        $result = $this->ModuleModel->getById($id);
        $this->loadOperateView('mc/module/edit', $result);

    }

    public function edit_post()
    {
        $this->validatePost('mc_module_edit');
        $data = array(
            'ID' => $this->input->post('ID'),
            'Name' => $this->input->post('Name'),
            'Remark' => $this->input->post('Remark'),
            'ParentID' => $this->input->post('ParentID'),
            'Url' => $this->input->post('Url'),
            'Code' => $this->input->post('Code'),
            'Icon' => $this->input->post('Icon'),
            'Sort' => $this->input->post('Sort'),
            'IsEnable' => $this->input->post('IsEnable') === 'true' ? 1 : 0,
            'IsLast' => $this->input->post('IsLast') === 'true' ? 1 : 0,
            'UpdateTime' => date('Y-m-d H:i:s', time())
        );
        $result = $this->ModuleModel->edit($this->errors, $data);
        $data['iconCls'] = $data['Icon'];
        $data['state'] = $data['IsLast'] == 1 ? 'open' : 'closed';
        $data['_parentId'] = $data['ParentID'];
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function delete($id)
    {
        $this->validateGet($id);
        $result = $this->ModuleModel->delete($this->errors, $id);
        echo $this->setAjaxResponse($result, $this->errors->getMessage());
    }

    public function details($id)
    {
        $this->validateGet($id);
        $result = $this->ModuleModel->getById($id);
        $this->loadOperateView('mc/module/details', $result);
    }

    public function create_operate($moduleId)
    {
        $this->validateGet($moduleId);
        $data = array('ModuleID' => $moduleId);
        $this->loadOperateView('mc/module/operate/create', $data);
    }

    public function create_operate_post()
    {
        $this->validatePost('mc_operate_create');
        $data = array(
            'Name' => $this->input->post('Name'),
            'Code' => $this->input->post('Code'),
            'ModuleID' => $this->input->post('ModuleID'),
            'Sort' => $this->input->post('Sort')
        );
        $result = $this->ModuleModel->createOperate($this->errors, $data);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function delete_operate($id)
    {
        $this->validateGet($id);
        $result = $this->ModuleModel->deleteOperate($this->errors, $id);
        echo $this->setAjaxResponse($result, $this->errors->getMessage());
    }

}
