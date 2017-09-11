<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class RightModel extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mc/ModuleModel');
    }

    public function updateRight(&$error, $optArray, $moduleId, $roleId)
    {
        $this->db->trans_start();
        //删除rightoperate表数据
        $this->db->where('ModuleID', $moduleId);
        $this->db->where('RoleID', $roleId);
        $this->db->delete('rightoperate');

        $rightFlag = 0;
        $data = array();
        foreach ($optArray as $opt)
        {
            if (!empty($opt))
            {
                $data[] = array(
                    'OperateID' => $opt,
                    'ModuleID' => $moduleId,
                    'RoleID' => $roleId,
                );
                $rightFlag = 1;
            }
        }
        if (count($data) > 0)
        {
            $this->db->insert_batch('rightoperate', $data);
        }
        $result = $this->db->affected_rows();

        $result += $this->_updateRightFlag($rightFlag, $moduleId, $roleId);
        $module = $this->ModuleModel->getById($moduleId);
        $parentId = $module['ParentID'];
        while ($parentId !== '0')
        {
            if ($rightFlag === 0)
            {
                $this->db->from('module');
                $this->db->join('right', 'module.ID = right.ModuleID');
                $this->db->where('module.ParentID', $parentId);
                $this->db->where('right.RoleID', $roleId);
                $this->db->where('right.RightFlag', 1);
                $count = $this->db->count_all_results();
                if ($count === 0)
                {
                    $result += $this->_updateRightFlag($rightFlag, $parentId, $roleId);
                }
            }
            else
            {
                $result += $this->_updateRightFlag($rightFlag, $parentId, $roleId);
            }
            $module = $this->ModuleModel->getById($parentId);
            $parentId = $module['ParentID'];
        }
        $this->db->trans_complete();

        if ($result > 0)
        {
            $error->addSuccess('角色权限分配成功');
            return TRUE;
        }
        else
        {
            $error->add('角色权限分配失败：数据操作异常');
            return FALSE;
        }
    }

    private function _updateRightFlag($rightFlag, $moduleId, $roleId)
    {
        $this->db->where('ModuleID', $moduleId);
        $this->db->where('RoleID', $roleId);
        $this->db->update('right', array('RightFlag' => $rightFlag));
        return $this->db->affected_rows();
    }

    public function getRightOperateByRoleAndModule($roleId, $moduleId)
    {
        $sql = 'SELECT mo.ID,mo.Name,mo.Code,mo.ModuleID,ro.RoleID, IF(ISNULL(ro.OperateID),0,1) AS Alloted 
                FROM (SELECT * FROM moduleoperate WHERE ModuleID=?) mo
                LEFT JOIN (SELECT * FROM rightoperate WHERE RoleID=? AND ModuleID=?) ro ON mo.ID=ro.OperateID
                ORDER BY mo.Sort';
        $data = array(
            $moduleId,
            $roleId,
            $moduleId
        );
        return $this->db->query($sql, $data)->result_array();
    }

    public function getRightOperateByUserAndController($userId, $controller)
    {
        $sql = 'SELECT DISTINCT mo.Code FROM moduleoperate mo
                INNER JOIN module m ON mo.ModuleID=m.ID
                INNER JOIN rightoperate ro ON mo.ID=ro.OperateID
                INNER JOIN roleuser ru ON ro.RoleID=ru.RoleID
                WHERE ru.UserID=? AND m.Code=?
                ORDER BY mo.Sort';
        $data = array(
            $userId,
            $controller
        );
        $operates = $this->db->query($sql, $data)->result_array();
        $data = array();
        foreach ($operates as $operate)
        {
            $data[] = $operate['Code'];
        }
        return $data;
    }
}
