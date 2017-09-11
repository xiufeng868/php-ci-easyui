<?php defined('BASEPATH') or exit('No direct script access allowed');

class MovieModel extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db_mv = $this->load->database('mv', true);
    }

    public function create(&$error, $data)
    {
        $this->db_mv->from('movie');
        $this->db_mv->where('ID', $data['ID']);
        $result = $this->db_mv->count_all_results();
        if ($result > 0) {
            $error->add('创建电影失败：ID重复');
            return false;
        }

        $this->db_mv->insert('movie', $data);
        $result = $this->db_mv->affected_rows();
        if ($result > 0) {
            $error->addSuccess('创建电影成功');
            return true;
        } else {
            $error->add('创建电影失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function edit(&$error, $data)
    {
        $this->db_mv->where('ID', $data['ID']);
        $this->db_mv->update('movie', $data);
        $result = $this->db_mv->affected_rows();
        if ($result > 0) {
            $error->addSuccess('修改电影成功');
            return true;
        } else {
            $error->add('修改电影失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function softDelete(&$error, $id)
    {
        $this->db_mv->where('ID', $id);
        $this->db_mv->update('movie', array('IsDelete' => 1));
        $result = $this->db_mv->affected_rows();
        if ($result > 0) {
            $error->addSuccess('删除电影成功');
            return true;
        } else {
            $error->add('删除电影失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function delete(&$error, $id)
    {
        $this->db_mv->trans_start();
        //删除tag表数据
        $this->db_mv->where('MovieID', $id);
        $this->db_mv->delete('tag');
        //删除link表数据
        $this->db_mv->where('MovieID', $id);
        $this->db_mv->delete('link');
        //删除movie_cast表数据
        $this->db_mv->where('MovieID', $id);
        $this->db_mv->delete('movie_cast');
        //删除movie表数据
        $this->db_mv->where('ID', $id);
        $this->db_mv->delete('movie');
        $result = $this->db_mv->affected_rows();
        $this->db_mv->trans_complete();
        if ($result > 0) {
            $error->addSuccess('彻底删除电影成功');
            return true;
        } else {
            $err = $this->db_mv->error();
            $error->add('彻底删除电影失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function restore(&$error, $id)
    {
        $this->db_mv->where('ID', $id);
        $this->db_mv->update('movie', array('IsDelete' => 0));
        $result = $this->db_mv->affected_rows();
        if ($result > 0) {
            $error->addSuccess('还原电影成功');
            return true;
        } else {
            $error->add('还原电影失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function crawl(&$error, $data)
    {
        $this->db_mv->trans_start();
        //删除movie表数据
        $this->db_mv->where('ID', $data['ID']);
        $this->db_mv->delete('movie');
        //插入movie表数据
        $this->db_mv->insert('movie', $data);
        $result = $this->db_mv->affected_rows();
        $this->db_mv->trans_complete();
        if ($result > 0) {
            $error->addSuccess('更新电影[' . $data['Title'] . ']成功');
            return true;
        } else {
            $err = $this->db_mv->error();
            $error->add('更新电影[' . $data['Title'] . ']失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function getById($id)
    {
        $this->db_mv->where('ID', $id);
        return $this->db_mv->get('movie')->row_array();
    }

    public function exists($id)
    {
        $this->db_mv->from('movie');
        $this->db_mv->where('ID', $id);
        return $this->db_mv->count_all_results();
    }

    public function getList(&$pager, $queryStr)
    {
        $where = array(
            'Title' => $queryStr,
            'TitleOrigin' => $queryStr,
            'Aka' => $queryStr,
            'ID' => $queryStr,
            'IMDb' => $queryStr,
            'Year' => $queryStr,
        );

        if (!empty($queryStr)) {
            $this->db_mv->or_like($where);
        }
        $this->db_mv->from('movie');
        $pager['totalRows'] = $this->db_mv->count_all_results();

        if (!empty($queryStr)) {
            $this->db_mv->or_like($where);
        }
        $this->db_mv->select('ID, Title, TitleOrigin, Url, Rating, CoverM, Year, IMDb, IsDelete, UpdateTime');
        $this->db_mv->order_by("UpdateTime", "DESC");
        $this->db_mv->limit($pager['rows'], ($pager['page'] - 1) * $pager['rows']);
        return $this->db_mv->get('movie')->result_array();
    }

    public function createMovieCast(&$error, &$data)
    {
        $this->load->model('mv/CastModel');
        $result = $this->CastModel->exists($data['CastID']);
        if ($result <= 0) {
            $error->add('创建电影演员关联失败：演员不存在');
            return false;
        }

        $this->db_mv->from('movie_cast');
        $this->db_mv->where('MovieID', $data['MovieID']);
        $this->db_mv->where('CastID', $data['CastID']);
        $result = $this->db_mv->count_all_results();
        if ($result > 0) {
            $error->add('创建电影演员关联失败：演员已关联');
            return false;
        }

        $this->db_mv->insert('movie_cast', $data);
        $data['ID'] = $this->db_mv->insert_id();
        $result = $this->db_mv->affected_rows();
        if ($result > 0) {
            $error->addSuccess('创建电影演员关联成功');
            return true;
        } else {
            $error->add('创建电影演员关联失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function editMovieCast(&$error, $data)
    {
        $this->db_mv->where('ID', $data['ID']);
        $this->db_mv->update('movie_cast', $data);
        $result = $this->db_mv->affected_rows();
        if ($result > 0) {
            $error->addSuccess('修改电影演员关联成功');
            return true;
        } else {
            $error->add('修改电影演员关联失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function deleteMovieCast(&$error, $id)
    {
        $this->db_mv->where('ID', $id);
        $this->db_mv->delete('movie_cast');
        $result = $this->db_mv->affected_rows();
        if ($result > 0) {
            $error->addSuccess('删除电影演员关联成功');
            return true;
        } else {
            $error->add('删除电影演员关联失败：数据操作异常', $this->db_mv->error());
            return false;
        }
    }

    public function getMovieCastById($id)
    {
        $this->db_mv->where('ID', $id);
        return $this->db_mv->get('movie_cast')->row_array();
    }

}
