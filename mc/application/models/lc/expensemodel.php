<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class ExpenseModel extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db_lc = $this->load->database('lc', TRUE);
	}

	public function create(&$error, &$data)
	{
		$this->db_lc->insert('expense', $data);
		$data['ID'] = $this->db_lc->insert_id();
		$result = $this->db_lc->affected_rows();
		if ($result > 0)
		{
			$error->addSuccess('创建支出成功');
			return TRUE;
		}
		else
		{
			$error->add('创建支出失败：数据操作异常');
			return FALSE;
		}
	}

	public function edit(&$error, $data)
	{
		$this->db_lc->where('ID', $data['ID']);
		$this->db_lc->update('expense', $data);
		$result = $this->db_lc->affected_rows();
		if ($result > 0)
		{
			$error->addSuccess('修改支出成功');
			return TRUE;
		}
		else
		{
			$error->add('修改支出失败：数据操作异常');
			return FALSE;
		}
	}

	public function delete(&$error, $id)
	{
		$this->db_lc->where('ID', $id);
		$this->db_lc->delete('expense');
		$result = $this->db_lc->affected_rows();
		if ($result > 0)
		{
			$error->addSuccess('删除支出成功');
			return TRUE;
		}
		else
		{
			$error->add('删除支出失败：数据操作异常');
			return FALSE;
		}
	}

	public function getById($id)
	{
		$this->db_lc->where('ID', $id);
		return $this->db_lc->get('expense')->row_array();
	}

	public function getList(&$pager, $queryStr)
	{
		$where = array(
			'Name' => $queryStr,
			'Remark' => $queryStr
		);

		if (!empty($queryStr))
		{
			$this->db_lc->or_like($where);
		}
		$this->db_lc->from('expense');
		$pager['totalRows'] = $this->db_lc->count_all_results();

		if (!empty($queryStr))
		{
			$this->db_lc->or_like($where);
		}
		$this->db_lc->order_by("PaymentTime", "desc");
		$this->db_lc->order_by("ID", "desc");
		$this->db_lc->limit($pager['rows'], ($pager['page'] - 1) * $pager['rows']);
		return $this->db_lc->get('expense')->result_array();
	}

}
