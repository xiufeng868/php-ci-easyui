<?php defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login($userName, $password)
    {
        $this->db->where('UserName', $userName);
        $this->db->where('Password', $password);
        return $this->db->get('user')->row_array();
    }

    public function create(&$error, &$data)
    {
        $this->db->from('user');
        $this->db->where('UserName', $data['UserName']);
        $result = $this->db->count_all_results();
        if ($result > 0) {
            $error->add('创建管理员失败：用户名重复');
            return false;
        }

        $this->db->insert('user', $data);
        $data['ID'] = $this->db->insert_id();
        $result = $this->db->affected_rows();
        if ($result > 0) {
            $error->addSuccess('创建管理员成功');
            return true;
        } else {
            $error->add('创建管理员失败：数据操作异常');
            return false;
        }
    }

    public function edit(&$error, $data)
    {
        $this->db->where('ID', $data['ID']);
        $this->db->update('user', $data);
        $result = $this->db->affected_rows();
        if ($result > 0) {
            $error->addSuccess('修改管理员成功');
            return true;
        } else {
            $error->add('修改管理员失败：数据操作异常');
            return false;
        }
    }

    public function delete(&$error, $id)
    {
        $this->db->trans_start();
        //删除roleuser表数据
        $this->db->where('UserID', $id);
        $this->db->delete('roleuser');
        //删除user表数据
        $this->db->where('ID', $id);
        $this->db->delete('user');
        $result = $this->db->affected_rows();
        $this->db->trans_complete();
        if ($result > 0) {
            $error->addSuccess('删除管理员成功');
            return true;
        } else {
            $error->add('删除管理员失败：数据操作异常');
            return false;
        }
    }

    public function getById($id)
    {
        $this->db->where('ID', $id);
        return $this->db->get('user')->row_array();
    }

    public function getList(&$pager, $queryStr)
    {
        $where = array(
            'UserName' => $queryStr,
            'DisplayName' => $queryStr,
        );

        if (!empty($queryStr)) {
            $this->db->or_like($where);
        }
        $this->db->from('user');
        $pager['totalRows'] = $this->db->count_all_results();

        if (!empty($queryStr)) {
            $this->db->or_like($where);
        }
        $this->db->order_by("UpdateTime", "DESC");
        $this->db->limit($pager['rows'], ($pager['page'] - 1) * $pager['rows']);
        $users = $this->db->get('user')->result_array();
        foreach ($users as &$user) {
            $user['Roles'] = '';
            $roles = $this->_getRoleList($user['ID']);
            foreach ($roles as $role) {
                $user['Roles'] .= ("[" . $role['Name'] . "] ");
            }
        }
        return $users;
    }

    private function _getRoleList($userId)
    {
        $sql = 'SELECT * FROM role WHERE ID IN (SELECT RoleID FROM roleuser WHERE UserID=?)';
        return $this->db->query($sql, array($userId))->result_array();
    }

    public function getRoleListForAllot($userId)
    {
        $sql = 'SELECT a.ID, a.Name, a.Remark, IF(ISNULL(b.userid),0,1) AS Alloted FROM role a
                LEFT JOIN (SELECT * FROM roleuser WHERE UserID=?) b ON a.ID=b.RoleID';
        return $this->db->query($sql, array($userId))->result_array();
    }

    public function updateRoleUser(&$error, $userId, &$roleId)
    {
        $this->db->trans_start();
        $this->db->where('UserID', $userId);
        $this->db->delete('roleuser');
        $data = array();
        foreach ($roleId as $value) {
            $data[] = array(
                'UserID' => $userId,
                'RoleID' => $value,
            );
        }
        $this->db->insert_batch('roleuser', $data);
        $result = $this->db->affected_rows();
        $this->db->trans_complete();
        if ($result > 0) {
            $roleId = '';
            $roles = $this->_getRoleList($userId);
            foreach ($roles as $role) {
                $roleId .= ("[" . $role['Name'] . "] ");
            }
            $error->addSuccess('分配角色成功');
            return true;
        } else {
            $error->add('分配角色失败：数据操作异常');
            return false;
        }
    }

}
