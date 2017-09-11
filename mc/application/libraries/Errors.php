<?php defined('BASEPATH') or exit('No direct script access allowed');

class Errors
{

    public $errors = array();

    public function __construct()
    {
        //Construct Code...
    }

    public function add($message)
    {
        if (func_num_args() > 1) {
            $err = func_get_arg(1);
            $this->errors[] = '<span class="icon-error icon"></span>' . $message . '<br>' . $err[0] . ' - ' . $err[1];
        } else {
            $this->errors[] = '<span class="icon-error icon"></span>' . $message;
        }

    }

    public function addSuccess($message)
    {
        $this->errors[] = '<span class="icon-success icon"></span>' . $message;
    }

    public function getMessage()
    {
        $result = '';
        foreach ($this->errors as $error) {
            $result .= (strlen($result) > 0 ? '<br>' : '') . $error;
        }
        return $result;
    }

}
