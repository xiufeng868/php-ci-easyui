<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends MY_Controller
{
    public function index()
    {
    	$this->load->model('mc/ModuleModel');
        $result = $this->ModuleModel->getTree2($this->getUserID());
        $data['menu'] = $result;
        $this->load->view('test', $data);
    }

}
