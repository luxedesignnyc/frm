<?php
error_reporting(0);
#Folder system
$system_folder = "system";
#Folder application
$application_folder = "application";
#BEGIN: Set server path
if(strpos($system_folder, '/') === FALSE)
{
	if(function_exists('realpath') AND @realpath(dirname(__FILE__)) !== FALSE)
	{
		$system_folder = realpath(dirname(__FILE__)).'/'.$system_folder;
	}
}
else
{
	#Server Unix
	$system_folder = str_replace("\\", "/", $system_folder); 
}
#END Set server path
#BEGIN: Define const
define('EXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION));
define('FCPATH', __FILE__);
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('BASEPATH', $system_folder.'/');
#END Define const
#BEGIN: Set path for application
if(is_dir($application_folder))
{
	define('APPPATH', $application_folder.'/');
}
else
{
	if($application_folder == '')
	{
		$application_folder = 'application';
	}
	define('APPPATH', BASEPATH.$application_folder.'/');
}
#END Set path for application
#Load Setting
require_once BASEPATH.$application_folder.'/config/setting.php';
#Load frontend controller
require_once BASEPATH.'codeigniter/CodeIgniter'.EXT;
#END INDEX