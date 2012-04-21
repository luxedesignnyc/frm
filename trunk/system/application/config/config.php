<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');
#Base url
$config['base_url']	= "http://localhost/raovat";
//$config['base_url']	= "http://thuexeoto24h.com/raovat";
//$config['base_url']	= "http://localhost/raovat";
#Index file
$config['index_page'] = "index.php";
#Uri protocol
$config['uri_protocol']	= "AUTO";
#Url suffix
$config['url_suffix'] = "";
#Language
$config['language']	= "vietnamese";
#Charset
$config['charset'] = "UTF-8";
#Hooks
$config['enable_hooks'] = FALSE;
#Sub class prefix
$config['subclass_prefix'] = 'MY_';
#Alowed url
$config['permitted_uri_chars'] = '';
#BEGIN: Common
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] 	= 'c';
$config['function_trigger'] 	= 'm';
$config['directory_trigger'] 	= 'd';
#END Common
#Log threshold
$config['log_threshold'] = 0;
#Log path
$config['log_path'] = '';
#Log date format
$config['log_date_format'] = 'Y-m-d H:i:s';
#Cache path
$config['cache_path'] = '';
#Encryption key
$config['encryption_key'] = "saY87kMi21";
#BEGIN: Session
$config['sess_cookie_name']		= '_sessionSite';
$config['sess_expiration']		= Setting::settingTimeSession * 60;
$config['sess_encrypt_cookie']	= TRUE;
$config['sess_use_database']	= TRUE;
$config['sess_table_name']		= 'tbtt_session';
$config['sess_match_ip']		= FALSE;
$config['sess_match_useragent']	= TRUE;
$config['sess_time_to_update'] 	= 120;
#END Session
#BEGIN: Cookie
$config['cookie_prefix']	= "";
$config['cookie_domain']	= "";
$config['cookie_path']		= "/";
#END Cookie
#XSS Filtering
$config['global_xss_filtering'] = TRUE;
#Compress output
$config['compress_output'] = TRUE;
#Time reference
$config['time_reference'] = 'local';
#Rewrite short tags
$config['rewrite_short_tags'] = FALSE;
#Proxy ips
$config['proxy_ips'] = '';