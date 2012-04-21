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
		#BEGIN: CHECK LOGIN
		if(!$this->check->is_logined($this->session->userdata('sessionUserAdmin'), $this->session->userdata('sessionGroupAdmin')))
		{
			redirect(base_url().'administ', 'location');
			die();
		}
		#END CHECK LOGIN
		#Load language
		$this->lang->load('admin/common');
		$this->lang->load('admin/shop');
		#Load model
		$this->load->model('shop_model');
		#BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			#Remove image
			$this->load->library('file');
			$listIdShop = implode(',', $this->input->post('checkone'));
			$shop = $this->shop_model->fetch("sho_logo, sho_dir_logo, sho_banner, sho_dir_banner", "sho_id IN($listIdShop)", "", "");
			foreach($shop as $shopArray)
			{
				if(trim($shopArray->sho_logo) != '' && file_exists('media/shop/logos/'.$shopArray->sho_dir_logo.'/'.$shopArray->sho_logo))
				{
					@unlink('media/shop/logos/'.$shopArray->sho_dir_logo.'/'.$shopArray->sho_logo);
				}
				if(trim($shopArray->sho_dir_logo) != '' && is_dir('media/shop/logos/'.$shopArray->sho_dir_logo) && count($this->file->load('media/shop/logos/'.$shopArray->sho_dir_logo, 'index.html')) == 0)
				{
					if(file_exists('media/shop/logos/'.$shopArray->sho_dir_logo.'/index.html'))
					{
						@unlink('media/shop/logos/'.$shopArray->sho_dir_logo.'/index.html');
					}
					@rmdir('media/shop/logos/'.$shopArray->sho_dir_logo);
				}
				if(trim($shopArray->sho_banner) != '' && file_exists('media/shop/banners/'.$shopArray->sho_dir_banner.'/'.$shopArray->sho_banner))
				{
					@unlink('media/shop/banners/'.$shopArray->sho_dir_banner.'/'.$shopArray->sho_banner);
				}
				if(trim($shopArray->sho_dir_banner) != '' && is_dir('media/shop/banners/'.$shopArray->sho_dir_banner) && count($this->file->load('media/shop/banners/'.$shopArray->sho_dir_banner, 'index.html')) == 0)
				{
					if(file_exists('media/shop/banners/'.$shopArray->sho_dir_banner.'/index.html'))
					{
						@unlink('media/shop/banners/'.$shopArray->sho_dir_banner.'/index.html');
					}
					@rmdir('media/shop/banners/'.$shopArray->sho_dir_banner);
				}
			}
			$this->shop_model->delete($this->input->post('checkone'), "sho_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
	}
	
	function index()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Search & Filter
		$where = '';
		$sort = '';
		$by = '';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = '';
		#If search
		if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
		{
            $keyword = $getVar['keyword'];
			switch(strtolower($getVar['search']))
			{
				case 'name':
				    $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $where .= "sho_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'link':
				    $sortUrl .= '/search/link/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/link/keyword/'.$getVar['keyword'];
				    $where .= "sho_link LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'saler':
				    $sortUrl .= '/search/saler/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/saler/keyword/'.$getVar['keyword'];
				    $where .= "use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
                case 'begindate':
				    $sortUrl .= '/filter/begindate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/begindate/key/'.$getVar['key'];
				    $where .= "sho_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= "sho_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "sho_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "sho_status = 0";
				    break;
                case 'saleoff':
				    $sortUrl .= '/filter/saleoff/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saleoff/key/'.$getVar['key'];
				    $where .= "sho_saleoff = 1";
				    break;
                case 'notsaleoff':
				    $sortUrl .= '/filter/notsaleoff/key/'.$getVar['key'];
				    $pageUrl .= '/filter/notsaleoff/key/'.$getVar['key'];
				    $where .= "sho_saleoff = 0";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'name':
				    $pageUrl .= '/sort/name';
				    $sort .= "sho_name";
				    break;
                case 'link':
				    $pageUrl .= '/sort/link';
				    $sort .= "sho_link";
				    break;
                case 'saler':
				    $pageUrl .= '/sort/saler';
				    $sort .= "use_username";
				    break;
                case 'category':
				    $pageUrl .= '/sort/category';
				    $sort .= "cat_name";
				    break;
                case 'begindate':
				    $pageUrl .= '/sort/begindate';
				    $sort .= "sho_begindate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "sho_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "sho_id";
			}
			if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
			{
                $pageUrl .= '/by/desc';
				$by .= "DESC";
			}
			else
			{
                $pageUrl .= '/by/asc';
				$by .= "ASC";
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
		#END Search & Filter
		#Keyword
		$data['keyword'] = $keyword;
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'administ/shop'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/shop'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->shop_model->update(array('sho_status'=>1), "sho_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->shop_model->update(array('sho_status'=>0), "sho_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->shop_model->fetch_join("sho_id", "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_shop.sho_category = tbtt_category.cat_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/shop'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingOtherAdmin;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#sTT - So thu tu
		$data['sTT'] = $start + 1;
		#Fetch record
		$select = "sho_id, sho_name, sho_view, sho_saleoff, sho_link, sho_address, sho_phone, sho_email, sho_status, sho_begindate, sho_enddate, use_id, use_username, use_email, cat_id, cat_name";
		$limit = Setting::settingOtherAdmin;
		$data['shop'] = $this->shop_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_shop.sho_category = tbtt_category.cat_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/shop/defaults', $data);
	}
	
	function end()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Update status = deactive
		if(!isset($_COOKIE['_cookieSetStatus']) || (isset($_COOKIE['_cookieSetStatus']) && !stristr(strtolower($_COOKIE['_cookieSetStatus']), 'shop')))
		{
            $this->shop_model->update(array('sho_status'=>0), "sho_enddate < $currentDate");
            if(isset($_COOKIE['_cookieSetStatus']))
            {
                setcookie('_cookieSetStatus', $_COOKIE['_cookieSetStatus'].'-shop');
            }
            else
            {
                setcookie('_cookieSetStatus', 'shop');
            }
		}
		#END Update status = deactive
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = "sho_enddate < $currentDate";
		$sort = '';
		$by = '';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = '';
		#If search
		if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
		{
            $keyword = $getVar['keyword'];
			switch(strtolower($getVar['search']))
			{
				case 'name':
				    $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $where .= " AND sho_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'link':
				    $sortUrl .= '/search/link/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/link/keyword/'.$getVar['keyword'];
				    $where .= " AND sho_link LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'saler':
				    $sortUrl .= '/search/saler/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/saler/keyword/'.$getVar['keyword'];
				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
                case 'begindate':
				    $sortUrl .= '/filter/begindate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/begindate/key/'.$getVar['key'];
				    $where .= " AND sho_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND sho_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND sho_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND sho_status = 0";
				    break;
                case 'saleoff':
				    $sortUrl .= '/filter/saleoff/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saleoff/key/'.$getVar['key'];
				    $where .= " AND sho_saleoff = 1";
				    break;
                case 'notsaleoff':
				    $sortUrl .= '/filter/notsaleoff/key/'.$getVar['key'];
				    $pageUrl .= '/filter/notsaleoff/key/'.$getVar['key'];
				    $where .= " AND sho_saleoff = 0";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'name':
				    $pageUrl .= '/sort/name';
				    $sort .= "sho_name";
				    break;
                case 'link':
				    $pageUrl .= '/sort/link';
				    $sort .= "sho_link";
				    break;
                case 'saler':
				    $pageUrl .= '/sort/saler';
				    $sort .= "use_username";
				    break;
                case 'category':
				    $pageUrl .= '/sort/category';
				    $sort .= "cat_name";
				    break;
                case 'begindate':
				    $pageUrl .= '/sort/begindate';
				    $sort .= "sho_begindate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "sho_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "sho_id";
			}
			if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
			{
                $pageUrl .= '/by/desc';
				$by .= "DESC";
			}
			else
			{
                $pageUrl .= '/by/asc';
				$by .= "ASC";
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
		#END Search & Filter
		#Keyword
		$data['keyword'] = $keyword;
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'administ/shop/end'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->shop_model->fetch_join("sho_id", "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_shop.sho_category = tbtt_category.cat_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/shop/end'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingOtherAdmin;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#sTT - So thu tu
		$data['sTT'] = $start + 1;
		#Fetch record
		$select = "sho_id, sho_name, sho_view, sho_saleoff, sho_link, sho_address, sho_phone, sho_email, sho_status, sho_begindate, sho_enddate, use_id, use_username, use_email, cat_id, cat_name";
		$limit = Setting::settingOtherAdmin;
		$data['shop'] = $this->shop_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_shop.sho_category = tbtt_category.cat_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/shop/end', $data);
	}
	
	function add()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_add'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        if($this->session->flashdata('sessionSuccessAdd'))
		{
            $data['successAdd'] = true;
		}
		else
		{
            $data['successAdd'] = false;
            #BEGIN: Fetch user is saler
            $this->load->model('user_model');
            $userShop = $this->shop_model->fetch("sho_user", "", "", "");
            $userUsed = array();
            foreach($userShop as $userShopArray)
            {
				$userUsed[] = $userShopArray->sho_user;
            }
            if(count($userUsed) > 0)
            {
                $userUsed = implode(',', $userUsed);
            	$data['user'] = $this->user_model->fetch("use_id, use_username, use_email", "use_group = 3 AND use_status = 1 AND use_id NOT IN($userUsed)", "use_username", "ASC");
            }
            else
            {
                $data['user'] = $this->user_model->fetch("use_id, use_username, use_email", "use_group = 3 AND use_status = 1", "use_username", "ASC");
            }
            #END Fetch user is saler
            #BEGIN: Fetch category
            $this->load->model('category_model');
            $data['category'] = $this->category_model->fetch("cat_id, cat_name", "", "cat_order", "ASC");
            #END Fetch category
            #BEGIN: Fetch province
            $this->load->model('province_model');
            $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
            #END Fetch province
            #BEGIN: Load style
            $this->load->library('folder');
			$data['style'] = $this->folder->load('templates/shop');
            #END Load style
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
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('link_shop', 'lang:link_label_add', 'trim|required|alpha_dash|min_length[5]|max_length[50]|callback__exist_link|callback__valid_link');
            $this->form_validation->set_rules('username_shop', 'lang:username_label_add', 'required|callback__exist_username');
            $this->form_validation->set_rules('name_shop', 'lang:name_label_add', 'trim|required|callback__exist_shop');
            $this->form_validation->set_rules('descr_shop', 'lang:descr_label_add', 'trim|required');
            $this->form_validation->set_rules('address_shop', 'lang:address_label_add', 'trim|required');
            $this->form_validation->set_rules('phone_shop', 'lang:phone_label_add', 'trim|required|callback__is_phone');
            $this->form_validation->set_rules('mobile_shop', 'lang:mobile_label_add', 'trim|callback__is_phone');
            $this->form_validation->set_rules('email_shop', 'lang:email_label_add', 'trim|required|valid_email');
            $this->form_validation->set_rules('yahoo_shop', 'lang:yahoo_label_add', 'trim|callback__valid_nick');
            $this->form_validation->set_rules('skype_shop', 'lang:skype_label_add', 'trim|callback__valid_nick');
            $this->form_validation->set_rules('website_shop', 'lang:website_label_add', 'callback__valid_website');
            $this->form_validation->set_rules('endday_shop', 'lang:enddate_label_add', 'callback__valid_enddate');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('alpha_dash', $this->lang->line('alpha_dash_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
			$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
			$this->form_validation->set_message('_exist_link', $this->lang->line('_exist_link_message_add'));
			$this->form_validation->set_message('_valid_link', $this->lang->line('_valid_link_message_add'));
			$this->form_validation->set_message('_exist_username', $this->lang->line('_exist_username_message_add'));
			$this->form_validation->set_message('_exist_shop', $this->lang->line('_exist_shop_message_add'));
			$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
			$this->form_validation->set_message('_valid_website', $this->lang->line('_valid_website_message_add'));
			$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
            $this->form_validation->set_message('_valid_nick', $this->lang->line('_valid_nick_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                $this->load->library('upload');
                #BEGIN: Upload logo
                $pathLogo = "media/shop/logos/";
				#Create folder
				$dir_logo = date('dmY');
				if(!is_dir($pathLogo.$dir_logo))
				{
					@mkdir($pathLogo.$dir_logo);
					$this->load->helper('file');
					@write_file($pathLogo.$dir_logo.'/index.html', '<p>Directory access is forbidden.</p>');
				}
				$config['upload_path'] = $pathLogo.$dir_logo.'/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']	= 1024;
				$config['max_width']  = 800;
				$config['max_height']  = 800;
				$config['encrypt_name'] = true;
				$this->upload->initialize($config);
				if($this->upload->do_upload('logo_shop'))
				{
					$uploadLogo = $this->upload->data();
					$logo_shop = $uploadLogo['file_name'];
                    #BEGIN: Resize logo
                    $this->load->library('image_lib');
                    if(file_exists($pathLogo.$dir_logo.'/'.$logo_shop))
                    {
                        $sizeLogo = size_thumbnail($pathLogo.$dir_logo.'/'.$logo_shop);
                        $configLogo['source_image'] = $pathLogo.$dir_logo.'/'.$logo_shop;
                        $configLogo['new_image'] = $pathLogo.$dir_logo.'/'.$logo_shop;
                        $configLogo['maintain_ratio'] = TRUE;
                        $configLogo['width'] = $sizeLogo['width'];
                        $configLogo['height'] = $sizeLogo['height'];
                        $this->image_lib->initialize($configLogo); 
                        $this->image_lib->resize();
                    }
                    #END Resize logo
     				$isLogoUploaded = true;
				}
				else
				{
                    $isLogoUploaded = false;
				}
				unset($config);
				#END Upload logo
				#BEGIN: Upload banner
                $pathBanner = "media/shop/banners/";
				#Create folder
				$dir_banner = date('dmY');
				if(!is_dir($pathBanner.$dir_banner))
				{
					@mkdir($pathBanner.$dir_banner);
					$this->load->helper('file');
					@write_file($pathBanner.$dir_banner.'/index.html', '<p>Directory access is forbidden.</p>');
				}
				$config['upload_path'] = $pathBanner.$dir_banner.'/';
				$config['allowed_types'] = 'gif|jpg|png|swf';
				$config['max_size']	= 2048;
				$config['max_width']  = 1024;
				$config['max_height']  = 1024;
				$config['encrypt_name'] = true;
				$this->upload->initialize($config);
				if($this->upload->do_upload('banner_shop'))
				{
					$uploadBanner = $this->upload->data();
					$banner_shop = $uploadBanner['file_name'];
     				$isBannerUploaded = true;
				}
				else
				{
                    $isBannerUploaded = false;
				}
				#END Upload banner
				if($isLogoUploaded == false || $isBannerUploaded == false)
				{
                    redirect(base_url().'administ/shop/add', 'location');
                    die();
				}
                if($this->input->post('active_shop') == '1')
				{
	                $active_shop = 1;
				}
				else
				{
	                $active_shop = 0;
				}
				if($this->input->post('saleoff_shop') == '1')
				{
	                $saleoff_shop = 1;
				}
				else
				{
	                $saleoff_shop = 0;
				}
				$enddate_shop = mktime(0, 0, 0, (int)$this->input->post('endmonth_shop'), (int)$this->input->post('endday_shop'), (int)$this->input->post('endyear_shop'));
				$dataAdd = array(
				                    'sho_name'      		=>      trim($this->filter->injection_html($this->input->post('name_shop'))),
				                    'sho_descr'      		=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_shop')))),
				                    'sho_link'				=>      trim(strtolower($this->filter->injection_html($this->input->post('link_shop')))),
				                    'sho_logo'         		=>      $logo_shop,
	                                'sho_dir_logo'      	=>      $dir_logo,
	                                'sho_banner'      		=>      $banner_shop,
				                    'sho_dir_banner'      	=>      $dir_banner,
				                    'sho_address'			=>      trim($this->filter->injection_html($this->input->post('address_shop'))),
				                    'sho_category'        	=>      (int)$this->input->post('category_shop'),
				                    'sho_province'     		=>      (int)$this->input->post('province_shop'),
				                    'sho_phone'      		=>      trim($this->filter->injection_html($this->input->post('phone_shop'))),
				                    'sho_mobile'			=>      trim($this->filter->injection_html($this->input->post('mobile_shop'))),
				                    'sho_email'      		=>      trim($this->filter->injection_html($this->input->post('email_shop'))),
				                    'sho_yahoo'         	=>      trim($this->filter->injection_html($this->input->post('yahoo_shop'))),
	                                'sho_skype'      		=>      trim($this->filter->injection_html($this->input->post('skype_shop'))),
	                                'sho_website'      		=>      trim($this->filter->injection_html($this->filter->link($this->input->post('website_shop')))),
	                                'sho_style'      		=>      trim($this->filter->injection_html($this->input->post('style_shop'))),
	                                'sho_saleoff'      		=>      $saleoff_shop,
	                                'sho_status'      		=>      $active_shop,
	                                'sho_user'      		=>      (int)$this->input->post('username_shop'),
	                                'sho_view'      		=>      1,
	                                'sho_begindate'      	=>      mktime(0, 0, 0, date('m'), date('d'), date('Y')),
	                                'sho_enddate'      		=>      $enddate_shop
									);
				if($this->shop_model->add($dataAdd))
				{
					#BEGIN: Update enddate user
					$this->user_model->update(array('use_enddate'=>$enddate_shop), "use_id = ".(int)$this->input->post('username_shop'));
					#END Update enddate user
         			$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/shop/add', 'location');
			}
			else
	        {
				$data['link_shop'] = $this->input->post('link_shop');
				$data['username_shop'] = $this->input->post('username_shop');
				$data['name_shop'] = $this->input->post('name_shop');
				$data['descr_shop'] = $this->input->post('descr_shop');
				$data['address_shop'] = $this->input->post('address_shop');
				$data['category_shop'] = $this->input->post('category_shop');
				$data['province_shop'] = $this->input->post('province_shop');
				$data['phone_shop'] = $this->input->post('phone_shop');
				$data['mobile_shop'] = $this->input->post('mobile_shop');
				$data['email_shop'] = $this->input->post('email_shop');
				$data['yahoo_shop'] = $this->input->post('yahoo_shop');
				$data['skype_shop'] = $this->input->post('skype_shop');
				$data['website_shop'] = $this->input->post('website_shop');
				$data['style_shop'] = $this->input->post('style_shop');
				$data['saleoff_shop'] = $this->input->post('saleoff_shop');
				$data['endday_shop'] = $this->input->post('endday_shop');
				$data['endmonth_shop'] = $this->input->post('endmonth_shop');
				$data['endyear_shop'] = $this->input->post('endyear_shop');
				$data['active_shop'] = $this->input->post('active_shop');
	        }
        }
		#Load view
		$this->load->view('admin/shop/add', $data);
	}
	
	function edit($id)
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_edit'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        if($this->session->flashdata('sessionSuccessEdit'))
		{
            $data['successEdit'] = true;
		}
		else
		{
            $data['successEdit'] = false;
            #BEGIN: Get shop by $id
            $shop = $this->shop_model->get("*", "sho_id = ".(int)$id);
            if(count($shop) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/shop', 'location');
				die();
			}
            #END Get shop by $id
            #BEGIN: Fetch user is saler
            $this->load->model('user_model');
            $thisUserShop = $shop->sho_user;
            $userShop = $this->shop_model->fetch("sho_user", "sho_user != $thisUserShop", "", "");
            $userUsed = array();
            foreach($userShop as $userShopArray)
            {
				$userUsed[] = $userShopArray->sho_user;
            }
            if(count($userUsed) > 0)
            {
                $userUsed = implode(',', $userUsed);
            	$data['user'] = $this->user_model->fetch("use_id, use_username, use_email", "use_group = 3 AND use_status = 1 AND use_id NOT IN($userUsed)", "use_username", "ASC");
            }
            else
            {
                $data['user'] = $this->user_model->fetch("use_id, use_username, use_email", "use_group = 3 AND use_status = 1", "use_username", "ASC");
            }
            #END Fetch user is saler
            #BEGIN: Fetch category
            $this->load->model('category_model');
            $data['category'] = $this->category_model->fetch("cat_id, cat_name", "", "cat_order", "ASC");
            #END Fetch category
            #BEGIN: Fetch province
            $this->load->model('province_model');
            $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
            #END Fetch province
            #BEGIN: Load style
            $this->load->library('folder');
			$data['style'] = $this->folder->load('templates/shop');
            #END Load style
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
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('descr_shop', 'lang:descr_label_edit', 'trim|required');
            $this->form_validation->set_rules('address_shop', 'lang:address_label_edit', 'trim|required');
            $this->form_validation->set_rules('phone_shop', 'lang:phone_label_edit', 'trim|required|callback__is_phone');
            $this->form_validation->set_rules('mobile_shop', 'lang:mobile_label_edit', 'trim|callback__is_phone');
            $this->form_validation->set_rules('email_shop', 'lang:email_label_edit', 'trim|required|valid_email');
            $this->form_validation->set_rules('yahoo_shop', 'lang:yahoo_label_edit', 'trim|callback__valid_nick');
            $this->form_validation->set_rules('skype_shop', 'lang:skype_label_edit', 'trim|callback__valid_nick');
            $this->form_validation->set_rules('website_shop', 'lang:website_label_edit', 'callback__valid_website');
            $this->form_validation->set_rules('endday_shop', 'lang:enddate_label_edit', 'callback__valid_enddate');
            #Expand
            if($shop->sho_link != trim(strtolower($this->filter->injection_html($this->input->post('link_shop')))))
            {
                $this->form_validation->set_rules('link_shop', 'lang:link_label_edit', 'trim|required|alpha_dash|min_length[5]|max_length[50]|callback__exist_link|callback__valid_link');
            }
            else
            {
                $this->form_validation->set_rules('link_shop', 'lang:link_label_edit', 'trim|required|alpha_dash|min_length[5]|max_length[50]|callback__valid_link');
            }
            if($shop->sho_user != (int)$this->input->post('username_shop'))
            {
                $this->form_validation->set_rules('username_shop', 'lang:username_label_edit', 'required|callback__exist_username');
            }
            else
            {
                $this->form_validation->set_rules('username_shop', 'lang:username_label_edit', 'required');
            }
            if($shop->sho_name != trim($this->filter->injection_html($this->input->post('name_shop'))))
            {
                $this->form_validation->set_rules('name_shop', 'lang:name_label_edit', 'trim|required|callback__exist_shop');
            }
            else
            {
                $this->form_validation->set_rules('name_shop', 'lang:name_label_edit', 'trim|required');
            }
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('alpha_dash', $this->lang->line('alpha_dash_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
			$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
			$this->form_validation->set_message('_exist_link', $this->lang->line('_exist_link_message_edit'));
			$this->form_validation->set_message('_valid_link', $this->lang->line('_valid_link_message_edit'));
			$this->form_validation->set_message('_exist_username', $this->lang->line('_exist_username_message_edit'));
			$this->form_validation->set_message('_exist_shop', $this->lang->line('_exist_shop_message_edit'));
			$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
			$this->form_validation->set_message('_valid_website', $this->lang->line('_valid_website_message_edit'));
			$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
            $this->form_validation->set_message('_valid_nick', $this->lang->line('_valid_nick_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                $this->load->library('upload');
                #BEGIN: Upload logo
                $pathLogo = "media/shop/logos/";
				#Create folder
				$dir_logo = $shop->sho_dir_logo;
				if(!is_dir($pathLogo.$dir_logo))
				{
					@mkdir($pathLogo.$dir_logo);
					$this->load->helper('file');
					@write_file($pathLogo.$dir_logo.'/index.html', '<p>Directory access is forbidden.</p>');
				}
				$config['upload_path'] = $pathLogo.$dir_logo.'/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']	= 1024;
				$config['max_width']  = 800;
				$config['max_height']  = 800;
				$config['encrypt_name'] = true;
				$this->upload->initialize($config);
				if($this->upload->do_upload('logo_shop'))
				{
					if($shop->sho_logo != '' && file_exists($pathLogo.$dir_logo.'/'.$shop->sho_logo))
					{
						@unlink($pathLogo.$dir_logo.'/'.$shop->sho_logo);
					}
					$uploadLogo = $this->upload->data();
					$logo_shop = $uploadLogo['file_name'];
                    #BEGIN: Resize logo
                    $this->load->library('image_lib');
                    if(file_exists($pathLogo.$dir_logo.'/'.$logo_shop))
                    {
                        $sizeLogo = size_thumbnail($pathLogo.$dir_logo.'/'.$logo_shop);
                        $configLogo['source_image'] = $pathLogo.$dir_logo.'/'.$logo_shop;
                        $configLogo['new_image'] = $pathLogo.$dir_logo.'/'.$logo_shop;
                        $configLogo['maintain_ratio'] = TRUE;
                        $configLogo['width'] = $sizeLogo['width'];
                        $configLogo['height'] = $sizeLogo['height'];
                        $this->image_lib->initialize($configLogo); 
                        $this->image_lib->resize();
                    }
                    #END Resize logo
     				$isLogoUploaded = true;
				}
				else
				{
					if($shop->sho_logo != '' && file_exists($pathLogo.$dir_logo.'/'.$shop->sho_logo))
					{
						$logo_shop = $shop->sho_logo;
						$isLogoUploaded = true;
					}
                    else
                    {
                        $isLogoUploaded = false;
                    }
				}
				unset($config);
				#END Upload logo
				#BEGIN: Upload banner
                $pathBanner = "media/shop/banners/";
				#Create folder
				$dir_banner = $shop->sho_dir_banner;
				if(!is_dir($pathBanner.$dir_banner))
				{
					@mkdir($pathBanner.$dir_banner);
					$this->load->helper('file');
					@write_file($pathBanner.$dir_banner.'/index.html', '<p>Directory access is forbidden.</p>');
				}
				$config['upload_path'] = $pathBanner.$dir_banner.'/';
				$config['allowed_types'] = 'gif|jpg|png|swf';
				$config['max_size']	= 2048;
				$config['max_width']  = 1024;
				$config['max_height']  = 1024;
				$config['encrypt_name'] = true;
				$this->upload->initialize($config);
				if($this->upload->do_upload('banner_shop'))
				{
                    if($shop->sho_banner != '' && file_exists($pathBanner.$dir_banner.'/'.$shop->sho_banner))
					{
						@unlink($pathBanner.$dir_banner.'/'.$shop->sho_banner);
					}
					$uploadBanner = $this->upload->data();
					$banner_shop = $uploadBanner['file_name'];
     				$isBannerUploaded = true;
				}
				else
				{
                    if($shop->sho_banner != '' && file_exists($pathBanner.$dir_banner.'/'.$shop->sho_banner))
					{
						$banner_shop = $shop->sho_banner;
						$isBannerUploaded = true;
					}
                    else
                    {
                        $isBannerUploaded = false;
                    }
				}
				#END Upload banner
				if($isLogoUploaded == false || $isBannerUploaded == false)
				{
                    redirect(base_url().'administ/shop/edit/'.$id, 'location');
                    die();
				}
                if($this->input->post('active_shop') == '1')
				{
	                $active_shop = 1;
				}
				else
				{
	                $active_shop = 0;
				}
				if($this->input->post('saleoff_shop') == '1')
				{
	                $saleoff_shop = 1;
				}
				else
				{
	                $saleoff_shop = 0;
				}
				$enddate_shop = mktime(0, 0, 0, (int)$this->input->post('endmonth_shop'), (int)$this->input->post('endday_shop'), (int)$this->input->post('endyear_shop'));
				$dataEdit = array(
				                    'sho_name'      		=>      trim($this->filter->injection_html($this->input->post('name_shop'))),
				                    'sho_descr'      		=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_shop')))),
				                    'sho_link'				=>      trim(strtolower($this->filter->injection_html($this->input->post('link_shop')))),
				                    'sho_logo'         		=>      $logo_shop,
	                                'sho_dir_logo'      	=>      $dir_logo,
	                                'sho_banner'      		=>      $banner_shop,
				                    'sho_dir_banner'      	=>      $dir_banner,
				                    'sho_address'			=>      trim($this->filter->injection_html($this->input->post('address_shop'))),
				                    'sho_category'        	=>      (int)$this->input->post('category_shop'),
				                    'sho_province'     		=>      (int)$this->input->post('province_shop'),
				                    'sho_phone'      		=>      trim($this->filter->injection_html($this->input->post('phone_shop'))),
				                    'sho_mobile'			=>      trim($this->filter->injection_html($this->input->post('mobile_shop'))),
				                    'sho_email'      		=>      trim($this->filter->injection_html($this->input->post('email_shop'))),
				                    'sho_yahoo'         	=>      trim($this->filter->injection_html($this->input->post('yahoo_shop'))),
	                                'sho_skype'      		=>      trim($this->filter->injection_html($this->input->post('skype_shop'))),
	                                'sho_website'      		=>      trim($this->filter->injection_html($this->filter->link($this->input->post('website_shop')))),
	                                'sho_style'      		=>      trim($this->filter->injection_html($this->input->post('style_shop'))),
	                                'sho_saleoff'      		=>      $saleoff_shop,
	                                'sho_status'      		=>      $active_shop,
	                                'sho_user'      		=>      (int)$this->input->post('username_shop'),
	                                'sho_enddate'      		=>      $enddate_shop
									);
				if($this->shop_model->update($dataEdit, "sho_id = ".(int)$id))
				{
					#BEGIN: Update enddate user
					$this->user_model->update(array('use_enddate'=>$enddate_shop), "use_id = ".(int)$this->input->post('username_shop'));
					#END Update enddate user
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				redirect(base_url().'administ/shop/edit/'.$id, 'location');
			}
			else
	        {
				$data['link_shop'] = $shop->sho_link;
				$data['username_shop'] = $shop->sho_user;
				$data['name_shop'] = $shop->sho_name;
				$data['descr_shop'] = $shop->sho_descr;
				$data['address_shop'] = $shop->sho_address;
				$data['category_shop'] = $shop->sho_category;
				$data['province_shop'] = $shop->sho_province;
				$data['phone_shop'] = $shop->sho_phone;
				$data['mobile_shop'] = $shop->sho_mobile;
				$data['email_shop'] = $shop->sho_email;
				$data['yahoo_shop'] = $shop->sho_yahoo;
				$data['skype_shop'] = $shop->sho_skype;
				$data['website_shop'] = $shop->sho_website;
				$data['style_shop'] = $shop->sho_style;
				$data['saleoff_shop'] = $shop->sho_saleoff;
				$data['endday_shop'] = date('d', $shop->sho_enddate);
				$data['endmonth_shop'] = date('m', $shop->sho_enddate);
				$data['endyear_shop'] = date('Y', $shop->sho_enddate);
				$data['active_shop'] = $shop->sho_status;
	        }
        }
		#Load view
		$this->load->view('admin/shop/edit', $data);
	}
	
	function _exist_shop()
	{
        if(count($this->shop_model->get("sho_id", "sho_name = '".trim($this->filter->injection_html($this->input->post('name_shop')))."'")) > 0)
		{
			return false;
		}
		return true;
	}
	
	function _exist_username()
	{
        if(count($this->shop_model->get("sho_id", "sho_user = '".(int)$this->input->post('username_shop')."'")) > 0)
		{
			return false;
		}
		return true;
	}
	
	function _exist_link()
	{
        if(count($this->shop_model->get("sho_id", "sho_link = '".trim(strtolower($this->filter->injection_html($this->input->post('link_shop'))))."'")) > 0)
		{
			return false;
		}
		return true;
	}
	
	function _valid_link($str)
	{
		$reject = array('home', 'product', 'ads', 'job', 'employ', 'defaults', 'shop', 'notify', 'guide', 'add', 'activation', 'post', 'delete', 'edit', 'view', 'register', 'login', 'showcart', 'forgot', 'status', 'sort', 'by', 'contact', 'search', 'account', 'logout', 'adm', 'admi', 'admin', 'admini', 'adminis', 'administ', 'administr', 'administra', 'administrat', 'administrato', 'administrator', 'quantri', 'system', 'media', 'templates', 'index', 'robots', '.htaccess', 'application', 'language', 'vietnamese', 'english', 'model', 'database', 'view', 'js', 'images', 'banners', 'logos');
        foreach($reject as $rejectArray)
        {
			if(trim(strtolower($str)) == $rejectArray)
			{
				return false;
			}
        }
		return true;
	}
	
	function _is_phone($str)
	{
		if($this->check->is_phone($str))
		{
			return true;
		}
		return false;
	}
	
	function _valid_website($str)
	{
        if(preg_match('/[^0-9a-z_.-]/i', $str))
		{
			return false;
		}
		return true;
	}

	function _valid_enddate()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$endDate = mktime(0, 0, 0, (int)$this->input->post('endmonth_shop'), (int)$this->input->post('endday_shop'), (int)$this->input->post('endyear_shop'));
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
}