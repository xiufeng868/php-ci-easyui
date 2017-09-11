<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A sp table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By sp there is only one group (the 'sp' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'mc';
$active_record = TRUE;

$db['mc']['hostname'] = 'localhost';
$db['mc']['username'] = 'root';
$db['mc']['password'] = '';
$db['mc']['database'] = 'mc';
$db['mc']['dbdriver'] = 'mysqli';
$db['mc']['dbprefix'] = '';
$db['mc']['pconnect'] = FALSE;
$db['mc']['db_debug'] = TRUE;
$db['mc']['cache_on'] = FALSE;
$db['mc']['cachedir'] = '';
$db['mc']['char_set'] = 'utf8';
$db['mc']['dbcollat'] = 'utf8_general_ci';
$db['mc']['swap_pre'] = '';
$db['mc']['autoinit'] = TRUE;
$db['mc']['stricton'] = FALSE;
$db['mc']['port'] = 3306;

$db['mv']['hostname'] = 'localhost';
$db['mv']['username'] = 'root';
$db['mv']['password'] = '';
$db['mv']['database'] = 'movie';
$db['mv']['dbdriver'] = 'mysqli';
$db['mv']['dbprefix'] = '';
$db['mv']['pconnect'] = FALSE;
$db['mv']['db_debug'] = TRUE;
$db['mv']['cache_on'] = FALSE;
$db['mv']['cachedir'] = '';
$db['mv']['char_set'] = 'utf8';
$db['mv']['dbcollat'] = 'utf8_general_ci';
$db['mv']['swap_pre'] = '';
$db['mv']['autoinit'] = TRUE;
$db['mv']['stricton'] = FALSE;
$db['mv']['port'] = 3306;

$db['lc']['hostname'] = 'localhost';
$db['lc']['username'] = 'root';
$db['lc']['password'] = '';
$db['lc']['database'] = 'lc';
$db['lc']['dbdriver'] = 'mysqli';
$db['lc']['dbprefix'] = '';
$db['lc']['pconnect'] = FALSE;
$db['lc']['db_debug'] = TRUE;
$db['lc']['cache_on'] = FALSE;
$db['lc']['cachedir'] = '';
$db['lc']['char_set'] = 'utf8';
$db['lc']['dbcollat'] = 'utf8_general_ci';
$db['lc']['swap_pre'] = '';
$db['lc']['autoinit'] = TRUE;
$db['lc']['stricton'] = FALSE;
$db['lc']['port'] = 3306;

/* End of file database.php */
/* Location: ./application/config/database.php */
