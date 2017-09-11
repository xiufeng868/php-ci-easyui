<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dictionary extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mc/DictionaryModel');
    }

    public function index()
    {
        $data['permission'] = $this->getPermission('mc' . __CLASS__);
        $this->loadModuleView('mc/dictionary/index', $data);
    }

    public function query()
    {
        $parentId = $this->input->get_post('id');
        if (empty($parentId)) //字典列表
        {
            $page = array(
                'totalRows' => 0,
                'rows' => $this->input->post('rows'),
                'page' => $this->input->post('page')
            );
            $result = $this->DictionaryModel->getList($page);
            echo $this->setDataGridResponse($page, $result);
        }
        else //编码列表
        {
            $result = $this->DictionaryModel->getTreeList($parentId);
            echo json_encode($result);
        }
    }

    public function create($returnBy, $parentId)
    {
        $this->validateGet($returnBy);
        $data = array(
            'ReturnBy' => $returnBy,
            'ParentID' => empty($parentId) ? '0' : $parentId
        );
        $this->loadOperateView('mc/dictionary/create', $data);
    }

    public function create_post()
    {
        $this->validatePost('mc_dictionary_create');
        $data = array(
            'ID' => $this->input->post('ID'),
            'Name' => $this->input->post('Name'),
            'Description' => $this->input->post('Description'),
            'ParentID' => $this->input->post('ParentID'),
            'IsLast' => ($this->input->post('ParentID') != '0' && $this->input->post('IsLast') == 'true') ? 1 : 0,
            'CreateTime' => date('Y-m-d H:i:s', time()),
            'UpdateTime' => date('Y-m-d H:i:s', time())
        );
        $result = $this->DictionaryModel->create($this->errors, $data);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function edit($returnBy, $id)
    {
        $this->validateGet($returnBy);
        $this->validateGet($id);
        $result = $this->DictionaryModel->getById($id);
        $result['ReturnBy'] = $returnBy;
        $this->loadOperateView('mc/dictionary/edit', $result);
    }

    public function edit_post()
    {
        $this->validatePost('mc_dictionary_edit');
        $data = array(
            // 禁止后台修改字典的编码(ID),上级编码(ParentID)和层级(IsLast)
            // 'ID' => $this->input->post('ID'),
            'Name' => $this->input->post('Name'),
            'Description' => $this->input->post('Description'),
            // 'ParentID' => $this->input->post('ParentID'),
            // 'IsLast' => ($this->input->post('ParentID') != '0' && $this->input->post('IsLast') == 'true') ? 1 : 0,
            'UpdateTime' => date('Y-m-d H:i:s', time())
        );
        $result = $this->DictionaryModel->edit($this->errors, $data, $this->input->post('OldID'));
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function delete($id)
    {
        $this->validateGet($id);
        $result = $this->DictionaryModel->delete($this->errors, $id);
        echo $this->setAjaxResponse($result, $this->errors->getMessage());
    }

}
