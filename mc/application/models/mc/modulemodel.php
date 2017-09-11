<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class ModuleModel extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function create(&$error, &$data) {
		$this->db->from('module');
		$this->db->where('Name', $data['Name']);
		$this->db->where('ParentID', $data['ParentID']);
		$result = $this->db->count_all_results();
		if ($result > 0) {
			$error->add('创建模块失败：模块名称重复');
			return FALSE;
		}

		$this->db->from('module');
		$this->db->where('ID', $data['ParentID']);
		$result = $this->db->count_all_results();
		if ($result <= 0 && $data['ParentID'] != '0') {
			$error->add('创建模块失败：上级模块不存在');
			return FALSE;
		}

		$this->db->insert('module', $data);
		$data['ID'] = $this->db->insert_id();
		$result = $this->db->affected_rows();
		if ($result > 0) {
			$this->insertRight();
			$error->addSuccess('创建模块成功');
			return TRUE;
		} else {
			$error->add('创建模块失败：数据操作异常');
			return FALSE;
		}
	}

	public function edit(&$error, $data) {
		$this->db->from('module');
		$this->db->where('Name', $data['Name']);
		$this->db->where('ParentID', $data['ParentID']);
		$this->db->where('ID !=', $data['ID']);
		$result = $this->db->count_all_results();
		if ($result > 0) {
			$error->add('修改模块失败：模块名称重复');
			return FALSE;
		}

		$this->db->from('module');
		$this->db->where('ID', $data['ParentID']);
		$result = $this->db->count_all_results();
		if ($result <= 0 && $data['ParentID'] != '0') {
			$error->add('创建模块失败：上级模块不存在');
			return FALSE;
		}

		$this->db->where('ID', $data['ID']);
		$this->db->update('module', $data);
		$result = $this->db->affected_rows();
		if ($result > 0) {
			$error->addSuccess('修改模块成功');
			return TRUE;
		} else {
			$error->add('修改模块失败：数据操作异常');
			return FALSE;
		}
	}

	public function delete(&$error, $id) {
		$this->db->from('module');
		$this->db->where('ParentID', $id);
		$result = $this->db->count_all_results();
		if ($result > 0) {
			$error->add('删除模块失败：存在子模块');
			return FALSE;
		}

		$this->db->trans_start();
		//删除right表数据
		$this->db->where('ModuleID', $id);
		$this->db->delete('right');
		//删除rightoperate表数据
		$this->db->where('ModuleID', $id);
		$this->db->delete('rightoperate');
		//删除moduleoperate表数据
		$this->db->where('ModuleID', $id);
		$this->db->delete('moduleoperate');
		//删除module表数据
		$this->db->where('ID', $id);
		$this->db->delete('module');
		$result = $this->db->affected_rows();
		$this->db->trans_complete();
		if ($result > 0) {
			$error->addSuccess('删除模块成功');
			return TRUE;
		} else {
			$error->add('删除模块失败：数据操作异常');
			return FALSE;
		}
	}

	public function getById($id) {
		$this->db->where('ID', $id);
		return $this->db->get('module')->row_array();
	}

	public function getList() {
		$this->db->select("*,Icon AS iconCls,IF(IsLast=1,'open','closed') AS state,IF(ParentID=0,'',ParentID) as _parentId", FALSE);
		//$this->db->where('ParentID', $parentId);
		$this->db->order_by("IsLast", "ASC");
		$this->db->order_by("Sort", "ASC");
		return $this->db->get('module')->result_array();
	}

	function getNavLeft($userId) {
		$this->db->select('module.ID AS id,module.Name AS text,module.ParentID,module.Url,module.IsLast,module.Icon AS iconCls');
		$this->db->from('module');
		$this->db->join('right', 'module.ID = right.ModuleID');
		$this->db->join('roleuser', 'right.RoleID = roleuser.RoleID');
		$this->db->where('module.IsEnable', 1);
		$this->db->where('right.RightFlag', 1);
		$this->db->where('roleuser.UserID', $userId);
		$this->db->distinct();
		$this->db->order_by("IsLast", "ASC");
		$this->db->order_by("Sort", "ASC");
		$result = $this->db->get()->result_array();
		$tree = array();
		$temp = array();
		foreach ($result as $key => $item) {
			$temp[$item['id']] = &$result[$key];
		}
		foreach ($result as $key => $item) {
			$parentId = $item['ParentID'];
			if ($parentId == 0) {
				$tree[] = &$result[$key];
			} else {
	               $parent = &$temp[$parentId];
				if (isset($parent)) {
					$parent['children'][] = &$result[$key];
					$parent['state'] = 'closed';
				}
			}
		}
		return $tree;
	}

	function getNavTop($userId) {
		$this->db->select('module.ID,module.Name,module.ParentID,module.Url,module.Icon');
		$this->db->from('module');
		$this->db->join('right', 'module.ID = right.ModuleID');
		$this->db->join('roleuser', 'right.RoleID = roleuser.RoleID');
		$this->db->where('module.IsEnable', 1);
		$this->db->where('right.RightFlag', 1);
		$this->db->where('roleuser.UserID', $userId);
		$this->db->distinct();
		$this->db->order_by("IsLast", "ASC");
		$this->db->order_by("Sort", "ASC");
		$result = $this->db->get()->result_array();
		$tree = array();
		$temp = array();
		foreach ($result as $key => $item) {
			$temp[$item['ID']] = &$result[$key];
		}
		foreach ($result as $key => $item) {
			$parentId = $item['ParentID'];
			if ($parentId == 0) {
				$tree[] = &$result[$key];
			} else {
				$parent = &$temp[$parentId];
				if (isset($parent)) {
					$parent['children'][] = &$result[$key];
				}
			}
		}
		$html = '';
		foreach ($tree as $node) {
			$child = $node['children'];
			if (isset($child)) {
				$html .= '<a class="easyui-menubutton" data-options="duration:10,menu:\'#menu' . $node['ID'] . '\',iconCls:\'' . $node['Icon'] . '\'">' . $node['Name'] . '</a>';
				$html .= '<div id="menu' . $node['ID'] . '">';
				$html .= $this->_getNavTopHtml($child);
				$html .= "</div>";
			} else {
				$html .= '<a class="easyui-linkbutton" data-options="plain:true">' . $node['Name'] . '</a>';
			}
		}
		return $html;
	}

	function _getNavTopHtml($tree) {
		$html = '';
		foreach ($tree as $node) {
			$child = $node['children'];
			if (isset($child)) {
				$html .= '<div data-options="iconCls:\'' . $node['Icon'] . '\'"><span>' . $node['Name'] . '</span><div>';
				$html .= procHtml($child);
				$html .= '</div></div>';
			} else {
				$html .= '<div data-options="iconCls:\'' . $node['Icon'] . '\'" onclick="AddTab(\''.$node['Name'].'\',\''.$node['Url'].'\',\''.$node['Icon'].'\');">' . $node['Name'] . '</div>';
			}
		}
		return $html;
	}

	public function createOperate(&$error, &$data) {
		$this->db->from('moduleoperate');
		$this->db->where('Name', $data['Name']);
		$this->db->where('ModuleID', $data['ModuleID']);
		$result = $this->db->count_all_results();
		if ($result > 0) {
			$error->add('创建操作码失败：操作名称重复');
			return FALSE;
		}

		$this->db->from('moduleoperate');
		$this->db->where('Code', $data['Code']);
		$this->db->where('ModuleID', $data['ModuleID']);
		$result = $this->db->count_all_results();
		if ($result > 0) {
			$error->add('创建操作码失败：操作码重复');
			return FALSE;
		}

		$this->db->insert('moduleoperate', $data);
		$data['ID'] = $this->db->insert_id();
		$result = $this->db->affected_rows();
		if ($result > 0) {
			$error->addSuccess('创建操作码成功');
			return TRUE;
		} else {
			$error->add('创建操作码失败：数据操作异常');
			return FALSE;
		}
	}

	public function deleteOperate(&$error, $id) {
		$this->db->trans_start();
		//删除rightoperate表数据
		$this->db->where('OperateID', $id);
		$this->db->delete('rightoperate');
		//删除moduleoperate表数据
		$this->db->where('ID', $id);
		$this->db->delete('moduleoperate');
		$result = $this->db->affected_rows();
		$this->db->trans_complete();
		if ($result > 0) {
			$error->addSuccess('删除操作码成功');
			return TRUE;
		} else {
			$error->add('删除操作码失败：数据操作异常');
			return FALSE;
		}
	}

	public function getOperateList($moduleId) {
		$this->db->where('ModuleID', $moduleId);
		$this->db->order_by("Sort", "ASC");
		return $this->db->get('moduleoperate')->result_array();
	}

}
