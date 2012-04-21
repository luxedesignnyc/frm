<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Account extends Controller
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
		#BEGIN: CHECK LOGIN
		if(!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
		{
			redirect(base_url().'login', 'location');
			die();
		}
		#END CHECK LOGIN
		#Load language
		$this->lang->load('home/common');
		$this->lang->load('home/account');
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
		$data['menuSelected'] = 'index';
		$data['menuType'] = 'account';
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'account';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Load view
		$this->load->view('home/account/defaults/defaults', $data);
	}
	
	function edit()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Menu
		$data['menuSelected'] = 'edit';
		$data['menuType'] = 'account';
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'account';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#BEGIN: Unlink captcha
        $this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionPathCaptchaEditAccount'));
		#END Unlink captcha
        if($this->session->flashdata('sessionSuccessEditAccount'))
		{
            $data['successEditAccount'] = true;
		}
		else
		{
            if($this->input->post('isPostAccount') && time() - (int)$this->session->userdata('sessionTimePosted') <= (int)Setting::settingTimePost)
            {
                redirect(base_url().'account/edit', 'location');
				die();
            }
			$this->load->library('form_validation');
            $data['successEditAccount'] = false;
			#BEGIN: Fetch data
			$this->load->model('province_model');
			$data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
			#END Fetch data
			#BEGIN: Get user
			$this->load->model('user_model');
			$user = $this->user_model->get("*", "use_id = ".(int)$this->session->userdata('sessionUser')." AND use_status = 1 AND use_enddate >= $currentDate");
			if(count($user) != 1 || (int)$user->use_group > 3)
			{
				redirect(base_url().'account', 'location');
				die();
			}
			#END Get user
			#BEGIN: Set rules
			$this->form_validation->set_rules('reemail_account', 'lang:reemail_account_label_edit_account', 'trim|required|matches[email_account]');
			$this->form_validation->set_rules('fullname_account', 'lang:fullname_account_label_edit_account', 'trim|required');
			$this->form_validation->set_rules('address_account', 'lang:address_account_label_edit_account', 'trim|required');
			$this->form_validation->set_rules('province_account', 'lang:province_account_label_edit_account', 'trim|required|callback__exist_province');
			$this->form_validation->set_rules('phone_account', 'lang:phone_account_label_edit_account', 'trim|required|callback__is_phone');
			$this->form_validation->set_rules('mobile_account', 'lang:mobile_account_label_edit_account', 'trim|callback__is_phone');
			$this->form_validation->set_rules('yahoo_account', 'lang:yahoo_account_label_edit_account', 'trim|callback__valid_nick');
			$this->form_validation->set_rules('skype_account', 'lang:skype_account_label_edit_account', 'trim|callback__valid_nick');
			$this->form_validation->set_rules('captcha_account', 'lang:captcha_account_label_edit_account', 'required|callback__valid_captcha_edit');
			#Expand
			if($user->use_email != trim(strtolower($this->filter->injection_html($this->input->post('email_account')))))
			{
                $this->form_validation->set_rules('email_account', 'lang:email_account_label_edit_account', 'trim|required|valid_email|callback__exist_email_edit');
			}
			else
			{
                $this->form_validation->set_rules('email_account', 'lang:email_account_label_edit_account', 'trim|required|valid_email');
			}
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('_valid_nick', $this->lang->line('_valid_nick_message'));
			$this->form_validation->set_message('matches', $this->lang->line('matches_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message'));
			$this->form_validation->set_message('_exist_email_edit', $this->lang->line('_exist_email_edit_message_edit_account'));
			$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
			$this->form_validation->set_message('_valid_captcha_edit', $this->lang->line('_valid_captcha_edit_message_edit_account'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				if($this->input->post('sex_account') == '1')
				{
	                $sex_account = 1;
				}
				else
				{
	                $sex_account = 0;
				}
				$dataEdit = array(
				                    'use_email'         =>      trim(strtolower($this->filter->injection_html($this->input->post('email_account')))),
				                    'use_fullname'      =>      trim($this->filter->injection_html($this->input->post('fullname_account'))),
	                                'use_birthday'      =>      mktime(0, 0, 0, (int)$this->input->post('month_account'), (int)$this->input->post('day_account'), (int)$this->input->post('year_account')),
	                                'use_sex'           =>      $sex_account,
	                                'use_address'       =>      trim($this->filter->injection_html($this->input->post('address_account'))),
	                                'use_province'      =>      (int)$this->input->post('province_account'),
	                                'use_phone'         =>      trim($this->filter->injection_html($this->input->post('phone_account'))),
	                                'use_mobile'        =>      trim($this->filter->injection_html($this->input->post('mobile_account'))),
	                                'use_yahoo'         =>      trim($this->filter->injection_html($this->input->post('yahoo_account'))),
	                                'use_skype'         =>      trim($this->filter->injection_html($this->input->post('skype_account')))
									);
				if($this->user_model->update($dataEdit, "use_id = ".(int)$this->session->userdata('sessionUser')))
				{
     				$this->session->set_flashdata('sessionSuccessEditAccount', 1);
				}
				$this->session->set_userdata('sessionTimePosted', time());
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			else
	        {
				$data['username_account'] = $user->use_username;
				$data['email_account'] = $user->use_email;
				$data['reemail_account'] = $user->use_email;
				$data['fullname_account'] = $user->use_fullname;
				$data['day_account'] = date('d', $user->use_birthday);
				$data['month_account'] = date('m', $user->use_birthday);
				$data['year_account'] = date('Y', $user->use_birthday);
				$data['sex_account'] = $user->use_sex;
				$data['address_account'] = $user->use_address;
				$data['province_account'] = $user->use_province;
				$data['phone_account'] = $user->use_phone;
				$data['mobile_account'] = $user->use_mobile;
				$data['yahoo_account'] = $user->use_yahoo;
				$data['skype_account'] = $user->use_skype;
	        }
            #BEGIN: Create captcha
            $this->load->library('captcha');
  			$codeCaptcha = $this->captcha->code(6);
	        $this->session->set_flashdata('sessionCaptchaEditAccount', $codeCaptcha);
	        $imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.(int)$this->session->userdata('sessionUser').'edia.jpg';
	        $this->session->set_flashdata('sessionPathCaptchaEditAccount', $imageCaptcha);
			$this->captcha->create($codeCaptcha, $imageCaptcha);
			if(file_exists($imageCaptcha))
			{
				$data['imageCaptchaEditAccount'] = $imageCaptcha;
			}
			#END Create captcha
        }
		#Load view
		$this->load->view('home/account/defaults/edit', $data);
	}
	
	function changepassword()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Menu
		$data['menuSelected'] = 'changepassword';
		$data['menuType'] = 'account';
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'account';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#BEGIN: Unlink captcha
        $this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionPathCaptchaChangePasswordAccount'));
		#END Unlink captcha
        if($this->session->flashdata('sessionSuccessChangePasswordAccount'))
		{
            $data['successChangePasswordAccount'] = true;
		}
		else
		{
			$this->load->library('form_validation');
            $data['successChangePasswordAccount'] = false;
            if($this->input->post('captcha_changepass') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
            {
				#BEGIN: Set rules
				$this->form_validation->set_rules('oldpassword_changepass', 'lang:oldpassword_changepass_label_change_password', 'trim|required|callback__valid_old_password');
				$this->form_validation->set_rules('password_changepass', 'lang:password_changepass_label_change_password', 'trim|required|min_length[6]|max_length[35]');
				$this->form_validation->set_rules('repassword_changepass', 'lang:repassword_changepass_label_change_password', 'trim|required|matches[password_changepass]');
				$this->form_validation->set_rules('captcha_changepass', 'lang:captcha_changepass_label_change_password', 'required|callback__valid_captcha_changepassword');
				#END Set rules
				#BEGIN: Set message
				$this->form_validation->set_message('required', $this->lang->line('required_message'));
				$this->form_validation->set_message('matches', $this->lang->line('matches_message'));
				$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
				$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
				$this->form_validation->set_message('_valid_old_password', $this->lang->line('_valid_old_password_message_change_password'));
				$this->form_validation->set_message('_valid_captcha_changepassword', $this->lang->line('_valid_captcha_changepassword_message_change_password'));
				$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
				#END Set message
				if($this->form_validation->run() != FALSE)
				{
	                $this->load->library('hash');
	                $this->load->model('user_model');
	                $salt = $this->hash->key(8);
					$dataChange = array(
					                    'use_password'      =>      $this->hash->create($this->input->post('password_changepass'), $salt, 'md5sha512'),
					                    'use_salt'          =>      $salt
										);
					if($this->user_model->update($dataChange, "use_id = ".(int)$this->session->userdata('sessionUser')))
					{
	     				$this->session->set_flashdata('sessionSuccessChangePasswordAccount', 1);
					}
					$this->session->set_userdata('sessionTimePosted', time());
					redirect(base_url().trim(uri_string(), '/'), 'location');
				}
	        }
            #BEGIN: Create captcha
            $this->load->library('captcha');
  			$codeCaptcha = $this->captcha->code(6);
	        $this->session->set_flashdata('sessionCaptchaChangePasswordAccount', $codeCaptcha);
	        $imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.(int)$this->session->userdata('sessionUser').'chpa.jpg';
	        $this->session->set_flashdata('sessionPathCaptchaChangePasswordAccount', $imageCaptcha);
			$this->captcha->create($codeCaptcha, $imageCaptcha);
			if(file_exists($imageCaptcha))
			{
				$data['imageCaptchaChangePasswordAccount'] = $imageCaptcha;
			}
			#END Create captcha
        }
		#Load view
		$this->load->view('home/account/defaults/changepassword', $data);
	}
	
	function shop()
	{
        #BEGIN: CHECK GROUP
		if((int)$this->session->userdata('sessionGroup') != 3)
		{
			redirect(base_url().'account', 'location');
			die();
		}
		#END CHECK GROUP
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Menu
		$data['menuSelected'] = 'shop';
		$data['menuType'] = 'account';
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'account';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#BEGIN: Unlink captcha
        $this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionPathCaptchaEditShopAccount'));
		#END Unlink captcha
		if($this->session->flashdata('sessionSuccessEditShopAccount'))
		{
            $data['successEditShopAccount'] = true;
		}
		else
		{
            if($this->input->post('isPostShopAccount') && time() - (int)$this->session->userdata('sessionTimePosted') <= (int)Setting::settingTimePost)
            {
                redirect(base_url().'account/shop', 'location');
				die();
            }
			$this->load->model('shop_model');
            $data['successEditShopAccount'] = false;
            #BEGIN: Get shop
            $shop = $this->shop_model->get("*", "sho_user = ".(int)$this->session->userdata('sessionUser')." AND sho_status = 1 AND sho_enddate >= $currentDate");
            if(count($shop) != 1)
			{
				redirect(base_url().'account', 'location');
				die();
			}
            #END Get shop
            #BEGIN: Fetch province
            $this->load->model('province_model');
            $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
            #END Fetch province
            #BEGIN: Load style
            $this->load->library('folder');
			$data['style'] = $this->folder->load('templates/shop');
            #END Load style
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('descr_shop', 'lang:descr_shop_label_shop_account', 'trim|required');
            $this->form_validation->set_rules('address_shop', 'lang:address_shop_label_shop_account', 'trim|required');
            $this->form_validation->set_rules('province_shop', 'lang:province_shop_label_shop_account', 'required|callback__exist_province');
            $this->form_validation->set_rules('phone_shop', 'lang:phone_shop_label_shop_account', 'trim|required|callback__is_phone');
            $this->form_validation->set_rules('mobile_shop', 'lang:mobile_shop_label_shop_account', 'trim|callback__is_phone');
            $this->form_validation->set_rules('email_shop', 'lang:email_shop_label_shop_account', 'trim|required|valid_email');
            $this->form_validation->set_rules('yahoo_shop', 'lang:yahoo_shop_label_shop_account', 'trim|callback__valid_nick');
            $this->form_validation->set_rules('skype_shop', 'lang:skype_shop_label_shop_account', 'trim|callback__valid_nick');
            $this->form_validation->set_rules('website_shop', 'lang:website_shop_label_shop_account', 'callback__valid_website');
            $this->form_validation->set_rules('captcha_shop', 'lang:captcha_shop_label_shop_account', 'callback__valid_captcha_shop');
            #Expand
            if($shop->sho_link != trim(strtolower($this->filter->injection_html($this->input->post('link_shop')))))
            {
                $this->form_validation->set_rules('link_shop', 'lang:link_shop_label_shop_account', 'trim|required|alpha_dash|min_length[5]|max_length[50]|callback__exist_link_shop|callback__valid_link_shop');
            }
            else
            {
                $this->form_validation->set_rules('link_shop', 'lang:link_shop_label_shop_account', 'trim|required|alpha_dash|min_length[5]|max_length[50]|callback__valid_link_shop');
            }
            if($shop->sho_name != trim($this->filter->injection_html($this->input->post('name_shop'))))
            {
                $this->form_validation->set_rules('name_shop', 'lang:name_shop_label_shop_account', 'trim|required|callback__exist_shop');
            }
            else
            {
                $this->form_validation->set_rules('name_shop', 'lang:name_shop_label_shop_account', 'trim|required');
            }
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('alpha_dash', $this->lang->line('alpha_dash_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
			$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
			$this->form_validation->set_message('_exist_link_shop', $this->lang->line('_exist_link_shop_message_shop_account'));
			$this->form_validation->set_message('_valid_link_shop', $this->lang->line('_valid_link_shop_message_shop_account'));
			$this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message'));
			$this->form_validation->set_message('_exist_shop', $this->lang->line('_exist_shop_message_shop_account'));
			$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
			$this->form_validation->set_message('_valid_website', $this->lang->line('_valid_website_message'));
            $this->form_validation->set_message('_valid_nick', $this->lang->line('_valid_nick_message'));
			$this->form_validation->set_message('_valid_captcha_shop', $this->lang->line('_valid_captcha_shop_message_shop_account'));
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
				$config['max_size']	= 100;#KB
				$config['max_width']  = 800;#px
				$config['max_height']  = 800;#px
				$config['encrypt_name'] = true;
				$this->upload->initialize($config);
				if($this->upload->do_upload('logo_shop'))
				{
                    $uploadLogo = $this->upload->data();
                    if($uploadLogo['is_image'] == TRUE)
                    {
						if($shop->sho_logo != '' && file_exists($pathLogo.$dir_logo.'/'.$shop->sho_logo))
						{
							@unlink($pathLogo.$dir_logo.'/'.$shop->sho_logo);
						}
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
				if($isLogoUploaded == false)
				{
                    redirect(base_url().'account/shop', 'location');
                    die();
				}
				#END Upload logo
				if($this->input->post('saleoff_shop') == '1')
				{
	                $saleoff_shop = 1;
				}
				else
				{
	                $saleoff_shop = 0;
				}
				$dataEdit = array(
				                    'sho_name'      		=>      trim($this->filter->injection_html($this->input->post('name_shop'))),
				                    'sho_descr'      		=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_shop')))),
				                    'sho_link'				=>      trim(strtolower($this->filter->injection_html($this->input->post('link_shop')))),
				                    'sho_logo'         		=>      $logo_shop,
	                                'sho_dir_logo'      	=>      $dir_logo,
				                    'sho_address'			=>      trim($this->filter->injection_html($this->input->post('address_shop'))),
				                    'sho_province'     		=>      (int)$this->input->post('province_shop'),
				                    'sho_phone'      		=>      trim($this->filter->injection_html($this->input->post('phone_shop'))),
				                    'sho_mobile'			=>      trim($this->filter->injection_html($this->input->post('mobile_shop'))),
				                    'sho_email'      		=>      trim($this->filter->injection_html($this->input->post('email_shop'))),
				                    'sho_yahoo'         	=>      trim($this->filter->injection_html($this->input->post('yahoo_shop'))),
	                                'sho_skype'      		=>      trim($this->filter->injection_html($this->input->post('skype_shop'))),
	                                'sho_website'      		=>      trim($this->filter->injection_html($this->filter->link($this->input->post('website_shop')))),
	                                'sho_style'      		=>      trim($this->filter->injection_html($this->input->post('style_shop'))),
	                                'sho_saleoff'      		=>      $saleoff_shop
									);
				if($this->shop_model->update($dataEdit, "sho_user = ".(int)$this->session->userdata('sessionUser')))
				{
     				$this->session->set_flashdata('sessionSuccessEditShopAccount', 1);
				}
				$this->session->set_userdata('sessionTimePosted', time());
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			else
	        {
                $data['dir_logo_shop'] = $shop->sho_dir_logo;
                $data['logo_shop'] = $shop->sho_logo;
				$data['link_shop'] = $shop->sho_link;
				$data['name_shop'] = $shop->sho_name;
				$data['descr_shop'] = $shop->sho_descr;
				$data['address_shop'] = $shop->sho_address;
				$data['province_shop'] = $shop->sho_province;
				$data['phone_shop'] = $shop->sho_phone;
				$data['mobile_shop'] = $shop->sho_mobile;
				$data['email_shop'] = $shop->sho_email;
				$data['yahoo_shop'] = $shop->sho_yahoo;
				$data['skype_shop'] = $shop->sho_skype;
				$data['website_shop'] = $shop->sho_website;
				$data['style_shop'] = $shop->sho_style;
				$data['saleoff_shop'] = $shop->sho_saleoff;
	        }
            #BEGIN: Create captcha
            $this->load->library('captcha');
  			$codeCaptcha = $this->captcha->code(6);
	        $this->session->set_flashdata('sessionCaptchaEditShopAccount', $codeCaptcha);
	        $imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.(int)$this->session->userdata('sessionUser').'shoa.jpg';
	        $this->session->set_flashdata('sessionPathCaptchaEditShopAccount', $imageCaptcha);
			$this->captcha->create($codeCaptcha, $imageCaptcha);
			if(file_exists($imageCaptcha))
			{
				$data['imageCaptchaEditShopAccount'] = $imageCaptcha;
			}
			#END Create captcha
        }
		#Load view
		$this->load->view('home/account/shop/defaults', $data);
	}
	
	function notify()
	{
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Menu
		$data['menuSelected'] = 'notify';
		$data['menuType'] = 'account';
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'account';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		$userID = (int)$this->session->userdata('sessionUser');
		$data['userID'] = $userID;
        #Define url for $getVar
		$action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		if(strtolower($this->uri->segment(3)) == 'detail' && $getVar['detail'] != FALSE)
		{
			$notify = $this->notify_model->get("not_title, not_begindate, not_detail, not_group, not_view", "not_id = ".(int)$getVar['detail']." AND not_status = 1 AND not_enddate >= $currentDate");
			if(count($notify) == 1 && $this->check->is_id($getVar['detail']) && trim($notify->not_group) != '' && stristr($notify->not_group, (string)$this->session->userdata('sessionGroup')))
			{
                $this->load->library('bbcode');
				#BEGIN: Update view
				if(trim($notify->not_view) == '' || (trim($notify->not_view) != '' && !stristr($notify->not_view, "[$userID]")))
				{
					$this->notify_model->update(array('not_view'=>$notify->not_view."[$userID]"), "not_id = ".(int)$getVar['detail']);
				}
				#END Update view
				$data['notify'] = $notify;
				$this->load->view('home/account/notify/detail', $data);
			}
			else
			{
				redirect(base_url().'account/notify', 'location');
			}
		}
		else
		{
			#BEGIN: Fetch id notify for group
			$notify = $this->notify_model->fetch("not_id, not_group", "not_status = 1 AND not_enddate >= $currentDate");
			$notifyID = array();
			foreach($notify as $notifyArray)
			{
				if(trim($notifyArray->not_group) != '' && stristr($notifyArray->not_group, (string)$this->session->userdata('sessionGroup')))
				{
                    $notifyID[] = $notifyArray->not_id;
				}
			}
			if(count($notifyID) > 0)
			{
                $notifyID = implode(',', $notifyID);
			}
			else
			{
                $notifyID = '0';
			}
			#END Fetch id notify for group
            #BEGIN: Search & sort
			$where = "not_id IN($notifyID) AND not_status = 1 AND not_enddate >= $currentDate";
			$sort = 'not_id';
			$by = 'DESC';
			$sortUrl = '';
			$pageSort = '';
			$pageUrl = '';
			$keyword = '';
			if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
			{
	            $keyword = $this->filter->html($getVar['keyword']);
				switch(strtolower($getVar['search']))
				{
					case 'title':
					    $sortUrl .= '/search/title/keyword/'.$getVar['keyword'];
					    $pageUrl .= '/search/title/keyword/'.$getVar['keyword'];
					    $where .= " AND not_title LIKE '%".$this->filter->injection_html($getVar['keyword'])."%'";
					    break;
				}
			}
			#If have sort
			if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
			{
				switch(strtolower($getVar['sort']))
				{
					case 'title':
					    $pageUrl .= '/sort/title';
					    $sort = "not_title";
					    break;
	                case 'degree':
					    $pageUrl .= '/sort/degree';
					    $sort = "not_degree";
					    break;
	                case 'date':
					    $pageUrl .= '/sort/date';
					    $sort = "not_begindate";
					    break;
	                case 'view':
					    $pageUrl .= '/sort/view';
					    $sort = "not_view";
					    break;
					default:
					    $pageUrl .= '/sort/id';
					    $sort = "not_id";
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
			#END Search & sort
			#Keyword
			$data['keyword'] = $keyword;
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'account/notify'.$sortUrl.'/sort/';
			$data['pageSort'] = $pageSort;
			#END Create link sort
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->notify_model->fetch("not_id", $where, "", ""));
	        $config['base_url'] = base_url().'account/notify'.$pageUrl.'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = Setting::settingOtherAccount;
			$config['num_links'] = 1;
			$config['uri_segment'] = 4;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			#sTT - So thu tu
			$data['sTT'] = $start + 1;
			#Fetch record
			$select = "not_id, not_title, not_degree, not_begindate, not_view";
			$limit = Setting::settingOtherAccount;
			$data['notify'] = $this->notify_model->fetch($select, $where, $sort, $by, $start, $limit);
			#Load view
			$this->load->view('home/account/notify/defaults', $data);
		}
	}
	
	function contact()
	{
		$this->load->model('contact_model');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Menu 1
		$data['menuSelected'] = 'contact';
		$data['menuType'] = 'account';
		#END Menu 1
		#BEGIN: Advertise
		$data['advertisePage'] = 'account';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Define url for $getVar
		$action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		if(strtolower($this->uri->segment(3)) == 'detail' && $getVar['detail'] != FALSE)
		{
			$contact = $this->contact_model->get("con_title, con_date_contact, con_detail", "con_id = ".(int)$getVar['detail']." AND con_user = ".(int)$this->session->userdata('sessionUser')." AND con_status = 1");
			if(count($contact) == 1 && $this->check->is_id($getVar['detail']))
			{
				$this->load->library('bbcode');
				$data['contact'] = $contact;
				#Load view
				$this->load->view('home/account/contact/detail', $data);
			}
			else
			{
  				redirect(base_url().'account/contact', 'location');
			}
		}
		elseif(strtolower($this->uri->segment(3)) == 'send')
		{
            #BEGIN: Menu 2
			$data['menuSelected'] = 'send_contact';
			#END Menu 2
			#BEGIN: Unlink captcha
            $this->load->helper('unlink');
            unlink_captcha($this->session->flashdata('sessionPathCaptchaSendContactAccount'));
		    #END Unlink captcha
			if($this->session->flashdata('sessionSuccessSendContactAccount'))
			{
				$data['successSendContactAccount'] = true;
			}
			else
			{
            	$this->load->library('form_validation');
                $data['successSendContactAccount'] = false;
				if($this->input->post('captcha_contact') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
				{
					#BEGIN: Set rules
		            $this->form_validation->set_rules('title_contact', 'lang:title_contact_label_send', 'trim|required|callback__exist_title_contact');
		            $this->form_validation->set_rules('txtContent', 'lang:txtcontent_contact_label_send', 'trim|required|min_length[10]|max_length[1000]');
		            $this->form_validation->set_rules('captcha_contact', 'lang:captcha_contact_label_send', 'required|callback__valid_captcha_contact');
					#END Set rules
					#BEGIN: Set message
					$this->form_validation->set_message('required', $this->lang->line('required_message'));
					$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
					$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
					$this->form_validation->set_message('_exist_title_contact', $this->lang->line('_exist_title_contact_message_send'));
					$this->form_validation->set_message('_valid_captcha_contact', $this->lang->line('_valid_captcha_contact_message_send'));
					$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
					#END Set message
					if($this->form_validation->run() != FALSE)
					{
						if($this->input->post('position_contact') == '1')
						{
							$position_contact = 1;
						}
						else
						{
							$position_contact = 2;
						}
						$txtContent = '[fieldset][legend][i][red]'.$this->lang->line('name_sender_contact_send').'[/red][/i][/legend]'.$this->input->post('txtContent').'[/fieldset]';
	                    $dataAdd = array(
	                                        'con_title'     	=>      trim($this->filter->injection_html($this->input->post('title_contact'))),
	                                        'con_detail'    	=>      trim($this->filter->injection_html($txtContent)),
	                                        'con_position'  	=>      $position_contact,
	                                        'con_user'      	=>      (int)$this->session->userdata('sessionUser'),
	                                        'con_date_contact'  =>      $currentDate,
	                                        'con_date_reply'    =>      0,
	                                        'con_view'          =>      0,
	                                        'con_reply'         =>      0,
	                                        'con_status'        =>      1
											);
						if($this->contact_model->add($dataAdd))
						{
							$this->session->set_flashdata('sessionSuccessSendContactAccount', 1);
						}
						$this->session->set_userdata('sessionTimePosted', time());
						redirect(base_url().trim(uri_string(), '/'), 'location');
					}
					else
					{
	                    $data['title_contact'] = $this->input->post('title_contact');
						$data['position_contact'] = $this->input->post('position_contact');
						$data['txtContent'] = $this->input->post('txtContent');
					}
				}
                #BEGIN: Create captcha
                $this->load->library('captcha');
	        	$codeCaptcha = $this->captcha->code(6);
	        	$this->session->set_flashdata('sessionCaptchaSendContactAccount', $codeCaptcha);
	        	$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.(int)$this->session->userdata('sessionUser').'cona.jpg';
	        	$this->session->set_flashdata('sessionPathCaptchaSendContactAccount', $imageCaptcha);
				$this->captcha->create($codeCaptcha, $imageCaptcha);
				if(file_exists($imageCaptcha))
				{
					$data['imageCaptchaSendContactAccount'] = $imageCaptcha;
				}
				#END Create captcha
			}
			#Load view
			$this->load->view('home/account/contact/send', $data);
		}
		else
		{
			#BEGIN: Delete
            if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
			{
				$this->contact_model->delete($this->input->post('checkone'), "con_id", (int)$this->session->userdata('sessionUser'), "con_user");
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			#END Delete
			#BEGIN: Search & sort
			$where = "con_user = ".(int)$this->session->userdata('sessionUser')." AND con_status = 1";
			$sort = 'con_id';
			$by = 'DESC';
			$sortUrl = '';
			$pageSort = '';
			$pageUrl = '';
			$keyword = '';
			if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
			{
	            $keyword = $this->filter->html($getVar['keyword']);
				switch(strtolower($getVar['search']))
				{
					case 'title':
					    $sortUrl .= '/search/title/keyword/'.$getVar['keyword'];
					    $pageUrl .= '/search/title/keyword/'.$getVar['keyword'];
					    $where .= " AND con_title LIKE '%".$this->filter->injection_html($getVar['keyword'])."%'";
					    break;
				}
			}
			#If have sort
			if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
			{
				switch(strtolower($getVar['sort']))
				{
					case 'title':
					    $pageUrl .= '/sort/title';
					    $sort = "con_title";
					    break;
	                case 'position':
					    $pageUrl .= '/sort/position';
					    $sort = "con_position";
					    break;
                    case 'reply':
					    $pageUrl .= '/sort/reply';
					    $sort = "con_reply";
					    break;
	                case 'date':
					    $pageUrl .= '/sort/date';
					    $sort = "con_date_contact";
					    break;
					default:
					    $pageUrl .= '/sort/id';
					    $sort = "con_id";
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
			#END Search & sort
			#Keyword
			$data['keyword'] = $keyword;
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'account/contact'.$sortUrl.'/sort/';
			$data['pageSort'] = $pageSort;
			#END Create link sort
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->contact_model->fetch("con_id", $where, "", ""));
	        $config['base_url'] = base_url().'account/contact'.$pageUrl.'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = Setting::settingOtherAccount;
			$config['num_links'] = 1;
			$config['uri_segment'] = 4;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			#sTT - So thu tu
			$data['sTT'] = $start + 1;
			#Fetch record
			$select = "con_id, con_title, con_position, con_reply, con_date_contact";
			$limit = Setting::settingOtherAccount;
			$data['contact'] = $this->contact_model->fetch($select, $where, $sort, $by, $start, $limit);
			#Load view
			$this->load->view('home/account/contact/defaults', $data);
		}
	}
	
	function product()
	{
        $this->load->model('product_model');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Menu 1
		$data['menuSelected'] = 'product';
		$data['menuType'] = 'account';
		#END Menu 1
		#BEGIN: Advertise
		$data['advertisePage'] = 'account';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Define url for $getVar
		$action = array('edit', 'search', 'keyword', 'sort', 'by', 'status', 'id', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		if(strtolower($this->uri->segment(3)) == 'edit' && $getVar['edit'] != FALSE)
		{
            #BEGIN: CHECK GROUP
			if((int)$this->session->userdata('sessionGroup') == 1)
			{
				redirect(base_url().'account', 'location');
				die();
			}
			#END CHECK GROUP
			$product = $this->product_model->get("*", "pro_id = ".(int)$getVar['edit']." AND pro_user = ".(int)$this->session->userdata('sessionUser'));
			if(count($product) != 1 || !$this->check->is_id($getVar['edit']))
			{
				redirect(base_url().'account/product', 'location');
				die();
			}
	        #BEGIN: Unlink captcha
            $this->load->helper('unlink');
            unlink_captcha($this->session->flashdata('sessionPathCaptchaEditProductAccount'));
			#END Unlink captcha
			if($this->session->flashdata('sessionSuccessEditProductAccount'))
			{
	            $data['successEditProductAccount'] = true;
			}
			else
			{
				$this->load->library('form_validation');
	            $data['successEditProductAccount'] = false;
	            #BEGIN: Province
	            $this->load->model('province_model');
	            $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
	            #END Province
	            #BEGIN: Category
	            $this->load->model('category_model');
	            $data['category'] = $this->category_model->fetch("cat_id, cat_name", "cat_status = 1", "cat_order", "ASC");
	            #END Category
				if($this->input->post('captcha_pro') && time() - (int)$this->session->userdata('sessionTimePosted') <= (int)Setting::settingTimePost)
				{
                    redirect(base_url().'account/product/edit/'.$getVar['edit'], 'location');
					die();
				}
				#BEGIN: Set rules
				$this->form_validation->set_rules('name_pro', 'lang:name_pro_label_product_edit', 'trim|required');
				$this->form_validation->set_rules('descr_pro', 'lang:descr_pro_label_product_edit', 'trim|required');
				$this->form_validation->set_rules('cost_pro', 'lang:cost_pro_label_product_edit', 'trim|required|is_natural');
				$this->form_validation->set_rules('province_pro', 'lang:province_pro_label_product_edit', 'required|callback__exist_province');
				$this->form_validation->set_rules('category_pro', 'lang:category_pro_label_product_edit', 'required|callback__exist_category');
				$this->form_validation->set_rules('day_pro', 'lang:day_pro_label_product_edit', 'required|callback__valid_enddate_edit_product');
				$this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_product_edit', 'trim|required|min_length[10]|max_length[10000]');
				$this->form_validation->set_rules('fullname_pro', 'lang:fullname_pro_label_product_edit', 'trim|required');
				$this->form_validation->set_rules('address_pro', 'lang:address_pro_label_product_edit', 'trim|required');
				$this->form_validation->set_rules('phone_pro', 'lang:phone_pro_label_product_edit', 'trim|required|callback__is_phone');
				$this->form_validation->set_rules('mobile_pro', 'lang:mobile_pro_label_product_edit', 'trim|callback__is_phone');
				$this->form_validation->set_rules('email_pro', 'lang:email_pro_label_product_edit', 'trim|required|valid_email');
				$this->form_validation->set_rules('yahoo_pro', 'lang:yahoo_pro_label_product_edit', 'trim|callback__valid_nick');
				$this->form_validation->set_rules('skype_pro', 'lang:skype_pro_label_product_edit', 'trim|callback__valid_nick');
				$this->form_validation->set_rules('captcha_pro', 'lang:captcha_pro_label_product_edit', 'required|callback__valid_captcha_edit_product');
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
				$this->form_validation->set_message('_valid_enddate_edit_product', $this->lang->line('_valid_enddate_message'));
				$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
				$this->form_validation->set_message('_valid_captcha_edit_product', $this->lang->line('_valid_captcha_message_product_edit'));
				$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
				#END Set message
				if($this->form_validation->run() != FALSE)
				{
					#BEGIN: Upload image
					$this->load->library('upload');
					$pathImage = "media/images/product/";
					#Create folder
					$dir_image = $product->pro_dir;
					if($dir_image == 'default')
					{
                        $dir_image = date('dmY');
					}
					$image = $product->pro_image;
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
                        #BEGIN: Remove image
                        $image = explode(',', $image);
                        foreach($image as $images)
                        {
                            if(trim($images) != '' && trim($images) != 'none.gif' && file_exists($pathImage.$dir_image.'/'.$images))
    		                {
  		                        @unlink($pathImage.$dir_image.'/'.$images);
    		                }
                        }
                        for($j = 1; $j <= 3; $j++)
                        {
                            if(file_exists($pathImage.$dir_image.'/thumbnail_'.$j.'_'.$image[0]))
                            {
                                @unlink($pathImage.$dir_image.'/thumbnail_'.$j.'_'.$image[0]);
                            }
                        }
                        #END Remove image
                        #BEGIN: Create thumbnail
                        $this->load->library('image_lib');
                        if(file_exists($pathImage.$dir_image.'/'.$imageArray[0]))
                        {
                            for($t = 1; $t <= 3; $t++)
                            {
                                switch($t)
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
                                $configImage['new_image'] = $pathImage.$dir_image.'/thumbnail_'.$t.'_'.$imageArray[0];
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
					$dataEdit = array(
										'pro_name'      	=>      trim($this->filter->injection_html($this->input->post('name_pro'))),
										'pro_descr'     	=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_pro')))),
										'pro_cost'      	=>      $cost_pro,
										'pro_currency'  	=>      $currency_pro,
										'pro_hondle'    	=>      $nego_pro,
										'pro_saleoff'   	=>      $saleoff_pro,
										'pro_province'  	=>      (int)$this->input->post('province_pro'),
										'pro_category'  	=>      (int)$this->input->post('category_pro'),
										'pro_enddate'   	=>      mktime(0, 0, 0, (int)$this->input->post('month_pro'), (int)$this->input->post('day_pro'), (int)$this->input->post('year_pro')),
										'pro_detail'    	=>      trim($this->filter->injection_html($this->input->post('txtContent'))),
										'pro_image'     	=>      $image,
										'pro_dir'       	=>      $dir_image,
										'pro_poster'    	=>      trim($this->filter->injection_html($this->input->post('fullname_pro'))),
										'pro_address'   	=>      trim($this->filter->injection_html($this->input->post('address_pro'))),
										'pro_phone'     	=>      trim($this->filter->injection_html($this->input->post('phone_pro'))),
										'pro_mobile'    	=>      trim($this->filter->injection_html($this->input->post('mobile_pro'))),
										'pro_email'     	=>      trim($this->filter->injection_html($this->input->post('email_pro'))),
										'pro_yahoo'     	=>      trim($this->filter->injection_html($this->input->post('yahoo_pro'))),
										'pro_skype'     	=>      trim($this->filter->injection_html($this->input->post('skype_pro'))),
										'pro_reliable'      =>      $reliable
										);
					if($this->product_model->update($dataEdit, "pro_id = ".$product->pro_id))
					{
						$this->session->set_flashdata('sessionSuccessEditProductAccount', 1);
					}
					$this->session->set_userdata('sessionTimePosted', time());
					redirect(base_url().trim(uri_string(), '/'), 'location');
				}
				else
				{
					$data['name_pro'] = $product->pro_name;
					$data['descr_pro'] = $product->pro_descr;
					$data['cost_pro'] = $product->pro_cost;
					$data['currency_pro'] = $product->pro_currency;
					if((int)$product->pro_cost == 0)
					{
                        $data['nonecost_pro'] = 1;
					}
					else
					{
                        $data['nonecost_pro'] = 0;
					}
					$data['nego_pro'] = $product->pro_hondle;
					$data['saleoff_pro'] = $product->pro_saleoff;
					$data['province_pro'] = $product->pro_province;
					$data['category_pro'] = $product->pro_category;
					$data['day_pro'] = date('d', $product->pro_enddate);
					$data['month_pro'] = date('m', $product->pro_enddate);
					$data['year_pro'] = date('Y', $product->pro_enddate);
					$data['txtContent'] = $product->pro_detail;
					$data['fullname_pro'] = $product->pro_poster;
					$data['address_pro'] = $product->pro_address;
					$data['phone_pro'] = $product->pro_phone;
					$data['mobile_pro'] = $product->pro_mobile;
					$data['email_pro'] = $product->pro_email;
					$data['yahoo_pro'] = $product->pro_yahoo;
					$data['skype_pro'] = $product->pro_skype;
				}
                #BEGIN: Create captcha edit product
                $this->load->library('captcha');
	            $codeCaptcha = $this->captcha->code(6);
				$this->session->set_flashdata('sessionCaptchaEditProductAccount', $codeCaptcha);
				$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.(int)$this->session->userdata('sessionUser').'edip.jpg';
				$this->session->set_flashdata('sessionPathCaptchaEditProductAccount', $imageCaptcha);
				$this->captcha->create($codeCaptcha, $imageCaptcha);
				if(file_exists($imageCaptcha))
				{
					$data['imageCaptchaEditProductAccount'] = $imageCaptcha;
				}
				#END Create captcha edit product
			}
			#Load view
			$this->load->view('home/account/product/edit', $data);
		}
		elseif(strtolower($this->uri->segment(3)) == 'favorite')
		{
            $this->load->model('product_favorite_model');
            #BEGIN: Menu 2
			$data['menuSelected'] = 'favorite_product';
			#END Menu 2
            #BEGIN: Delete
			if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
			{
				$this->product_favorite_model->delete($this->input->post('checkone'), "prf_id", (int)$this->session->userdata('sessionUser'), "prf_user");
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			#END Delete
            #Define url for $getVar
			$action = array('search', 'keyword', 'sort', 'by', 'page');
			$getVar = $this->uri->uri_to_assoc(4, $action);
            #BEGIN: Search & sort
			$where = "prf_user = ".(int)$this->session->userdata('sessionUser');
			$sort = 'prf_id';
			$by = 'DESC';
			$sortUrl = '';
			$pageSort = '';
			$pageUrl = '';
			$keyword = '';
			if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
			{
	            $keyword = $this->filter->html($getVar['keyword']);
				switch(strtolower($getVar['search']))
				{
					case 'name':
					    $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
					    $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
					    $where .= " AND pro_name LIKE '%".$this->filter->injection_html($getVar['keyword'])."%'";
					    break;
				}
			}
			#If have sort
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
                    case 'postdate':
					    $pageUrl .= '/sort/postdate';
					    $sort = "pro_begindate";
					    break;
	                case 'date':
					    $pageUrl .= '/sort/date';
					    $sort = "prf_date";
					    break;
					default:
					    $pageUrl .= '/sort/id';
					    $sort = "prf_id";
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
			#END Search & sort
			#Keyword
			$data['keyword'] = $keyword;
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'account/product/favorite'.$sortUrl.'/sort/';
			$data['pageSort'] = $pageSort;
			#END Create link sort
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->product_favorite_model->fetch_join("prf_id", "LEFT", "tbtt_product", "tbtt_product_favorite.prf_product = tbtt_product.pro_id", $where, "", ""));
	        $config['base_url'] = base_url().'account/product/favorite'.$pageUrl.'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = Setting::settingOtherAccount;
			$config['num_links'] = 1;
			$config['uri_segment'] = 4;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			#sTT - So thu tu
			$data['sTT'] = $start + 1;
			#Fetch record
			$select = "prf_id, prf_date, pro_id, pro_name, pro_descr, pro_category, pro_dir, pro_image, pro_begindate, pro_cost, pro_currency, pro_view";
			$limit = Setting::settingOtherAccount;
			$data['favoriteProduct'] = $this->product_favorite_model->fetch_join($select, "LEFT", "tbtt_product", "tbtt_product_favorite.prf_product = tbtt_product.pro_id", $where, $sort, $by, $start, $limit);
			#Load view
			$this->load->view('home/account/product/favorite', $data);
		}
		else
		{
            #BEGIN: CHECK GROUP
			if((int)$this->session->userdata('sessionGroup') == 1)
			{
				redirect(base_url().'account', 'location');
				die();
			}
			#END CHECK GROUP
            #BEGIN: Delete
			if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
			{
                $this->load->library('file');
				$idCheckOneProduct = implode(',', $this->input->post('checkone'));
				$checkOneProduct = $this->product_model->fetch("pro_id, pro_image, pro_dir", "pro_id IN($idCheckOneProduct) AND pro_user = ".(int)$this->session->userdata('sessionUser'));
				$idProduct = array();
				foreach($checkOneProduct as $checkOneProductArray)
				{
                    $idProduct[] = $checkOneProductArray->pro_id;
                    #Remove image
					if($checkOneProductArray->pro_image != 'none.gif')
					{
                        $imageArray = explode(',', $checkOneProductArray->pro_image);
                        foreach($imageArray as $imageArrays)
                        {
    						if(trim($imageArrays) != '' && file_exists('media/images/product/'.$checkOneProductArray->pro_dir.'/'.$imageArrays))
    						{
    							@unlink('media/images/product/'.$checkOneProductArray->pro_dir.'/'.$imageArrays);
    						}
                        }
                        for($i = 1; $i <= 3; $i++)
                        {
                            if(file_exists('media/images/product/'.$checkOneProductArray->pro_dir.'/thumbnail_'.$i.'_'.$imageArray[0]))
                            {
                                @unlink('media/images/product/'.$checkOneProductArray->pro_dir.'/thumbnail_'.$i.'_'.$imageArray[0]);
                            }
                        }
						if(trim($checkOneProductArray->pro_dir) != '' && is_dir('media/images/product/'.$checkOneProductArray->pro_dir) && count($this->file->load('media/images/product/'.$checkOneProductArray->pro_dir, 'index.html')) == 0)
						{
							if(file_exists('media/images/product/'.$checkOneProductArray->pro_dir.'/index.html'))
							{
								@unlink('media/images/product/'.$checkOneProductArray->pro_dir.'/index.html');
							}
							@rmdir('media/images/product/'.$checkOneProductArray->pro_dir);
						}
					}
				}
				if(count($idProduct) > 0)
				{
                    $this->load->model('product_favorite_model');
					$this->load->model('product_comment_model');
					$this->load->model('product_bad_model');
					$this->load->model('showcart_model');
					$this->product_favorite_model->delete($idProduct, "prf_product");
					$this->product_comment_model->delete($idProduct, "prc_product");
					$this->product_bad_model->delete($idProduct, "prb_product");
					$this->showcart_model->delete($idProduct, "shc_product");
					$this->product_model->delete($idProduct, "pro_id");
				}
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			#END Delete
            $this->load->library('hash');
			#BEGIN: Search & sort
			$where = "pro_user = ".(int)$this->session->userdata('sessionUser');
			$sort = 'pro_id';
			$by = 'DESC';
			$sortUrl = '';
			$pageSort = '';
			$pageUrl = '';
			$keyword = '';
			if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
			{
	            $keyword = $this->filter->html($getVar['keyword']);
				switch(strtolower($getVar['search']))
				{
					case 'name':
					    $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
					    $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
					    $where .= " AND pro_name LIKE '%".$this->filter->injection_html($getVar['keyword'])."%'";
					    break;
				}
			}
			#If have sort
			if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
			{
				switch(strtolower($getVar['sort']))
				{
					case 'name':
					    $pageUrl .= '/sort/name';
					    $sort = "pro_name";
					    break;
	                case 'category':
					    $pageUrl .= '/sort/category';
					    $sort = "cat_name";
					    break;
                    case 'postdate':
					    $pageUrl .= '/sort/postdate';
					    $sort = "pro_begindate";
					    break;
	                case 'enddate':
					    $pageUrl .= '/sort/enddate';
					    $sort = "pro_enddate";
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
			#END Search & sort
			#Keyword
			$data['keyword'] = $keyword;
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'account/product'.$sortUrl.'/sort/';
			$data['pageSort'] = $pageSort;
			#END Create link sort
			#BEGIN: Status
			$statusUrl = $pageUrl.$pageSort;
			$data['statusUrl'] = base_url().'account/product'.$statusUrl;
			if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
			{
				switch(strtolower($getVar['status']))
				{
					case 'active':
					    $this->product_model->update(array('pro_status'=>1), "pro_id = ".(int)$getVar['id']." AND pro_user = ".(int)$this->session->userdata('sessionUser'));
						break;
					case 'deactive':
					    $this->product_model->update(array('pro_status'=>0), "pro_id = ".(int)$getVar['id']." AND pro_user = ".(int)$this->session->userdata('sessionUser'));
						break;
				}
				redirect($data['statusUrl'], 'location');
			}
			#END Status
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->product_model->fetch_join("pro_id", "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", "", "", "", "", "", "", $where, "", ""));
	        $config['base_url'] = base_url().'account/product'.$pageUrl.'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = Setting::settingOtherAccount;
			$config['num_links'] = 1;
			$config['uri_segment'] = 4;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			#sTT - So thu tu
			$data['sTT'] = $start + 1;
			#Fetch record
			$select = "pro_id, pro_name, pro_descr, pro_category, pro_dir, pro_image, pro_begindate, pro_enddate, pro_status, pro_view, cat_name";
			$limit = Setting::settingOtherAccount;
			$data['product'] = $this->product_model->fetch_join($select, "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", "", "", "", "", "", "", $where, $sort, $by, $start, $limit);
			#Load view
			$this->load->view('home/account/product/defaults', $data);
		}
	}
	
	function ads()
	{
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Menu 1
		$data['menuSelected'] = 'ads';
		$data['menuType'] = 'account';
		#END Menu 1
		#BEGIN: Advertise
		$data['advertisePage'] = 'account';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Define url for $getVar
		$action = array('edit', 'search', 'keyword', 'sort', 'by', 'status', 'id', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		if(strtolower($this->uri->segment(3)) == 'edit' && $getVar['edit'] != FALSE)
		{
            $ads = $this->ads_model->get("*", "ads_id = ".(int)$getVar['edit']." AND ads_user = ".(int)$this->session->userdata('sessionUser'));
			if(count($ads) != 1 || !$this->check->is_id($getVar['edit']))
			{
				redirect(base_url().'account/ads', 'location');
				die();
			}
            #BEGIN: Unlink captcha
            $this->load->helper('unlink');
            unlink_captcha($this->session->flashdata('sessionPathCaptchaEditAdsAccount'));
			#END Unlink captcha
			if($this->session->flashdata('sessionSuccessEditAdsAccount'))
			{
	            $data['successEditAdsAccount'] = true;
			}
			else
			{
				$this->load->library('form_validation');
	            $data['successEditAdsAccount'] = false;
	            #BEGIN: Province
	            $this->load->model('province_model');
	            $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
	            #END Province
	            #BEGIN: Category
	            $this->load->model('category_model');
	            $data['category'] = $this->category_model->fetch("cat_id, cat_name", "cat_status = 1", "cat_order", "ASC");
	            #END Category
				if($this->input->post('captcha_ads') && time() - (int)$this->session->userdata('sessionTimePosted') <= (int)Setting::settingTimePost)
				{
                    redirect(base_url().'account/ads/edit/'.$getVar['edit'], 'location');
                    die();
				}
				#BEGIN: Set rules
				$this->form_validation->set_rules('title_ads', 'lang:title_ads_label_ads_edit', 'trim|required');
				$this->form_validation->set_rules('descr_ads', 'lang:descr_ads_label_ads_edit', 'trim|required');
				$this->form_validation->set_rules('province_ads', 'lang:province_ads_label_ads_edit', 'required|callback__exist_province');
				$this->form_validation->set_rules('category_ads', 'lang:category_ads_label_ads_edit', 'required|callback__exist_category');
				$this->form_validation->set_rules('day_ads', 'lang:day_ads_label_ads_edit', 'required|callback__valid_enddate_edit_ads');
				$this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_ads_edit', 'trim|required|min_length[10]|max_length[10000]');
				$this->form_validation->set_rules('fullname_ads', 'lang:fullname_ads_label_ads_edit', 'trim|required');
				$this->form_validation->set_rules('address_ads', 'lang:address_ads_label_ads_edit', 'trim|required');
				$this->form_validation->set_rules('phone_ads', 'lang:phone_ads_label_ads_edit', 'trim|required|callback__is_phone');
				$this->form_validation->set_rules('mobile_ads', 'lang:mobile_ads_label_ads_edit', 'trim|callback__is_phone');
				$this->form_validation->set_rules('email_ads', 'lang:email_ads_label_ads_edit', 'trim|required|valid_email');
				$this->form_validation->set_rules('yahoo_ads', 'lang:yahoo_ads_label_ads_edit', 'trim|callback__valid_nick');
				$this->form_validation->set_rules('skype_ads', 'lang:skype_ads_label_ads_edit', 'trim|callback__valid_nick');
				$this->form_validation->set_rules('captcha_ads', 'lang:captcha_ads_label_ads_edit', 'required|callback__valid_captcha_edit_ads');
				#END Set rules
				#BEGIN: Set message
				$this->form_validation->set_message('required', $this->lang->line('required_message'));
				$this->form_validation->set_message('_valid_nick', $this->lang->line('_valid_nick_message'));
				$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
				$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
				$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
				$this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message'));
				$this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message'));
				$this->form_validation->set_message('_valid_enddate_edit_ads', $this->lang->line('_valid_enddate_message'));
				$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
				$this->form_validation->set_message('_valid_captcha_edit_ads', $this->lang->line('_valid_captcha_message_ads_edit'));
				$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
				#END Set message
				if($this->form_validation->run() != FALSE)
				{
					#BEGIN: Upload image
					$this->load->library('upload');
	                $pathImage = "media/images/ads/";
					#Create folder
					$dir_image = $ads->ads_dir;
					if($dir_image == 'default')
					{
                        $dir_image = date('dmY');
					}
					$image = $ads->ads_image;
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
					if($this->upload->do_upload('image_ads'))
					{
	                    $uploadData = $this->upload->data();
	                    if($uploadData['is_image'] == TRUE)
	                    {
							if(trim($image) != '' && trim($image) != 'none.gif' && file_exists($pathImage.$dir_image.'/'.$image))
							{
								@unlink($pathImage.$dir_image.'/'.$image);
                                if(file_exists($pathImage.$dir_image.'/thumbnail_3_'.$image))
                                {
                                    @unlink($pathImage.$dir_image.'/thumbnail_3_'.$image);
                                }
							}
							$image = $uploadData['file_name'];
                            #BEGIN: Create thumbnail
                            $this->load->library('image_lib');
                            if(file_exists($pathImage.$dir_image.'/'.$image))
                            {
                                $maxWidth = 200;#px
                                $maxHeight = 170;#px
                                $sizeImage = size_thumbnail($pathImage.$dir_image.'/'.$image, $maxWidth, $maxHeight);
                                $configImage['source_image'] = $pathImage.$dir_image.'/'.$image;
                                $configImage['new_image'] = $pathImage.$dir_image.'/thumbnail_3_'.$image;
                                $configImage['maintain_ratio'] = TRUE;
                                $configImage['width'] = $sizeImage['width'];
                                $configImage['height'] = $sizeImage['height'];
                                $this->image_lib->initialize($configImage);
                                $this->image_lib->resize();
                            }
                            #END Create thumbnail
	     				}
	     				elseif(file_exists($pathImage.$dir_image.'/'.$uploadData['file_name']))
	     				{
							@unlink($pathImage.$dir_image.'/'.$uploadData['file_name']);
	     				}
					}
					if($image == 'none.gif')
					{
                        #Remove dir
                        $this->load->library('file');
                        if(trim($dir_image) != '' && trim($dir_image) != 'default' && is_dir('media/images/ads/'.$dir_image) && count($this->file->load('media/images/ads/'.$dir_image, 'index.html')) == 0)
                        {
							if(file_exists('media/images/ads/'.$dir_image.'/index.html'))
							{
								@unlink('media/images/ads/'.$dir_image.'/index.html');
							}
							@rmdir('media/images/ads/'.$dir_image);
                        }
                        $dir_image = 'default';
					}
					#END Upload image
					if((int)$this->session->userdata('sessionGroup') == 2 || (int)$this->session->userdata('sessionGroup') == 3)
					{
						$reliable = 1;
					}
					else
					{
                        $reliable = 0;
					}
					#IF is shop
					$this->load->model('shop_model');
					$shop = $this->shop_model->get("sho_id", "sho_status = 1 AND sho_enddate >= $currentDate AND sho_user = ".(int)$this->session->userdata('sessionUser'));
					if(count($shop) == 1)
					{
						$is_shop = 1;
					}
					else
					{
                        $is_shop = 0;
					}
					$dataEdit = array(
					                    'ads_title'      	=>      trim($this->filter->injection_html($this->input->post('title_ads'))),
					                    'ads_descr'     	=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_ads')))),
					                    'ads_province'  	=>      (int)$this->input->post('province_ads'),
					                    'ads_category'  	=>      (int)$this->input->post('category_ads'),
					                    'ads_enddate'   	=>      mktime(0, 0, 0, (int)$this->input->post('month_ads'), (int)$this->input->post('day_ads'), (int)$this->input->post('year_ads')),
					                    'ads_detail'    	=>      trim($this->filter->injection_html($this->input->post('txtContent'))),
					                    'ads_image'     	=>      $image,
					                    'ads_dir'       	=>      $dir_image,
					                    'ads_poster'    	=>      trim($this->filter->injection_html($this->input->post('fullname_ads'))),
					                    'ads_address'   	=>      trim($this->filter->injection_html($this->input->post('address_ads'))),
					                    'ads_phone'     	=>      trim($this->filter->injection_html($this->input->post('phone_ads'))),
					                    'ads_mobile'    	=>      trim($this->filter->injection_html($this->input->post('mobile_ads'))),
					                    'ads_email'     	=>      trim($this->filter->injection_html($this->input->post('email_ads'))),
					                    'ads_yahoo'     	=>      trim($this->filter->injection_html($this->input->post('yahoo_ads'))),
					                    'ads_skype'     	=>      trim($this->filter->injection_html($this->input->post('skype_ads'))),
                                        'ads_reliable'      =>      $reliable,
                                        'ads_is_shop'       =>      $is_shop
										);
					if($this->ads_model->update($dataEdit, "ads_id = ".$ads->ads_id))
					{
						$this->session->set_flashdata('sessionSuccessEditAdsAccount', 1);
					}
					$this->session->set_userdata('sessionTimePosted', time());
					redirect(base_url().trim(uri_string(), '/'), 'location');
				}
				else
				{
					$data['title_ads'] = $ads->ads_title;
					$data['descr_ads'] = $ads->ads_descr;
					$data['province_ads'] = $ads->ads_province;
					$data['category_ads'] = $ads->ads_category;
					$data['day_ads'] = date('d', $ads->ads_enddate);
					$data['month_ads'] = date('m', $ads->ads_enddate);
					$data['year_ads'] = date('Y', $ads->ads_enddate);
					$data['txtContent'] = $ads->ads_detail;
     				$data['fullname_ads'] = $ads->ads_poster;
					$data['address_ads'] = $ads->ads_address;
     				$data['phone_ads'] = $ads->ads_phone;
     				$data['mobile_ads'] = $ads->ads_mobile;
                    $data['email_ads'] = $ads->ads_email;
                    $data['yahoo_ads'] = $ads->ads_yahoo;
                    $data['skype_ads'] = $ads->ads_skype;
				}
                #BEGIN: Create captcha post ads
                $this->load->library('captcha');
	            $codeCaptcha = $this->captcha->code(6);
				$this->session->set_flashdata('sessionCaptchaEditAdsAccount', $codeCaptcha);
				$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.(int)$this->session->userdata('sessionUser').'edia.jpg';
				$this->session->set_flashdata('sessionPathCaptchaEditAdsAccount', $imageCaptcha);
				$this->captcha->create($codeCaptcha, $imageCaptcha);
				if(file_exists($imageCaptcha))
				{
					$data['imageCaptchaEditAdsAccount'] = $imageCaptcha;
				}
				#END Create captcha post ads
			}
			#Load view
			$this->load->view('home/account/ads/edit', $data);
		}
		elseif(strtolower($this->uri->segment(3)) == 'favorite')
		{
            $this->load->model('ads_favorite_model');
            #BEGIN: Menu 2
			$data['menuSelected'] = 'favorite_ads';
			#END Menu 2
            #BEGIN: Delete
			if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
			{
				$this->ads_favorite_model->delete($this->input->post('checkone'), "adf_id", (int)$this->session->userdata('sessionUser'), "adf_user");
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			#END Delete
            #Define url for $getVar
			$action = array('search', 'keyword', 'sort', 'by', 'page');
			$getVar = $this->uri->uri_to_assoc(4, $action);
            #BEGIN: Search & sort
			$where = "adf_user = ".(int)$this->session->userdata('sessionUser');
			$sort = 'adf_id';
			$by = 'DESC';
			$sortUrl = '';
			$pageSort = '';
			$pageUrl = '';
			$keyword = '';
			if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
			{
	            $keyword = $this->filter->html($getVar['keyword']);
				switch(strtolower($getVar['search']))
				{
					case 'title':
					    $sortUrl .= '/search/title/keyword/'.$getVar['keyword'];
					    $pageUrl .= '/search/title/keyword/'.$getVar['keyword'];
					    $where .= " AND ads_title LIKE '%".$this->filter->injection_html($getVar['keyword'])."%'";
					    break;
				}
			}
			#If have sort
			if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
			{
				switch(strtolower($getVar['sort']))
				{
					case 'title':
					    $pageUrl .= '/sort/title';
					    $sort = "ads_title";
					    break;
                    case 'postdate':
					    $pageUrl .= '/sort/postdate';
					    $sort = "ads_begindate";
					    break;
	                case 'date':
					    $pageUrl .= '/sort/date';
					    $sort = "adf_date";
					    break;
					default:
					    $pageUrl .= '/sort/id';
					    $sort = "adf_id";
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
			#END Search & sort
			#Keyword
			$data['keyword'] = $keyword;
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'account/ads/favorite'.$sortUrl.'/sort/';
			$data['pageSort'] = $pageSort;
			#END Create link sort
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->ads_favorite_model->fetch_join("adf_id", "LEFT", "tbtt_ads", "tbtt_ads_favorite.adf_ads = tbtt_ads.ads_id", $where, "", ""));
	        $config['base_url'] = base_url().'account/ads/favorite'.$pageUrl.'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = Setting::settingOtherAccount;
			$config['num_links'] = 1;
			$config['uri_segment'] = 4;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			#sTT - So thu tu
			$data['sTT'] = $start + 1;
			#Fetch record
			$select = "adf_id, adf_date, ads_id, ads_title, ads_category, ads_descr, ads_view, ads_begindate";
			$limit = Setting::settingOtherAccount;
			$data['favoriteAds'] = $this->ads_favorite_model->fetch_join($select, "LEFT", "tbtt_ads", "tbtt_ads_favorite.adf_ads = tbtt_ads.ads_id", $where, $sort, $by, $start, $limit);
			#Load view
			$this->load->view('home/account/ads/favorite', $data);
		}
		else
		{
            #BEGIN: Delete
			if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
			{
                $this->load->library('file');
				$idCheckOneAds = implode(',', $this->input->post('checkone'));
				$checkOneAds = $this->ads_model->fetch("ads_id, ads_image, ads_dir", "ads_id IN($idCheckOneAds) AND ads_user = ".(int)$this->session->userdata('sessionUser'));
				$idAds = array();
				foreach($checkOneAds as $checkOneAdsArray)
				{
                    $idAds[] = $checkOneAdsArray->ads_id;
                    #Remove image
					if($checkOneAdsArray->ads_image != 'none.gif')
					{
						if(trim($checkOneAdsArray->ads_image) != '' && file_exists('media/images/ads/'.$checkOneAdsArray->ads_dir.'/'.$checkOneAdsArray->ads_image))
						{
							@unlink('media/images/ads/'.$checkOneAdsArray->ads_dir.'/'.$checkOneAdsArray->ads_image);
                            if(file_exists('media/images/ads/'.$checkOneAdsArray->ads_dir.'/thumbnail_3_'.$checkOneAdsArray->ads_image))
                            {
                                @unlink('media/images/ads/'.$checkOneAdsArray->ads_dir.'/thumbnail_3_'.$checkOneAdsArray->ads_image);
                            }
						}
						if(trim($checkOneAdsArray->ads_dir) != '' && is_dir('media/images/ads/'.$checkOneAdsArray->ads_dir) && count($this->file->load('media/images/ads/'.$checkOneAdsArray->ads_dir, 'index.html')) == 0)
						{
							if(file_exists('media/images/ads/'.$checkOneAdsArray->ads_dir.'/index.html'))
							{
								@unlink('media/images/ads/'.$checkOneAdsArray->ads_dir.'/index.html');
							}
							@rmdir('media/images/ads/'.$checkOneAdsArray->ads_dir);
						}
					}
				}
				if(count($idAds) > 0)
				{
                    $this->load->model('ads_favorite_model');
					$this->load->model('ads_comment_model');
					$this->load->model('ads_bad_model');
					$this->ads_favorite_model->delete($idAds, "adf_ads");
					$this->ads_comment_model->delete($idAds, "adc_ads");
					$this->ads_bad_model->delete($idAds, "adb_ads");
					$this->ads_model->delete($idAds, "ads_id");
				}
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			#END Delete
            $this->load->library('hash');
			#BEGIN: Search & sort
			$where = "ads_user = ".(int)$this->session->userdata('sessionUser');
			$sort = 'ads_id';
			$by = 'DESC';
			$sortUrl = '';
			$pageSort = '';
			$pageUrl = '';
			$keyword = '';
			if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
			{
	            $keyword = $this->filter->html($getVar['keyword']);
				switch(strtolower($getVar['search']))
				{
					case 'title':
					    $sortUrl .= '/search/title/keyword/'.$getVar['keyword'];
					    $pageUrl .= '/search/title/keyword/'.$getVar['keyword'];
					    $where .= " AND ads_title LIKE '%".$this->filter->injection_html($getVar['keyword'])."%'";
					    break;
				}
			}
			#If have sort
			if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
			{
				switch(strtolower($getVar['sort']))
				{
					case 'title':
					    $pageUrl .= '/sort/title';
					    $sort = "ads_title";
					    break;
	                case 'category':
					    $pageUrl .= '/sort/category';
					    $sort = "cat_name";
					    break;
                    case 'postdate':
					    $pageUrl .= '/sort/postdate';
					    $sort = "ads_begindate";
					    break;
	                case 'enddate':
					    $pageUrl .= '/sort/enddate';
					    $sort = "ads_enddate";
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
			#END Search & sort
			#Keyword
			$data['keyword'] = $keyword;
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'account/ads'.$sortUrl.'/sort/';
			$data['pageSort'] = $pageSort;
			#END Create link sort
			#BEGIN: Status
			$statusUrl = $pageUrl.$pageSort;
			$data['statusUrl'] = base_url().'account/ads'.$statusUrl;
			if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
			{
				switch(strtolower($getVar['status']))
				{
					case 'active':
					    $this->ads_model->update(array('ads_status'=>1), "ads_id = ".(int)$getVar['id']." AND ads_user = ".(int)$this->session->userdata('sessionUser'));
						break;
					case 'deactive':
					    $this->ads_model->update(array('ads_status'=>0), "ads_id = ".(int)$getVar['id']." AND ads_user = ".(int)$this->session->userdata('sessionUser'));
						break;
				}
				redirect($data['statusUrl'], 'location');
			}
			#END Status
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_category", "tbtt_ads.ads_category = tbtt_category.cat_id", "", "", "", "", "", "", $where, "", ""));
	        $config['base_url'] = base_url().'account/ads'.$pageUrl.'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = Setting::settingOtherAccount;
			$config['num_links'] = 1;
			$config['uri_segment'] = 4;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			#sTT - So thu tu
			$data['sTT'] = $start + 1;
			#Fetch record
			$select = "ads_id, ads_category, ads_title, ads_descr, ads_begindate, ads_enddate, ads_status, ads_view, cat_name";
			$limit = Setting::settingOtherAccount;
			$data['ads'] = $this->ads_model->fetch_join($select, "LEFT", "tbtt_category", "tbtt_ads.ads_category = tbtt_category.cat_id", "", "", "", "", "", "", $where, $sort, $by, $start, $limit);
			#Load view
			$this->load->view('home/account/ads/defaults', $data);
		}
	}
	
	function job()
	{
        $this->load->model('job_model');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Menu 1
		$data['menuSelected'] = 'job';
		$data['menuType'] = 'account';
		#END Menu 1
		#BEGIN: Advertise
		$data['advertisePage'] = 'account';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Define url for $getVar
		$action = array('edit', 'search', 'keyword', 'sort', 'by', 'status', 'id', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		if(strtolower($this->uri->segment(3)) == 'edit' && $getVar['edit'] != FALSE)
		{
            $job = $this->job_model->get("*", "job_id = ".(int)$getVar['edit']." AND job_user = ".(int)$this->session->userdata('sessionUser'));
			if(count($job) != 1 || !$this->check->is_id($getVar['edit']))
			{
				redirect(base_url().'account/job', 'location');
				die();
			}
            #BEGIN: Unlink captcha
            $this->load->helper('unlink');
            unlink_captcha($this->session->flashdata('sessionPathCaptchaEditJobAccount'));
			#END Unlink captcha
			if($this->session->flashdata('sessionSuccessEditJobAccount'))
			{
	            $data['successEditJobAccount'] = true;
			}
			else
			{
				$this->load->library('form_validation');
	            $data['successEditJobAccount'] = false;
	            #BEGIN: Province
	            $this->load->model('province_model');
	            $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
	            #END Province
	            #BEGIN: Field
	            $this->load->model('field_model');
	            $data['field'] = $this->field_model->fetch("fie_id, fie_name", "fie_status = 1", "fie_order", "ASC");
	            #END Field
				if($this->input->post('captcha_job') && time() - (int)$this->session->userdata('sessionTimePosted') <= (int)Setting::settingTimePost)
				{
                    redirect(base_url().'account/job/edit/'.$getVar['edit'], 'location');
					die();
				}
				#BEGIN: Set rules
				$this->form_validation->set_rules('title_job', 'lang:title_job_label_job_edit', 'trim|required');
				$this->form_validation->set_rules('field_job', 'lang:field_job_label_job_edit', 'required|callback__exist_field');
				$this->form_validation->set_rules('position_job', 'lang:position_job_label_job_edit', 'trim|required');
				$this->form_validation->set_rules('level_job', 'lang:level_job_label_job_edit', 'trim|required');
				$this->form_validation->set_rules('age1_job', 'lang:age_job_label_job_edit', 'required|callback__valid_age_job_edit');
				$this->form_validation->set_rules('require_job', 'lang:require_job_label_job_edit', 'trim|required');
				$this->form_validation->set_rules('province_job', 'lang:province_job_label_job_edit', 'required|callback__exist_province');
				$this->form_validation->set_rules('salary_job', 'lang:salary_job_label_job_edit', 'trim|required|is_natural_no_zero');
				$this->form_validation->set_rules('try_job', 'lang:try_job_label_job_edit', 'trim|required|is_natural');
				$this->form_validation->set_rules('interest_job', 'lang:interest_job_label_job_edit', 'trim|required|max_length[500]');
				$this->form_validation->set_rules('quantity_job', 'lang:quantity_job_label_job_edit', 'trim|required|is_natural_no_zero');
				$this->form_validation->set_rules('record_job', 'lang:record_job_label_job_edit', 'trim|required|max_length[500]');
				$this->form_validation->set_rules('day_job', 'lang:day_job_label_job_edit', 'required|callback__valid_date_job_edit');
				$this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_job_edit', 'trim|required|min_length[10]|max_length[10000]');
				$this->form_validation->set_rules('name_job', 'lang:name_job_label_job_edit', 'trim|required');
				$this->form_validation->set_rules('address_job', 'lang:address_job_label_job_edit', 'trim|required');
				$this->form_validation->set_rules('phone_job', 'lang:phone_job_label_job_edit', 'trim|required|callback__is_phone');
				$this->form_validation->set_rules('mobile_job', 'lang:mobile_job_label_job_edit', 'trim|callback__is_phone');
				$this->form_validation->set_rules('email_job', 'lang:email_job_label_job_edit', 'trim|required|valid_email');
				$this->form_validation->set_rules('website_job', 'lang:website_job_label_job_edit', 'trim|callback__valid_website');
				$this->form_validation->set_rules('namecontact_job', 'lang:namecontact_job_label_job_edit', 'trim|required');
				$this->form_validation->set_rules('addresscontact_job', 'lang:addresscontact_job_label_job_edit', 'trim|required');
				$this->form_validation->set_rules('phonecontact_job', 'lang:phonecontact_job_label_job_edit', 'trim|required|callback__is_phone');
				$this->form_validation->set_rules('mobilecontact_job', 'lang:mobilecontact_job_label_job_edit', 'trim|callback__is_phone');
				$this->form_validation->set_rules('emailcontact_job', 'lang:emailcontact_job_label_job_edit', 'trim|required|valid_email');
				$this->form_validation->set_rules('yahoo_job', 'lang:yahoo_job_label_job_edit', 'trim|callback__valid_nick');
				$this->form_validation->set_rules('skype_job', 'lang:skype_job_label_job_edit', 'trim|callback__valid_nick');
				$this->form_validation->set_rules('endday_job', 'lang:endday_job_label_job_edit', 'required|callback__valid_enddate_job_edit');
				$this->form_validation->set_rules('captcha_job', 'lang:captcha_job_label_job_edit', 'required|callback__valid_captcha_job_edit');
				#END Set rules
				#BEGIN: Set message
				$this->form_validation->set_message('required', $this->lang->line('required_message'));
				$this->form_validation->set_message('_valid_nick', $this->lang->line('_valid_nick_message'));
				$this->form_validation->set_message('is_natural', $this->lang->line('is_natural_message'));
				$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
				$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
				$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
				$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
				$this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message'));
				$this->form_validation->set_message('_exist_field', $this->lang->line('_exist_field_message'));
				$this->form_validation->set_message('_valid_enddate_job_edit', $this->lang->line('_valid_enddate_message'));
				$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
				$this->form_validation->set_message('_valid_website', $this->lang->line('_valid_website_message'));
				$this->form_validation->set_message('_valid_date_job_edit', $this->lang->line('_valid_date_message_job_edit'));
				$this->form_validation->set_message('_valid_age_job_edit', $this->lang->line('_valid_age_message_job_edit'));
				$this->form_validation->set_message('_valid_captcha_job_edit', $this->lang->line('_valid_captcha_message_job_edit'));
				$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
				#END Set message
				if($this->form_validation->run() != FALSE)
				{
					if($this->input->post('time_job') == '1')
					{
						$time_job = $this->lang->line('time_job_1_job_edit');
					}
					elseif($this->input->post('time_job') == '2')
					{
                        $time_job = $this->lang->line('time_job_2_job_edit');
					}
					elseif($this->input->post('time_job') == '3')
					{
                        $time_job = $this->lang->line('time_job_3_job_edit');
					}
					elseif($this->input->post('time_job') == '4')
					{
                        $time_job = $this->lang->line('time_job_4_job_edit');
					}
					else
					{
                        $time_job = $this->lang->line('time_job_5_job_edit');
					}
					if(strtoupper($this->input->post('currency_job')) == 'USD')
					{
						$salary_job = (int)$this->input->post('salary_job').'|USD/';
					}
					else
					{
                        $salary_job = (int)$this->input->post('salary_job').'|VND/';
					}
					if($this->input->post('datesalary_job') == '3')
					{
						$datesalary_job = $this->lang->line('year_job_edit');
					}
					elseif($this->input->post('datesalary_job') == '1')
					{
                        $datesalary_job = $this->lang->line('day_job_edit');
					}
					else
					{
                        $datesalary_job = $this->lang->line('month_job_edit');
					}
					if($this->input->post('datetry_job') == '3')
					{
						$try_job = $this->lang->line('year_job_edit');
					}
					elseif($this->input->post('datetry_job') == '1')
					{
                        $try_job = $this->lang->line('day_job_edit');
					}
					else
					{
                        $try_job = $this->lang->line('month_job_edit');
					}
					$try_job = (int)$this->input->post('try_job').' '.$try_job;
					if($this->input->post('bestcontact_job') == '1')
					{
						$bestcontact_job = $this->lang->line('best_contact_1_contact_job_edit');
					}
					elseif($this->input->post('bestcontact_job') == '2')
					{
                        $bestcontact_job = $this->lang->line('best_contact_2_contact_job_edit');
					}
					elseif($this->input->post('bestcontact_job') == '3')
					{
                        $bestcontact_job = $this->lang->line('best_contact_3_contact_job_edit');
					}
					elseif($this->input->post('bestcontact_job') == '4')
					{
                        $bestcontact_job = $this->lang->line('best_contact_4_contact_job_edit');
					}
					else
					{
                        $bestcontact_job = $this->lang->line('best_contact_5_contact_job_edit');
					}
					$dataEdit = array(
					                    'job_title'      		=>      trim($this->filter->injection_html($this->input->post('title_job'))),
					                    'job_field'     		=>      (int)$this->input->post('field_job'),
					                    'job_position'  		=>      trim($this->filter->injection_html($this->input->post('position_job'))),
					                    'job_level'  			=>      trim($this->filter->injection_html($this->input->post('level_job'))),
					                    'job_foreign_language' 	=>      trim($this->filter->injection_html($this->input->post('foreign_language_job'))),
					                    'job_computer'   		=>      trim($this->filter->injection_html($this->input->post('computer_job'))),
					                    'job_age'    			=>      (int)$this->input->post('age1_job').'-'.(int)$this->input->post('age2_job'),
					                    'job_sex'     			=>      (int)$this->input->post('sex_job'),
					                    'job_require'       	=>      trim($this->filter->injection_html($this->input->post('require_job'))),
					                    'job_exper'      		=>      (int)$this->input->post('experience_job'),
					                    'job_province'    		=>      (int)$this->input->post('province_job'),
					                    'job_time_job'   		=>      $this->filter->injection($time_job),
					                    'job_salary'     		=>      $this->filter->injection($salary_job.$datesalary_job),
					                    'job_timetry'    		=>      $this->filter->injection($try_job),
					                    'job_interest'     		=>      trim($this->filter->injection_html($this->input->post('interest_job'))),
					                    'job_quantity'     		=>      (int)$this->input->post('quantity_job'),
					                    'job_record'     		=>      trim($this->filter->injection_html($this->input->post('record_job'))),
					                    'job_time_surrend'    	=>      mktime(0, 0, 0, (int)$this->input->post('month_job'), (int)$this->input->post('day_job'), (int)$this->input->post('year_job')),
					                    'job_detail'      		=>      trim($this->filter->injection_html($this->input->post('txtContent'))),
					                    'job_jober'   			=>      trim($this->filter->injection_html($this->input->post('name_job'))),
                                        'job_address'      		=>      trim($this->filter->injection_html($this->input->post('address_job'))),
                                        'job_phone'       		=>      trim($this->filter->injection_html($this->input->post('phone_job'))),
                                        'job_mobile'   			=>      trim($this->filter->injection_html($this->input->post('mobile_job'))),
                                        'job_email'      		=>      trim($this->filter->injection_html($this->input->post('email_job'))),
                                        'job_website'       	=>      trim($this->filter->injection_html($this->filter->link($this->input->post('website_job')))),
                                        'job_name_contact'   	=>      trim($this->filter->injection_html($this->input->post('namecontact_job'))),
                                        'job_address_contact'   =>      trim($this->filter->injection_html($this->input->post('addresscontact_job'))),
                                        'job_phone_contact'     =>      trim($this->filter->injection_html($this->input->post('phonecontact_job'))),
                                        'job_mobile_contact'   	=>      trim($this->filter->injection_html($this->input->post('mobilecontact_job'))),
                                        'job_email_contact'     =>      trim($this->filter->injection_html($this->input->post('emailcontact_job'))),
                                        'job_yahoo'       		=>      trim($this->filter->injection_html($this->input->post('yahoo_job'))),
                                        'job_skype'   			=>      trim($this->filter->injection_html($this->input->post('skype_job'))),
                                        'job_best_contact'      =>      $this->filter->injection($bestcontact_job),
                                        'job_enddate'   		=>      mktime(0, 0, 0, (int)$this->input->post('endmonth_job'), (int)$this->input->post('endday_job'), (int)$this->input->post('endyear_job'))
										);
					if($this->job_model->update($dataEdit, "job_id = ".$job->job_id))
					{
						$this->session->set_flashdata('sessionSuccessEditJobAccount', 1);
					}
					$this->session->set_userdata('sessionTimePosted', time());
					redirect(base_url().trim(uri_string(), '/'), 'location');
				}
				else
				{
					$data['title_job'] = $job->job_title;
					$data['field_job'] = $job->job_field;
					$data['position_job'] = $job->job_position;
					$data['level_job'] = $job->job_level;
					$data['foreign_language_job'] = $job->job_foreign_language;
					$data['computer_job'] = $job->job_computer;
					$ageJob = explode('-', $job->job_age);
					$data['age1_job'] = $ageJob[0];
					$data['age2_job'] = array_pop($ageJob);
     				$data['sex_job'] = $job->job_sex;
					$data['require_job'] = $job->job_require;
     				$data['experience_job'] = $job->job_exper;
     				$data['province_job'] = $job->job_province;
     				if($job->job_time_job == $this->lang->line('time_job_1_job_edit'))
     				{
                        $data['time_job'] = 1;
     				}
     				elseif($job->job_time_job == $this->lang->line('time_job_2_job_edit'))
     				{
                        $data['time_job'] = 2;
     				}
     				elseif($job->job_time_job == $this->lang->line('time_job_3_job_edit'))
     				{
                        $data['time_job'] = 3;
     				}
     				elseif($job->job_time_job == $this->lang->line('time_job_4_job_edit'))
     				{
                        $data['time_job'] = 4;
     				}
     				else
     				{
                        $data['time_job'] = 5;
     				}
                    $salaryJob = explode('|', $job->job_salary);
                    $data['salary_job'] = $salaryJob[0];
                    $salaryJob = explode('/', array_pop($salaryJob));
                    $data['currency_job'] = $salaryJob[0];
                    $salaryJob = array_pop($salaryJob);
                    if($salaryJob == $this->lang->line('day_job_edit'))
                    {
                        $data['datesalary_job'] = 1;
                    }
                    elseif($salaryJob == $this->lang->line('year_job_edit'))
                    {
                        $data['datesalary_job'] = 3;
                    }
                    else
                    {
                        $data['datesalary_job'] = 2;
                    }
                    $timeTryJob = explode(' ', $job->job_timetry);
					$data['try_job'] = $timeTryJob[0];
					$timeTryJob = array_pop($timeTryJob);
					if($timeTryJob == $this->lang->line('day_job_edit'))
					{
                        $data['datetry_job'] = 1;
					}
					elseif($timeTryJob == $this->lang->line('year_job_edit'))
					{
                        $data['datetry_job'] = 3;
					}
					else
					{
                        $data['datetry_job'] = 2;
					}
					$data['interest_job'] = $job->job_interest;
					$data['quantity_job'] = $job->job_quantity;
					$data['record_job'] = $job->job_record;
					$data['day_job'] = date('d', $job->job_time_surrend);
					$data['month_job'] = date('m', $job->job_time_surrend);
     				$data['year_job'] = date('Y', $job->job_time_surrend);
					$data['txtContent'] = $job->job_detail;
     				$data['name_job'] = $job->job_jober;
     				$data['address_job'] = $job->job_address;
                    $data['phone_job'] = $job->job_phone;
                    $data['mobile_job'] = $job->job_mobile;
                    $data['email_job'] = $job->job_email;
                    $data['website_job'] = $job->job_website;
					$data['namecontact_job'] = $job->job_name_contact;
					$data['addresscontact_job'] = $job->job_address_contact;
					$data['phonecontact_job'] = $job->job_phone_contact;
					$data['mobilecontact_job'] = $job->job_mobile_contact;
					$data['emailcontact_job'] = $job->job_email_contact;
					$data['yahoo_job'] = $job->job_yahoo;
					$data['skype_job'] = $job->job_skype;
					if($job->job_best_contact == $this->lang->line('best_contact_1_contact_job_edit'))
     				{
                        $data['bestcontact_job'] = 1;
     				}
     				elseif($job->job_best_contact == $this->lang->line('best_contact_2_contact_job_edit'))
     				{
                        $data['bestcontact_job'] = 2;
     				}
     				elseif($job->job_best_contact == $this->lang->line('best_contact_3_contact_job_edit'))
     				{
                        $data['bestcontact_job'] = 3;
     				}
     				elseif($job->job_best_contact == $this->lang->line('best_contact_4_contact_job_edit'))
     				{
                        $data['bestcontact_job'] = 4;
     				}
     				else
     				{
                        $data['bestcontact_job'] = 5;
     				}
					$data['endday_job'] = date('d', $job->job_enddate);
     				$data['endmonth_job'] = date('m', $job->job_enddate);
     				$data['endyear_job'] = date('Y', $job->job_enddate);
				}
                #BEGIN: Create captcha post job
                $this->load->library('captcha');
	            $codeCaptcha = $this->captcha->code(6);
				$this->session->set_flashdata('sessionCaptchaEditJobAccount', $codeCaptcha);
				$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.(int)$this->session->userdata('sessionUser').'edij.jpg';
				$this->session->set_flashdata('sessionPathCaptchaEditJobAccount', $imageCaptcha);
				$this->captcha->create($codeCaptcha, $imageCaptcha);
				if(file_exists($imageCaptcha))
				{
					$data['imageCaptchaEditJobAccount'] = $imageCaptcha;
				}
				#END Create captcha post job
			}
			#Load view
			$this->load->view('home/account/job/edit', $data);
		}
		elseif(strtolower($this->uri->segment(3)) == 'favorite')
		{
            $this->load->model('job_favorite_model');
            #BEGIN: Menu 2
			$data['menuSelected'] = 'favorite_job';
			#END Menu 2
            #BEGIN: Delete
			if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
			{
				$this->job_favorite_model->delete($this->input->post('checkone'), "jof_id", (int)$this->session->userdata('sessionUser'), "jof_user");
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			#END Delete
            #Define url for $getVar
			$action = array('search', 'keyword', 'sort', 'by', 'page');
			$getVar = $this->uri->uri_to_assoc(4, $action);
            #BEGIN: Search & sort
			$where = "jof_user = ".(int)$this->session->userdata('sessionUser');
			$sort = 'jof_id';
			$by = 'DESC';
			$sortUrl = '';
			$pageSort = '';
			$pageUrl = '';
			$keyword = '';
			if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
			{
	            $keyword = $this->filter->html($getVar['keyword']);
				switch(strtolower($getVar['search']))
				{
					case 'title':
					    $sortUrl .= '/search/title/keyword/'.$getVar['keyword'];
					    $pageUrl .= '/search/title/keyword/'.$getVar['keyword'];
					    $where .= " AND job_title LIKE '%".$this->filter->injection_html($getVar['keyword'])."%'";
					    break;
				}
			}
			#If have sort
			if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
			{
				switch(strtolower($getVar['sort']))
				{
					case 'title':
					    $pageUrl .= '/sort/title';
					    $sort = "job_title";
					    break;
                    case 'salary':
					    $pageUrl .= '/sort/salary';
					    $sort = "job_salary";
					    break;
                    case 'postdate':
					    $pageUrl .= '/sort/postdate';
					    $sort = "job_begindate";
					    break;
	                case 'date':
					    $pageUrl .= '/sort/date';
					    $sort = "jof_date";
					    break;
					default:
					    $pageUrl .= '/sort/id';
					    $sort = "jof_id";
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
			#END Search & sort
			#Keyword
			$data['keyword'] = $keyword;
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'account/job/favorite'.$sortUrl.'/sort/';
			$data['pageSort'] = $pageSort;
			#END Create link sort
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->job_favorite_model->fetch_join("jof_id", "LEFT", "tbtt_job", "tbtt_job_favorite.jof_job = tbtt_job.job_id", $where, "", ""));
	        $config['base_url'] = base_url().'account/job/favorite'.$pageUrl.'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = Setting::settingOtherAccount;
			$config['num_links'] = 1;
			$config['uri_segment'] = 4;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			#sTT - So thu tu
			$data['sTT'] = $start + 1;
			#Fetch record
			$select = "jof_id, jof_date, job_id, job_title, job_view, job_field, job_salary, job_begindate";
			$limit = Setting::settingOtherAccount;
			$data['favoriteJob'] = $this->job_favorite_model->fetch_join($select, "LEFT", "tbtt_job", "tbtt_job_favorite.jof_job = tbtt_job.job_id", $where, $sort, $by, $start, $limit);
			#Load view
			$this->load->view('home/account/job/favorite', $data);
		}
		else
		{
            #BEGIN: Delete
			if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
			{
				$idCheckOneJob = implode(',', $this->input->post('checkone'));
				$checkOneJob = $this->job_model->fetch("job_id", "job_id IN($idCheckOneJob) AND job_user = ".(int)$this->session->userdata('sessionUser'));
				$idJob = array();
				foreach($checkOneJob as $checkOneJobArray)
				{
                    $idJob[] = $checkOneJobArray->job_id;
				}
				if(count($idJob) > 0)
				{
                    $this->load->model('job_favorite_model');
					$this->load->model('job_bad_model');
					$this->job_favorite_model->delete($idJob, "jof_job");
					$this->job_bad_model->delete($idJob, "jba_job");
					$this->job_model->delete($idJob, "job_id");
				}
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			#END Delete
            $this->load->library('hash');
			#BEGIN: Search & sort
			$where = "job_user = ".(int)$this->session->userdata('sessionUser');
			$sort = 'job_id';
			$by = 'DESC';
			$sortUrl = '';
			$pageSort = '';
			$pageUrl = '';
			$keyword = '';
			if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
			{
	            $keyword = $this->filter->html($getVar['keyword']);
				switch(strtolower($getVar['search']))
				{
					case 'title':
					    $sortUrl .= '/search/title/keyword/'.$getVar['keyword'];
					    $pageUrl .= '/search/title/keyword/'.$getVar['keyword'];
					    $where .= " AND job_title LIKE '%".$this->filter->injection_html($getVar['keyword'])."%'";
					    break;
				}
			}
			#If have sort
			if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
			{
				switch(strtolower($getVar['sort']))
				{
					case 'title':
					    $pageUrl .= '/sort/title';
					    $sort = "job_title";
					    break;
	                case 'field':
					    $pageUrl .= '/sort/field';
					    $sort = "fie_name";
					    break;
                    case 'postdate':
					    $pageUrl .= '/sort/postdate';
					    $sort = "job_begindate";
					    break;
	                case 'enddate':
					    $pageUrl .= '/sort/enddate';
					    $sort = "job_enddate";
					    break;
					default:
					    $pageUrl .= '/sort/id';
					    $sort = "job_id";
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
			#END Search & sort
			#Keyword
			$data['keyword'] = $keyword;
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'account/job'.$sortUrl.'/sort/';
			$data['pageSort'] = $pageSort;
			#END Create link sort
			#BEGIN: Status
			$statusUrl = $pageUrl.$pageSort;
			$data['statusUrl'] = base_url().'account/job'.$statusUrl;
			if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
			{
				switch(strtolower($getVar['status']))
				{
					case 'active':
					    $this->job_model->update(array('job_status'=>1), "job_id = ".(int)$getVar['id']." AND job_user = ".(int)$this->session->userdata('sessionUser'));
						break;
					case 'deactive':
					    $this->job_model->update(array('job_status'=>0), "job_id = ".(int)$getVar['id']." AND job_user = ".(int)$this->session->userdata('sessionUser'));
						break;
				}
				redirect($data['statusUrl'], 'location');
			}
			#END Status
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->job_model->fetch_join("job_id", "LEFT", "tbtt_field", "tbtt_job.job_field = tbtt_field.fie_id", "", "", "", "", "", "", $where, "", ""));
	        $config['base_url'] = base_url().'account/job'.$pageUrl.'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = Setting::settingOtherAccount;
			$config['num_links'] = 1;
			$config['uri_segment'] = 4;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			#sTT - So thu tu
			$data['sTT'] = $start + 1;
			#Fetch record
			$select = "job_id, job_title, job_field, job_view, job_begindate, job_enddate, job_status, fie_name";
			$limit = Setting::settingOtherAccount;
			$data['job'] = $this->job_model->fetch_join($select, "LEFT", "tbtt_field", "tbtt_job.job_field = tbtt_field.fie_id", "", "", "", "", "", "", $where, $sort, $by, $start, $limit);
			#Load view
			$this->load->view('home/account/job/defaults', $data);
		}
	}
	
	function employ()
	{
        $this->load->model('employ_model');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Menu 1
		$data['menuSelected'] = 'employ';
		$data['menuType'] = 'account';
		#END Menu 1
		#BEGIN: Advertise
		$data['advertisePage'] = 'account';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Define url for $getVar
		$action = array('edit', 'search', 'keyword', 'sort', 'by', 'status', 'id', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		if(strtolower($this->uri->segment(3)) == 'edit' && $getVar['edit'] != FALSE)
		{
            $employ = $this->employ_model->get("*", "emp_id = ".(int)$getVar['edit']." AND emp_user = ".(int)$this->session->userdata('sessionUser'));
			if(count($employ) != 1 || !$this->check->is_id($getVar['edit']))
			{
				redirect(base_url().'account/employ', 'location');
				die();
			}
            #BEGIN: Unlink captcha
            $this->load->helper('unlink');
            unlink_captcha($this->session->flashdata('sessionPathCaptchaEditEmployAccount'));
			#END Unlink captcha
			if($this->session->flashdata('sessionSuccessEditEmployAccount'))
			{
	            $data['successEditEmployAccount'] = true;
			}
			else
			{
				$this->load->library('form_validation');
	            $data['successEditEmployAccount'] = false;
	            #BEGIN: Province
	            $this->load->model('province_model');
	            $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
	            #END Province
	            #BEGIN: Field
	            $this->load->model('field_model');
	            $data['field'] = $this->field_model->fetch("fie_id, fie_name", "fie_status = 1", "fie_order", "ASC");
	            #END Field
				if($this->input->post('captcha_employ') && time() - (int)$this->session->userdata('sessionTimePosted') <= (int)Setting::settingTimePost)
				{
                    redirect(base_url().'account/employ/edit/'.$getVar['edit'], 'location');
					die();
				}
				#BEGIN: Set rules
				$this->form_validation->set_rules('title_employ', 'lang:title_employ_label_employ_edit', 'trim|required');
				$this->form_validation->set_rules('field_employ', 'lang:field_employ_label_employ_edit', 'required|callback__exist_field');
				$this->form_validation->set_rules('position_employ', 'lang:position_employ_label_employ_edit', 'trim|required');
				$this->form_validation->set_rules('province_employ', 'lang:province_employ_label_employ_edit', 'required|callback__exist_province');
				$this->form_validation->set_rules('salary_employ', 'lang:salary_employ_label_employ_edit', 'trim|required|is_natural_no_zero');
				$this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_employ_edit', 'trim|required|min_length[10]|max_length[10000]');
				$this->form_validation->set_rules('name_employ', 'lang:name_employ_label_employ_edit', 'trim|required');
				$this->form_validation->set_rules('level_employ', 'lang:level_employ_label_employ_edit', 'trim|required');
				$this->form_validation->set_rules('address_employ', 'lang:address_employ_label_employ_edit', 'trim|required');
				$this->form_validation->set_rules('phone_employ', 'lang:phone_employ_label_employ_edit', 'trim|required|callback__is_phone');
				$this->form_validation->set_rules('mobile_employ', 'lang:mobile_employ_label_employ_edit', 'trim|callback__is_phone');
				$this->form_validation->set_rules('email_employ', 'lang:email_employ_label_employ_edit', 'trim|required|valid_email');
				$this->form_validation->set_rules('yahoo_employ', 'lang:yahoo_employ_label_employ_edit', 'trim|callback__valid_nick');
				$this->form_validation->set_rules('skype_employ', 'lang:skype_employ_label_employ_edit', 'trim|callback__valid_nick');
				$this->form_validation->set_rules('endday_employ', 'lang:endday_employ_label_employ_edit', 'required|callback__valid_enddate_employ_edit');
				$this->form_validation->set_rules('captcha_employ', 'lang:captcha_employ_label_employ_edit', 'required|callback__valid_captcha_employ_edit');
				#END Set rules
				#BEGIN: Set message
				$this->form_validation->set_message('required', $this->lang->line('required_message'));
				$this->form_validation->set_message('_valid_nick', $this->lang->line('_valid_nick_message'));
				$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
				$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
				$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
				$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
				$this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message'));
				$this->form_validation->set_message('_exist_field', $this->lang->line('_exist_field_message'));
				$this->form_validation->set_message('_valid_enddate_employ_edit', $this->lang->line('_valid_enddate_message'));
				$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
				$this->form_validation->set_message('_valid_captcha_employ_edit', $this->lang->line('_valid_captcha_message_employ_edit'));
				$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
				#END Set message
				if($this->form_validation->run() != FALSE)
				{
					if($this->input->post('time_employ') == '1')
					{
						$time_employ = $this->lang->line('time_employ_1_employ_edit');
					}
					elseif($this->input->post('time_employ') == '2')
					{
                        $time_employ = $this->lang->line('time_employ_2_employ_edit');
					}
					elseif($this->input->post('time_employ') == '3')
					{
                        $time_employ = $this->lang->line('time_employ_3_employ_edit');
					}
					elseif($this->input->post('time_employ') == '4')
					{
                        $time_employ = $this->lang->line('time_employ_4_employ_edit');
					}
					else
					{
                        $time_employ = $this->lang->line('time_employ_5_employ_edit');
					}
					if(strtoupper($this->input->post('currency_employ')) == 'USD')
					{
						$salary_employ = (int)$this->input->post('salary_employ').'|USD/';
					}
					else
					{
                        $salary_employ = (int)$this->input->post('salary_employ').'|VND/';
					}
					if($this->input->post('datesalary_employ') == '3')
					{
						$datesalary_employ = $this->lang->line('year_employ_edit');
					}
					elseif($this->input->post('datesalary_employ') == '1')
					{
                        $datesalary_employ = $this->lang->line('day_employ_edit');
					}
					else
					{
                        $datesalary_employ = $this->lang->line('month_employ_edit');
					}
					$dataEdit = array(
					                    'emp_title'      		=>      trim($this->filter->injection_html($this->input->post('title_employ'))),
					                    'emp_field'     		=>      (int)$this->input->post('field_employ'),
					                    'emp_position'  		=>      trim($this->filter->injection_html($this->input->post('position_employ'))),
					                    'emp_province'    		=>      (int)$this->input->post('province_employ'),
					                    'emp_time_job'   		=>      $this->filter->injection($time_employ),
					                    'emp_salary'     		=>      $this->filter->injection($salary_employ.$datesalary_employ),
					                    'emp_detail'      		=>      trim($this->filter->injection_html($this->input->post('txtContent'))),
					                    'emp_fullname'   		=>      trim($this->filter->injection_html($this->input->post('name_employ'))),
					                    'emp_age'    			=>      (int)$this->input->post('age_employ'),
					                    'emp_sex'     			=>      (int)$this->input->post('sex_employ'),
                         				'emp_level'  			=>      trim($this->filter->injection_html($this->input->post('level_employ'))),
					                    'emp_foreign_language' 	=>      trim($this->filter->injection_html($this->input->post('foreign_language_employ'))),
					                    'emp_computer'   		=>      trim($this->filter->injection_html($this->input->post('computer_employ'))),
					                    'emp_exper'      		=>      (int)$this->input->post('experience_employ'),
					                    'emp_address'      		=>      trim($this->filter->injection_html($this->input->post('address_employ'))),
                                        'emp_phone'       		=>      trim($this->filter->injection_html($this->input->post('phone_employ'))),
                                        'emp_mobile'   			=>      trim($this->filter->injection_html($this->input->post('mobile_employ'))),
                                        'emp_email'      		=>      trim($this->filter->injection_html($this->input->post('email_employ'))),
					                    'emp_yahoo'       		=>      trim($this->filter->injection_html($this->input->post('yahoo_employ'))),
                                        'emp_skype'   			=>      trim($this->filter->injection_html($this->input->post('skype_employ'))),
                                        'emp_enddate'   		=>      mktime(0, 0, 0, (int)$this->input->post('endmonth_employ'), (int)$this->input->post('endday_employ'), (int)$this->input->post('endyear_employ'))
										);
					if($this->employ_model->update($dataEdit, "emp_id = ".$employ->emp_id))
					{
						$this->session->set_flashdata('sessionSuccessEditEmployAccount', 1);
					}
					$this->session->set_userdata('sessionTimePosted', time());
					redirect(base_url().trim(uri_string(), '/'), 'location');
				}
				else
				{
					$data['title_employ'] = $employ->emp_title;
					$data['field_employ'] = $employ->emp_field;
					$data['position_employ'] = $employ->emp_position;
     				$data['province_employ'] = $employ->emp_province;
     				if($employ->emp_time_job == $this->lang->line('time_employ_1_employ_edit'))
     				{
                        $data['time_employ'] = 1;
     				}
     				elseif($employ->emp_time_job == $this->lang->line('time_employ_2_employ_edit'))
     				{
                        $data['time_employ'] = 2;
     				}
     				elseif($employ->emp_time_job == $this->lang->line('time_employ_3_employ_edit'))
     				{
                        $data['time_employ'] = 3;
     				}
     				elseif($employ->emp_time_job == $this->lang->line('time_employ_4_employ_edit'))
     				{
                        $data['time_employ'] = 4;
     				}
     				else
     				{
                        $data['time_employ'] = 5;
     				}
     				$salaryEmploy = explode('|', $employ->emp_salary);
                    $data['salary_employ'] = $salaryEmploy[0];
                    $salaryEmploy = explode('/', array_pop($salaryEmploy));
                    $data['currency_employ'] = $salaryEmploy[0];
                    $salaryEmploy = array_pop($salaryEmploy);
                    if($salaryEmploy == $this->lang->line('year_employ_edit'))
                    {
                        $data['datesalary_employ'] = 3;
                    }
                    elseif($salaryEmploy == $this->lang->line('day_employ_edit'))
                    {
                        $data['datesalary_employ'] = 1;
                    }
                    else
                    {
                        $data['datesalary_employ'] = 2;
                    }
					$data['txtContent'] = $employ->emp_detail;
     				$data['name_employ'] = $employ->emp_fullname;
     				$data['age_employ'] = $employ->emp_age;
     				$data['sex_employ'] = $employ->emp_sex;
     				$data['level_employ'] = $employ->emp_level;
					$data['foreign_language_employ'] = $employ->emp_foreign_language;
					$data['computer_employ'] = $employ->emp_computer;
     				$data['experience_employ'] = $employ->emp_exper;
     				$data['address_employ'] = $employ->emp_address;
                    $data['phone_employ'] = $employ->emp_phone;
                    $data['mobile_employ'] = $employ->emp_mobile;
                    $data['email_employ'] = $employ->emp_email;
					$data['yahoo_employ'] = $employ->emp_yahoo;
					$data['skype_employ'] = $employ->emp_skype;
					$data['endday_employ'] = date('d', $employ->emp_enddate);
     				$data['endmonth_employ'] = date('m', $employ->emp_enddate);
     				$data['endyear_employ'] = date('Y', $employ->emp_enddate);
				}
                #BEGIN: Create captcha post employ
                $this->load->library('captcha');
	            $codeCaptcha = $this->captcha->code(6);
				$this->session->set_flashdata('sessionCaptchaEditEmployAccount', $codeCaptcha);
				$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.(int)$this->session->userdata('sessionUser').'edie.jpg';
				$this->session->set_flashdata('sessionPathCaptchaEditEmployAccount', $imageCaptcha);
				$this->captcha->create($codeCaptcha, $imageCaptcha);
				if(file_exists($imageCaptcha))
				{
					$data['imageCaptchaEditEmployAccount'] = $imageCaptcha;
				}
				#END Create captcha post employ
			}
			#Load view
			$this->load->view('home/account/employ/edit', $data);
		}
		elseif(strtolower($this->uri->segment(3)) == 'favorite')
		{
            $this->load->model('employ_favorite_model');
            #BEGIN: Menu 2
			$data['menuSelected'] = 'favorite_employ';
			#END Menu 2
            #BEGIN: Delete
			if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
			{
				$this->employ_favorite_model->delete($this->input->post('checkone'), "emf_id", (int)$this->session->userdata('sessionUser'), "emf_user");
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			#END Delete
            #Define url for $getVar
			$action = array('search', 'keyword', 'sort', 'by', 'page');
			$getVar = $this->uri->uri_to_assoc(4, $action);
            #BEGIN: Search & sort
			$where = "emf_user = ".(int)$this->session->userdata('sessionUser');
			$sort = 'emf_id';
			$by = 'DESC';
			$sortUrl = '';
			$pageSort = '';
			$pageUrl = '';
			$keyword = '';
			if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
			{
	            $keyword = $this->filter->html($getVar['keyword']);
				switch(strtolower($getVar['search']))
				{
					case 'title':
					    $sortUrl .= '/search/title/keyword/'.$getVar['keyword'];
					    $pageUrl .= '/search/title/keyword/'.$getVar['keyword'];
					    $where .= " AND emp_title LIKE '%".$this->filter->injection_html($getVar['keyword'])."%'";
					    break;
				}
			}
			#If have sort
			if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
			{
				switch(strtolower($getVar['sort']))
				{
					case 'title':
					    $pageUrl .= '/sort/title';
					    $sort = "emp_title";
					    break;
                    case 'salary':
					    $pageUrl .= '/sort/salary';
					    $sort = "emp_salary";
					    break;
                    case 'postdate':
					    $pageUrl .= '/sort/postdate';
					    $sort = "emp_begindate";
					    break;
	                case 'date':
					    $pageUrl .= '/sort/date';
					    $sort = "emf_date";
					    break;
					default:
					    $pageUrl .= '/sort/id';
					    $sort = "emf_id";
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
			#END Search & sort
			#Keyword
			$data['keyword'] = $keyword;
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'account/employ/favorite'.$sortUrl.'/sort/';
			$data['pageSort'] = $pageSort;
			#END Create link sort
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->employ_favorite_model->fetch_join("emf_id", "LEFT", "tbtt_employ", "tbtt_employ_favorite.emf_employ = tbtt_employ.emp_id", $where, "", ""));
	        $config['base_url'] = base_url().'account/employ/favorite'.$pageUrl.'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = Setting::settingOtherAccount;
			$config['num_links'] = 1;
			$config['uri_segment'] = 4;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			#sTT - So thu tu
			$data['sTT'] = $start + 1;
			#Fetch record
			$select = "emf_id, emf_date, emp_id, emp_title, emp_view, emp_field, emp_salary, emp_begindate";
			$limit = Setting::settingOtherAccount;
			$data['favoriteEmploy'] = $this->employ_favorite_model->fetch_join($select, "LEFT", "tbtt_employ", "tbtt_employ_favorite.emf_employ = tbtt_employ.emp_id", $where, $sort, $by, $start, $limit);
			#Load view
			$this->load->view('home/account/employ/favorite', $data);
		}
		else
		{
            #BEGIN: Delete
			if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
			{
				$idCheckOneEmploy = implode(',', $this->input->post('checkone'));
				$checkOneEmploy = $this->employ_model->fetch("emp_id", "emp_id IN($idCheckOneEmploy) AND emp_user = ".(int)$this->session->userdata('sessionUser'));
				$idEmploy = array();
				foreach($checkOneEmploy as $checkOneEmployArray)
				{
                    $idEmploy[] = $checkOneEmployArray->emp_id;
				}
				if(count($idEmploy) > 0)
				{
                    $this->load->model('employ_favorite_model');
					$this->load->model('employ_bad_model');
					$this->employ_favorite_model->delete($idEmploy, "emf_employ");
					$this->employ_bad_model->delete($idEmploy, "emb_employ");
					$this->employ_model->delete($idEmploy, "emp_id");
				}
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			#END Delete
            $this->load->library('hash');
			#BEGIN: Search & sort
			$where = "emp_user = ".(int)$this->session->userdata('sessionUser');
			$sort = 'emp_id';
			$by = 'DESC';
			$sortUrl = '';
			$pageSort = '';
			$pageUrl = '';
			$keyword = '';
			if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
			{
	            $keyword = $this->filter->html($getVar['keyword']);
				switch(strtolower($getVar['search']))
				{
					case 'title':
					    $sortUrl .= '/search/title/keyword/'.$getVar['keyword'];
					    $pageUrl .= '/search/title/keyword/'.$getVar['keyword'];
					    $where .= " AND emp_title LIKE '%".$this->filter->injection_html($getVar['keyword'])."%'";
					    break;
				}
			}
			#If have sort
			if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
			{
				switch(strtolower($getVar['sort']))
				{
					case 'title':
					    $pageUrl .= '/sort/title';
					    $sort = "emp_title";
					    break;
	                case 'field':
					    $pageUrl .= '/sort/field';
					    $sort = "fie_name";
					    break;
                    case 'postdate':
					    $pageUrl .= '/sort/postdate';
					    $sort = "emp_begindate";
					    break;
	                case 'enddate':
					    $pageUrl .= '/sort/enddate';
					    $sort = "emp_enddate";
					    break;
					default:
					    $pageUrl .= '/sort/id';
					    $sort = "emp_id";
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
			#END Search & sort
			#Keyword
			$data['keyword'] = $keyword;
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'account/employ'.$sortUrl.'/sort/';
			$data['pageSort'] = $pageSort;
			#END Create link sort
			#BEGIN: Status
			$statusUrl = $pageUrl.$pageSort;
			$data['statusUrl'] = base_url().'account/employ'.$statusUrl;
			if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
			{
				switch(strtolower($getVar['status']))
				{
					case 'active':
					    $this->employ_model->update(array('emp_status'=>1), "emp_id = ".(int)$getVar['id']." AND emp_user = ".(int)$this->session->userdata('sessionUser'));
						break;
					case 'deactive':
					    $this->employ_model->update(array('emp_status'=>0), "emp_id = ".(int)$getVar['id']." AND emp_user = ".(int)$this->session->userdata('sessionUser'));
						break;
				}
				redirect($data['statusUrl'], 'location');
			}
			#END Status
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->employ_model->fetch_join("emp_id", "LEFT", "tbtt_field", "tbtt_employ.emp_field = tbtt_field.fie_id", "", "", "", "", "", "", $where, "", ""));
	        $config['base_url'] = base_url().'account/employ'.$pageUrl.'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = Setting::settingOtherAccount;
			$config['num_links'] = 1;
			$config['uri_segment'] = 4;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			#sTT - So thu tu
			$data['sTT'] = $start + 1;
			#Fetch record
			$select = "emp_id, emp_title, emp_field, emp_view, emp_begindate, emp_enddate, emp_status, fie_name";
			$limit = Setting::settingOtherAccount;
			$data['employ'] = $this->employ_model->fetch_join($select, "LEFT", "tbtt_field", "tbtt_employ.emp_field = tbtt_field.fie_id", "", "", "", "", "", "", $where, $sort, $by, $start, $limit);
			#Load view
			$this->load->view('home/account/employ/defaults', $data);
		}
	}
	
	function customer()
	{
        #BEGIN: CHECK GROUP
		if((int)$this->session->userdata('sessionGroup') == 1)
		{
			redirect(base_url().'account', 'location');
			die();
		}
		#END CHECK GROUP
        $this->load->model('showcart_model');
		#BEGIN: Delete - update status
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
			$idCheckOne = implode(',', $this->input->post('checkone'));
			$this->showcart_model->update(array('shc_status'=>0), "shc_id IN($idCheckOne) AND shc_saler = ".(int)$this->session->userdata('sessionUser'));
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete - update status
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Menu
		$data['menuSelected'] = 'customer';
		$data['menuType'] = 'account';
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'account';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
        #Define url for $getVar
		$action = array('search', 'keyword', 'sort', 'by', 'process', 'id', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Search & Filter
		$where = "shc_status = 1 AND shc_saler = ".(int)$this->session->userdata('sessionUser');
		$sort = "shc_id";
		$by = "DESC";
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = '';
		#If search
		if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
		{
            $keyword = $this->filter->html($getVar['keyword']);
			switch(strtolower($getVar['search']))
			{
				case 'customer':
				    $sortUrl .= '/search/customer/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/customer/keyword/'.$getVar['keyword'];
				    $where .= " AND use_fullname LIKE '%".$this->filter->injection_html($getVar['keyword'])."%'";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
                case 'customer':
				    $pageUrl .= '/sort/customer';
				    $sort = "use_fullname";
				    break;
				case 'product':
				    $pageUrl .= '/sort/product';
				    $sort = "pro_name";
				    break;
                case 'cost':
				    $pageUrl .= '/sort/cost';
				    $sort = "pro_cost";
				    break;
                case 'quantity':
				    $pageUrl .= '/sort/quantity';
				    $sort = "shc_quantity";
				    break;
                case 'buydate':
				    $pageUrl .= '/sort/buydate';
				    $sort = "shc_buydate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort = "shc_id";
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
		#END Search & Filter
		#Keyword
		$data['keyword'] = $keyword;
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'account/customer'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Process
		$processUrl = $pageUrl.$pageSort;
		$data['processUrl'] = base_url().'account/customer'.$processUrl;
		if($getVar['process'] != FALSE && trim($getVar['process']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
			switch(strtolower($getVar['process']))
			{
				case 'active':
					$this->showcart_model->update(array('shc_process'=>1), "shc_id = ".(int)$getVar['id']." AND shc_saler = ".(int)$this->session->userdata('sessionUser'));
					break;
				case 'deactive':
					$this->showcart_model->update(array('shc_process'=>0), "shc_id = ".(int)$getVar['id']." AND shc_saler = ".(int)$this->session->userdata('sessionUser'));
					break;
			}
			redirect($data['processUrl'], 'location');
		}
		#END Process
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->showcart_model->fetch_join("shc_id", "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", "LEFT", "tbtt_user", "tbtt_showcart.shc_buyer = tbtt_user.use_id", $where, "", ""));
        $config['base_url'] = base_url().'account/customer'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingOtherAccount;
		$config['num_links'] = 1;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#sTT - So thu tu
		$data['sTT'] = $start + 1;
		#Fetch record
		$select = "shc_id, shc_buydate, shc_process, shc_quantity, pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_cost, pro_currency, pro_view, use_fullname, use_email, use_phone";
		$limit = Setting::settingOtherAccount;
		$data['customer'] = $this->showcart_model->fetch_join($select, "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", "LEFT", "tbtt_user", "tbtt_showcart.shc_buyer = tbtt_user.use_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('home/account/showcart/customer', $data);
	}
	
	function showcart()
	{
        $this->load->model('showcart_model');
		#BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
			$this->showcart_model->delete($this->input->post('checkone'), "shc_id", (int)$this->session->userdata('sessionUser'), "shc_buyer");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
		$data['successAddShowcart'] = '';
		if($this->session->flashdata('sessionSuccessAddShowcart'))
		{
			$data['successAddShowcart'] = $this->session->flashdata('sessionSuccessAddShowcart');
		}
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Menu
		$data['menuSelected'] = 'showcart';
		$data['menuType'] = 'account';
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'account';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
        #Define url for $getVar
		$action = array('search', 'keyword', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Search & Filter
		$where = "shc_buyer = ".(int)$this->session->userdata('sessionUser');
		$sort = "shc_id";
		$by = "DESC";
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = '';
		#If search
		if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
		{
            $keyword = $this->filter->html($getVar['keyword']);
			switch(strtolower($getVar['search']))
			{
				case 'name':
				    $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $where .= " AND pro_name LIKE '%".$this->filter->injection_html($getVar['keyword'])."%'";
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
				    $sort = "pro_name";
				    break;
                case 'cost':
				    $pageUrl .= '/sort/cost';
				    $sort = "pro_cost";
				    break;
                case 'quantity':
				    $pageUrl .= '/sort/quantity';
				    $sort = "shc_quantity";
				    break;
                case 'saler':
				    $pageUrl .= '/sort/saler';
				    $sort = "use_fullname";
				    break;
                case 'buydate':
				    $pageUrl .= '/sort/buydate';
				    $sort = "shc_buydate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort = "shc_id";
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
		#END Search & Filter
		#Keyword
		$data['keyword'] = $keyword;
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'account/showcart'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->showcart_model->fetch_join("shc_id", "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", "LEFT", "tbtt_user", "tbtt_showcart.shc_saler = tbtt_user.use_id", $where, "", ""));
        $config['base_url'] = base_url().'account/showcart'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingOtherAccount;
		$config['num_links'] = 1;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#sTT - So thu tu
		$data['sTT'] = $start + 1;
		#Fetch record
		$select = "shc_id, shc_buydate, shc_process, shc_quantity, pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_cost, pro_currency, pro_view, use_fullname, use_email, use_phone";
		$limit = Setting::settingOtherAccount;
		$data['showcart'] = $this->showcart_model->fetch_join($select, "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", "LEFT", "tbtt_user", "tbtt_showcart.shc_saler = tbtt_user.use_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('home/account/showcart/showcart', $data);
	}
    
    function ajax()
    {
        $this->load->library('hash');
        if($this->input->post('id') && $this->check->is_id($this->input->post('id')) && $this->input->post('enddate') && $this->input->post('token') && $this->input->post('token') == $this->hash->create($this->session->userdata('sessionUser')))
        {
            $id = (int)$this->input->post('id');
            $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $endDate = explode('-', $this->input->post('enddate'));
            if(isset($endDate[0]) && isset($endDate[1]) && isset($endDate[2]))
            {
                $endDate = mktime(0, 0, 0, $endDate[1], $endDate[0], $endDate[2]);
            }
            else
            {
                $endDate = $currentDate;
            }
            $maxDate = $currentDate+(6*31*24*3600);#6 month
            switch((int)$this->input->post('type'))
            {
                case 2:
                    $ads = $this->ads_model->get("ads_id", "ads_id = $id AND ads_user = ".(int)$this->session->userdata('sessionUser'));
                    if(count($ads) == 1)
                    {
                        if($endDate > $currentDate)
                        {
                            if($endDate > $maxDate)
                            {
                                $endDate = $maxDate;
                            }
                            $this->ads_model->update(array('ads_enddate'=>(int)$endDate), "ads_id = $id AND ads_user = ".(int)$this->session->userdata('sessionUser'));
                        }
                    }
                    break;
                case 3:
                    $this->load->model('job_model');
                    $job = $this->job_model->get("job_id", "job_id = $id AND job_user = ".(int)$this->session->userdata('sessionUser'));
                    if(count($job) == 1)
                    {
                        if($endDate > $currentDate)
                        {
                            if($endDate > $maxDate)
                            {
                                $endDate = $maxDate;
                            }
                            $this->job_model->update(array('job_enddate'=>(int)$endDate), "job_id = $id AND job_user = ".(int)$this->session->userdata('sessionUser'));
                        }
                    }
                    break;
                case 4:
                    $this->load->model('employ_model');
                    $employ = $this->employ_model->get("emp_id", "emp_id = $id AND emp_user = ".(int)$this->session->userdata('sessionUser'));
                    if(count($employ) == 1)
                    {
                        if($endDate > $currentDate)
                        {
                            if($endDate > $maxDate)
                            {
                                $endDate = $maxDate;
                            }
                            $this->employ_model->update(array('emp_enddate'=>(int)$endDate), "emp_id = $id AND emp_user = ".(int)$this->session->userdata('sessionUser'));
                        }
                    }
                    break;
                default:
                    $this->load->model('product_model');
                    $product = $this->product_model->get("pro_id", "pro_id = $id AND pro_user = ".(int)$this->session->userdata('sessionUser'));
                    if(count($product) == 1)
                    {
                        if($endDate > $currentDate)
                        {
                            if($endDate > $maxDate)
                            {
                                $endDate = $maxDate;
                            }
                            $this->product_model->update(array('pro_enddate'=>(int)$endDate), "pro_id = $id AND pro_user = ".(int)$this->session->userdata('sessionUser'));
                        }
                    }
            }
        }
        else
        {
            show_404();
        }
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
	
	function _exist_email_edit()
	{
        if(count($this->user_model->get("use_id", "use_email = '".trim(strtolower($this->filter->injection_html($this->input->post('email_account'))))."'")) > 0)
		{
			return false;
		}
		return true;
	}
	
	function _valid_captcha_edit($str)
	{
        if($this->session->flashdata('sessionCaptchaEditAccount') && $this->session->flashdata('sessionCaptchaEditAccount') === $str)
		{
			return true;
		}
		return false;
	}
	
	function _valid_captcha_changepassword($str)
	{
        if($this->session->flashdata('sessionCaptchaChangePasswordAccount') && $this->session->flashdata('sessionCaptchaChangePasswordAccount') === $str)
		{
			return true;
		}
		return false;
	}

	function _valid_old_password()
	{
		$this->load->library('hash');
		$this->load->model('user_model');
        $user = $this->user_model->get("use_password, use_salt", "use_id = ".(int)$this->session->userdata('sessionUser'));
		if($user->use_password === $this->hash->create($this->input->post('oldpassword_changepass'), $user->use_salt, 'md5sha512'))
		{
			return true;
		}
		return false;
	}
	
	function _exist_shop()
	{
		$this->load->model('shop_model');
        if(count($this->shop_model->get("sho_id", "sho_name = '".trim($this->filter->injection_html($this->input->post('name_shop')))."'")) > 0)
		{
			return false;
		}
		return true;
	}
	
	function _exist_link_shop()
	{
        $this->load->model('shop_model');
        if(count($this->shop_model->get("sho_id", "sho_link = '".trim(strtolower($this->filter->injection_html($this->input->post('link_shop'))))."'")) > 0)
		{
			return false;
		}
		return true;
	}

	function _valid_link_shop($str)
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
	
	function _valid_website($str)
	{
        if(preg_match('/[^0-9a-z_.-]/i', $str))
		{
			return false;
		}
		return true;
	}
	
	function _valid_captcha_shop($str)
	{
        if($this->session->flashdata('sessionCaptchaEditShopAccount') && $this->session->flashdata('sessionCaptchaEditShopAccount') === $str)
		{
			return true;
		}
		return false;
	}
	
	function _valid_captcha_contact($str)
	{
        if($this->session->flashdata('sessionCaptchaSendContactAccount') && $this->session->flashdata('sessionCaptchaSendContactAccount') === $str)
		{
			return true;
		}
		return false;
	}
	
	function _exist_title_contact()
	{
        $this->load->model('contact_model');
		if(count($this->contact_model->get("con_id", "con_title = '".trim($this->filter->injection_html($this->input->post('title_contact')))."'")) > 0)
		{
			return false;
		}
		return true;
	}

	function _exist_category($str)
	{
		if(count($this->category_model->get("cat_id", "cat_status = 1 AND cat_id = ".(int)$str)) == 1)
		{
			return true;
		}
		return false;
	}
    
    function _valid_nick($str)
    {
        if(preg_match('/[^0-9a-z._-]/i', $str))
		{
			return false;
		}
		return true;
    }

	function _valid_enddate_edit_product()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$endDate = mktime(0, 0, 0, (int)$this->input->post('month_pro'), (int)$this->input->post('day_pro'), (int)$this->input->post('year_pro'));
		if($this->check->is_more($currentDate, $endDate))
		{
		    return false;
		}
		return true;
	}

	function _valid_captcha_edit_product($str)
	{
		if($this->session->flashdata('sessionCaptchaEditProductAccount') && $this->session->flashdata('sessionCaptchaEditProductAccount') === $str)
		{
			return true;
		}
		return false;
	}
	
	function _valid_enddate_edit_ads()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$endDate = mktime(0, 0, 0, (int)$this->input->post('month_ads'), (int)$this->input->post('day_ads'), (int)$this->input->post('year_ads'));
		if($this->check->is_more($currentDate, $endDate))
		{
		    return false;
		}
		return true;
	}

	function _valid_captcha_edit_ads($str)
	{
		if($this->session->flashdata('sessionCaptchaEditAdsAccount') && $this->session->flashdata('sessionCaptchaEditAdsAccount') === $str)
		{
			return true;
		}
		return false;
	}
	
	function _valid_age_job_edit()
	{
        $fromAge = (int)$this->input->post('age1_job');
		$toAge = (int)$this->input->post('age2_job');
		if($this->check->is_more($fromAge, $toAge, false))
		{
		    return false;
		}
		return true;
	}
	
	function _exist_field($str)
	{
		if(count($this->field_model->get("fie_id", "fie_status = 1 AND fie_id = ".(int)$str)) == 1)
		{
			return true;
		}
		return false;
	}

	function _valid_date_job_edit()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$date = mktime(0, 0, 0, (int)$this->input->post('month_job'), (int)$this->input->post('day_job'), (int)$this->input->post('year_job'));
		if($this->check->is_more($currentDate, $date))
		{
		    return false;
		}
		return true;
	}

	function _valid_enddate_job_edit()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$endDate = mktime(0, 0, 0, (int)$this->input->post('endmonth_job'), (int)$this->input->post('endday_job'), (int)$this->input->post('endyear_job'));
		if($this->check->is_more($currentDate, $endDate))
		{
		    return false;
		}
		return true;
	}

	function _valid_captcha_job_edit($str)
	{
		if($this->session->flashdata('sessionCaptchaEditJobAccount') && $this->session->flashdata('sessionCaptchaEditJobAccount') === $str)
		{
			return true;
		}
		return false;
	}
	
	function _valid_enddate_employ_edit()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$endDate = mktime(0, 0, 0, (int)$this->input->post('endmonth_employ'), (int)$this->input->post('endday_employ'), (int)$this->input->post('endyear_employ'));
		if($this->check->is_more($currentDate, $endDate))
		{
		    return false;
		}
		return true;
	}

	function _valid_captcha_employ_edit($str)
	{
		if($this->session->flashdata('sessionCaptchaEditEmployAccount') && $this->session->flashdata('sessionCaptchaEditEmployAccount') === $str)
		{
			return true;
		}
		return false;
	}
}