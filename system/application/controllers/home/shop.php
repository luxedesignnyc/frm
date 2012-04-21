<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Shop extends Controller
{
	function __construct()
	{
		parent::Controller();
		#CHECK SETTING
		if((int)Setting::settingStopSite == 1)
		{
            $this->lang->load('home/common');
			show_error($this->lang->line('stop_site_main'));
			die();
		}
		#END CHECK SETTING
		#Load language
		$this->lang->load('home/common');
		$this->lang->load('home/shop');
		#Load model
		$this->load->model('shop_model');
		$this->load->model('category_model');
		#BEGIN: Update counter
		if(!$this->session->userdata('sessionUpdateCounter'))
		{
			$this->counter_model->update();
			$this->session->set_userdata('sessionUpdateCounter', 1);
		}
		#END Update counter
		#BEGIN: Ads & Notify Taskbar
		$this->load->model('ads_model');
		$this->load->model('notify_model');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$adsTaskbar = $this->ads_model->fetch("ads_id, ads_title, ads_category, ads_descr", "ads_status = 1 AND ads_enddate >= $currentDate AND ads_reliable = 1", "rand()", "DESC", 0, (int)Setting::settingAdsNew_Home);
		$data['adsTaskbarGlobal'] = $adsTaskbar;
		$notifyTaskbar = $this->notify_model->fetch("not_id, not_title, not_begindate", "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate", "not_id", "DESC", 0, 4);
		$data['notifyTaskbarGlobal'] = $notifyTaskbar;
		$this->load->vars($data);
		#END Ads & Notify Taskbar
	}
	
	function index()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
		$data['menuSelected'] = 0;
		$data['menuType'] = 'shop';
		$data['menu'] = $this->menu_model->fetch("men_name, men_descr, men_image, men_category", "men_status = 1", "men_order", "ASC");
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'shop_index';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Module
        $data['module'] = 'top_saleoff_shop,top_productest_shop';
        #BEGIN: Top shop saleoff right
		$select = "sho_name, sho_link, sho_descr, sho_begindate";
		$start = 0;
  		$limit = (int)Setting::settingShopSaleoff_Top;
		$data['topSaleoffShop'] = $this->shop_model->fetch($select, "sho_saleoff = 1 AND sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top shop saleoff right
        #BEGIN: Top productest right
		$select = "sho_descr, sho_link, sho_dir_logo, sho_logo";
		$start = 0;
  		$limit = (int)Setting::settingShopProductest_Top;
		$data['topProductestShop'] = $this->shop_model->fetch($select, "sho_status = 1 AND sho_enddate >= $currentDate", "sho_quantity_product", "DESC", $start, $limit);
		#END Top productest right
		#BEGIN: Interest shop
		$select = "sho_descr, sho_link, sho_dir_logo, sho_logo";
		$start = 0;
  		$limit = (int)Setting::settingShopInterest;
		$data['interestShop'] = $this->shop_model->fetch($select, "sho_status = 1 AND sho_enddate >= $currentDate", "sho_view", "DESC", $start, $limit);
		#END Interest shop
        #Define url for $getVar
		$action = array('sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(2, $action);
		#BEGIN: Sort
		$where = "sho_status = 1 AND sho_enddate >= $currentDate";
		$sort = 'sho_id';
		$by = 'DESC';
		$pageSort = '';
		$pageUrl = '';
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'name':
				    $pageUrl .= '/sort/name';
				    $sort = "sho_name";
				    break;
                case 'address':
				    $pageUrl .= '/sort/address';
				    $sort = "sho_address";
				    break;
                case 'product':
				    $pageUrl .= '/sort/product';
				    $sort = "sho_quantity_product";
				    break;
                case 'view':
				    $pageUrl .= '/sort/view';
				    $sort = "sho_view";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort = "sho_id";
			}
			if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
			{
                $pageUrl .= '/by/desc';
				$by = "DESC";
			}
			else
			{
                $pageUrl .= '/by/asc';
				$by = "ASC";
			}
		}
		#If have page
		if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
		{
			$start = (int)$getVar['page'];
			$pageSort .= '/page/'.$start;
		}
		else
		{
			$start = 0;
		}
		#END Sort
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'shop/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->shop_model->fetch_join("sho_id", "LEFT", "tbtt_province", "tbtt_shop.sho_province = tbtt_province.pre_id", "", "", "", $where, "", ""));
        $config['base_url'] = base_url().'shop'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingShopNew_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$select = "sho_name, sho_descr, sho_view, sho_quantity_product, sho_link, sho_dir_logo, sho_logo, sho_address, sho_saleoff, sho_yahoo, sho_phone, pre_name";
		$limit = Setting::settingShopNew_Category;
		$data['shop'] = $this->shop_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_shop.sho_province = tbtt_province.pre_id", "", "", "", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('home/shop/defaults', $data);
	}
	
	function category($categoryID)
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Check exist category by $categoryID
		$category = $this->category_model->get("cat_id", "cat_id = ".(int)$categoryID." AND cat_status = 1");
		if(count($category) != 1 || !$this->check->is_id($categoryID))
		{
			redirect(base_url(), 'location');
			die();
		}
		#END Check exist category by $categoryID
		$categoryIDQuery = (int)$categoryID;
        #BEGIN: Menu
		$data['menuSelected'] = (int)$categoryID;
		$data['menuType'] = 'shop';
		$data['menu'] = $this->menu_model->fetch("men_name, men_descr, men_image, men_category", "men_status = 1", "men_order", "ASC");
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'shop_sub';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Module
        $data['module'] = 'top_saleoff_shop,top_productest_shop';
        #BEGIN: Top shop saleoff right
		$select = "sho_name, sho_link, sho_descr, sho_begindate";
		$start = 0;
  		$limit = (int)Setting::settingShopSaleoff_Top;
		$data['topSaleoffShop'] = $this->shop_model->fetch($select, "sho_saleoff = 1 AND sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top shop saleoff right
        #BEGIN: Top productest right
		$select = "sho_descr, sho_link, sho_dir_logo, sho_logo";
		$start = 0;
  		$limit = (int)Setting::settingShopProductest_Top;
		$data['topProductestShop'] = $this->shop_model->fetch($select, "sho_status = 1 AND sho_enddate >= $currentDate", "sho_quantity_product", "DESC", $start, $limit);
		#END Top productest right
		#BEGIN: Interest shop
		$select = "sho_descr, sho_link, sho_dir_logo, sho_logo";
		$start = 0;
  		$limit = (int)Setting::settingShopInterest_Category;
		$data['interestShop'] = $this->shop_model->fetch($select, "sho_category = $categoryIDQuery AND sho_status = 1 AND sho_enddate >= $currentDate", "sho_view", "DESC", $start, $limit);
		#END Interest shop
        #Define url for $getVar
		$action = array('sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Sort
		$where = "sho_category = $categoryIDQuery AND sho_status = 1 AND sho_enddate >= $currentDate";
		$sort = 'sho_id';
		$by = 'DESC';
		$pageSort = '';
		$pageUrl = '';
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'name':
				    $pageUrl .= '/sort/name';
				    $sort = "sho_name";
				    break;
                case 'address':
				    $pageUrl .= '/sort/address';
				    $sort = "sho_address";
				    break;
                case 'product':
				    $pageUrl .= '/sort/product';
				    $sort = "sho_quantity_product";
				    break;
                case 'view':
				    $pageUrl .= '/sort/view';
				    $sort = "sho_view";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort = "sho_id";
			}
			if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
			{
                $pageUrl .= '/by/desc';
				$by = "DESC";
			}
			else
			{
                $pageUrl .= '/by/asc';
				$by = "ASC";
			}
		}
		#If have page
		if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
		{
			$start = (int)$getVar['page'];
			$pageSort .= '/page/'.$start;
		}
		else
		{
			$start = 0;
		}
		#END Sort
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'shop/category/'.$categoryID.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->shop_model->fetch_join("sho_id", "LEFT", "tbtt_province", "tbtt_shop.sho_province = tbtt_province.pre_id", "", "", "", $where, "", ""));
        $config['base_url'] = base_url().'shop/category/'.$categoryID.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingShopNew_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$select = "sho_name, sho_descr, sho_view, sho_quantity_product, sho_link, sho_dir_logo, sho_logo, sho_address, sho_saleoff, sho_yahoo, sho_phone, pre_name";
		$limit = Setting::settingShopNew_Category;
		$data['shop'] = $this->shop_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_shop.sho_province = tbtt_province.pre_id", "", "", "", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('home/shop/category', $data);
	}
	
	function saleoff()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
		$data['menuSelected'] = 0;
		$data['menuType'] = 'shop';
		$data['menu'] = $this->menu_model->fetch("men_name, men_descr, men_image, men_category", "men_status = 1", "men_order", "ASC");
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'shop_sub';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Module
        $data['module'] = 'top_lastest_shop,top_productest_shop';
        #BEGIN: Top lastest shop right
		$select = "sho_name, sho_link, sho_descr";
		$start = 0;
  		$limit = (int)Setting::settingShopNew_Top;
		$data['topLastestShop'] = $this->shop_model->fetch($select, "sho_status = 1 AND sho_enddate >= $currentDate", "sho_id", "DESC", $start, $limit);
		#END Top lastest shop right
        #BEGIN: Top productest right
		$select = "sho_descr, sho_link, sho_dir_logo, sho_logo";
		$start = 0;
  		$limit = (int)Setting::settingShopProductest_Top;
		$data['topProductestShop'] = $this->shop_model->fetch($select, "sho_status = 1 AND sho_enddate >= $currentDate", "sho_quantity_product", "DESC", $start, $limit);
		#END Top productest right
        #Define url for $getVar
		$action = array('sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Sort
		$where = "sho_saleoff = 1 AND sho_status = 1 AND sho_enddate >= $currentDate";
		$sort = 'sho_id';
		$by = 'DESC';
		$pageSort = '';
		$pageUrl = '';
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'name':
				    $pageUrl .= '/sort/name';
				    $sort = "sho_name";
				    break;
                case 'address':
				    $pageUrl .= '/sort/address';
				    $sort = "sho_address";
				    break;
                case 'product':
				    $pageUrl .= '/sort/product';
				    $sort = "sho_quantity_product";
				    break;
                case 'view':
				    $pageUrl .= '/sort/view';
				    $sort = "sho_view";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort = "sho_id";
			}
			if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
			{
                $pageUrl .= '/by/desc';
				$by = "DESC";
			}
			else
			{
                $pageUrl .= '/by/asc';
				$by = "ASC";
			}
		}
		#If have page
		if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
		{
			$start = (int)$getVar['page'];
			$pageSort .= '/page/'.$start;
		}
		else
		{
			$start = 0;
		}
		#END Sort
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'shop/saleoff/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->shop_model->fetch_join("sho_id", "LEFT", "tbtt_province", "tbtt_shop.sho_province = tbtt_province.pre_id", "", "", "", $where, "", ""));
        $config['base_url'] = base_url().'shop/saleoff'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingShopSaleoff;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$select = "sho_name, sho_descr, sho_view, sho_quantity_product, sho_link, sho_dir_logo, sho_logo, sho_address, sho_saleoff, sho_yahoo, sho_phone, pre_name";
		$limit = Setting::settingShopSaleoff;
		$data['saleoffShop'] = $this->shop_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_shop.sho_province = tbtt_province.pre_id", "", "", "", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('home/shop/saleoff', $data);
	}
	
	function detail()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #Get link shop
        $linkShop = $this->uri->segment(1);
		#BEGIN: Get shop by $linkShop
		$shop = $this->shop_model->get("*", "sho_link = '".$this->filter->injection($linkShop)."' AND sho_status = 1 AND sho_enddate >= $currentDate");
		if(count($shop) != 1 || strlen(trim($linkShop)) < 5 || strlen(trim($linkShop)) > 50)
		{
			redirect(base_url(), 'location');
			die();
		}
		$idUser = (int)$shop->sho_user;
		#END Get shop by $linkShop
		#BEGIN: Update view
		if(!$this->session->userdata('sessionViewShopDetail_'.$shop->sho_id))
		{
            $this->shop_model->update(array('sho_view' => (int)$shop->sho_view + 1), "sho_id = ".$shop->sho_id);
            $this->session->set_userdata('sessionViewShopDetail_'.$shop->sho_id, 1);
		}
		#END Update view
		$this->load->model('product_model');
		#BEGIN: Menu 1
		$data['menuSelected'] = 'home';
		#END Menu 1
		#BEGIN: Advertise
		$data['advertisePage'] = 'shop_detail';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Fetch relate search
		$this->load->model('province_model');
		$data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
		#END Fetch Relate search
		#BEGIN: Global site (Not change)
		$data['siteGlobal'] = $shop;
		#END Globale site
		switch(strtolower($this->uri->segment(2)))
		{
			case 'product':
			    #BEGIN: Add favorite
				$data['successFavoriteProduct'] = false;
				$data['isLogined'] = false;
				if($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
				{
					$data['isLogined'] = true;
					if($this->session->flashdata('sessionSuccessFavoriteProduct'))
					{
						$data['successFavoriteProduct'] = true;
					}
					if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0 && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
					{
						$this->load->model('product_favorite_model');
						$isAdded = false;
						foreach($this->input->post('checkone') as $checkOneArray)
						{
							$productOne = $this->product_model->get("pro_user", "pro_id = ".(int)$checkOneArray." AND pro_user = $idUser");
							$productFavorite = $this->product_favorite_model->get("prf_id", "prf_product = ".(int)$checkOneArray." AND prf_user = ".(int)$this->session->userdata('sessionUser'));
							if(count($productOne) == 1 && count($productFavorite) == 0 && $productOne->pro_user != $this->session->userdata('sessionUser') && $this->check->is_id($checkOneArray))
							{
								$dataAdd = array(
													'prf_product'       =>      (int)$checkOneArray,
													'prf_user'          =>      (int)$this->session->userdata('sessionUser'),
													'prf_date'          =>      $currentDate
													);
								if($this->product_favorite_model->add($dataAdd))
								{
									$isAdded = true;
								}
							}
						}
						unset($productOne);
						unset($productFavorite);
						if($isAdded == true)
						{
							$this->session->set_flashdata('sessionSuccessFavoriteProduct', 1);
						}
						$this->session->set_userdata('sessionTimePosted', time());
						redirect(base_url().trim(uri_string(), '/'), 'location');
					}
				}
				#END Add favorite
				#BEGIN: Menu 2
				$data['menuSelected'] = 'product';
				#END Menu 2
				#Module
				$data['module'] = 'top_lastest_ads';
				#BEGIN: Top lastest ads right
				$select = "ads_id, ads_title, ads_descr";
				$start = 0;
				$limit = (int)Setting::settingShoppingAdsNew_Top;
				$data['topLastestAds'] = $this->ads_model->fetch($select, "ads_user = $idUser AND ads_status = 1 AND ads_enddate >= $currentDate", "ads_id", "DESC", $start, $limit);
				#END Top lastest ads right
			    switch(strtolower($this->uri->segment(3)))
			    {
					case 'saleoff':
					    #Define url for $getVar
						$action = array('sort', 'by', 'page');
						$getVar = $this->uri->uri_to_assoc(4, $action);
						#BEGIN: Sort
						$where = "pro_saleoff = 1 AND pro_user = $idUser AND pro_status = 1 AND pro_enddate >= $currentDate";
						$sort = 'pro_id';
						$by = 'DESC';
						$pageSort = '';
						$pageUrl = '';
						if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
						{
							switch(strtolower($getVar['sort']))
							{
								case 'name':
								    $pageUrl .= '/sort/name';
								    $sort = "pro_name";
								    break;
				                case 'cost':
								    $pageUrl .= '/sort/cost';
								    $sort = "pro_cost";
								    break;
				                case 'buy':
								    $pageUrl .= '/sort/buy';
								    $sort = "pro_buy";
								    break;
				                case 'view':
								    $pageUrl .= '/sort/view';
								    $sort = "pro_view";
								    break;
				                case 'date':
								    $pageUrl .= '/sort/date';
								    $sort = "pro_begindate";
								    break;
								default:
								    $pageUrl .= '/sort/id';
								    $sort = "pro_id";
							}
							if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
							{
				                $pageUrl .= '/by/desc';
								$by = "DESC";
							}
							else
							{
				                $pageUrl .= '/by/asc';
								$by = "ASC";
							}
						}
						#If have page
						if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
						{
							$start = (int)$getVar['page'];
							$pageSort .= '/page/'.$start;
						}
						else
						{
							$start = 0;
						}
						#END Sort
						#BEGIN: Create link sort
						$data['sortUrl'] = base_url().$linkShop.'/product/saleoff/sort/';
						$data['pageSort'] = $pageSort;
						#END Create link sort
						#BEGIN: Pagination
      					$this->load->library('pagination');
						#Count total record
						$totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
				        $config['base_url'] = base_url().$linkShop.'/product/saleoff'.$pageUrl.'/page/';
						$config['total_rows'] = $totalRecord;
						$config['per_page'] = Setting::settingShoppingSaleoff_List;
						$config['num_links'] = 1;
						$config['uri_segment'] = 4;
						$config['cur_page'] = $start;
						$this->pagination->initialize($config);
						$data['linkPage'] = $this->pagination->create_links();
						#END Pagination
						#Fetch record
						$select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle";
						$limit = Setting::settingShoppingSaleoff_List;
						$data['saleoffProduct'] = $this->product_model->fetch($select, $where, $sort, $by, $start, $limit);
						#Load view
						$this->load->view('shop/product/saleoff', $data);
					    break;
					case 'detail':
					    #Define url for $getVar
						$action = array('detail');
						$getVar = $this->uri->uri_to_assoc(3, $action);
						if($getVar['detail'] != FALSE)
						{
						    #BEGIN: Check exist product by id
							$product = $this->product_model->get("*", "pro_id = ".(int)$getVar['detail']." AND pro_user = $idUser AND pro_status = 1 AND pro_enddate >= $currentDate");
							if(count($product) != 1 || !$this->check->is_id($getVar['detail']))
							{
								redirect(base_url().$linkShop, 'location');
								die();
							}
							#END Check exist product by id
							$this->load->library('bbcode');
							#BEGIN: Update view
							if(!$this->session->userdata('sessionViewProduct_'.(int)$getVar['detail']))
							{
					            $this->product_model->update(array('pro_view' => (int)$product->pro_view + 1), "pro_id = ".(int)$getVar['detail']);
					            $this->session->set_userdata('sessionViewProduct_'.(int)$getVar['detail'], 1);
							}
							#END Update view
							#BEGIN: Get product by id and relate info
							$data['product'] = $product;
							$this->load->model('category_model');
							$data['category'] = $this->category_model->get("cat_id, cat_name, cat_descr, cat_status", "cat_id = ".(int)$product->pro_category);
							#END Get product by id and relate info
							#Load view
							$this->load->view('shop/product/detail', $data);
						}
						else
						{
                            redirect(base_url().$linkShop, 'location');
                            die();
						}
					    break;
					default:
	                    #Define url for $getVar
						$action = array('sort', 'by', 'page');
						$getVar = $this->uri->uri_to_assoc(3, $action);
						#BEGIN: Sort
						$where = "pro_user = $idUser AND pro_status = 1 AND pro_enddate >= $currentDate";
						$sort = 'pro_id';
						$by = 'DESC';
						$pageSort = '';
						$pageUrl = '';
						if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
						{
							switch(strtolower($getVar['sort']))
							{
								case 'name':
								    $pageUrl .= '/sort/name';
								    $sort = "pro_name";
								    break;
				                case 'cost':
								    $pageUrl .= '/sort/cost';
								    $sort = "pro_cost";
								    break;
				                case 'buy':
								    $pageUrl .= '/sort/buy';
								    $sort = "pro_buy";
								    break;
				                case 'view':
								    $pageUrl .= '/sort/view';
								    $sort = "pro_view";
								    break;
				                case 'date':
								    $pageUrl .= '/sort/date';
								    $sort = "pro_begindate";
								    break;
								default:
								    $pageUrl .= '/sort/id';
								    $sort = "pro_id";
							}
							if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
							{
				                $pageUrl .= '/by/desc';
								$by = "DESC";
							}
							else
							{
				                $pageUrl .= '/by/asc';
								$by = "ASC";
							}
						}
						#If have page
						if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
						{
							$start = (int)$getVar['page'];
							$pageSort .= '/page/'.$start;
						}
						else
						{
							$start = 0;
						}
						#END Sort
						#BEGIN: Create link sort
						$data['sortUrl'] = base_url().$linkShop.'/product/sort/';
						$data['pageSort'] = $pageSort;
						#END Create link sort
						#BEGIN: Pagination
						$this->load->library('pagination');
						#Count total record
						$totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
						#BEGIN: Update quantity product
						if(!$this->session->userdata('sessionQuantityProductShopDetail_'.$shop->sho_id))
						{
				            $this->shop_model->update(array('sho_quantity_product' => $totalRecord), "sho_id = ".$shop->sho_id);
				            $this->session->set_userdata('sessionQuantityProductShopDetail_'.$shop->sho_id, 1);
						}
						#END Update quantity product
				        $config['base_url'] = base_url().$linkShop.'/product'.$pageUrl.'/page/';
						$config['total_rows'] = $totalRecord;
						$config['per_page'] = Setting::settingShoppingNew_List;
						$config['num_links'] = 1;
						$config['uri_segment'] = 4;
						$config['cur_page'] = $start;
						$this->pagination->initialize($config);
						$data['linkPage'] = $this->pagination->create_links();
						#END Pagination
						#Fetch record
						$select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle";
						$limit = Setting::settingShoppingNew_List;
						$data['product'] = $this->product_model->fetch($select, $where, $sort, $by, $start, $limit);
						#Load view
						$this->load->view('shop/product/defaults', $data);
			    }
			    break;
			case 'ads':
			    #BEGIN: Menu 3
				$data['menuSelected'] = 'ads';
				#END Menu 3
			    #Module
			    $data['module'] = 'top_lastest_product';
		        #BEGIN: Top lastest product right
				$select = "pro_id, pro_name, pro_descr, pro_image, pro_dir";
				$start = 0;
		  		$limit = (int)Setting::settingShoppingProductNew_Top;
				$data['topLastestProduct'] = $this->product_model->fetch($select, "pro_user = $idUser AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_id", "DESC", $start, $limit);
				#END Top lastest product right
			    switch(strtolower($this->uri->segment(3)))
			    {
					case 'detail':
					    #Define url for $getVar
						$action = array('detail');
						$getVar = $this->uri->uri_to_assoc(3, $action);
						if($getVar['detail'] != FALSE)
						{
						    #BEGIN: Check exist ads by id
							$ads = $this->ads_model->get("*", "ads_id = ".(int)$getVar['detail']." AND ads_user = $idUser AND ads_status = 1 AND ads_enddate >= $currentDate");
							if(count($ads) != 1 || !$this->check->is_id($getVar['detail']))
							{
								redirect(base_url().$linkShop, 'location');
								die();
							}
							#END Check exist ads by id
							$data['successFavoriteAds'] = false;
							$data['isLogined'] = false;
							if($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
							{
					            $data['isLogined'] = true;
					            if($this->session->flashdata('sessionSuccessFavoriteAds'))
					        	{
									$data['successFavoriteAds'] = true;
					        	}
					            #BEGIN: Favorite
					        	if($this->input->post('checkone') && $this->check->is_id($this->input->post('checkone')) && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
					        	{
									$this->load->model('ads_favorite_model');
					    			$adsOne = $this->ads_model->get("ads_user", "ads_id = ".(int)$this->input->post('checkone')." AND ads_user = $idUser");
					    			$adsFavorite = $this->ads_favorite_model->get("adf_id", "adf_ads = ".(int)$this->input->post('checkone')." AND adf_user = ".(int)$this->session->userdata('sessionUser'));
									if(count($adsOne) == 1 && count($adsFavorite) == 0 && $adsOne->ads_user != $this->session->userdata('sessionUser'))
									{
									    $dataAdd = array(
														    'adf_ads'       =>      (int)$this->input->post('checkone'),
														    'adf_user'      =>      (int)$this->session->userdata('sessionUser'),
														    'adf_date'      =>      $currentDate
																);
										if($this->ads_favorite_model->add($dataAdd))
										{
						    				$this->session->set_flashdata('sessionSuccessFavoriteAds', 1);
										}
									}
									unset($adsOne);
									unset($adsFavorite);
									$this->session->set_userdata('sessionTimePosted', time());
									redirect(base_url().trim(uri_string(), '/'), 'location');
					        	}
					        	#END Favorite
							}
							$this->load->library('bbcode');
							#BEGIN: Update view
							if(!$this->session->userdata('sessionViewAds_'.(int)$getVar['detail']))
							{
					            $this->ads_model->update(array('ads_view' => (int)$ads->ads_view + 1), "ads_id = ".(int)$getVar['detail']);
					            $this->session->set_userdata('sessionViewAds_'.(int)$getVar['detail'], 1);
							}
							#END Update view
							#BEGIN: Get ads by id and relate info
							$data['ads'] = $ads;
							$this->load->model('category_model');
							$data['category'] = $this->category_model->get("cat_id, cat_name, cat_descr, cat_status", "cat_id = ".(int)$ads->ads_category);
							#END Get ads by id and relate info
							#Load view
							$this->load->view('shop/ads/detail', $data);
						}
						else
						{
                            redirect(base_url().$linkShop, 'location');
                            die();
						}
					    break;
					default:
						#Define url for $getVar
						$action = array('sort', 'by', 'page');
						$getVar = $this->uri->uri_to_assoc(3, $action);
						#BEGIN: Sort
						$where = "ads_user = $idUser AND ads_status = 1 AND ads_enddate >= $currentDate";
						$sort = 'ads_id';
						$by = 'DESC';
						$pageSort = '';
						$pageUrl = '';
						if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
						{
							switch(strtolower($getVar['sort']))
							{
								case 'title':
								    $pageUrl .= '/sort/title';
								    $sort = "ads_title";
								    break;
				                case 'date':
								    $pageUrl .= '/sort/date';
								    $sort = "ads_begindate";
								    break;
				                case 'place':
								    $pageUrl .= '/sort/place';
								    $sort = "pre_name";
								    break;
				                case 'view':
								    $pageUrl .= '/sort/view';
								    $sort = "ads_view";
								    break;
								default:
								    $pageUrl .= '/sort/id';
								    $sort = "ads_id";
							}
							if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
							{
				                $pageUrl .= '/by/desc';
								$by = "DESC";
							}
							else
							{
				                $pageUrl .= '/by/asc';
								$by = "ASC";
							}
						}
						#If have page
						if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
						{
							$start = (int)$getVar['page'];
							$pageSort .= '/page/'.$start;
						}
						else
						{
							$start = 0;
						}
						#END Sort
						#BEGIN: Create link Sort
						$data['sortUrl'] = base_url().$linkShop.'/ads/sort/';
						$data['pageSort'] = $pageSort;
						#END Create link Sort
						#BEGIN: Pagination
						$this->load->library('pagination');
						#Count total record
						$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, "", ""));
				        $config['base_url'] = base_url().$linkShop.'/ads'.$pageUrl.'/page/';
						$config['total_rows'] = $totalRecord;
						$config['per_page'] = Setting::settingShoppingAdsNew;
						$config['num_links'] = 1;
						$config['uri_segment'] = 4;
						$config['cur_page'] = $start;
						$this->pagination->initialize($config);
						$data['linkPage'] = $this->pagination->create_links();
						#END Pagination
						#Fetch record
						$select = "ads_id, ads_title, ads_descr, ads_view, ads_begindate, pre_name";
						$limit = Setting::settingShoppingAdsNew;
						$data['ads'] = $this->ads_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, $sort, $by, $start, $limit);
						#Load view
						$this->load->view('shop/ads/defaults', $data);
			    }
			    break;
			case 'search':
			    #BEGIN: Add favorite
				$data['successFavoriteProduct'] = false;
				$data['isLogined'] = false;
				if($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
				{
					$data['isLogined'] = true;
					if($this->session->flashdata('sessionSuccessFavoriteProduct'))
					{
						$data['successFavoriteProduct'] = true;
					}
					if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0 && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
					{
						$this->load->model('product_favorite_model');
						$isAdded = false;
						foreach($this->input->post('checkone') as $checkOneArray)
						{
							$productOne = $this->product_model->get("pro_user", "pro_id = ".(int)$checkOneArray." AND pro_user = $idUser");
							$productFavorite = $this->product_favorite_model->get("prf_id", "prf_product = ".(int)$checkOneArray." AND prf_user = ".(int)$this->session->userdata('sessionUser'));
							if(count($productOne) == 1 && count($productFavorite) == 0 && $productOne->pro_user != $this->session->userdata('sessionUser') && $this->check->is_id($checkOneArray))
							{
								$dataAdd = array(
													'prf_product'       =>      (int)$checkOneArray,
													'prf_user'          =>      (int)$this->session->userdata('sessionUser'),
													'prf_date'          =>      $currentDate
													);
								if($this->product_favorite_model->add($dataAdd))
								{
									$isAdded = true;
								}
							}
						}
						unset($productOne);
						unset($productFavorite);
						if($isAdded == true)
						{
							$this->session->set_flashdata('sessionSuccessFavoriteProduct', 1);
						}
						$this->session->set_userdata('sessionTimePosted', time());
						redirect(base_url().trim(uri_string(), '/'), 'location');
					}
				}
				#END Add favorite
				#BEGIN: Menu 2
				$data['menuSelected'] = 'search';
				#END Menu 2
				#Module
				$data['module'] = 'top_lastest_ads';
				#BEGIN: Top lastest ads right
				$select = "ads_id, ads_title, ads_descr";
				$start = 0;
				$limit = (int)Setting::settingShoppingAdsNew_Top;
				$data['topLastestAds'] = $this->ads_model->fetch($select, "ads_user = $idUser AND ads_status = 1 AND ads_enddate >= $currentDate", "ads_id", "DESC", $start, $limit);
				#END Top lastest ads right
				#Define url for $getVar
				$action = array('name', 'sCost', 'eCost', 'currency', 'saleoff', 'place', 'sPostdate', 'ePostdate', 'sort', 'by', 'page');
				$getVar = $this->uri->uri_to_assoc(3, $action);
				#BEGIN: Sort
				$where = "pro_user = $idUser AND pro_status = 1 AND pro_enddate >= $currentDate";
				$sort = 'pro_id';
				$by = 'DESC';
				$sortUrl = '';
				$pageSort = '';
				$pageUrl = '';
				$haveSearch = 0;
				if($getVar['name'] != FALSE && strlen(trim($getVar['name'])) > 2)
				{
		  			$data['nameKeyword'] = $this->filter->html($getVar['name']);
		  			$sortUrl .= '/name/'.$getVar['name'];
			    	$pageUrl .= '/name/'.$getVar['name'];
					$where .= " AND pro_name LIKE '%".$this->filter->injection_html($getVar['name'])."%'";
					$haveSearch++;
				}
				if($getVar['sCost'] != FALSE && (int)$getVar['sCost'] > 0 && $getVar['eCost'] != FALSE && (int)$getVar['eCost'] >= (int)$getVar['sCost'] && $getVar['currency'] != FALSE && (strtoupper($getVar['currency']) == 'VND' || strtoupper($getVar['currency']) == 'USD'))
				{
		  			$data['sCostKeyword'] = (int)$getVar['sCost'];
		  			$data['eCostKeyword'] = (int)$getVar['eCost'];
		  			$data['currencyKeyword'] = $getVar['currency'];
		  			$sortUrl .= '/sCost/'.$getVar['sCost'].'/eCost/'.$getVar['eCost'].'/currency/'.$getVar['currency'];
			    	$pageUrl .= '/sCost/'.$getVar['sCost'].'/eCost/'.$getVar['eCost'].'/currency/'.$getVar['currency'];
			    	if((int)$getVar['sCost'] == (int)$getVar['eCost'])
			    	{
		                $where .= " AND pro_cost = ".(int)$getVar['sCost'];
			    	}
					else
					{
		                $where .= " AND pro_cost >= ".(int)$getVar['sCost']." AND pro_cost <= ".(int)$getVar['eCost'];
					}
					$where .= " AND pro_currency = '".$this->filter->injection_html(strtoupper($getVar['currency']))."'";
					$haveSearch++;
				}
				if($getVar['saleoff'] != FALSE && (int)$getVar['saleoff'] == 1)
				{
		  			$data['saleoffKeyword'] = $getVar['saleoff'];
		  			$sortUrl .= '/saleoff/'.$getVar['saleoff'];
			    	$pageUrl .= '/saleoff/'.$getVar['saleoff'];
					$where .= " AND pro_saleoff = 1";
					$haveSearch++;
				}
				if($getVar['place'] != FALSE && (int)$getVar['place'] > 0)
				{
		  			$data['placeKeyword'] = $getVar['place'];
		  			$sortUrl .= '/place/'.$getVar['place'];
			    	$pageUrl .= '/place/'.$getVar['place'];
					$where .= " AND pro_province = ".(int)$getVar['place'];
					$haveSearch++;
				}
				if($getVar['sPostdate'] != FALSE && (int)$getVar['sPostdate'] > (int)mktime(0, 0, 0, 1, 1, 2008) && $getVar['ePostdate'] != FALSE && (int)$getVar['ePostdate'] >= (int)$getVar['sPostdate'])
				{
		  			$data['sDayKeyword'] = date('d', $getVar['sPostdate']);
		  			$data['sMonthKeyword'] = date('m', $getVar['sPostdate']);
		  			$data['sYearKeyword'] = date('Y', $getVar['sPostdate']);
		  			$data['eDayKeyword'] = date('d', $getVar['ePostdate']);
		  			$data['eMonthKeyword'] = date('m', $getVar['ePostdate']);
		  			$data['eYearKeyword'] = date('Y', $getVar['ePostdate']);
		  			$sortUrl .= '/sPostdate/'.$getVar['sPostdate'].'/ePostdate/'.$getVar['ePostdate'];
			    	$pageUrl .= '/sPostdate/'.$getVar['sPostdate'].'/ePostdate/'.$getVar['ePostdate'];
			    	if((int)$getVar['sPostdate'] == (int)$getVar['ePostdate'])
			    	{
		                $where .= " AND pro_begindate = ".(int)$getVar['sPostdate'];
			    	}
					else
					{
		                $where .= " AND pro_begindate >= ".(int)$getVar['sPostdate']." AND pro_begindate <= ".(int)$getVar['ePostdate'];
					}
					$haveSearch++;
				}
				if($haveSearch > 0)
				{
					if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
					{
						switch(strtolower($getVar['sort']))
						{
							case 'nameSort':
							    $pageUrl .= '/sort/nameSort';
							    $sort = "pro_name";
							    break;
			                case 'cost':
							    $pageUrl .= '/sort/cost';
							    $sort = "pro_cost";
							    break;
			                case 'buy':
							    $pageUrl .= '/sort/buy';
							    $sort = "pro_buy";
							    break;
			                case 'view':
							    $pageUrl .= '/sort/view';
							    $sort = "pro_view";
							    break;
			                case 'date':
							    $pageUrl .= '/sort/date';
							    $sort = "pro_begindate";
							    break;
							default:
							    $pageUrl .= '/sort/id';
							    $sort = "pro_id";
						}
						if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
						{
			                $pageUrl .= '/by/desc';
							$by = "DESC";
						}
						else
						{
			                $pageUrl .= '/by/asc';
							$by = "ASC";
						}
					}
					#If have page
					if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
					{
						$start = (int)$getVar['page'];
						$pageSort .= '/page/'.$start;
					}
					else
					{
						$start = 0;
					}
					#END Sort
					#BEGIN: Create link sort
					$data['sortUrl'] = base_url().$linkShop.'/search'.$sortUrl.'/sort/';
					$data['pageSort'] = $pageSort;
					#END Create link sort
					#BEGIN: Pagination
					$this->load->library('pagination');
					#Count total record
					$totalRecord = count($this->product_model->fetch("pro_id", $where, "", "", 0, (int)Setting::settingShoppingSearch*50));
			        $config['base_url'] = base_url().$linkShop.'/search'.$pageUrl.'/page/';
					$config['total_rows'] = $totalRecord;
					$config['per_page'] = Setting::settingShoppingSearch;
					$config['num_links'] = 1;
					$config['uri_segment'] = 5;
					$config['cur_page'] = $start;
					$this->pagination->initialize($config);
					$data['linkPage'] = $this->pagination->create_links();
					#END Pagination
					$data['totalResult'] = $totalRecord;
					#Fetch record
					$select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle";
					$limit = Setting::settingShoppingSearch;
					$data['searchProduct'] = $this->product_model->fetch($select, $where, $sort, $by, $start, $limit);
				}
				#Load view
				$this->load->view('shop/search/defaults', $data);
			    break;
            case 'contact':
			    #BEGIN: Menu 3
				$data['menuSelected'] = 'contact';
				#END Menu 3
				#Module
			    $data['module'] = 'top_lastest_product';
		        #BEGIN: Top lastest product right
				$select = "pro_id, pro_name, pro_descr, pro_image, pro_dir";
				$start = 0;
		  		$limit = (int)Setting::settingShoppingProductNew_Top;
				$data['topLastestProduct'] = $this->product_model->fetch($select, "pro_user = $idUser AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_id", "DESC", $start, $limit);
				#END Top lastest product right
				#BEGIN: Unlink captcha
				$this->load->helper('unlink');
                unlink_captcha($this->session->flashdata('sessionPathCaptchaContactShopDetail'));
			    #END Unlink captcha
				if($this->session->flashdata('sessionSuccessContactShopDetail'))
				{
					$data['successContactShopDetail'] = true;
				}
				else
				{
	            	$this->load->library('form_validation');
	                $data['successContactShopDetail'] = false;
					if($this->input->post('captcha_contact') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
					{
						#BEGIN: Set rules
						$this->form_validation->set_rules('name_contact', 'lang:name_contact_label_detail_contact', 'trim|required');
						$this->form_validation->set_rules('email_contact', 'lang:email_contact_label_detail_contact', 'trim|required|valid_email');
						$this->form_validation->set_rules('address_contact', 'lang:address_contact_label_detail_contact', 'trim|required');
						$this->form_validation->set_rules('phone_contact', 'lang:phone_contact_label_detail_contact', 'trim|required');
			            $this->form_validation->set_rules('title_contact', 'lang:title_contact_label_detail_contact', 'trim|required');
			            $this->form_validation->set_rules('content_contact', 'lang:content_contact_label_detail_contact', 'trim|required|min_length[10]|max_length[1000]');
			            $this->form_validation->set_rules('captcha_contact', 'lang:captcha_contact_label_detail_contact', 'required|callback__valid_captcha_contact');
						#END Set rules
						#BEGIN: Set message
						$this->form_validation->set_message('required', $this->lang->line('required_message'));
						$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
						$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
						$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
						$this->form_validation->set_message('_valid_captcha_contact', $this->lang->line('_valid_captcha_contact_message_detail_contact'));
						$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
						#END Set message
						if($this->form_validation->run() != FALSE)
						{
                            $this->load->library('email');
                            $config['useragent'] = $this->lang->line('useragen_mail_detail_contact');
							$config['mailtype'] = 'html';
							$this->email->initialize($config);
							$messageContact = $this->lang->line('info_title_sender_detail_contact').$this->lang->line('fullname_sender_detail_contact').$this->input->post('name_contact').'<br>'.$this->lang->line('address_sender_detail_contact').$this->input->post('address_contact').'<br>'.$this->lang->line('phone_sender_detail_contact').$this->input->post('phone_contact').'<br>'.$this->lang->line('content_sender_detail_contact').nl2br($this->filter->html($this->input->post('content_contact')));
							$this->email->from($this->input->post('email_contact'));
							if(trim($shop->sho_email) != '')
							{
                                $emailContact = $shop->sho_email;
							}
							else
							{
                                $emailContact = Setting::settingEmail_1;
							}
							$this->email->to($emailContact);
							$this->email->subject($this->input->post('title_contact'));
							$this->email->message($messageContact);
							if($this->email->send())
							{
								$this->session->set_flashdata('sessionSuccessContactShopDetail', 1);
							}
							$this->session->set_userdata('sessionTimePosted', time());
							redirect(base_url().trim(uri_string(), '/'), 'location');
						}
						else
						{
		                    $data['name_contact'] = $this->input->post('name_contact');
							$data['email_contact'] = $this->input->post('email_contact');
							$data['address_contact'] = $this->input->post('address_contact');
							$data['phone_contact'] = $this->input->post('phone_contact');
							$data['title_contact'] = $this->input->post('title_contact');
							$data['content_contact'] = $this->input->post('content_contact');
						}
					}
                    #BEGIN: Create captcha
                    $this->load->library('captcha');
		        	$codeCaptcha = $this->captcha->code(6);
		        	$this->session->set_flashdata('sessionCaptchaContactShopDetail', $codeCaptcha);
		        	$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.rand(10, 10000).'cons.jpg';
		        	$this->session->set_flashdata('sessionPathCaptchaContactShopDetail', $imageCaptcha);
					$this->captcha->create($codeCaptcha, $imageCaptcha);
					if(file_exists($imageCaptcha))
					{
						$data['imageCaptchaContactShopDetail'] = $imageCaptcha;
					}
					#END Create captcha
				}
				#Load view
				$this->load->view('shop/contact/defaults', $data);
			    break;
			default:
			    $this->load->library('hash');
			    #Module
		        $data['module'] = 'top_lastest_ads';
		        #BEGIN: Top lastest ads right
				$select = "ads_id, ads_title, ads_descr";
				$start = 0;
		  		$limit = (int)Setting::settingShoppingAdsNew_Top;
				$data['topLastestAds'] = $this->ads_model->fetch($select, "ads_user = $idUser AND ads_status = 1 AND ads_enddate >= $currentDate", "ads_id", "DESC", $start, $limit);
				#END Top lastest ads right
				#Load view
				$this->load->view('shop/defaults/defaults', $data);
		}
	}
	
	function ajax()
	{
        $this->load->library('hash');
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Get shop by $linkShop
		$shop = $this->shop_model->get("sho_user", "sho_link = '".$this->filter->injection($this->input->post('link'))."' AND sho_status = 1 AND sho_enddate >= $currentDate");
		#END Get shop by $linkShop
        if($this->input->post('token') && $this->input->user_agent() != FALSE && $this->input->post('token') == $this->hash->create($this->input->post('link'), $this->input->user_agent(), 'sha256md5') && $this->input->post('type') && count($shop) == 1 && strlen(trim($this->input->post('link'))) >= 5 && strlen(trim($this->input->post('link'))) <= 50)
        {
            $this->load->model('product_model');
            $idUser = (int)$shop->sho_user;
            $where = "pro_image != 'none.gif' AND pro_cost > 0 AND pro_user = $idUser AND pro_status = 1 AND pro_enddate >= $currentDate";
            $sort = "rand()";
            $by = "DESC";
            $limit = (int)Setting::settingShoppingInterest_Home;
			switch((int)$this->input->post('type'))
			{
				case 1:
					$sort = "pro_view";
					break;
              	case 2:
					$sort = "pro_id";
					$limit = (int)Setting::settingShoppingNew_Home;
					break;
             	case 3:
					$where .= " AND pro_saleoff = 1";
					$limit = (int)Setting::settingShoppingSaleoff_Home;
					break;
			}
			$select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir";
			$start = 0;
			$product = $this->product_model->fetch($select, $where, $sort, $by, $start, $limit);
			echo "[".json_encode($product).",".count($product)."]";
		}
		else
		{
			show_404();
			die();
		}
	}
	
	function _valid_captcha_contact($str)
	{
        if($this->session->flashdata('sessionCaptchaContactShopDetail') && $this->session->flashdata('sessionCaptchaContactShopDetail') === $str)
		{
			return true;
		}
		return false;
	}
}