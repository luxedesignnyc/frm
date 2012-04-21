<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');
#BEGIN: Route Default
$route['default_controller'] = "home/defaults";
$route['scaffolding_trigger'] = "";
#END Route Default
#BEGIN: Administ
//Default
$route['administ'] = 'administ/defaults';
//User
$route['administ/user/(search|filter|sort|page|status).*'] = 'administ/user';
$route['administ/user/end/(search|filter|sort|page).*'] = 'administ/user/end';
$route['administ/user/inactive/(search|filter|sort|page|status).*'] = 'administ/user/inactive';
$route['administ/user/vip/(search|filter|sort|page|status).*'] = 'administ/user/vip';
$route['administ/user/vip/end.*'] = 'administ/user/endvip';
$route['administ/user/saler/(search|filter|sort|page|status).*'] = 'administ/user/saler';
$route['administ/user/saler/end.*'] = 'administ/user/endsaler';
$route['administ/user/add'] = 'administ/user/add';
$route['administ/user/edit/(:num)'] = 'administ/user/edit/$1';
//Group
$route['administ/group/(search|filter|sort|page|status).*'] = 'administ/group';
$route['administ/group/add'] = 'administ/group/add';
$route['administ/group/edit/(:num)'] = 'administ/group/edit/$1';
//Category
$route['administ/category/(search|filter|sort|page|status).*'] = 'administ/category';
$route['administ/category/add'] = 'administ/category/add';
$route['administ/category/edit/(:num)'] = 'administ/category/edit/$1';
//Field
$route['administ/field/(search|filter|sort|page|status).*'] = 'administ/field';
$route['administ/field/add'] = 'administ/field/add';
$route['administ/field/edit/(:num)'] = 'administ/field/edit/$1';
//Province
$route['administ/province/(search|filter|sort|page|status).*'] = 'administ/province';
$route['administ/province/add'] = 'administ/province/add';
$route['administ/province/edit/(:num)'] = 'administ/province/edit/$1';
//Menu
$route['administ/menu/(search|filter|sort|page|status).*'] = 'administ/menu';
$route['administ/menu/add'] = 'administ/menu/add';
$route['administ/menu/edit/(:num)'] = 'administ/menu/edit/$1';
//Notify
$route['administ/notify/(search|filter|sort|page|status).*'] = 'administ/notify';
$route['administ/notify/add'] = 'administ/notify/add';
$route['administ/notify/edit/(:num)'] = 'administ/notify/edit/$1';
//Contact
$route['administ/contact'] = 'administ/contact';
$route['administ/contact/(search|filter|sort|page|status).*'] = 'administ/contact';
$route['administ/contact/view/(:num)'] = 'administ/contact/view/$1';
//Advertise
$route['administ/advertise/(search|filter|sort|page|status).*'] = 'administ/advertise';
$route['administ/advertise/end/(search|filter|sort|page).*'] = 'administ/advertise/end';
$route['administ/advertise/add'] = 'administ/advertise/add';
$route['administ/advertise/edit/(:num)'] = 'administ/advertise/edit/$1';
//Shop
$route['administ/shop/(search|filter|sort|page|status).*'] = 'administ/shop';
$route['administ/shop/end/(search|filter|sort|page).*'] = 'administ/shop/end';
$route['administ/shop/add'] = 'administ/shop/add';
$route['administ/shop/edit/(:num)'] = 'administ/shop/edit/$1';
//Product
$route['administ/product'] = 'administ/product';
$route['administ/product/(search|filter|sort|page|status).*'] = 'administ/product';
$route['administ/product/bad/(search|filter|sort|page|status|detail).*'] = 'administ/product/bad';
$route['administ/product/end/(search|filter|sort|page).*'] = 'administ/product/end';
//Ads
$route['administ/ads'] = 'administ/ads';
$route['administ/ads/(search|filter|sort|page|status).*'] = 'administ/ads';
$route['administ/ads/bad/(search|filter|sort|page|status|detail).*'] = 'administ/ads/bad';
$route['administ/ads/end/(search|filter|sort|page).*'] = 'administ/ads/end';
//Job
$route['administ/job/(search|filter|sort|page|status|reliable).*'] = 'administ/job';
$route['administ/job/bad/(search|filter|sort|page|status|reliable|detail).*'] = 'administ/job/bad';
$route['administ/job/end/(search|filter|sort|page|reliable).*'] = 'administ/job/end';
//Employ
$route['administ/employ/(search|filter|sort|page|status|reliable).*'] = 'administ/employ';
$route['administ/employ/bad/(search|filter|sort|page|status|reliable|detail).*'] = 'administ/employ/bad';
$route['administ/employ/end/(search|filter|sort|page|reliable).*'] = 'administ/employ/end';
//Showcart
$route['administ/showcart/(search|filter|sort|page).*'] = 'administ/showcart';
//Config
$route['administ/system/config'] = 'administ/config';
$route['administ/system/info'] = 'administ/config/info';
//Tool
$route['administ/tool/mail'] = 'administ/tool/mail';
$route['administ/tool/cache'] = 'administ/tool/cache';
$route['administ/tool/captcha'] = 'administ/tool/captcha';
//Logout
$route['administ/logout'] = 'administ/logout';
#END Administ
#BEGIN: Home
//Defaults
$route['ajax'] = 'home/defaults/ajax';
//Information
$route['information'] = 'home/information/index';
//Product
$route['product/category/(:num)'] = 'home/product/category/$1';
$route['product/category/(:num)/sort.*'] = 'home/product/category/$1';
$route['product/category/(:num)/page.*'] = 'home/product/category/$1';
$route['product/saleoff.*'] = 'home/product/saleoff';
$route['product/category/(:num)/detail/(:num).*'] = 'home/product/detail/$1/$2';
$route['product/post'] = 'home/product/post';
//Ads
$route['ads'] = 'home/ads';
$route['ads/rSort.*'] = 'home/ads';
$route['ads/nSort.*'] = 'home/ads';
$route['ads/rPage.*'] = 'home/ads';
$route['ads/nPage.*'] = 'home/ads';
$route['ads/category/(:num)'] = 'home/ads/category/$1';
$route['ads/category/(:num)/rSort.*'] = 'home/ads/category/$1';
$route['ads/category/(:num)/nSort.*'] = 'home/ads/category/$1';
$route['ads/category/(:num)/rPage.*'] = 'home/ads/category/$1';
$route['ads/category/(:num)/nPage.*'] = 'home/ads/category/$1';
$route['ads/shop.*'] = 'home/ads/shop';
$route['ads/category/(:num)/detail/(:num).*'] = 'home/ads/detail/$1/$2';
$route['ads/post'] = 'home/ads/post';
//Job
$route['job'] = 'home/job';
$route['job/sort.*'] = 'home/job';
$route['job/page.*'] = 'home/job';
$route['job/field/(:num)'] = 'home/job/field/$1';
$route['job/field/(:num)/sort.*'] = 'home/job/field/$1';
$route['job/field/(:num)/page.*'] = 'home/job/field/$1';
$route['job/field/(:num)/detail/(:num).*'] = 'home/job/detail/$1/$2';
$route['job/post'] = 'home/job/post';
//Employ
$route['employ'] = 'home/employ';
$route['employ/sort.*'] = 'home/employ';
$route['employ/page.*'] = 'home/employ';
$route['employ/field/(:num)'] = 'home/employ/field/$1';
$route['employ/field/(:num)/sort.*'] = 'home/employ/field/$1';
$route['employ/field/(:num)/page.*'] = 'home/employ/field/$1';
$route['employ/field/(:num)/detail/(:num).*'] = 'home/employ/detail/$1/$2';
$route['employ/post'] = 'home/employ/post';
//Showcart
$route['showcart.*'] = 'home/showcart';
//Notify
$route['notify/(:num)'] = 'home/notify';
$route['notify/(:num)/page'] = 'home/notify';
$route['notify/(:num)/page/(:num)'] = 'home/notify';
//Guide
$route['guide'] = 'home/guide';
//Register
$route['register'] = 'home/register';
$route['register/ajax'] = 'home/register/ajax';
$route['activation/user/(:any)/key/(:any)/token/(:any)'] = 'home/register/activation/$1/$2/$3';
//Contact
$route['contact'] = 'home/contact';
//Search
$route['search/product.*'] = 'home/search/product';
$route['search/ads.*'] = 'home/search/ads';
$route['search/job.*'] = 'home/search/job';
$route['search/employ.*'] = 'home/search/employ';
$route['search/shop.*'] = 'home/search/shop';
//Login - logout
$route['login'] = 'home/login';
$route['logout'] = 'home/login/logout';
//Forgot
$route['forgot'] = 'home/forgot';
$route['forgot/reset/key/(:any)/token/(:any)'] = 'home/forgot/reset/$1/$2';
//Account
$route['account'] = 'home/account';
$route['account/edit'] = 'home/account/edit';
$route['account/changepassword'] = 'home/account/changepassword';
$route['account/shop'] = 'home/account/shop';
$route['account/notify.*'] = 'home/account/notify';
$route['account/contact.*'] = 'home/account/contact';
$route['account/product.*'] = 'home/account/product';
$route['account/ads.*'] = 'home/account/ads';
$route['account/job.*'] = 'home/account/job';
$route['account/employ.*'] = 'home/account/employ';
$route['account/customer.*'] = 'home/account/customer';
$route['account/showcart.*'] = 'home/account/showcart';
$route['account/ajax'] = 'home/account/ajax';
//Shop
$route['shop'] = 'home/shop';
$route['shop/sort.*'] = 'home/shop';
$route['shop/page.*'] = 'home/shop';
$route['shop/category/(:num)'] = 'home/shop/category/$1';
$route['shop/category/(:num)/sort.*'] = 'home/shop/category/$1';
$route['shop/category/(:num)/page.*'] = 'home/shop/category/$1';
$route['shop/saleoff.*'] = 'home/shop/saleoff';
$route['shop/ajax'] = 'home/shop/ajax';
$route['([a-z0-9_-])+'] = 'home/shop/detail';
$route['([a-z0-9_-])+/product'] = 'home/shop/detail';
$route['([a-z0-9_-])+/product/sort.*'] = 'home/shop/detail';
$route['([a-z0-9_-])+/product/page.*'] = 'home/shop/detail';
$route['([a-z0-9_-])+/product/saleoff'] = 'home/shop/detail';
$route['([a-z0-9_-])+/product/saleoff/sort.*'] = 'home/shop/detail';
$route['([a-z0-9_-])+/product/saleoff/page.*'] = 'home/shop/detail';
$route['([a-z0-9_-])+/product/detail/(:num)'] = 'home/shop/detail';
$route['([a-z0-9_-])+/ads'] = 'home/shop/detail';
$route['([a-z0-9_-])+/ads/sort.*'] = 'home/shop/detail';
$route['([a-z0-9_-])+/ads/page.*'] = 'home/shop/detail';
$route['([a-z0-9_-])+/ads/detail/(:num)'] = 'home/shop/detail';
$route['([a-z0-9_-])+/search.*'] = 'home/shop/detail';
$route['([a-z0-9_-])+/contact'] = 'home/shop/detail';
#END Home