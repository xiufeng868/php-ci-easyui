<?php defined('BASEPATH') or exit('No direct script access allowed');

$config['lc_expense_create'] = array(
    array('field' => 'Mode', 'label' => '支付方式', 'rules' => 'required|max_length[20]'),
    array('field' => 'Name', 'label' => '支出名称', 'rules' => 'trim|required|max_length[50]'),
    array('field' => 'Type1', 'label' => '支出类别', 'rules' => 'required|max_length[20]'),
    array('field' => 'Type2', 'label' => '支出子类别', 'rules' => 'required|max_length[20]'),
    array('field' => 'Amount', 'label' => '支出金额', 'rules' => 'required|numeric|max_length[20]'),
    array('field' => 'PaymentTime', 'label' => '支付日期', 'rules' => 'trim|required'),
    array('field' => 'Beneficiary', 'label' => '受益人', 'rules' => 'required|max_length[20]'),
    array('field' => 'Remark', 'label' => '备注', 'rules' => 'trim|max_length[500]'),
);
$config['lc_expense_edit'] = array(
    array('field' => 'ID', 'label' => '支出ID', 'rules' => 'required'),
    array('field' => 'Mode', 'label' => '支付方式', 'rules' => 'required|max_length[20]'),
    array('field' => 'Name', 'label' => '支出名称', 'rules' => 'trim|required|max_length[50]'),
    array('field' => 'Type1', 'label' => '支出类别', 'rules' => 'required|max_length[20]'),
    array('field' => 'Type2', 'label' => '支出子类别', 'rules' => 'required|max_length[20]'),
    array('field' => 'Amount', 'label' => '支出金额', 'rules' => 'required|numeric|max_length[20]'),
    array('field' => 'PaymentTime', 'label' => '支付日期', 'rules' => 'trim|required'),
    array('field' => 'Beneficiary', 'label' => '受益人', 'rules' => 'required|max_length[20]'),
    array('field' => 'Remark', 'label' => '备注', 'rules' => 'trim|max_length[500]'),
);
