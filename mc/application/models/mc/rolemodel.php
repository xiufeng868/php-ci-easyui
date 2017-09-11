<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class RoleModel extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create(&$error, &$data)
    {
        $this->db->from('role');
        $this->db->where('Name', $data['Name']);
        $result = $this->db->count_all_results();
        if ($result > 0) {
            $error->add('创建角色失败：角色名称重复');
            return false;
        }

        $this->db->insert('role', $data);
        $data['ID'] = $this->db->insert_id();
        $result = $this->db->affected_rows();
        if ($result > 0) {
            $this->insertRight();
            $error->addSuccess('创建角色成功');
            return true;
        } else {
            $error->add('创建角色失败：数据操作异常');
            return false;
        }
    }

    public function edit(&$error, $data)
    {
        $this->db->from('role');
        $this->db->where('Name', $data['Name']);
        $this->db->where('ID !=', $data['ID']);
        $result = $this->db->count_all_results();
        if ($result > 0) {
            $error->add('修改角色失败：角色名称重复');
            return false;
        }

        $this->db->where('ID', $data['ID']);
        $this->db->update('role', $data);
        $result = $this->db->affected_rows();
        if ($result > 0) {
            $error->addSuccess('修改角色成功');
            return true;
        } else {
            $error->add('修改角色失败：数据操作异常');
            return false;
        }
    }

    public function delete(&$error, $id)
    {
        $this->db->from('roleuser');
        $this->db->where('RoleID', $id);
        $result = $this->db->count_all_results();
        if ($result > 0) {
            $error->add('删除角色失败：角色属下存在用户');
            return false;
        }

        $this->db->trans_start();
        //删除right表数据
        $this->db->where('RoleID', $id);
        $this->db->delete('right');
        //删除rightoperate表数据
        $this->db->where('RoleID', $id);
        $this->db->delete('rightoperate');
        //删除role表数据
        $this->db->where('ID', $id);
        $this->db->delete('role');
        $result = $this->db->affected_rows();
        $this->db->trans_complete();
        if ($result > 0) {
            $error->addSuccess('删除角色成功');
            return true;
        } else {
            $error->add('删除角色失败：数据操作异常');
            return false;
        }
    }

    public function getById($id)
    {
        $this->db->where('ID', $id);
        return $this->db->get('role')->row_array();
    }

    public function getList(&$pager, $queryStr)
    {
        $where = array(
            'Name' => $queryStr,
            'Remark' => $queryStr,
        );

        if (!empty($queryStr)) {
            $this->db->or_like($where);
        }
        $this->db->from('role');
        $pager['totalRows'] = $this->db->count_all_results();

        if (!empty($queryStr)) {
            $this->db->or_like($where);
        }
        $this->db->order_by("UpdateTime", "DESC");
        $this->db->limit($pager['rows'], ($pager['page'] - 1) * $pager['rows']);
        $roles = $this->db->get('role')->result_array();
        foreach ($roles as &$role) {
            $role['Users'] = '';
            $users = $this->_getUserList($role['ID']);
            foreach ($users as $user) {
                $role['Users'] .= ("[" . $user['DisplayName'] . "] ");
            }
        }
        return $roles;
    }

    private function _getUserList($roleId)
    {
        $sql = 'SELECT * FROM user WHERE ID IN (SELECT UserID FROM roleuser WHERE RoleID=?)';
        return $this->db->query($sql, array($roleId))->result_array();
    }

    public function getUserListForAllot($roleId)
    {
        $sql = 'SELECT a.ID, a.UserName, a.DisplayName, IF(ISNULL(b.userid),0,1) AS Alloted FROM user a
                LEFT JOIN (SELECT * FROM roleuser WHERE RoleID=?) b ON a.ID=b.UserID';
        return $this->db->query($sql, array($roleId))->result_array();
    }

    public function updateRoleUser(&$error, $roleId, &$userId)
    {
        $this->db->trans_start();
        $this->db->where('RoleID', $roleId);
        $this->db->delete('roleuser');
        $data = array();
        foreach ($userId as $value) {
            $data[] = array(
                'UserID' => $value,
                'RoleID' => $roleId,
            );
        }
        $this->db->insert_batch('roleuser', $data);
        $result = $this->db->affected_rows();
        $this->db->trans_complete();
        if ($result > 0) {
            $userId = '';
            $users = $this->_getUserList($roleId);
            foreach ($users as $user) {
                $userId .= ("[" . $user['DisplayName'] . "] ");
            }
            $error->addSuccess('分配管理员成功');
            return true;
        } else {
            $error->add('分配管理员失败：数据操作异常');
            return false;
        }
    }

}
