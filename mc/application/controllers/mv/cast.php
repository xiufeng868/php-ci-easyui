<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cast extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mv/CastModel');
    }

    public function index()
    {
        $data['permission'] = $this->getPermission('mv' . __CLASS__);
        $this->loadModuleView('mv/cast/index', $data);
    }

    public function query()
    {
        $queryStr = $this->input->post('queryStr');
        $page = array(
            'totalRows' => 0,
            'rows' => $this->input->post('rows'),
            'page' => $this->input->post('page'),
        );
        $result = $this->CastModel->getList($page, $queryStr);
        echo $this->setDataGridResponse($page, $result);
    }

    public function crawl()
    {
        $this->loadOperateView('mv/cast/crawl');
    }

    public function crawl_post()
    {
        $this->validatePost('mv_cast_crawl');
        $id = $this->input->post('ID');
        $data = array();
        $result = crawler_douban_cast($this->errors, $id, true, $data);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function create()
    {
        $this->loadOperateView('mv/cast/create');
    }

    public function create_post()
    {
        $this->validatePost('mv_cast');
        $data = array(
            'ID' => $this->input->post('ID'),
            'Name' => $this->input->post('Name'),
            'NameE' => $this->input->post('NameE'),
            'Aka' => $this->input->post('Aka'),
            'AkaE' => $this->input->post('AkaE'),
            'Url' => $this->input->post('Url'),
            'UrlM' => $this->input->post('UrlM'),
            'AvatarL' => $this->input->post('AvatarL'),
            'AvatarM' => $this->input->post('AvatarM'),
            'AvatarS' => $this->input->post('AvatarS'),
            'AvatarLL' => $this->input->post('AvatarLL'),
            'AvatarML' => $this->input->post('AvatarML'),
            'AvatarSL' => $this->input->post('AvatarSL'),
            'Summary' => $this->input->post('Summary'),
            'Gender' => $this->input->post('Gender'),
            'Birthday' => $this->input->post('Birthday'),
            'BirthPlace' => $this->input->post('BirthPlace'),
            'Professions' => $this->input->post('Professions'),
            'Constellation' => $this->input->post('Constellation'),
            'IMDb' => $this->input->post('IMDb'),
            'Website' => $this->input->post('Website'),
            'Gallery' => $this->input->post('Gallery'),
            'IsDelete' => 0,
            'UpdateTime' => date('Y-m-d H:i:s', time()),
        );
        $result = $this->CastModel->create($this->errors, $data);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function edit($id)
    {
        $this->validateGet($id);
        $result = $this->CastModel->getById($id);
        $this->loadOperateView('mv/cast/edit', $result);
    }

    public function edit_post()
    {
        $this->validatePost('mv_cast');
        $data = array(
            'ID' => $this->input->post('ID'),
            'Name' => $this->input->post('Name'),
            'NameE' => $this->input->post('NameE'),
            'Aka' => $this->input->post('Aka'),
            'AkaE' => $this->input->post('AkaE'),
            'Url' => $this->input->post('Url'),
            'UrlM' => $this->input->post('UrlM'),
            'AvatarL' => $this->input->post('AvatarL'),
            'AvatarM' => $this->input->post('AvatarM'),
            'AvatarS' => $this->input->post('AvatarS'),
            'AvatarLL' => $this->input->post('AvatarLL'),
            'AvatarML' => $this->input->post('AvatarML'),
            'AvatarSL' => $this->input->post('AvatarSL'),
            'Summary' => $this->input->post('Summary'),
            'Gender' => $this->input->post('Gender'),
            'Birthday' => $this->input->post('Birthday'),
            'BirthPlace' => $this->input->post('BirthPlace'),
            'Professions' => $this->input->post('Professions'),
            'Constellation' => $this->input->post('Constellation'),
            'IMDb' => $this->input->post('IMDb'),
            'Website' => $this->input->post('Website'),
            'Gallery' => $this->input->post('Gallery'),
            'UpdateTime' => date('Y-m-d H:i:s', time()),
        );
        $result = $this->CastModel->edit($this->errors, $data);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function delete($id)
    {
        $this->validateGet($id);
        $result = $this->CastModel->delete($this->errors, $id);
        echo $this->setAjaxResponse($result, $this->errors->getMessage());
    }

    public function restore($id)
    {
        $this->validateGet($id);
        $result = $this->CastModel->restore($this->errors, $id);
        echo $this->setAjaxResponse($result, $this->errors->getMessage());
    }

    public function details($id)
    {
        $this->validateGet($id);
        $result = $this->CastModel->getById($id);
        // $result['Summary'] = str_replace('<br>', '&#10;', $result['Summary']);
        $this->loadOperateView('mv/cast/details', $result);
    }

}
