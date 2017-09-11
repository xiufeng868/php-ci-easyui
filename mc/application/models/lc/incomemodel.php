<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class IncomeModel extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this-> db_lc = $this-> load-> database('lc', TRUE);
	}

	public function create(&$error, $data)
	{
		$this-> db_lc-> insert('income', $data);
		$result = $this-> db_lc-> affected_rows();
		if ($result > 0)
		{
			$error-> addSuccess('创建收入成功');
			return TRUE;
		}
		else
		{
			$error-> add('创建收入失败：数据操作异常');
			return FALSE;
		}
	}

	public function edit(&$error, $data)
	{
		$this-> db_lc-> where('ID', $data['ID']);
		$this-> db_lc-> update('income', $data);
		$result = $this-> db_lc-> affected_rows();
		if ($result > 0)
		{
			$error-> addSuccess('修改收入成功');
			return TRUE;
		}
		else
		{
			$error-> add('修改收入失败：数据操作异常');
			return FALSE;
		}
	}

	public function delete(&$error, $id)
	{
		$this-> db_lc-> where('ID', $id);
		$this-> db_lc-> delete('income');
		$result = $this-> db_lc-> affected_rows();
		if ($result > 0)
		{
			$error-> addSuccess('删除收入成功');
			return TRUE;
		}
		else
		{
			$error-> add('删除收入失败：数据操作异常');
			return FALSE;
		}
	}

	public function getById($id)
	{
		$this-> db_lc-> where('ID', $id);
		return $this-> db_lc-> get('income')-> row_array();
	}

	public function getList(&$pager, $queryStr)
	{
		$where = array(
			'Name' => $queryStr,
			'Remark' => $queryStr
		);

		if (!empty($queryStr))
		{
			$this-> db_lc-> or_like($where);
		}
		$this-> db_lc-> from('income');
		$pager['totalRows'] = $this-> db_lc-> count_all_results();

		if (!empty($queryStr))
		{
			$this-> db_lc-> or_like($where);
		}
		$this-> db_lc-> order_by("IncomeTime", "desc");
		$this-> db_lc-> limit($pager['rows'], ($pager['page'] - 1) * $pager['rows']);
		return $this-> db_lc-> get('income')-> result_array();
	}

}
