<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Defaults extends Controller
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
		#Load library
		$this->load->library('hash');
		#Load language
		$this->lang->load('home/common');
		$this->lang->load('home/defaults');
		#Load model
		$this->load->model('category_model');
		$this->load->model('product_model');
		$this->load->model('ads_model');
		$this->load->model('job_model');
		$this->load->model('shop_model');
		#BEGIN: Update counter
		if(!$this->session->userdata('sessionUpdateCounter'))
		{
			$this->counter_model->update();
			$this->session->set_userdata('sessionUpdateCounter', 1);
		}
		#END Update counter
		#BEGIN: Ads & Notify Taskbar
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
		$data['menuType'] = 'product';
		$data['menu'] = $this->menu_model->fetch("men_name, men_descr, men_image, men_category", "men_status = 1", "men_order", "ASC");
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'home';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Module
        $data['module'] = 'top_saleoff_product,top_buyest_product';
		#BEGIN: Top product saleoff right
		$select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate";
		$start = 0;
  		$limit = (int)Setting::settingProductSaleoff_Top;
		$data['topSaleoffProduct'] = $this->product_model->fetch($select, "pro_saleoff = 1 AND pro_status = 1 AND pro_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top product saleoff right
		#BEGIN: Top product buyest right
		$select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
		$start = 0;
  		$limit = (int)Setting::settingProductBuyest_Top;
		$data['topBuyestProduct'] = $this->product_model->fetch($select, "pro_status = 1 AND pro_enddate >= $currentDate", "pro_buy", "DESC", $start, $limit);
		#END Top product buyest right
		#BEGIN: Tab product category (4 tab)
		if((int)date('j') > 10)
		{
			$tabStart = 0;
		}
		else
		{
            $tabStart = (int)date('j') - 1;
		}
		$tabProductCategory = $this->category_model->fetch("cat_id, cat_name", "cat_status = 1", "cat_id", "ASC", $tabStart, 4);
		$tabIs = 1;
		foreach($tabProductCategory as $tabProductCategoryArray)
		{
			$data['tabIDCategoryProduct_'.$tabIs] = $tabProductCategoryArray->cat_id;
			$data['tabNameCategoryProduct_'.$tabIs] = $tabProductCategoryArray->cat_name;
			$tabIs++;
		}
		#END Tab product category (4 tab)
		#BEGIN: Favorite product
  		$select = "pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_vote, pro_vote_total";
  		$start = 0;
  		$limit = 8;
  		$data['favoriteProduct'] = $this->product_model->fetch($select, "pro_image != 'none.gif' AND pro_cost > 0 AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_vote", "DESC", $start, $limit);
		#END Favorite product
		#Load view
		$this->load->view('home/defaults/defaults', $data);
	}
	
	function ajax()
	{
        if($this->input->post('token') && $this->input->user_agent() != FALSE && $this->input->post('token') == $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5') && $this->input->post('object'))
        {
			if($this->input->post('type') && (int)$this->input->post('object') == 1)
			{
				$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
			    $categoryProduct = (int)$this->input->post('type');
			    $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_category";
			    $start = 0;
			    $limit = (int)Setting::settingProductNew_Home;
			    $product = $this->product_model->fetch($select, "pro_image != 'none.gif' AND pro_cost > 0 AND pro_category = $categoryProduct AND pro_status = 1 AND pro_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
			    echo "[".json_encode($product).",".count($product)."]";
			}
			elseif((int)$this->input->post('object') == 2)
			{
                $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
			    $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_category";
			    $start = 0;
			    $limit = (int)Setting::settingProductReliable_Home;
			    $product = $this->product_model->fetch($select, "pro_image != 'none.gif' AND pro_cost > 0 AND pro_reliable = 1 AND pro_status = 1 AND pro_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
			    echo "[".json_encode($product).",".count($product)."]";
			}
			elseif((int)$this->input->post('object') == 3)
			{
                $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
			    $select = "sho_descr, sho_logo, sho_dir_logo, sho_link";
			    $start = 0;
			    $limit = (int)Setting::settingShopInterest;
			    $shop = $this->shop_model->fetch($select, "sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
			    echo "[".json_encode($shop).",".count($shop)."]";
			}
			elseif($this->input->post('type') && (int)$this->input->post('object') == 4)
			{
                $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
				$where = "ads_status = 1 AND ads_enddate >= $currentDate";
				$sort = "ads_id";
				$by = "DESC";
				switch((int)$this->input->post('type'))
				{
					case 1:
					    $sort = "ads_view";
					    break;
                    case 2:
					    break;
					default:
					    $where .= " AND ads_reliable = 1";
					    $sort = "rand()";
				}
			    $select = "ads_id, ads_category, ads_title, ads_descr, pre_name";
			    $start = 0;
			    $limit = (int)Setting::settingAdsNew_Home;
			    $ads = $this->ads_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, $sort, $by, $start, $limit);
			    echo "[".json_encode($ads).",".count($ads)."]";
			}
			elseif((int)$this->input->post('object') == 5)
			{
                $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
				$where = "job_status = 1 AND job_enddate >= $currentDate";
				$sort = "rand()";
				$by = "DESC";
			    $select = "job_id, job_title, job_field, job_jober";
			    $start = 0;
			    $limit = (int)Setting::settingAdsNew_Home;
			    $job = $this->job_model->fetch($select, $where, $sort, $by, $start, $limit);
			    echo "[".json_encode($job).",".count($job)."]";
			}
		}
		else
		{
			show_404();
			die();
		}
	}
}