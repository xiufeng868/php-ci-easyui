<?php defined('BASEPATH') or exit('No direct script access allowed');

class Movie extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mv/MovieModel');
        $this->load->model('mv/LinkModel');
        $this->load->model('mv/CastModel');
        $this->load->model('mv/TagModel');
    }

    public function index()
    {
        $data['permission'] = $this->getPermission('mv' . __CLASS__);
        $this->loadModuleView('mv/movie/index', $data);
    }

    /* Movie */

    public function query()
    {
        $queryStr = $this->input->post('queryStr');
        $page = array(
            'totalRows' => 0,
            'rows' => $this->input->post('rows'),
            'page' => $this->input->post('page'),
        );
        $result = $this->MovieModel->getList($page, $queryStr);
        echo $this->setDataGridResponse($page, $result);
    }

    public function crawl()
    {
        $this->loadOperateView('mv/movie/crawl');
    }

    public function crawl_post()
    {
        $this->validatePost('mv_movie_crawl');
        $id = $this->input->post('ID');
        $category = $this->input->post('Category');
        $data = array();
        $result = crawler_douban_movie($this->errors, $id, $category, $data);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function create()
    {
        $this->loadOperateView('mv/movie/create');
    }

    public function create_post()
    {
        $this->validatePost('mv_movie');
        $data = array(
            'ID' => $this->input->post('ID'),
            'Title' => $this->input->post('Title'),
            'TitleOrigin' => $this->input->post('TitleOrigin'),
            'Aka' => $this->input->post('Aka'),
            'Url' => $this->input->post('Url'),
            'UrlM' => $this->input->post('UrlM'),
            'Rating' => $this->input->post('Rating'),
            'RatingCount' => $this->input->post('RatingCount'),
            'CoverL' => $this->input->post('CoverL'),
            'CoverM' => $this->input->post('CoverM'),
            'CoverS' => $this->input->post('CoverS'),
            'CoverLL' => $this->input->post('CoverLL'),
            'CoverML' => $this->input->post('CoverML'),
            'CoverSL' => $this->input->post('CoverSL'),
            'Writer' => $this->input->post('Writer'),
            'Pubdate' => $this->input->post('Pubdate'),
            'Year' => $this->input->post('Year'),
            'Language' => $this->input->post('Language'),
            'Duration' => $this->input->post('Duration'),
            'Country' => $this->input->post('Country'),
            'Summary' => $this->input->post('Summary'),
            'CommentCount' => $this->input->post('CommentCount'),
            'ReviewCount' => $this->input->post('ReviewCount'),
            'SeasonCount' => $this->input->post('SeasonCount'),
            'CurrentSeason' => $this->input->post('CurrentSeason'),
            'EpisodeCount' => $this->input->post('EpisodeCount'),
            'IMDb' => $this->input->post('IMDb'),
            'Category' => $this->input->post('Category'),
            'Gallery' => $this->input->post('Gallery'),
            'Comment' => $this->input->post('Comment'),
            'Review' => $this->input->post('Review'),
            'IsDelete' => 0,
            'UpdateTime' => date('Y-m-d H:i:s', time()),
        );
        $result = $this->MovieModel->create($this->errors, $data);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function edit($id)
    {
        $this->validateGet($id);
        $result = $this->MovieModel->getById($id);
        $this->loadOperateView('mv/movie/edit', $result);
    }

    public function edit_post()
    {
        $this->validatePost('mv_movie');
        $data = array(
            'ID' => $this->input->post('ID'),
            'Title' => $this->input->post('Title'),
            'TitleOrigin' => $this->input->post('TitleOrigin'),
            'Aka' => $this->input->post('Aka'),
            'Url' => $this->input->post('Url'),
            'UrlM' => $this->input->post('UrlM'),
            'Rating' => $this->input->post('Rating'),
            'RatingCount' => $this->input->post('RatingCount'),
            'CoverL' => $this->input->post('CoverL'),
            'CoverM' => $this->input->post('CoverM'),
            'CoverS' => $this->input->post('CoverS'),
            'CoverLL' => $this->input->post('CoverLL'),
            'CoverML' => $this->input->post('CoverML'),
            'CoverSL' => $this->input->post('CoverSL'),
            'Writer' => $this->input->post('Writer'),
            'Pubdate' => $this->input->post('Pubdate'),
            'Year' => $this->input->post('Year'),
            'Language' => $this->input->post('Language'),
            'Duration' => $this->input->post('Duration'),
            'Country' => $this->input->post('Country'),
            'Summary' => $this->input->post('Summary'),
            'CommentCount' => $this->input->post('CommentCount'),
            'ReviewCount' => $this->input->post('ReviewCount'),
            'SeasonCount' => $this->input->post('SeasonCount'),
            'CurrentSeason' => $this->input->post('CurrentSeason'),
            'EpisodeCount' => $this->input->post('EpisodeCount'),
            'IMDb' => $this->input->post('IMDb'),
            'Category' => $this->input->post('Category'),
            'Gallery' => $this->input->post('Gallery'),
            'Comment' => $this->input->post('Comment'),
            'Review' => $this->input->post('Review'),
            'UpdateTime' => date('Y-m-d H:i:s', time()),
        );
        $result = $this->MovieModel->edit($this->errors, $data);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function delete($id)
    {
        $this->validateGet($id);
        $result = $this->MovieModel->softDelete($this->errors, $id);
        echo $this->setAjaxResponse($result, $this->errors->getMessage());
    }

    public function restore($id)
    {
        $this->validateGet($id);
        $result = $this->MovieModel->restore($this->errors, $id);
        echo $this->setAjaxResponse($result, $this->errors->getMessage());
    }

    public function details($id)
    {
        $this->validateGet($id);
        $result = $this->MovieModel->getById($id);
        $result['Tag'] = '';
        $tags = $this->TagModel->getListInMovie($id);
        $index = 0;
        foreach ($tags as $tag) {
            if ($index > 0) {
                $result['Tag'] .= ' / ' . $tag['Name'];
            } else {
                $result['Tag'] .= $tag['Name'];
            }
            $index++;
        }
        $this->loadOperateView('mv/movie/details', $result);
    }

    /* Cast */

    public function query_cast($movieId)
    {
        $result = $this->CastModel->getListInMovie($movieId);
        echo json_encode($result);
    }

    public function create_cast()
    {
        $this->loadOperateView('mv/movie/cast/create');
    }

    public function create_cast_post()
    {
        $this->validatePost('mv_moviecast_create');
        $data = array(
            'MovieID' => $this->input->post('MovieID'),
            'CastID' => $this->input->post('CastID'),
            'Sort' => $this->input->post('Sort'),
            'IsDirector' => $this->input->post('IsDirector') === 'true' ? 1 : 0,
        );
        $result = $this->MovieModel->createMovieCast($this->errors, $data);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function edit_cast($id)
    {
        $this->validateGet($id);
        $result = $this->MovieModel->getMovieCastById($id);
        $this->loadOperateView('mv/movie/cast/edit', $result);
    }

    public function edit_cast_post()
    {
        $this->validatePost('mv_moviecast_edit');
        $data = array(
            'ID' => $this->input->post('ID'),
            'Sort' => $this->input->post('Sort'),
            'IsDirector' => $this->input->post('IsDirector') === 'true' ? 1 : 0,
        );
        $result = $this->MovieModel->editMovieCast($this->errors, $data);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function delete_cast($id)
    {
        $this->validateGet($id);
        $result = $this->MovieModel->deleteMovieCast($this->errors, $id);
        echo $this->setAjaxResponse($result, $this->errors->getMessage());
    }

    /* Link */

    public function query_link($movieId)
    {
        $result = $this->LinkModel->getListInMovie($movieId);
        echo json_encode($result);
    }

    public function create_link()
    {
        $this->loadOperateView('mv/movie/link/create');
    }

    public function create_link_post()
    {
        $this->validatePost('mv_link_create');
        $data = array(
            'Title' => $this->input->post('Title'),
            'Url' => $this->input->post('Url'),
            'Remark' => $this->input->post('Remark'),
            'Resolution' => $this->input->post('Resolution'),
            'Size' => $this->input->post('Size'),
            'Sort' => $this->input->post('Sort'),
            'MovieID' => $this->input->post('MovieID'),
        );
        $result = $this->LinkModel->create($this->errors, $data);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function edit_link($id)
    {
        $this->validateGet($id);
        $result = $this->LinkModel->getById($id);
        $this->loadOperateView('mv/movie/link/edit', $result);
    }

    public function edit_link_post()
    {
        $this->validatePost('mv_link_edit');
        $data = array(
            'ID' => $this->input->post('ID'),
            'Title' => $this->input->post('Title'),
            'Url' => $this->input->post('Url'),
            'Remark' => $this->input->post('Remark'),
            'Resolution' => $this->input->post('Resolution'),
            'Size' => $this->input->post('Size'),
            'Sort' => $this->input->post('Sort'),
            'MovieID' => $this->input->post('MovieID'),
        );
        $result = $this->LinkModel->edit($this->errors, $data);
        echo $this->setAjaxResponse($result, $this->errors->getMessage(), $data);
    }

    public function delete_link($id)
    {
        $this->validateGet($id);
        $result = $this->LinkModel->delete($this->errors, $id);
        echo $this->setAjaxResponse($result, $this->errors->getMessage());
    }

    public function details_link($id)
    {
        $this->validateGet($id);
        $result = $this->LinkModel->getById($id);

        $kv_dictionary = cache_dictionary_kv();
        $result['Resolution'] = $kv_dictionary[$result['Resolution']];

        $this->loadOperateView('mv/movie/link/details', $result);
    }

}
