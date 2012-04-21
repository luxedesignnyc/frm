<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');
$active_group = "default";
$active_record = TRUE;
#BEGIN: Database
$db['default']['hostname'] = "localhost";
$db['default']['username'] = "mua3s";
$db['default']['password'] = "mua3s";
$db['default']['database'] = "raovatdb";
$db['default']['dbdriver'] = "mysql";
$db['default']['dbprefix'] = "tbtt_";
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "system/cache";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";
#END Database