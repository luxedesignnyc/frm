<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Showcart extends Controller
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
		$this->lang->load('home/showcart');
		#Load model
		$this->load->model('showcart_model');
		$this->load->model('product_model');
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
		#BEGIN: Delete & add
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
			$listProductShowcart = explode(',', trim($this->session->userdata('sessionProductShowcart'), ','));
			$productShowcartOne = $this->input->post('checkone');
			$newProductShowcart = array();
			foreach($listProductShowcart as $listProductShowcartArray)
			{
				$isDelete = false;
				for($i = 0; $i < count($productShowcartOne); $i++)
				{
					if($listProductShowcartArray == $productShowcartOne[$i])
					{
                        $isDelete = true;
                        break;
					}
				}
				if($isDelete == false)
				{
                    $newProductShowcart[] = $listProductShowcartArray;
				}
			}
			$this->session->set_userdata('sessionProductShowcart', implode(',', $newProductShowcart));
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		elseif($this->input->post('QuantityShowcart') && is_array($this->input->post('QuantityShowcart')) && count($this->input->post('QuantityShowcart')) > 0 && $this->input->post('IdProductShowcart') && is_array($this->input->post('IdProductShowcart')) && count($this->input->post('IdProductShowcart')) == count($this->input->post('QuantityShowcart')) && count($this->input->post('IdProductShowcart')) <= Setting::settingOtherShowcart && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
		{
            #BEGIN: CHECK LOGIN
			if(!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
			{
				redirect(base_url().'login', 'location');
				die();
			}
			#END CHECK LOGIN
			$idProductShowcart = $this->input->post('IdProductShowcart');
			$quantityShowcart = $this->input->post('QuantityShowcart');
			$numberNewProductAddedShowcart = 0;
			$numberUpdateProductAddedShowcart = 0;
			for($i = 0; $i < count($idProductShowcart); $i++)
			{
				$productAddCart = $this->product_model->get("pro_user, pro_buy", "pro_id = ".(int)$idProductShowcart[$i]." AND pro_user != ".(int)$this->session->userdata('sessionUser')." AND pro_status = 1 AND pro_enddate >= $currentDate");
				if(count($productAddCart) == 1 && (int)$quantityShowcart[$i] > 0 && $this->check->is_id($idProductShowcart[$i]))
				{
					$productInCart = $this->showcart_model->get("shc_id, shc_quantity", "shc_product = ".(int)$idProductShowcart[$i]." AND shc_buyer = ".(int)$this->session->userdata('sessionUser')." AND shc_buydate = $currentDate");
					if(count($productInCart) == 1)
					{
						if($this->showcart_model->update(array('shc_quantity'=>(int)$productInCart->shc_quantity + (int)$quantityShowcart[$i]), "shc_id = ".$productInCart->shc_id))
						{
							#Update pro_buy
							$this->product_model->update(array('pro_buy'=>$productAddCart->pro_buy + 1), "pro_id = ".(int)$idProductShowcart[$i]);
                            $numberUpdateProductAddedShowcart++;
						}
					}
					else
					{
						$dataAdd = array(
						                    'shc_product'       =>      (int)$idProductShowcart[$i],
						                    'shc_quantity'      =>      (int)$quantityShowcart[$i],
						                    'shc_saler'         =>      (int)$productAddCart->pro_user,
						                    'shc_buyer'         =>      (int)$this->session->userdata('sessionUser'),
						                    'shc_buydate'       =>      $currentDate,
						                    'shc_process'       =>      0,
						                    'shc_status'        =>      1
											);
						if($this->showcart_model->add($dataAdd))
						{
                            #Update pro_buy
                            $this->product_model->update(array('pro_buy'=>$productAddCart->pro_buy + 1), "pro_id = ".(int)$idProductShowcart[$i]);
							$numberNewProductAddedShowcart++;
						}
					}
				}
			}
			if($numberNewProductAddedShowcart > 0 || $numberUpdateProductAddedShowcart > 0)
			{
                $this->session->unset_userdata('sessionProductShowcart');
				$this->session->set_flashdata('sessionSuccessAddShowcart', $numberNewProductAddedShowcart.$this->lang->line('success_add_product_showcart_defaults').'\n'.$numberUpdateProductAddedShowcart.$this->lang->line('success_update_product_showcart_defaults'));
			}
			$this->session->set_userdata('sessionTimePosted', time());
			redirect(base_url().'account/showcart', 'location');
		}
		#END Delete & add
		#BEGIN: Add in showcart
		$data['fullProductShowcart'] = false;
		if($this->session->flashdata('sessionFullProductShowcart'))
		{
            $data['fullProductShowcart'] = true;
		}
		if($this->input->post('product_showcart') && $this->check->is_id($this->input->post('product_showcart')))
		{
			if(!$this->_is_exist_product_showcart((int)$this->input->post('product_showcart')))
			{
				if(count(explode(',', trim($this->session->userdata('sessionProductShowcart'), ','))) < Setting::settingOtherShowcart)
				{
					$product = $this->product_model->get("pro_id", "pro_id = ".(int)$this->input->post('product_showcart')." AND pro_status = 1 AND pro_enddate >= $currentDate");
					if(count($product) == 1)
					{
						if(!$this->session->userdata('sessionProductShowcart') || trim(trim($this->session->userdata('sessionProductShowcart'), ',')) == '')
						{
		                    $this->session->set_userdata('sessionProductShowcart', (int)$this->input->post('product_showcart'));
						}
						else
						{
		                    $this->session->set_userdata('sessionProductShowcart', $this->session->userdata('sessionProductShowcart').','.(int)$this->input->post('product_showcart'));
						}
					}
				}
				else
				{
					$this->session->set_flashdata('sessionFullProductShowcart', 1);
				}
			}
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Add in showcart
		$data['isLogined'] = false;
        if($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
		{
			$data['isLogined'] = true;
		}
		#BEGIN: Menu
		$data['menuSelected'] = 0;
		$data['menuType'] = 'product';
		$data['menu'] = $this->menu_model->fetch("men_name, men_descr, men_image, men_category", "men_status = 1", "men_order", "ASC");
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'showcart';
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
        #Define url for $getVar
		$action = array('sort', 'by');
		$getVar = $this->uri->uri_to_assoc(2, $action);
		#BEGIN: Sort
		if($this->session->userdata('sessionProductShowcart') && trim(trim($this->session->userdata('sessionProductShowcart'), ',')) != '')
		{
			$idProduct = trim($this->session->userdata('sessionProductShowcart'), ',');
			$where = "pro_id IN($idProduct) AND pro_status = 1 AND pro_enddate >= $currentDate";
			$sort = '';
			$by = '';
			if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
			{
				switch(strtolower($getVar['sort']))
				{
					case 'name':
					    $sort .= "pro_name";
					    break;
	                case 'cost':
					    $sort .= "pro_cost";
					    break;
					default:
					    $sort .= "pro_id";
				}
				if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
				{
					$by .= "DESC";
				}
				else
				{
					$by .= "ASC";
				}
			}
			#END Sort
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'showcart/sort/';
			#END Create link sort
			#Fetch record
			$select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir";
			$start = 0;
			$limit = Setting::settingOtherShowcart;
			$data['productShowcart'] = $this->product_model->fetch($select, $where, $sort, $by, $start, $limit);
		}
		#Load view
		$this->load->view('home/showcart/defaults', $data);
	}
	
	function _is_exist_product_showcart($product)
	{
		$productShowcart = explode(',', $this->session->userdata('sessionProductShowcart'));
		foreach($productShowcart as $productShowcartArray)
		{
			if($productShowcartArray == $product)
			{
				return true;
			}
		}
		return false;
	}
}