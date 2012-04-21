<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');
#Auto load libraries
$autoload['libraries'] = array('database', 'session', 'filter', 'check');
#Auto load helper
$autoload['helper'] = array('url', 'str', 'thumbnail');
#Auto load plugin
$autoload['plugin'] = array();
#Auto load config
$autoload['config'] = array();
#Auto load language
$autoload['language'] = array();
#Auto load model
$autoload['model'] = array('counter_model', 'menu_model', 'advertise_model');