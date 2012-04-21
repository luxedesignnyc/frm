<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class User extends Controller
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
		$this->lang->load('admin/user');
		#Load model
		$this->load->model('user_model');
		#BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->load->library('file');
			$this->load->model('product_model');
			$this->load->model('product_favorite_model');
			$this->load->model('product_comment_model');
			$this->load->model('product_bad_model');
			$this->load->model('ads_model');
			$this->load->model('ads_favorite_model');
			$this->load->model('ads_comment_model');
			$this->load->model('ads_bad_model');
			$this->load->model('job_model');
			$this->load->model('job_favorite_model');
			$this->load->model('job_bad_model');
			$this->load->model('employ_model');
			$this->load->model('employ_favorite_model');
			$this->load->model('employ_bad_model');
			$this->load->model('shop_model');
			$this->load->model('contact_model');
			$this->load->model('showcart_model');
			$idUser = $this->input->post('checkone');
			$listIdUser = implode(',', $idUser);
			#Get id product
			$product = $this->product_model->fetch("pro_id, pro_image, pro_dir", "pro_user IN($listIdUser)", "", "");
			$idProduct = array();
			foreach($product as $productArray)
			{
				$idProduct[] = $productArray->pro_id;
				#Remove image
				if($productArray->pro_image != 'none.gif')
				{
					$imageArray = explode(',', $productArray->pro_image);
                    foreach($imageArray as $imageArrays)
                    {
					   if(trim($imageArrays) != '' && file_exists('media/images/product/'.$productArray->pro_dir.'/'.$imageArrays))
    				    {
    						@unlink('media/images/product/'.$productArray->pro_dir.'/'.$imageArrays);
  						}
                    }
                    for($i = 1; $i <= 3; $i++)
                    {
                        if(file_exists('media/images/product/'.$productArray->pro_dir.'/thumbnail_'.$i.'_'.$imageArray[0]))
                        {
                            @unlink('media/images/product/'.$productArray->pro_dir.'/thumbnail_'.$i.'_'.$imageArray[0]);
                        }
                    }
					if(trim($productArray->pro_dir) != '' && is_dir('media/images/product/'.$productArray->pro_dir) && count($this->file->load('media/images/product/'.$productArray->pro_dir, 'index.html')) == 0)
					{
						if(file_exists('media/images/product/'.$productArray->pro_dir.'/index.html'))
						{
							@unlink('media/images/product/'.$productArray->pro_dir.'/index.html');
						}
						@rmdir('media/images/product/'.$productArray->pro_dir);
					}
				}
			}
			#Get id ads
			$ads = $this->ads_model->fetch("ads_id, ads_image, ads_dir", "ads_user IN($listIdUser)", "", "");
			$idAds = array();
			foreach($ads as $adsArray)
			{
				$idAds[] = $adsArray->ads_id;
				#Remove image
				if($adsArray->ads_image != 'none.gif')
				{
					if(trim($adsArray->ads_image) != '' && file_exists('media/images/ads/'.$adsArray->ads_dir.'/'.$adsArray->ads_image))
					{
						@unlink('media/images/ads/'.$adsArray->ads_dir.'/'.$adsArray->ads_image);
                        if(file_exists('media/images/ads/'.$adsArray->ads_dir.'/thumbnail_3_'.$adsArray->ads_image))
                        {
                            @unlink('media/images/ads/'.$adsArray->ads_dir.'/thumbnail_3_'.$adsArray->ads_image);
                        }
					}
					if(trim($adsArray->ads_dir) != '' && is_dir('media/images/ads/'.$adsArray->ads_dir) && count($this->file->load('media/images/ads/'.$adsArray->ads_dir, 'index.html')) == 0)
					{
						if(file_exists('media/images/ads/'.$adsArray->ads_dir.'/index.html'))
						{
							@unlink('media/images/ads/'.$adsArray->ads_dir.'/index.html');
						}
						@rmdir('media/images/ads/'.$adsArray->ads_dir);
					}
				}
			}
			#Get id job
			$job = $this->job_model->fetch("job_id", "job_user IN($listIdUser)", "", "");
			$idJob = array();
			foreach($job as $jobArray)
			{
				$idJob[] = $jobArray->job_id;
			}
			#Get id employ
			$employ = $this->employ_model->fetch("emp_id", "emp_user IN($listIdUser)", "", "");
			$idEmploy = array();
			foreach($employ as $employArray)
			{
				$idEmploy[] = $employArray->emp_id;
			}
			#Delete product
			if(count($idProduct) > 0)
			{
                $this->product_favorite_model->delete($idProduct, "prf_product");
                $this->product_comment_model->delete($idProduct, "prc_product");
                $this->product_bad_model->delete($idProduct, "prb_product");
			}
			$this->product_favorite_model->delete($idUser, "prf_user");
			$this->product_comment_model->delete($idUser, "prc_user");
			$this->product_model->delete($idUser, "pro_user");
			#Delete ads
			if(count($idAds) > 0)
			{
                $this->ads_favorite_model->delete($idAds, "adf_ads");
                $this->ads_comment_model->delete($idAds, "adc_ads");
                $this->ads_bad_model->delete($idAds, "adb_ads");
			}
			$this->ads_favorite_model->delete($idUser, "adf_user");
			$this->ads_comment_model->delete($idUser, "adc_user");
			$this->ads_model->delete($idUser, "ads_user");
			#Delete job
			if(count($idJob) > 0)
			{
                $this->job_favorite_model->delete($idJob, "jof_job");
                $this->job_bad_model->delete($idJob, "jba_job");
			}
			$this->job_favorite_model->delete($idUser, "jof_user");
			$this->job_model->delete($idUser, "job_user");
			#Delete employ
			if(count($idEmploy) > 0)
			{
                $this->employ_favorite_model->delete($idEmploy, "emf_employ");
                $this->employ_bad_model->delete($idEmploy, "emb_employ");
			}
			$this->employ_favorite_model->delete($idUser, "emf_user");
			$this->employ_model->delete($idUser, "emp_user");
			#Delete shop
			#Remove image
			$shop = $this->shop_model->fetch("sho_logo, sho_dir_logo, sho_banner, sho_dir_banner", "sho_user IN($listIdUser)", "", "");
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
			$this->shop_model->delete($idUser, "sho_user");
			#Delete contact
			$this->contact_model->delete($idUser, "con_user");
			#Delete showcart
			if(count($idProduct) > 0)
			{
				$this->showcart_model->delete($idProduct, "shc_product");
			}
			$this->showcart_model->delete($idUser, "shc_saler");
			$this->showcart_model->delete($idUser, "shc_buyer");
			#Delete user
			$this->user_model->delete($idUser, "use_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
	}
	
	function index()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= "use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= "use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= "use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= "use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "use_status = 0";
				    break;
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= "use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= "use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= "use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= "use_group = 1";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
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
		$data['sortUrl'] = base_url().'administ/user'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_group, use_address, use_phone, use_yahoo, gro_name, use_status, use_regisdate, use_enddate";
		$limit = Setting::settingOtherAdmin;
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/user/defaults', $data);
	}
	
	function end()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Update status = deactive
		if(!isset($_COOKIE['_cookieSetStatus']) || (isset($_COOKIE['_cookieSetStatus']) && !stristr(strtolower($_COOKIE['_cookieSetStatus']), 'user')))
		{
            $this->user_model->update(array('use_status'=>0), "use_enddate < $currentDate");
            if(isset($_COOKIE['_cookieSetStatus']))
            {
                setcookie('_cookieSetStatus', $_COOKIE['_cookieSetStatus'].'-user');
            }
            else
            {
                setcookie('_cookieSetStatus', 'user');
            }
		}
		#END Update status = deactive
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = "use_enddate < $currentDate";
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= " AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND use_status = 0";
				    break;
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= " AND use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= " AND use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= " AND use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= " AND use_group = 1";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
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
		$data['sortUrl'] = base_url().'administ/user/end'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/end'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_group, use_address, use_phone, use_yahoo, gro_name, use_status, use_regisdate, use_enddate";
		$limit = Setting::settingOtherAdmin;
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/user/end', $data);
	}
	
	function inactive()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$lockAccount = Setting::settingLockAccount * 3600 * 24;
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = "$currentDate - use_lastest_login > $lockAccount";
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'lastestlogin':
				    $sortUrl .= '/filter/lastestlogin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/lastestlogin/key/'.$getVar['key'];
				    $where .= " AND use_lastest_login = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND use_status = 0";
				    break;
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= " AND use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= " AND use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= " AND use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= " AND use_group = 1";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
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
		$data['sortUrl'] = base_url().'administ/user/inactive'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/inactive'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/inactive'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_email, use_group, gro_name, use_status, use_regisdate, use_enddate, use_lastest_login";
		$limit = Setting::settingOtherAdmin;
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/user/inactive', $data);
	}
	
	function vip()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = "use_group = 2";
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= " AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND use_status = 0";
				    break;
                case 'setenddate':
				    $sortUrl .= '/filter/setenddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/setenddate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate < use_enddate";
				    break;
                case 'notsetenddate':
				    $sortUrl .= '/filter/notsetenddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/notsetenddate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = use_enddate";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
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
		$data['sortUrl'] = base_url().'administ/user/vip'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/vip'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/vip'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_address, use_phone, use_yahoo, use_status, use_regisdate, use_enddate";
		$limit = Setting::settingOtherAdmin;
		$data['user'] = $this->user_model->fetch($select, $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/user/vip', $data);
	}
	
	function endvip()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Update status = deactive
		if(!isset($_COOKIE['_cookieSetStatus']) || (isset($_COOKIE['_cookieSetStatus']) && !stristr(strtolower($_COOKIE['_cookieSetStatus']), 'vip')))
		{
            $this->user_model->update(array('use_status'=>0), "use_enddate < $currentDate");
            if(isset($_COOKIE['_cookieSetStatus']))
            {
                setcookie('_cookieSetStatus', $_COOKIE['_cookieSetStatus'].'-vip');
            }
            else
            {
                setcookie('_cookieSetStatus', 'vip');
            }
		}
		#END Update status = deactive
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(5, $action);
		#BEGIN: Search & Filter
		$where = "use_group = 2 AND use_regisdate < use_enddate AND use_enddate < $currentDate";
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= " AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND use_status = 0";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
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
		$data['sortUrl'] = base_url().'administ/user/vip/end'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/vip/end'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_address, use_phone, use_yahoo, use_status, use_regisdate, use_enddate";
		$limit = Setting::settingOtherAdmin;
		$data['user'] = $this->user_model->fetch($select, $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/user/endvip', $data);
	}
	
	function saler()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = "use_group = 3";
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= " AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'shop':
				    $sortUrl .= '/search/shop/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/shop/keyword/'.$getVar['keyword'];
				    $where .= " AND sho_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND use_status = 0";
				    break;
                case 'haveshop':
				    $sortUrl .= '/filter/haveshop/key/'.$getVar['key'];
				    $pageUrl .= '/filter/haveshop/key/'.$getVar['key'];
				    $where .= " AND sho_name != ''";
				    break;
                case 'notshop':
				    $sortUrl .= '/filter/notshop/key/'.$getVar['key'];
				    $pageUrl .= '/filter/notshop/key/'.$getVar['key'];
				    $where .= " AND sho_name is null";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
                case 'shop':
				    $pageUrl .= '/sort/shop';
				    $sort .= "sho_name";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
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
		$data['sortUrl'] = base_url().'administ/user/saler'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/saler'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch_join("use_id", "LEFT", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", $where, "", "", -1, 0, true));
        $config['base_url'] = base_url().'administ/user/saler'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_address, use_phone, use_yahoo, use_status, use_regisdate, use_enddate, sho_name, sho_link";
		$limit = Setting::settingOtherAdmin;
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", $where, $sort, $by, $start, $limit, true);
		#Load view
		$this->load->view('admin/user/saler', $data);
	}
	
	function endsaler()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Update status = deactive
		if(!isset($_COOKIE['_cookieSetStatus']) || (isset($_COOKIE['_cookieSetStatus']) && !stristr(strtolower($_COOKIE['_cookieSetStatus']), 'saler')))
		{
            $this->user_model->update(array('use_status'=>0), "use_enddate < $currentDate");
            if(isset($_COOKIE['_cookieSetStatus']))
            {
                setcookie('_cookieSetStatus', $_COOKIE['_cookieSetStatus'].'-saler');
            }
            else
            {
                setcookie('_cookieSetStatus', 'saler');
            }
		}
		#END Update status = deactive
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(5, $action);
		#BEGIN: Search & Filter
		$where = "use_group = 3 AND use_regisdate < use_enddate AND use_enddate < $currentDate";
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= " AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'shop':
				    $sortUrl .= '/search/shop/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/shop/keyword/'.$getVar['keyword'];
				    $where .= " AND sho_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND use_status = 0";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
                case 'shop':
				    $pageUrl .= '/sort/shop';
				    $sort .= "sho_name";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
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
		$data['sortUrl'] = base_url().'administ/user/saler/end'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch_join("use_id", "LEFT", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", $where, "", "", -1, 0, true));
        $config['base_url'] = base_url().'administ/user/saler/end'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_address, use_phone, use_yahoo, use_status, use_regisdate, use_enddate, sho_name, sho_link";
		$limit = Setting::settingOtherAdmin;
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", $where, $sort, $by, $start, $limit, true);
		#Load view
		$this->load->view('admin/user/endsaler', $data);
	}
	
	function add()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_add'))
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
			#BEGIN: Fetch data
			$this->load->model('province_model');
			$data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
			$this->load->model('group_model');
			$data['group'] = $this->group_model->fetch("gro_id, gro_name", "gro_status = 1", "gro_order", "ASC");
			#END Fetch data
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
            $this->form_validation->set_rules('username_user', 'lang:username_label_add', 'trim|required|alpha_dash|min_length[6]|max_length[35]|callback__exist_username');
            $this->form_validation->set_rules('password_user', 'lang:password_label_add', 'trim|required|min_length[6]|max_length[35]');
            $this->form_validation->set_rules('repassword_user', 'lang:repassword_label_add', 'trim|required|matches[password_user]');
            $this->form_validation->set_rules('email_user', 'lang:email_label_add', 'trim|required|valid_email|callback__exist_email');
            $this->form_validation->set_rules('reemail_user', 'lang:reemail_label_add', 'trim|required|matches[email_user]');
            $this->form_validation->set_rules('fullname_user', 'lang:fullname_label_add', 'trim|required');
            $this->form_validation->set_rules('address_user', 'lang:address_label_add', 'trim|required');
            $this->form_validation->set_rules('phone_user', 'lang:phone_label_add', 'trim|required|callback__is_phone');
            $this->form_validation->set_rules('mobile_user', 'lang:mobile_label_add', 'trim|callback__is_phone');
            $this->form_validation->set_rules('yahoo_user', 'lang:yahoo_label_add', 'trim|callback__valid_nick');
            $this->form_validation->set_rules('skype_user', 'lang:skype_label_add', 'trim|callback__valid_nick');
            $this->form_validation->set_rules('endday_user', 'lang:endday_label_add', 'callback__valid_enddate');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('alpha_dash', $this->lang->line('alpha_dash_message'));
			$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
			$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
			$this->form_validation->set_message('matches', $this->lang->line('matches_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('_exist_username', $this->lang->line('_exist_username_message_add'));
			$this->form_validation->set_message('_exist_email', $this->lang->line('_exist_email_message_add'));
			$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
            $this->form_validation->set_message('_valid_nick', $this->lang->line('_valid_nick_message'));
			$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				$this->load->library('hash');
                $salt = $this->hash->key(8);
				if($this->input->post('active_user') == '1')
				{
	                $active_user = 1;
				}
				else
				{
	                $active_user = 0;
				}
				$regisdate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
				if($this->input->post('role_user') == '4')
				{
	                $enddate = mktime(0, 0, 0, date('m'), date('d'), 2035);
				}
				elseif($this->input->post('role_user') == '3')
				{
					$enddate = $regisdate;
				}
				elseif($this->input->post('role_user') == '2')
				{
					$enddate = mktime(0, 0, 0, (int)$this->input->post('endmonth_user'), (int)$this->input->post('endday_user'), (int)$this->input->post('endyear_user'));
				}
				else
				{
					$enddate = mktime(0, 0, 0, date('m'), date('d'), (int)date('Y')+10);
				}
				$lastest_login = $regisdate;
				$dataAdd = array(
				                    'use_username'      =>      trim(strtolower($this->filter->injection_html($this->input->post('username_user')))),
				                    'use_password'      =>      $this->hash->create($this->input->post('password_user'), $salt, 'md5sha512'),
				                    'use_salt'          =>      $salt,
				                    'use_email'         =>      trim(strtolower($this->filter->injection_html($this->input->post('email_user')))),
				                    'use_fullname'      =>      trim($this->filter->injection_html($this->input->post('fullname_user'))),
	                                'use_birthday'      =>      mktime(0, 0, 0, (int)$this->input->post('month_user'), (int)$this->input->post('day_user'), (int)$this->input->post('year_user')),
	                                'use_sex'           =>      (int)$this->input->post('sex_user'),
	                                'use_address'       =>      trim($this->filter->injection_html($this->input->post('address_user'))),
	                                'use_province'      =>      (int)$this->input->post('province_user'),
	                                'use_phone'         =>      trim($this->filter->injection_html($this->input->post('phone_user'))),
	                                'use_mobile'        =>      trim($this->filter->injection_html($this->input->post('mobile_user'))),
	                                'use_yahoo'         =>      trim($this->filter->injection_html($this->input->post('yahoo_user'))),
	                                'use_skype'         =>      trim($this->filter->injection_html($this->input->post('skype_user'))),
	                                'use_group'         =>      (int)$this->input->post('role_user'),
	                                'use_status'        =>      $active_user,
	                                'use_regisdate'     =>      $regisdate,
	                                'use_enddate'       =>      $enddate,
	                                'use_key'           =>      $this->hash->create($this->input->post('username_user'), $this->input->post('email_user'), 'sha256md5'),
	                                'use_lastest_login' =>      $lastest_login
									);
				if($this->user_model->add($dataAdd))
				{
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/user/add', 'location');
			}
			else
	        {
				$data['username_user'] = $this->input->post('username_user');
				$data['email_user'] = $this->input->post('email_user');
				$data['reemail_user'] = $this->input->post('reemail_user');
				$data['fullname_user'] = $this->input->post('fullname_user');
				$data['day_user'] = $this->input->post('day_user');
				$data['month_user'] = $this->input->post('month_user');
				$data['year_user'] = $this->input->post('year_user');
				$data['sex_user'] = $this->input->post('sex_user');
				$data['address_user'] = $this->input->post('address_user');
				$data['province_user'] = $this->input->post('province_user');
				$data['phone_user'] = $this->input->post('phone_user');
				$data['mobile_user'] = $this->input->post('mobile_user');
				$data['yahoo_user'] = $this->input->post('yahoo_user');
				$data['skype_user'] = $this->input->post('skype_user');
				$data['role_user'] = $this->input->post('role_user');
				$data['endday_user'] = $this->input->post('endday_user');
				$data['endmonth_user'] = $this->input->post('endmonth_user');
				$data['endyear_user'] = $this->input->post('endyear_user');
				$data['active_user'] = $this->input->post('active_user');
	        }
        }
		#Load view
		$this->load->view('admin/user/add', $data);
	}
	
	function edit($id)
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
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
			#BEGIN: Fetch data
			$this->load->model('province_model');
			$data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
			$this->load->model('group_model');
			$data['group'] = $this->group_model->fetch("gro_id, gro_name", "gro_status = 1", "gro_order", "ASC");
			#END Fetch data
			#BEGIN: Get user by $id
			$user = $this->user_model->get("*", "use_id = ".(int)$id);
			if(count($user) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/user', 'location');
				die();
			}
			#END Get user by $id
			#Set sessionUser
			if($this->session->userdata('sessionUserAdmin') == $user->use_id)
			{
				$data['userLogined'] = true;
			}
			else
			{
                $data['userLogined'] = false;
			}
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
   			$this->form_validation->set_rules('reemail_user', 'lang:reemail_label_edit', 'trim|required|matches[email_user]');
			$this->form_validation->set_rules('fullname_user', 'lang:fullname_label_edit', 'trim|required');
			$this->form_validation->set_rules('address_user', 'lang:address_label_edit', 'trim|required');
			$this->form_validation->set_rules('phone_user', 'lang:phone_label_edit', 'trim|required|callback__is_phone');
			$this->form_validation->set_rules('mobile_user', 'lang:mobile_label_edit', 'trim|callback__is_phone');
			$this->form_validation->set_rules('yahoo_user', 'lang:yahoo_label_edit', 'trim|callback__valid_nick');
			$this->form_validation->set_rules('skype_user', 'lang:skype_label_edit', 'trim|callback__valid_nick');
			$this->form_validation->set_rules('endday_user', 'lang:endday_label_edit', 'callback__valid_enddate');
			#Expand
            if($user->use_username != trim(strtolower($this->filter->injection_html($this->input->post('username_user')))))
			{
                $this->form_validation->set_rules('username_user', 'lang:username_label_edit', 'trim|required|alpha_dash|min_length[6]|max_length[35]|callback__exist_username');
			}
			else
			{
                $this->form_validation->set_rules('username_user', 'lang:username_label_edit', 'trim|required|alpha_dash|min_length[6]|max_length[35]');
			}
			if($this->input->post('password_user') && trim($this->input->post('password_user')) != '')
			{
                $this->form_validation->set_rules('password_user', 'lang:password_label_edit', 'trim|required|min_length[6]|max_length[35]');
                $this->form_validation->set_rules('repassword_user', 'lang:repassword_label_edit', 'trim|required|matches[password_user]');
				$changedPassword = true;
			}
			else
			{
                $this->form_validation->set_rules('password_user', 'lang:password_label_edit', '');
                $changedPassword = false;
			}
			if($user->use_email != trim(strtolower($this->filter->injection_html($this->input->post('email_user')))))
			{
                $this->form_validation->set_rules('email_user', 'lang:email_label_edit', 'trim|required|valid_email|callback__exist_email');
			}
			else
			{
                $this->form_validation->set_rules('email_user', 'lang:email_label_edit', 'trim|required|valid_email');
			}
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('alpha_dash', $this->lang->line('alpha_dash_message'));
			$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
			$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
			$this->form_validation->set_message('matches', $this->lang->line('matches_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('_exist_username', $this->lang->line('_exist_username_message_edit'));
			$this->form_validation->set_message('_exist_email', $this->lang->line('_exist_email_message_edit'));
			$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
            $this->form_validation->set_message('_valid_nick', $this->lang->line('_valid_nick_message'));
			$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                $this->load->library('hash');
				if($changedPassword == true)
				{
                    $salt = $this->hash->key(8);
                    $password_user = $this->hash->create($this->input->post('password_user'), $salt, 'md5sha512');
				}
				else
				{
                    $salt = $user->use_salt;
                    $password_user = $user->use_password;
				}
				if($this->input->post('active_user') == '1')
				{
	                $active_user = 1;
				}
				else
				{
	                $active_user = 0;
				}
				if($this->session->userdata('sessionUserAdmin') == $user->use_id)
				{
                    $active_user = 1;
				}
				$role_user = (int)$this->input->post('role_user');
				if($this->session->userdata('sessionUserAdmin') == $user->use_id)
				{
                    $role_user = $user->use_group;
				}
				if($this->input->post('role_user') == '4')
				{
	                $enddate = mktime(0, 0, 0, date('m'), date('d'), 2035);
				}
				elseif($this->input->post('role_user') == '3')
				{
					$enddate = $user->use_regisdate;
				}
				elseif($this->input->post('role_user') == '2')
				{
					$enddate = mktime(0, 0, 0, (int)$this->input->post('endmonth_user'), (int)$this->input->post('endday_user'), (int)$this->input->post('endyear_user'));
				}
				else
				{
					$enddate = mktime(0, 0, 0, date('m'), date('d'), (int)date('Y')+10);
				}
				if($this->session->userdata('sessionUserAdmin') == $user->use_id)
				{
                    $enddate = $user->use_enddate;
				}
				$dataEdit = array(
				                    'use_username'      =>      trim(strtolower($this->filter->injection_html($this->input->post('username_user')))),
				                    'use_password'      =>      $password_user,
				                    'use_salt'          =>      $salt,
				                    'use_email'         =>      trim(strtolower($this->filter->injection_html($this->input->post('email_user')))),
				                    'use_fullname'      =>      trim($this->filter->injection_html($this->input->post('fullname_user'))),
	                                'use_birthday'      =>      mktime(0, 0, 0, (int)$this->input->post('month_user'), (int)$this->input->post('day_user'), (int)$this->input->post('year_user')),
	                                'use_sex'           =>      (int)$this->input->post('sex_user'),
	                                'use_address'       =>      trim($this->filter->injection_html($this->input->post('address_user'))),
	                                'use_province'      =>      (int)$this->input->post('province_user'),
	                                'use_phone'         =>      trim($this->filter->injection_html($this->input->post('phone_user'))),
	                                'use_mobile'        =>      trim($this->filter->injection_html($this->input->post('mobile_user'))),
	                                'use_yahoo'         =>      trim($this->filter->injection_html($this->input->post('yahoo_user'))),
	                                'use_skype'         =>      trim($this->filter->injection_html($this->input->post('skype_user'))),
	                                'use_group'         =>      $role_user,
	                                'use_status'        =>      $active_user,
	                                'use_enddate'       =>      $enddate
									);
				if($this->user_model->update($dataEdit, "use_id = ".(int)$id))
				{
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				redirect(base_url().'administ/user/edit/'.$id, 'location');
			}
			else
	        {
				$data['username_user'] = $user->use_username;
				$data['email_user'] = $user->use_email;
				$data['reemail_user'] = $user->use_email;
				$data['fullname_user'] = $user->use_fullname;
				$data['day_user'] = date('d', $user->use_birthday);
				$data['month_user'] = date('m', $user->use_birthday);
				$data['year_user'] = date('Y', $user->use_birthday);
				$data['sex_user'] = $user->use_sex;
				$data['address_user'] = $user->use_address;
				$data['province_user'] = $user->use_province;
				$data['phone_user'] = $user->use_phone;
				$data['mobile_user'] = $user->use_mobile;
				$data['yahoo_user'] = $user->use_yahoo;
				$data['skype_user'] = $user->use_skype;
				$data['role_user'] = $user->use_group;
				$data['endday_user'] = date('d', $user->use_enddate);
				$data['endmonth_user'] = date('m', $user->use_enddate);
				$data['endyear_user'] = date('Y', $user->use_enddate);
				$data['active_user'] = $user->use_status;
	        }
        }
		#Load view
		$this->load->view('admin/user/edit', $data);
	}
	
	function _exist_username()
	{
		if(count($this->user_model->get("use_id", "use_username = '".trim(strtolower($this->filter->injection_html($this->input->post('username_user'))))."'")) > 0)
		{
			return false;
		}
		return true;
	}
	
	function _exist_email()
	{
        if(count($this->user_model->get("use_id", "use_email = '".trim(strtolower($this->filter->injection_html($this->input->post('email_user'))))."'")) > 0)
		{
			return false;
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
	
	function _valid_enddate()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$endDate = mktime(0, 0, 0, (int)$this->input->post('endmonth_user'), (int)$this->input->post('endday_user'), (int)$this->input->post('endyear_user'));
		if($this->input->post('role_user') == '2' && $this->check->is_more($currentDate, $endDate))
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