<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Product extends Controller
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
		$this->lang->load('home/product');
		#Load model
		$this->load->model('product_model');
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
	
	function category($categoryID)
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
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
                    $productOne = $this->product_model->get("pro_user", "pro_id = ".(int)$checkOneArray);
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
		$data['menuType'] = 'product';
		$data['menu'] = $this->menu_model->fetch("men_name, men_descr, men_image, men_category", "men_status = 1", "men_order", "ASC");
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'product_sub';
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
		#BEGIN: Reliable product
		$select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_category";
		$start = 0;
  		$limit = (int)Setting::settingProductReliable_Category;
		$data['reliableProduct'] = $this->product_model->fetch($select, "pro_image != 'none.gif' AND pro_cost > 0 AND pro_category = $categoryIDQuery AND pro_reliable = 1 AND pro_status = 1 AND pro_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Reliable product
		#BEGIN: Favorite product
  		$select = "pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_vote, pro_vote_total";
  		$start = 0;
  		$limit = 8;
  		$data['favoriteProduct'] = $this->product_model->fetch($select, "pro_image != 'none.gif' AND pro_cost > 0 AND pro_category = $categoryIDQuery AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_vote", "DESC", $start, $limit);
		#END Favorite product
        #Define url for $getVar
		$action = array('sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Sort
		$where = "pro_category = $categoryIDQuery AND pro_status = 1 AND pro_enddate >= $currentDate";
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
		$data['sortUrl'] = base_url().'product/category/'.$categoryID.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
        $config['base_url'] = base_url().'product/category/'.$categoryID.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingProductNew_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle";
		$limit = Setting::settingProductNew_Category;
		$data['newProduct'] = $this->product_model->fetch($select, $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('home/product/category', $data);
	}
	
	function saleoff()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
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
                    $productOne = $this->product_model->get("pro_user", "pro_id = ".(int)$checkOneArray);
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
		#BEGIN: Menu
		$data['menuSelected'] = 0;
		$data['menuType'] = 'product';
		$data['menu'] = $this->menu_model->fetch("men_name, men_descr, men_image, men_category", "men_status = 1", "men_order", "ASC");
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'product_sub';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Module
        $data['module'] = 'top_lastest_product,top_buyest_product';
        #BEGIN: Top product lastest right
		$select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir";
		$start = 0;
  		$limit = (int)Setting::settingProductNew_Top;
		$data['topLastestProduct'] = $this->product_model->fetch($select, "pro_status = 1 AND pro_enddate >= $currentDate", "pro_id", "DESC", $start, $limit);
		#END Top product lastest right
        #BEGIN: Top product buyest right
		$select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
		$start = 0;
  		$limit = (int)Setting::settingProductBuyest_Top;
		$data['topBuyestProduct'] = $this->product_model->fetch($select, "pro_status = 1 AND pro_enddate >= $currentDate", "pro_buy", "DESC", $start, $limit);
		#END Top product buyest right
        #Define url for $getVar
		$action = array('sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Sort
		$where = "pro_saleoff = 1 AND pro_status = 1 AND pro_enddate >= $currentDate";
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
		$data['sortUrl'] = base_url().'product/saleoff/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
        $config['base_url'] = base_url().'product/saleoff'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingProductSaleoff;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle";
		$limit = Setting::settingProductSaleoff;
		$data['saleoffProduct'] = $this->product_model->fetch($select, $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('home/product/saleoff', $data);
	}
	
	function detail($categoryID, $productID)
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
		#BEGIN: Check exist product by $productID
		$product = $this->product_model->get("*", "pro_id = ".(int)$productID." AND pro_category = $categoryIDQuery AND pro_status = 1 AND pro_enddate >= $currentDate");
		if(count($product) != 1 || !$this->check->is_id($productID))
		{
			redirect(base_url(), 'location');
			die();
		}
		#END Check exist product by $productID
		$productIDQuery = (int)$productID;
		#BEGIN: Update view
		if(!$this->session->userdata('sessionViewProduct_'.$productIDQuery))
		{
            $this->product_model->update(array('pro_view' => (int)$product->pro_view + 1), "pro_id = ".$productIDQuery);
            $this->session->set_userdata('sessionViewProduct_'.$productIDQuery, 1);
		}
		#END Update view
		$this->load->library('bbcode');
		$this->load->library('captcha');
		$this->load->library('form_validation');
        $this->load->helper('unlink');
		#BEGIN: Vote & send friend & send fail
		$data['successVote'] = false;
		$data['successSendFriendProduct'] = false;
        $data['successSendFailProduct'] = false;
		if($this->session->flashdata('sessionSuccessVote'))
		{
			$data['successVote'] = true;
		}
		elseif($this->session->flashdata('sessionSuccessSendFriendProduct'))
 		{
  			$data['successSendFriendProduct'] = true;
 		}
 		elseif($this->session->flashdata('sessionSuccessSendFailProduct'))
 		{
  			$data['successSendFailProduct'] = true;
 		}
		#BEGIN: Vote
		if($this->input->post('cost') && $this->input->post('quanlity') && $this->input->post('model') && $this->input->post('service') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost && time() - (int)$this->session->userdata('sessionTimeVote_'.$productIDQuery) > (int)Setting::settingTimePost*20)
		{
			$dataVote = array(
			                    'pro_vote_cost'     =>      (int)$product->pro_vote_cost + (int)$this->input->post('cost'),
			                    'pro_vote_quanlity' =>      (int)$product->pro_vote_quanlity + (int)$this->input->post('quanlity'),
			                    'pro_vote_model'    =>      (int)$product->pro_vote_model + (int)$this->input->post('model'),
			                    'pro_vote_service'  =>      (int)$product->pro_vote_service + (int)$this->input->post('service'),
			                    'pro_vote_total'    =>		round(((int)$product->pro_vote_cost + (int)$this->input->post('cost') + (int)$product->pro_vote_quanlity + (int)$this->input->post('quanlity') + (int)$product->pro_vote_model + (int)$this->input->post('model') + (int)$product->pro_vote_service + (int)$this->input->post('service'))/(4*((int)$product->pro_vote + 1))),
			                    'pro_vote'          =>      (int)$product->pro_vote + 1
								);
			if($this->product_model->update($dataVote, "pro_id = ".$productIDQuery))
			{
				$this->session->set_flashdata('sessionSuccessVote', 1);
				$this->session->set_userdata('sessionTimeVote_'.$productIDQuery, time());
			}
			$this->session->set_userdata('sessionTimePosted', time());
            redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Vote
		#BEGIN: Send link for friend
		elseif($this->input->post('captcha_sendlink') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
		{
			#BEGIN: Set rules
			$this->form_validation->set_rules('sender_sendlink', 'lang:sender_sendlink_label_detail', 'trim|required|valid_email');
			$this->form_validation->set_rules('receiver_sendlink', 'lang:receiver_sendlink_label_detail', 'trim|required|valid_email');
			$this->form_validation->set_rules('title_sendlink', 'lang:title_sendlink_label_detail', 'trim|required');
			$this->form_validation->set_rules('content_sendlink', 'lang:content_sendlink_label_detail', 'trim|required|min_length[10]|max_length[400]');
			$this->form_validation->set_rules('captcha_sendlink', 'lang:captcha_sendlink_label_detail', 'required|callback__valid_captcha_send_friend');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
			$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
			$this->form_validation->set_message('_valid_captcha_send_friend', $this->lang->line('_valid_captcha_send_friend_message_detail'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				$this->load->library('email');
				$config['useragent'] = $this->lang->line('useragen_mail_detail');
				$config['mailtype'] = 'html';
				$this->email->initialize($config);
				$this->email->from($this->input->post('sender_sendlink'));
				$this->email->to($this->input->post('receiver_sendlink'));
				$this->email->subject($this->input->post('title_sendlink'));
				$this->email->message($this->lang->line('content_default_send_friend_detail').base_url().trim(uri_string(), '/').'">'.base_url().trim(uri_string(), '/').'</a> '.$this->lang->line('next_content_default_send_friend_detail').$this->filter->html($this->input->post('content_sendlink')));
				if($this->email->send())
				{
					$this->session->set_flashdata('sessionSuccessSendFriendProduct', 1);
				}
				$this->session->set_userdata('sessionTimePosted', time());
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			else
			{
				$data['sender_sendlink'] = $this->input->post('sender_sendlink');
				$data['receiver_sendlink'] = $this->input->post('receiver_sendlink');
				$data['title_sendlink'] = $this->input->post('title_sendlink');
				$data['content_sendlink'] = $this->input->post('content_sendlink');
				$data['isSendFriend'] = true;
			}
		}
		#END Send link for friend
		#BEGIN: Send link fail product
		elseif($this->input->post('captcha_sendfail') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost && !$this->session->userdata('sessionSendFailedProduct_'.$productIDQuery))
		{
			#BEGIN: Set rules
			$this->form_validation->set_rules('sender_sendfail', 'lang:sender_sendfail_label_detail', 'trim|required|valid_email');
			$this->form_validation->set_rules('title_sendfail', 'lang:title_sendfail_label_detail', 'trim|required');
			$this->form_validation->set_rules('content_sendfail', 'lang:content_sendfail_label_detail', 'trim|required|min_length[10]|max_length[400]');
			$this->form_validation->set_rules('captcha_sendfail', 'lang:captcha_sendfail_label_detail', 'required|callback__valid_captcha_send_fail');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
			$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
			$this->form_validation->set_message('_valid_captcha_send_fail', $this->lang->line('_valid_captcha_send_fail_message_detail'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				$this->load->model('product_bad_model');
				$dataFailAdd = array(
										'prb_title'     =>      trim($this->filter->injection_html($this->input->post('title_sendfail'))),
										'prb_detail'    =>      trim($this->filter->injection_html($this->input->post('content_sendfail'))),
										'prb_email'     =>      trim($this->filter->injection_html($this->input->post('sender_sendfail'))),
										'prb_product'   =>      (int)$product->pro_id,
										'prb_date'      =>      $currentDate
										);
				if($this->product_bad_model->add($dataFailAdd))
				{
					$this->session->set_flashdata('sessionSuccessSendFailProduct', 1);
					$this->session->set_userdata('sessionSendFailedProduct_'.$productIDQuery, 1);
				}
				$this->session->set_userdata('sessionTimePosted', time());
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			else
			{
				$data['sender_sendfail'] = $this->input->post('sender_sendfail');
				$data['title_sendfail'] = $this->input->post('title_sendfail');
				$data['content_sendfail'] = $this->input->post('content_sendfail');
				$data['isSendFail'] = true;
			}
		}
		#END Send link fail product
        #BEGIN: Create captcha send friend
        unlink_captcha($this->session->flashdata('sessionPathCaptchaSendFriendProduct'));
		$codeCaptcha = $this->captcha->code(6);
		$this->session->set_flashdata('sessionCaptchaSendFriendProduct', $codeCaptcha);
		$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.rand(1, 10000).'f.jpg';
		$this->session->set_flashdata('sessionPathCaptchaSendFriendProduct', $imageCaptcha);
		$this->captcha->create($codeCaptcha, $imageCaptcha);
		if(file_exists($imageCaptcha))
		{
			$data['imageCaptchaSendFriendProduct'] = $imageCaptcha;
		}
		#END Create captcha send friend
		#BEGIN: Create captcha send fail
        unlink_captcha($this->session->flashdata('sessionPathCaptchaSendFailProduct'));
		$data['isSendedOneFail'] = false;
		if($this->session->userdata('sessionSendFailedProduct_'.$productIDQuery))
		{
			$data['isSendedOneFail'] = true;
		}
		else
		{
			$codeCaptcha = $this->captcha->code(6);
			$this->session->set_flashdata('sessionCaptchaSendFailProduct', $codeCaptcha);
			$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.rand(10000, 100000).'b.jpg';
			$this->session->set_flashdata('sessionPathCaptchaSendFailProduct', $imageCaptcha);
			$this->captcha->create($codeCaptcha, $imageCaptcha);
			if(file_exists($imageCaptcha))
			{
				$data['imageCaptchaSendFailProduct'] = $imageCaptcha;
			}
		}
		#END Create captcha send fail
		#END Vote & send friend & send fail
		$this->load->model('product_comment_model');
		#BEGIN: Add favorite and submit forms
        $data['successFavoriteProduct'] = false;
        $data['successReplyProduct'] = false;
        $data['isLogined'] = false;
		if($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
		{
            $data['isLogined'] = true;
            if($this->session->flashdata('sessionSuccessFavoriteProduct'))
        	{
				$data['successFavoriteProduct'] = true;
        	}
        	elseif($this->session->flashdata('sessionSuccessReplyProduct'))
        	{
				$data['successReplyProduct'] = true;
        	}
            #BEGIN: Favorite
        	if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0 && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
        	{
				$this->load->model('product_favorite_model');
				$isAdded = false;
				foreach($this->input->post('checkone') as $checkOneArray)
				{
                    $productOne = $this->product_model->get("pro_user", "pro_id = ".(int)$checkOneArray);
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
        	#END Favorite
        	#BEGIN: Reply (Comment)
			elseif($this->input->post('captcha_reply') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
			{
				#BEGIN: Set rules
	            $this->form_validation->set_rules('title_reply', 'lang:title_reply_label_detail', 'trim|required');
	            $this->form_validation->set_rules('content_reply', 'lang:content_reply_label_detail', 'trim|required|min_length[10]|max_length[400]');
	            $this->form_validation->set_rules('captcha_reply', 'lang:captcha_reply_label_detail', 'required|callback__valid_captcha_reply');
				#END Set rules
				#BEGIN: Set message
				$this->form_validation->set_message('required', $this->lang->line('required_message'));
				$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
				$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
				$this->form_validation->set_message('_valid_captcha_reply', $this->lang->line('_valid_captcha_reply_message_detail'));
				$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
				#END Set message
				if($this->form_validation->run() != FALSE)
				{
					$dataAddReply = array(
					                        'prc_title'     =>      trim($this->filter->injection_html($this->input->post('title_reply'))),
					                        'prc_comment'   =>      trim($this->filter->injection_html($this->input->post('content_reply'))),
					                        'prc_product'   =>      (int)$product->pro_id,
					                        'prc_user'      =>      (int)$this->session->userdata('sessionUser'),
					                        'prc_date'      =>      mktime(date('H'), date('i'), 0, date('m'), date('d'), date('Y'))
											);
					if($this->product_comment_model->add($dataAddReply))
					{
						$this->product_model->update(array('pro_comment' => (int)$product->pro_comment + 1), "pro_id = ".$productIDQuery);
						$this->session->set_flashdata('sessionSuccessReplyProduct', 1);
					}
					$this->session->set_userdata('sessionTimePosted', time());
					redirect(base_url().trim(uri_string(), '/'), 'location');
				}
				else
				{
					$data['title_reply'] = $this->input->post('title_reply');
					$data['content_reply'] = $this->input->post('content_reply');
					$data['isReply'] = true;
				}
			}
            #BEGIN: Create captcha reply
        	unlink_captcha($this->session->flashdata('sessionPathCaptchaReplyProduct'));
        	$codeCaptcha = $this->captcha->code(6);
        	$this->session->set_flashdata('sessionCaptchaReplyProduct', $codeCaptcha);
        	$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.(int)$this->session->userdata('sessionUser').'r.jpg';
        	$this->session->set_flashdata('sessionPathCaptchaReplyProduct', $imageCaptcha);
			$this->captcha->create($codeCaptcha, $imageCaptcha);
			if(file_exists($imageCaptcha))
			{
				$data['imageCaptchaReplyProduct'] = $imageCaptcha;
			}
			#END Create captcha reply
            #END Reply (Comment)
		}
        #END Add favorite and submit forms
		#Assign title and description for site
		$data['titleSiteGlobal'] = $product->pro_name;
		$data['descrSiteGlobal'] = $product->pro_descr;
		#BEGIN: Get product by $productID and relate info
		$data['product'] = $product;
		$this->load->model('shop_model');
		$shop = $this->shop_model->get("sho_name, sho_descr, sho_link", "sho_user = ".(int)$product->pro_user);
		if(count($shop) == 1)
		{
            $data['shop'] = $shop;
            $data['placeSaleIsShop'] =  true;
		}
		else
		{
			$this->load->model('province_model');
			$data['province'] = $this->province_model->get("pre_name", "pre_id = ".(int)$product->pro_province);
			$data['placeSaleIsShop'] = false;
		}
		#END Get product by $productID and relate info
		#BEGIN: Menu
		$data['menuSelected'] = (int)$categoryID;
		$data['menuType'] = 'product';
		$data['menu'] = $this->menu_model->fetch("men_name, men_descr, men_image, men_category", "men_status = 1", "men_order", "ASC");
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'product_detail';
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
		$action = array('sort', 'by', 'page', 'cPage');
		$getVar = $this->uri->uri_to_assoc(6, $action);
		#BEGIN: Comment
		#Check open tab comment
		$data['isViewComment'] = false;
		if(trim(uri_string()) != '' && stristr(uri_string(), 'cPage'))
		{
            $data['isViewComment'] = true;
		}
		if($getVar['cPage'] != FALSE && (int)$getVar['cPage'] > 0)
		{
			$start = (int)$getVar['cPage'];
		}
		else
		{
			$start = 0;
		}
		$this->load->library('pagination');
		$totalRecord = count($this->product_comment_model->fetch_join("prc_id", "LEFT", "tbtt_user", "tbtt_product_comment.prc_user = tbtt_user.use_id", "prc_product = $productIDQuery", "", ""));
        $config['base_url'] = base_url().'product/category/'.$categoryID.'/detail/'.$productID.'/cPage/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = 5;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['cLinkPage'] = $this->pagination->create_links();
		$select = "prc_title, prc_comment, prc_date, use_fullname, use_email";
  		$limit = 5;
		$data['comment'] = $this->product_comment_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_product_comment.prc_user = tbtt_user.use_id", "prc_product = $productIDQuery", "prc_id", "DESC", $start, $limit);
		unset($start);
		unset($config);
		#END Comment
		#BEGIN: Relate user
		#BEGIN: Sort
		$where = "pro_user = ".(int)$product->pro_user." AND pro_id != $productIDQuery AND pro_status = 1 AND pro_enddate >= $currentDate";
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
		$data['sortUrl'] = base_url().'product/category/'.$categoryID.'/detail/'.$productID.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		#Count total record
		$totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
        $config['base_url'] = base_url().'product/category/'.$categoryID.'/detail/'.$productID.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingProductUser;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle";
		$limit = Setting::settingProductUser;
		$data['userProduct'] = $this->product_model->fetch($select, $where, $sort, $by, $start, $limit);
		#END Relate user
		#BEGIN: Relate category
		$select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle";
		$start = 0;
  		$limit = (int)Setting::settingProductCategory;
		$data['categoryProduct'] = $this->product_model->fetch($select, "pro_category = ".(int)$product->pro_category." AND pro_id != $productIDQuery AND pro_status = 1 AND pro_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Relate category
		#Load view
		$this->load->view('home/product/detail', $data);
	}
	
	function post()
	{
        #BEGIN: CHECK LOGIN
		if(!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
		{
			redirect(base_url().'login', 'location');
			die();
		}
		#END CHECK LOGIN
  		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
	    #BEGIN: Advertise
		$data['advertisePage'] = 'post';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
        #BEGIN: Unlink captcha
        $this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionPathCaptchaPostProduct'));
        #END Unlink captcha
        if((int)$this->session->userdata('sessionGroup') == 2 || (int)$this->session->userdata('sessionGroup') == 3)
		{
			if($this->session->flashdata('sessionSuccessPostProduct'))
			{
	            $data['successPostProduct'] = true;
			}
			else
			{
				$this->load->library('form_validation');
	            $data['successPostProduct'] = false;
	            #BEGIN: Set date
				if((int)date('m') < 12)
				{
					$data['nextMonth'] = (int)date('m') + 1;
					$data['nextYear'] = (int)date('Y');
				}
				else
				{
		            $data['nextMonth'] = 1;
					$data['nextYear'] = (int)date('Y') + 1;
				}
				#END: Set date
	            #BEGIN: Province
	            $this->load->model('province_model');
	            $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
	            #END Province
	            #BEGIN: Category
	            $data['category'] = $this->category_model->fetch("cat_id, cat_name", "cat_status = 1", "cat_order", "ASC");
	            #END Category
	            #BEGIN: User
	            $this->load->model('user_model');
				$user = $this->user_model->get("use_fullname, use_address, use_email, use_phone, use_mobile, use_yahoo, use_skype", "use_id = ".(int)$this->session->userdata('sessionUser'));
				$data['fullname_pro'] = $user->use_fullname;
				$data['address_pro'] = $user->use_address;
				$data['phone_pro'] = $user->use_phone;
				$data['mobile_pro'] = $user->use_mobile;
				$data['email_pro'] = $user->use_email;
				$data['yahoo_pro'] = $user->use_yahoo;
				$data['skype_pro'] = $user->use_skype;
	            #END User
				if($this->input->post('captcha_pro') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
				{
					#BEGIN: Set rules
					$this->form_validation->set_rules('name_pro', 'lang:name_pro_label_post', 'trim|required');
					$this->form_validation->set_rules('descr_pro', 'lang:descr_pro_label_post', 'trim|required');
					$this->form_validation->set_rules('cost_pro', 'lang:cost_pro_label_post', 'trim|required|is_natural');
					$this->form_validation->set_rules('province_pro', 'lang:province_pro_label_post', 'required|callback__exist_province');
					$this->form_validation->set_rules('category_pro', 'lang:category_pro_label_post', 'required|callback__exist_category');
					$this->form_validation->set_rules('day_pro', 'lang:day_pro_label_post', 'required|callback__valid_enddate');
					$this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_post', 'trim|required|min_length[10]|max_length[10000]');
					$this->form_validation->set_rules('fullname_pro', 'lang:fullname_pro_label_post', 'trim|required');
					$this->form_validation->set_rules('address_pro', 'lang:address_pro_label_post', 'trim|required');
					$this->form_validation->set_rules('phone_pro', 'lang:phone_pro_label_post', 'trim|required|callback__is_phone');
					$this->form_validation->set_rules('mobile_pro', 'lang:mobile_pro_label_post', 'trim|callback__is_phone');
					$this->form_validation->set_rules('email_pro', 'lang:email_pro_label_post', 'trim|required|valid_email');
					$this->form_validation->set_rules('yahoo_pro', 'lang:yahoo_pro_label_post', 'trim|callback__valid_nick');
					$this->form_validation->set_rules('skype_pro', 'lang:skype_pro_label_post', 'trim|callback__valid_nick');
					$this->form_validation->set_rules('captcha_pro', 'lang:captcha_pro_label_post', 'required|callback__valid_captcha_post');
					#END Set rules
					#BEGIN: Set message
					$this->form_validation->set_message('required', $this->lang->line('required_message'));
					$this->form_validation->set_message('is_natural', $this->lang->line('is_natural_message'));
					$this->form_validation->set_message('_valid_nick', $this->lang->line('_valid_nick_message'));
					$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
					$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
					$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
					$this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message'));
					$this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message'));
					$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
					$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
					$this->form_validation->set_message('_valid_captcha_post', $this->lang->line('_valid_captcha_post_message_post'));
					$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
					#END Set message
					if($this->form_validation->run() != FALSE)
					{
						#BEGIN: Upload image
						$this->load->library('upload');
		                $pathImage = "media/images/product/";
						#Create folder
						$dir_image = date('dmY');
						$image = 'none.gif';
						if(!is_dir($pathImage.$dir_image))
						{
							@mkdir($pathImage.$dir_image);
							$this->load->helper('file');
							@write_file($pathImage.$dir_image.'/index.html', '<p>Directory access is forbidden.</p>');
						}
						$config['upload_path'] = $pathImage.$dir_image.'/';
						$config['allowed_types'] = 'gif|jpg|png';
						$config['max_size']	= 100;#KB
						$config['max_width']  = 1024;#px
						$config['max_height']  = 1024;#px
						$config['encrypt_name'] = true;
						$this->upload->initialize($config);
                        $imageArray = array();
                        for($i = 1; $i <= 3; $i++)
                        {
    						if($this->upload->do_upload('image_'.$i.'_pro'))
    						{
    		                    $uploadData = $this->upload->data();
    		                    if($uploadData['is_image'] == TRUE)
    		                    {
    								$imageArray[] = $uploadData['file_name'];
    		     				}
    		     				elseif(file_exists($pathImage.$dir_image.'/'.$uploadData['file_name']))
    		     				{
    								@unlink($pathImage.$dir_image.'/'.$uploadData['file_name']);
    		     				}
                                unset($uploadData);
    						}
                        }
                        if(count($imageArray) > 0)
                        {
                            #BEGIN: Create thumbnail
                            $this->load->library('image_lib');
                            if(file_exists($pathImage.$dir_image.'/'.$imageArray[0]))
                            {
                                for($j = 1; $j <= 3; $j++)
                                {
                                    switch($j)
                                    {
                                        case 1:
                                            $maxWidth = 100;#px
                                            $maxHeight = 75;#px
                                            break;
                                        case 3:
                                            $maxWidth = 200;#px
                                            $maxHeight = 170;#px
                                            break;
                                        default:
                                            $maxWidth = 125;#px
                                            $maxHeight = 90;#px
                                    }
                                    $sizeImage = size_thumbnail($pathImage.$dir_image.'/'.$imageArray[0], $maxWidth, $maxHeight);
                                    $configImage['source_image'] = $pathImage.$dir_image.'/'.$imageArray[0];
                                    $configImage['new_image'] = $pathImage.$dir_image.'/thumbnail_'.$j.'_'.$imageArray[0];
                                    $configImage['maintain_ratio'] = TRUE;
                                    $configImage['width'] = $sizeImage['width'];
                                    $configImage['height'] = $sizeImage['height'];
                                    $this->image_lib->initialize($configImage); 
                                    $this->image_lib->resize();
                                    $this->image_lib->clear();
                                }
                            }
                            #END Create thumbnail
                            $image = implode(',', $imageArray);
                        }
						if($image == 'none.gif')
						{
                            #Remove dir
	                        $this->load->library('file');
	                        if(trim($dir_image) != '' && trim($dir_image) != 'default' && is_dir('media/images/product/'.$dir_image) && count($this->file->load('media/images/product/'.$dir_image, 'index.html')) == 0)
	                        {
								if(file_exists('media/images/product/'.$dir_image.'/index.html'))
								{
									@unlink('media/images/product/'.$dir_image.'/index.html');
								}
								@rmdir('media/images/product/'.$dir_image);
	                        }
	                        $dir_image = 'default';
						}
						#END Upload image
						if(strtoupper($this->input->post('currency_pro')) == 'USD')
						{
	                        $currency_pro = 'USD';
						}
						else
						{
	                        $currency_pro = 'VND';
						}
						if((int)$this->input->post('cost_pro') == 0 || $this->input->post('nonecost_pro') == '1')
						{
							$cost_pro = 0;
							$currency_pro = 'VND';
						}
						else
						{
	                        $cost_pro = (int)$this->input->post('cost_pro');
						}
						if($this->input->post('nego_pro') == '1')
						{
							$nego_pro = 1;
						}
						else
						{
	                        $nego_pro = 0;
						}
						if($this->input->post('saleoff_pro') == '1')
						{
							$saleoff_pro = 1;
						}
						else
						{
	                        $saleoff_pro = 0;
						}
						if((int)$this->session->userdata('sessionGroup') == 3)
						{
							$reliable = 1;
						}
						else
						{
	                        $reliable = 0;
						}
						$dataPost = array(
						                    'pro_name'      	=>      trim($this->filter->injection_html($this->input->post('name_pro'))),
						                    'pro_descr'     	=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_pro')))),
						                    'pro_cost'      	=>      $cost_pro,
						                    'pro_currency'  	=>      $currency_pro,
						                    'pro_hondle'    	=>      $nego_pro,
						                    'pro_saleoff'   	=>      $saleoff_pro,
						                    'pro_province'  	=>      (int)$this->input->post('province_pro'),
						                    'pro_category'  	=>      (int)$this->input->post('category_pro'),
						                    'pro_begindate' 	=>      $currentDate,
						                    'pro_enddate'   	=>      mktime(0, 0, 0, (int)$this->input->post('month_pro'), (int)$this->input->post('day_pro'), (int)$this->input->post('year_pro')),
						                    'pro_detail'    	=>      trim($this->filter->injection_html($this->input->post('txtContent'))),
						                    'pro_image'     	=>      $image,
						                    'pro_dir'       	=>      $dir_image,
						                    'pro_user'      	=>      (int)$this->session->userdata('sessionUser'),
						                    'pro_poster'    	=>      trim($this->filter->injection_html($this->input->post('fullname_pro'))),
						                    'pro_address'   	=>      trim($this->filter->injection_html($this->input->post('address_pro'))),
						                    'pro_phone'     	=>      trim($this->filter->injection_html($this->input->post('phone_pro'))),
						                    'pro_mobile'    	=>      trim($this->filter->injection_html($this->input->post('mobile_pro'))),
						                    'pro_email'     	=>      trim($this->filter->injection_html($this->input->post('email_pro'))),
						                    'pro_yahoo'     	=>      trim($this->filter->injection_html($this->input->post('yahoo_pro'))),
						                    'pro_skype'     	=>      trim($this->filter->injection_html($this->input->post('skype_pro'))),
						                    'pro_status'    	=>      1,
						                    'pro_view'      	=>      0,
						                    'pro_buy'       	=>      0,
						                    'pro_comment'   	=>      0,
						                    'pro_vote_cost' 	=>      0,
						                    'pro_vote_quanlity' =>  	0,
	                                        'pro_vote_model'    =>      0,
	                                        'pro_vote_service'  =>      0,
	                                        'pro_vote_total'    =>      0,
	                                        'pro_vote'          =>      0,
	                                        'pro_reliable'      =>      $reliable
											);
						if($this->product_model->add($dataPost))
						{
							$this->session->set_flashdata('sessionSuccessPostProduct', 1);
						}
						$this->session->set_userdata('sessionTimePosted', time());
						redirect(base_url().trim(uri_string(), '/'), 'location');
					}
					else
					{
						$data['name_pro'] = $this->input->post('name_pro');
						$data['descr_pro'] = $this->input->post('descr_pro');
						$data['cost_pro'] = $this->input->post('cost_pro');
						$data['currency_pro'] = $this->input->post('currency_pro');
						$data['nonecost_pro'] = $this->input->post('nonecost_pro');
						$data['nego_pro'] = $this->input->post('nego_pro');
						$data['saleoff_pro'] = $this->input->post('saleoff_pro');
						$data['province_pro'] = $this->input->post('province_pro');
						$data['category_pro'] = $this->input->post('category_pro');
						$data['day_pro'] = $this->input->post('day_pro');
						$data['month_pro'] = $this->input->post('month_pro');
						$data['year_pro'] = $this->input->post('year_pro');
						$data['txtContent'] = $this->input->post('txtContent');
	     				$data['fullname_pro'] = $this->input->post('fullname_pro');
						$data['address_pro'] = $this->input->post('address_pro');
	     				$data['phone_pro'] = $this->input->post('phone_pro');
	                    $data['mobile_pro'] = $this->input->post('mobile_pro');
	                    $data['email_pro'] = $this->input->post('email_pro');
	                    $data['yahoo_pro'] = $this->input->post('yahoo_pro');
	                    $data['skype_pro'] = $this->input->post('skype_pro');
					}
				}
                #BEGIN: Create captcha post product
                $this->load->library('captcha');
   	            $codeCaptcha = $this->captcha->code(6);
				$this->session->set_flashdata('sessionCaptchaPostProduct', $codeCaptcha);
				$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.(int)$this->session->userdata('sessionUser').'posp.jpg';
				$this->session->set_flashdata('sessionPathCaptchaPostProduct', $imageCaptcha);
				$this->captcha->create($codeCaptcha, $imageCaptcha);
				if(file_exists($imageCaptcha))
				{
				    $data['imageCaptchaPostProduct'] = $imageCaptcha;
				}
				#END Create captcha post product
			}
		}
		else
		{
			$data['disAllowPost'] = true;
		}
		#Load view
		$this->load->view('home/product/post', $data);
	}
	
	function _valid_captcha_reply($str)
	{
		if($this->session->flashdata('sessionCaptchaReplyProduct') && $this->session->flashdata('sessionCaptchaReplyProduct') === $str)
		{
			return true;
		}
		return false;
	}
	
	function _valid_captcha_send_friend($str)
	{
		if($this->session->flashdata('sessionCaptchaSendFriendProduct') && $this->session->flashdata('sessionCaptchaSendFriendProduct') === $str)
		{
			return true;
		}
		return false;
	}
	
	function _valid_captcha_send_fail($str)
	{
		if($this->session->flashdata('sessionCaptchaSendFailProduct') && $this->session->flashdata('sessionCaptchaSendFailProduct') === $str)
		{
			return true;
		}
		return false;
	}
	
	function _is_phone($str)
	{
		if($this->check->is_phone($str))
		{
			return true;
		}
		return false;
	}

	function _exist_province($str)
	{
		$this->load->model('province_model');
		if(count($this->province_model->get("pre_id", "pre_status = 1 AND pre_id = ".(int)$str)) == 1)
		{
			return true;
		}
		return false;
	}
	
	function _exist_category($str)
	{
		if(count($this->category_model->get("cat_id", "cat_status = 1 AND cat_id = ".(int)$str)) == 1)
		{
			return true;
		}
		return false;
	}
	
	function _valid_enddate()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$endDate = mktime(0, 0, 0, (int)$this->input->post('month_pro'), (int)$this->input->post('day_pro'), (int)$this->input->post('year_pro'));
		if($this->check->is_more($currentDate, $endDate))
		{
		    return false;
		}
		return true;
	}
    
    function _valid_nick($str)
    {
        if(preg_match('/[^0-9a-z._-]/i', $str))
		{
			return false;
		}
		return true;
    }
	
	function _valid_captcha_post($str)
	{
		if($this->session->flashdata('sessionCaptchaPostProduct') && $this->session->flashdata('sessionCaptchaPostProduct') === $str)
		{
			return true;
		}
		return false;
	}
}