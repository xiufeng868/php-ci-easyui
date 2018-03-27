<?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function insertRight()
    {
        $sql = 'INSERT INTO `right`(ModuleID,RoleID,RightFlag)
                SELECT DISTINCT a.ID,b.ID,0 FROM module a,role b
                WHERE CONCAT(a.ID,b.ID) NOT IN(SELECT CONCAT(ModuleID,RoleID) FROM `right`)';
        return $this->db->query($sql);
    }
}
