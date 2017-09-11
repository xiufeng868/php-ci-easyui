<?php defined('BASEPATH') or exit('No direct script access allowed');

class CastModel extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db_mv = $this->load->database('mv', true);
    }

    public function create(&$error, $data)
    {
        $result = $this->exists($data['ID']);
        if ($result > 0) {
            $error->add('创建演员失败：ID重复');
            return false;
        }

        $this->db_mv->insert('cast', $data);
        $result = $this->db_mv->affected_rows();
        if ($result > 0) {
            $error->addSuccess('创建演员成功');
            return true;
        } else {
            $error->add('创建演员失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function edit(&$error, $data)
    {
        $this->db_mv->where('ID', $data['ID']);
        $this->db_mv->update('cast', $data);
        $result = $this->db_mv->affected_rows();
        if ($result > 0) {
            $error->addSuccess('修改演员成功');
            return true;
        } else {
            $error->add('修改演员失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function delete(&$error, $id)
    {
        $this->db_mv->where('ID', $id);
        $this->db_mv->update('cast', array('IsDelete' => 1));
        $result = $this->db_mv->affected_rows();
        if ($result > 0) {
            $error->addSuccess('删除演员成功');
            return true;
        } else {
            $error->add('删除演员失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function restore(&$error, $id)
    {
        $this->db_mv->where('ID', $id);
        $this->db_mv->update('cast', array('IsDelete' => 0));
        $result = $this->db_mv->affected_rows();
        if ($result > 0) {
            $error->addSuccess('还原演员成功');
            return true;
        } else {
            $error->add('还原演员失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function crawl(&$error, $data)
    {
        $this->db_mv->trans_start();
        //删除cast表数据
        $this->db_mv->where('ID', $data['ID']);
        $this->db_mv->delete('cast');
        //插入cast表数据
        $this->db_mv->insert('cast', $data);
        $result = $this->db_mv->affected_rows();
        $this->db_mv->trans_complete();
        if ($result > 0) {
            $error->addSuccess('更新演员[' . $data['Name'] . ']成功');
            return true;
        } else {
            $err = $this->db_mv->error();
            $error->add('更新演员[' . $data['Name'] . ']失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function getById($id)
    {
        $this->db_mv->where('ID', $id);
        return $this->db_mv->get('cast')->row_array();
    }

    public function exists($id)
    {
        $this->db_mv->from('cast');
        $this->db_mv->where('ID', $id);
        return $this->db_mv->count_all_results();
    }

    public function getList(&$pager, $queryStr)
    {
        $where = array(
            'Name' => $queryStr,
            'NameE' => $queryStr,
            'Aka' => $queryStr,
            'AkaE' => $queryStr,
            'ID' => $queryStr,
            'IMDb' => $queryStr,
        );

        if (!empty($queryStr)) {
            $this->db_mv->or_like($where);
        }
        $this->db_mv->from('cast');
        $pager['totalRows'] = $this->db_mv->count_all_results();

        if (!empty($queryStr)) {
            $this->db_mv->or_like($where);
        }
        $this->db_mv->select('ID, Name, NameE, Url, AvatarM, Gender, IMDb, IsDelete, UpdateTime');
        $this->db_mv->order_by("UpdateTime", "DESC");
        $this->db_mv->limit($pager['rows'], ($pager['page'] - 1) * $pager['rows']);
        return $this->db_mv->get('cast')->result_array();
    }

    public function getListInMovie($movieId)
    {
        $sql = 'SELECT a.Name, a.IsDelete, b.ID, b.CastID, b.Sort, b.IsDirector
                FROM (SELECT * FROM movie_cast WHERE MovieID=?) b LEFT JOIN CAST a ON a.ID=b.CastID
                ORDER BY b.IsDirector DESC, b.Sort ASC';
        return $this->db_mv->query($sql, array($movieId))->result_array();
    }

}
