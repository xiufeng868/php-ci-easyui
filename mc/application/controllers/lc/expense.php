<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expense extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('lc/ExpenseModel');
    }

    public function index()
    {
        $data['permission'] = $this->getPermission('lc' . __CLASS__);
        $this->loadModuleView('lc/expense/index', $data);
    }

    public function query()
    {
        $queryStr = $this->input->post('queryStr');
        $page = array(
            'totalRows' => 0,
            'rows' => $this->input->post('rows'),
            'page' => $this->input->post('page')
        );
        $result = $this->ExpenseModel->getList($page, $queryStr);

		$kv_dictionary = cache_dictionary_kv();
		$kv_user = cache_user_kv();
		foreach ($result as &$row)
		{
			$this->_formatData($row, $kv_dictionary, $kv_user);
		}

        echo $this->setDataGridResponse($page, $result);
    }

    public function create()
    {
        $this->loadOperateView('lc/expense/create');
    }

    public function create_post()
    {
        $this->validatePost('lc_expense_create');
        $data = array(
            'Mode' => $this->input->post('Mode'),
            'Name' => $this->input->post('Name'),
            'Type1' => $this->input->post('Type1'),
            'Type2' => $this->input->post('Type2'),
            'Amount' => $this->input->post('Amount'),
            'PaymentTime' => $this->input->post('PaymentTime'),
            'Beneficiary' => $this->input->post('Beneficiary'),
            'Remark' => $this->input->post('Remark'),
            'UserID' => $this->session->userdata('UserID'),
            'CreateTime' => date('Y-m-d H:i:s', time()),
            'UpdateTime' => date('Y-m-d H:i:s', time())
        );
        $result = $this->ExpenseModel->create($this->errors, $data);
        $this->_formatData($data, cache_dictionary_kv(), cache_user_kv());
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function edit($id)
    {
        $this->validateGet($id);
        $result = $this->ExpenseModel->getById($id);
        $this->loadOperateView('lc/expense/edit', $result);

    }

    public function edit_post()
    {
		$this->validatePost('lc_expense_edit');
        $data = array(
        	'ID' => $this->input->post('ID'),
            'Mode' => $this->input->post('Mode'),
            'Name' => $this->input->post('Name'),
            'Type1' => $this->input->post('Type1'),
            'Type2' => $this->input->post('Type2'),
            'Amount' => $this->input->post('Amount'),
            'PaymentTime' => $this->input->post('PaymentTime'),
            'Beneficiary' => $this->input->post('Beneficiary'),
            'Remark' => $this->input->post('Remark'),
            'UserID' => $this->session->userdata('UserID'),
            'UpdateTime' => date('Y-m-d H:i:s', time())
        );
        $result = $this->ExpenseModel->edit($this->errors, $data);
        $this->_formatData($data, cache_dictionary_kv(), cache_user_kv());
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function details($id)
    {
        $this->validateGet($id);
        $result = $this->ExpenseModel->getById($id);

		$kv_dictionary = cache_dictionary_kv();
		$kv_user = cache_user_kv();
		$this->_formatData($result, cache_dictionary_kv(), cache_user_kv());
        $this->loadOperateView('lc/expense/details', $result);
    }

	public function delete($id)
    {
        $this->validateGet($id);
        $result = $this->ExpenseModel->delete($this->errors, $id);
        echo $this->setAjaxResponse($result, $this->errors->getMessage());
    }

    private function _formatData(&$data, $kv_dictionary, $kv_user)
    {
        $data['PaymentTime'] = substr($data['PaymentTime'], 0, 10);
        $data['Type1'] = $kv_dictionary[$data['Type1']] . ' - ' . $kv_dictionary[$data['Type2']];
        $data['Mode'] = $kv_dictionary[$data['Mode']];
        $data['Beneficiary'] = $kv_dictionary[$data['Beneficiary']];
        $data['Amount'] = '￥' . $data['Amount'];
        $data['UserID'] = $kv_user[$data['UserID']];
    }
}
