<?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions
{
    public function __construct()
    {
        parent::__construct();
    }

    function show_404($page = '', $log_error = TRUE)
    {
        $heading = "404 Page Not Found";
        $message = "The page you requested was not found.";

        set_status_header(404);
        $message = '<p>' . implode('</p><p>', array($message)) . '</p>';
        ob_start();
        include (APPPATH . 'errors/error_404.php');
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
        exit ;
    }

    //{
    //    "$heading": "A Database Error Occurred",
    //    "$message": [
    //        "Error Number: 1054",
    //        "Unknown column 'UserNamexxx' in 'where clause'",
    //        "SELECT COUNT(*) AS `numrows` FROM (`user`) WHERE `UserNamexxx` LIKE '%111%'OR `DisplayName` LIKE '%111%'",
    //        "Filename: D:\Dev\PHP\www\mc\system\database\DB_driver.php",
    //        "Line Number: 330"
    //    ],
    //    "$template": "error_db",
    //    "$status_code": 500
    //}
    function show_error($heading, $message, $template = 'error_general', $status_code = 500)
    {
        $message = '<p><b>' . $heading . '</b></p><p>' . implode('</p><p>', (!is_array($message)) ? array($message) : $message) . '</p>';

        $error = array(
            'result' => 0,
            'message' => $message
        );
        header('content-type:application/json;charset=utf8');
		if (version_compare(PHP_VERSION,'5.4.0','<'))
		{
			echo json_encode($error);
		}
        else
		{
			echo json_encode($error, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		}
        exit ;
    }

    function show_php_error($severity, $message, $filepath, $line)
    {
        $severity = (!isset($this->levels[$severity])) ? $severity : $this->levels[$severity];
        $filepath = substr($filepath, strpos($filepath, 'application') + 11);
        $filepath = str_replace("\\", "/", $filepath);
        $message = "<b>$severity</b>: $message in <b>$filepath</b> on line $line";
        $error = array(
            'result' => 0,
            'message' => $message
        );
        header('content-type:application/json;charset=utf8');
        if (version_compare(PHP_VERSION,'5.4.0','<'))
		{
			echo json_encode($error);
		}
        else
		{
			echo json_encode($error, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		}
        exit ;
    }

}
