<?php defined('BASEPATH') or exit('No direct script access allowed');

class LinkModel extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db_mv = $this->load->database('mv', true);
    }

    public function create(&$error, &$data)
    {
        $this->db_mv->from('link');
        $this->db_mv->where('Title', $data['Title']);
        $result = $this->db_mv->count_all_results();
        if ($result > 0) {
            $error->add('创建链接失败：标题重复');
            return false;
        }

        $this->db_mv->insert('link', $data);
        $data['ID'] = $this->db_mv->insert_id();
        $result = $this->db_mv->affected_rows();
        if ($result > 0) {
            $error->addSuccess('创建链接成功');
            return true;
        } else {
            $error->add('创建链接失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function edit(&$error, $data)
    {
        $this->db_mv->from('link');
        $this->db_mv->where('Title', $data['Title']);
        $this->db_mv->where('ID !=', $data['ID']);
        $result = $this->db_mv->count_all_results();
        if ($result > 0) {
            $error->add('修改链接失败：标题重复');
            return false;
        }

        $this->db_mv->where('ID', $data['ID']);
        $this->db_mv->update('link', $data);
        $result = $this->db_mv->affected_rows();
        if ($result > 0) {
            $error->addSuccess('修改演链接成功');
            return true;
        } else {
            $error->add('修改链接失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function delete(&$error, $id)
    {
        $this->db_mv->where('ID', $id);
        $this->db_mv->delete('link');
        $result = $this->db_mv->affected_rows();
        if ($result > 0) {
            $error->addSuccess('删除链接成功');
            return true;
        } else {
            $error->add('删除链接失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function getById($id)
    {
        $this->db_mv->where('ID', $id);
        return $this->db_mv->get('link')->row_array();
    }

    public function getListInMovie($movieId)
    {
        $this->db_mv->select('ID, Title, Sort');
        $this->db_mv->where('MovieID', $movieId);
        $this->db_mv->order_by("Sort", "ASC");
        return $this->db_mv->get('link')->result_array();
    }

}
