<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class DictionaryModel extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create(&$error, $data)
    {
        $this->db->from('dictionary');
        $this->db->where('Name', $data['Name']);
        $this->db->where('ParentID', $data['ParentID']);
        $result = $this->db->count_all_results();
        if ($result > 0) {
            $error->add('创建字典失败：名称重复');
            return false;
        }

        $this->db->from('dictionary');
        $this->db->where('ID', $data['ID']);
        $result = $this->db->count_all_results();
        if ($result > 0) {
            $error->add('创建字典失败：编码重复');
            return false;
        }

        $this->db->insert('dictionary', $data);
        $result = $this->db->affected_rows();
        if ($result > 0) {
            $error->addSuccess('创建字典成功');
            return true;
        } else {
            $error->add('创建字典失败：数据操作异常');
            return false;
        }
    }

    public function edit(&$error, $data, $id)
    {
        $this->db->from('dictionary');
        $this->db->where('Name', $data['Name']);
        $this->db->where('ParentID', $data['ParentID']);
        $this->db->where('ID !=', $id);
        $result = $this->db->count_all_results();
        if ($result > 0) {
            $error->add('修改字典失败：名称重复');
            return false;
        }

        $this->db->from('dictionary');
        $this->db->where('ID', $data['ID']);
        $this->db->where('ID !=', $id);
        $result = $this->db->count_all_results();
        if ($result > 0) {
            $error->add('修改字典失败：编码重复');
            return false;
        }

        $this->db->where('ID', $id);
        $this->db->update('dictionary', $data);
        $result = $this->db->affected_rows();
        if ($result > 0) {
            $error->addSuccess('修改字典成功');
            return true;
        } else {
            $error->add('修改字典失败：数据操作异常');
            return false;
        }
    }

    public function delete(&$error, $id)
    {
        $this->db->from('dictionary');
        $this->db->where('ParentID', $id);
        $result = $this->db->count_all_results();
        if ($result > 0) {
            $error->add('删除字典失败：存在子编码');
            return false;
        }

        $this->db->where('ID', $id);
        $this->db->delete('dictionary');
        $result = $this->db->affected_rows();
        if ($result > 0) {
            $error->addSuccess('删除字典成功');
            return true;
        } else {
            $error->add('删除字典失败：数据操作异常');
            return false;
        }
    }

    public function getById($id)
    {
        $this->db->where('ID', $id);
        return $this->db->get('dictionary')->row_array();
    }

    public function getSubList($parentId)
    {
        $this->db->select('ID,Name,ParentID');
        if ($parentId != null) {
            $this->db->where('ParentID', $parentId);
        }
        $this->db->order_by("ID", "ASC");
        return $this->db->get('dictionary')->result_array();
    }

    public function getTreeList($parentId)
    {
        $this->db->select("ID,Name,Description,ParentID,IsLast,IF(IsLast=1,'open','closed') AS state", false);
        $this->db->where('ParentID', $parentId);
        $this->db->order_by("ID", "ASC");
        return $this->db->get('dictionary')->result_array();
    }

    public function getList(&$pager)
    {
        $this->db->where('ParentID', '0');
        $this->db->from('dictionary');
        $pager['totalRows'] = $this->db->count_all_results();

        $this->db->select('ID,Name,Description');
        $this->db->where('ParentID', '0');
        $this->db->order_by("ID", "ASC");
        $this->db->limit($pager['rows'], ($pager['page'] - 1) * $pager['rows']);
        return $this->db->get('dictionary')->result_array();
    }

}
