<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Category extends Controller
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
		$this->lang->load('admin/category');
		#Load model
		$this->load->model('category_model');
	}
	
	function index()
	{
        #BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_delete'))
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
			$this->load->model('shop_model');
			$this->load->model('showcart_model');
			$this->load->model('menu_model');
			$idCategory = $this->input->post('checkone');
			$listIdCategory = implode(',', $idCategory);
			#Get id product
			$product = $this->product_model->fetch("pro_id, pro_image, pro_dir", "pro_category IN($listIdCategory)", "", "");
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
			$ads = $this->ads_model->fetch("ads_id, ads_image, ads_dir", "ads_category IN($listIdCategory)", "", "");
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
			#Delete product
			if(count($idProduct) > 0)
			{
                $this->product_favorite_model->delete($idProduct, "prf_product");
                $this->product_comment_model->delete($idProduct, "prc_product");
                $this->product_bad_model->delete($idProduct, "prb_product");
			}
			$this->product_model->delete($idCategory, "pro_category");
			#Delete ads
			if(count($idAds) > 0)
			{
                $this->ads_favorite_model->delete($idAds, "adf_ads");
                $this->ads_comment_model->delete($idAds, "adc_ads");
                $this->ads_bad_model->delete($idAds, "adb_ads");
			}
			$this->ads_model->delete($idCategory, "ads_category");
			#Delete shop
			#Remove image
			$shop = $this->shop_model->fetch("sho_logo, sho_dir_logo, sho_banner, sho_dir_banner", "sho_category IN($listIdCategory)", "", "");
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
			$this->shop_model->delete($idCategory, "sho_category");
			#Delete showcart
			if(count($idProduct) > 0)
			{
				$this->showcart_model->delete($idProduct, "shc_product");
			}
			#Delete menu
			$this->menu_model->delete($idCategory, "men_category");
			#Delete category
			$this->category_model->delete($idCategory, "cat_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_view'))
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
				    $where .= "cat_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "cat_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "cat_status = 0";
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
				    $sort .= "cat_name";
				    break;
				case 'order':
				    $pageUrl .= '/sort/order';
				    $sort .= "cat_order";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "cat_id";
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
		$data['sortUrl'] = base_url().'administ/category'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/category'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->load->model('menu_model');
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->category_model->update(array('cat_status'=>1), "cat_id = ".(int)$getVar['id']);
				    $this->menu_model->update(array('men_status'=>1), "men_category = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->category_model->update(array('cat_status'=>0), "cat_id = ".(int)$getVar['id']);
				    $this->menu_model->update(array('men_status'=>0), "men_category = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->category_model->fetch("cat_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/category'.$pageUrl.'/page/';
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
		$select = "*";
		$limit = Setting::settingOtherAdmin;
		$data['category'] = $this->category_model->fetch($select, $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/category/defaults', $data);
	}
	
	function add()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_add'))
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
            #BEGIN: Load image category
            $this->load->library('file');
			$imageCategory = $this->category_model->fetch("cat_image", "", "", "");
			$usedImage = array();
			foreach($imageCategory as $imageCategoryArray)
			{
				$usedImage[] = $imageCategoryArray->cat_image;
			}
			$usedImage = array_merge($usedImage, array('index.html'));
			$data['image'] = $this->file->load('templates/home/images/category', $usedImage);
            #END Load image category
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('name_category', 'lang:name_label_add', 'trim|required|callback__exist_category');
            $this->form_validation->set_rules('descr_category', 'lang:descr_label_add', 'trim|required');
            $this->form_validation->set_rules('image_category', 'lang:image_label_add', 'required');
            $this->form_validation->set_rules('order_category', 'lang:order_label_add', 'trim|required|is_natural_no_zero');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message_add'));
			$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                if($this->input->post('active_category') == '1')
				{
	                $active_category = 1;
				}
				else
				{
	                $active_category = 0;
				}
				$dataAdd = array(
				                    'cat_name'      	=>      trim($this->filter->injection_html($this->input->post('name_category'))),
				                    'cat_descr'      	=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_category')))),
				                    'cat_image'			=>      $this->filter->injection($this->input->post('image_category')),
				                    'cat_order'         =>      (int)$this->input->post('order_category'),
	                                'cat_status'      	=>      $active_category
									);
				if($this->category_model->add($dataAdd))
				{
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/category/add', 'location');
			}
			else
	        {
				$data['name_category'] = $this->input->post('name_category');
				$data['descr_category'] = $this->input->post('descr_category');
				$data['image_category'] = $this->input->post('image_category');
				$data['order_category'] = $this->input->post('order_category');
				$data['active_category'] = $this->input->post('active_category');
	        }
        }
		#Load view
		$this->load->view('admin/category/add', $data);
	}
	
	function edit($id)
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_edit'))
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
            #BEGIN: Get category by $id
			$category = $this->category_model->get("*", "cat_id = ".(int)$id);
			if(count($category) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/category', 'location');
				die();
			}
			#END Get category by $id
			#BEGIN: Load image category
            $this->load->library('file');
			$imageCategory = $this->category_model->fetch("cat_image", "", "", "");
			$usedImage = array();
			foreach($imageCategory as $imageCategoryArray)
			{
				$usedImage[] = $imageCategoryArray->cat_image;
			}
			$usedImage = array_merge($usedImage, array('index.html'));
			$data['image'] = array_merge($this->file->load('templates/home/images/category', $usedImage), array($category->cat_image));
            #END Load image category
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('descr_category', 'lang:descr_label_edit', 'trim|required');
            $this->form_validation->set_rules('image_category', 'lang:image_label_edit', 'required');
            $this->form_validation->set_rules('order_category', 'lang:order_label_edit', 'trim|required|is_natural_no_zero');
            #Expand
            if($category->cat_name != trim($this->filter->injection_html($this->input->post('name_category'))))
            {
                $this->form_validation->set_rules('name_category', 'lang:name_label_edit', 'trim|required|callback__exist_category');
            }
            else
            {
                $this->form_validation->set_rules('name_category', 'lang:name_label_edit', 'trim|required');
            }
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message_edit'));
			$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                if($this->input->post('active_category') == '1')
				{
	                $active_category = 1;
				}
				else
				{
	                $active_category = 0;
				}
				$dataEdit = array(
				                    'cat_name'      	=>      trim($this->filter->injection_html($this->input->post('name_category'))),
				                    'cat_descr'      	=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_category')))),
				                    'cat_image'			=>      $this->filter->injection($this->input->post('image_category')),
				                    'cat_order'         =>      (int)$this->input->post('order_category'),
	                                'cat_status'      	=>      $active_category
									);
				if($this->category_model->update($dataEdit, "cat_id = ".(int)$id))
				{
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				redirect(base_url().'administ/category/edit/'.$id, 'location');
			}
			else
	        {
				$data['name_category'] = $category->cat_name;
				$data['descr_category'] = $category->cat_descr;
				$data['image_category'] = $category->cat_image;
				$data['order_category'] = $category->cat_order;
				$data['active_category'] = $category->cat_status;
	        }
        }
		#Load view
		$this->load->view('admin/category/edit', $data);
	}
	
	function _exist_category()
	{
        if(count($this->category_model->get("cat_id", "cat_name = '".trim($this->filter->injection_html($this->input->post('name_category')))."'")) > 0)
		{
			return false;
		}
		return true;
	}
}