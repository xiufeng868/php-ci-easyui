<?php defined('BASEPATH') or exit('No direct script access allowed');

class TagModel extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db_mv = $this->load->database('mv', true);
    }

    public function create(&$error, $data)
    {
        $this->db_mv->from('tag');
        $this->db_mv->where('MovieID', $data['MovieID']);
        $this->db_mv->where('Name', $data['Name']);
        $result = $this->db_mv->count_all_results();
        if ($result > 0) {
            $error->add('创建标签[' . $data['Name'] . ']失败：标签已存在');
            return false;
        }

        $this->db_mv->insert('tag', $data);
        $result = $this->db_mv->affected_rows();
        if ($result > 0) {
            $error->addSuccess('创建标签[' . $data['Name'] . ']成功');
            return true;
        } else {
            $error->add('创建标签[' . $data['Name'] . ']失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function delete(&$error, $id)
    {
        $this->db_mv->where('ID', $id);
        $this->db_mv->delete('tag');
        $result = $this->db_mv->affected_rows();
        if ($result > 0) {
            $error->addSuccess('删除标签成功');
            return true;
        } else {
            $error->add('删除标签失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function getListInMovie($movieId)
    {
        $this->db_mv->select('ID, Name');
        $this->db_mv->where('MovieID', $movieId);
        return $this->db_mv->get('tag')->result_array();
    }

}
