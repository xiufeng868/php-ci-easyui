<?php defined('BASEPATH') or exit('No direct script access allowed');

class M extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('lc/ExpenseModel');
    }

    public function index()
    {
        $data = cache_m_dictionary_all();
        $data['Type1'] = $this->_iosSelectArray($data['Type1']);
        $data['Type2'] = $this->_iosSelectArray($data['Type2']);
        $data['Mode'] = $this->_iosSelectArray($data['Mode']);
        $data['Beneficiary'] = $this->_iosSelectArray($data['Beneficiary']);
        $data['ExpenseList'] = null;
        $this->load->view('m', $data);
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

    private function _formatData(&$data, $kv_dictionary, $kv_user)
    {
        $data['PaymentTime'] = substr($data['PaymentTime'], 0, 10);
        $data['TypeSelect'] = $kv_dictionary[$data['Type1']] . ' - ' . $kv_dictionary[$data['Type2']];
        $data['ModeSelect'] = $kv_dictionary[$data['Mode']];
        $data['BeneficiarySelect'] = $kv_dictionary[$data['Beneficiary']];
        $data['UserName'] = $kv_user[$data['UserID']];
    }

    private function _iosSelectArray($array)
    {
        $temp = '';
        $index = 0;
        foreach ($array as $obj)
        {
            if ($index > 0) {
                $temp .= ",";
            }
            $temp .= "{'ID': '" . $obj['ID'] . "', 'Name': '" . $obj['Name'] . "', 'ParentID': '" . $obj['ParentID'] . "'}";
            $index++;
        }
        return $temp;
    }
}
