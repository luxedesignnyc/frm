<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Register extends Controller
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
		if($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
		{
			redirect(base_url(), 'location');
			die();
		}
		#END CHECK LOGIN
		#Load library
		$this->load->library('hash');
		#Load language
		$this->lang->load('home/common');
		$this->lang->load('home/register');
		#Load model
		$this->load->model('user_model');
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
        #BEGIN: Advertise
		$data['advertisePage'] = 'register';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
        #BEGIN: Unlink captcha
		$this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionPathCaptchaRegister'));
		#END Unlink captcha
		if((int)Setting::settingStopRegister == 1)
		{
			$data['stopRegister'] = true;
		}
		else
		{
            $data['stopRegister'] = false;
			$data['stopRegisterVip'] = false;
			$data['stopRegisterShop'] = false;
			$data['isActivation'] = false;
			$data['successSendActivation'] = false;
			if((int)Setting::settingActiveAccount == 1)
			{
	            $data['isActivation'] = true;
				if($this->session->flashdata('sessionSuccessSendActivation'))
				{
		            $data['successSendActivation'] = true;
				}
			}
			if($this->session->flashdata('sessionSuccessRegister'))
			{
	            $data['successRegister'] = true;
			}
			else
			{
	            $data['successRegister'] = false;
	            if((int)Setting::settingStopRegisterVip == 1)
				{
	   				$data['stopRegisterVip'] = true;
				}
				if((int)Setting::settingStopRegisterShop == 1)
				{
	   				$data['stopRegisterShop'] = true;
				}
				#BEGIN: Fetch data
				$this->load->model('province_model');
				$data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
				#END Fetch data
				$this->load->library('form_validation');
				if($this->input->post('captcha_regis') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
				{
					#BEGIN: Set rules
		            $this->form_validation->set_rules('username_regis', 'lang:username_regis_label_defaults', 'trim|required|alpha_dash|min_length[6]|max_length[35]|callback__exist_username');
		            $this->form_validation->set_rules('password_regis', 'lang:password_regis_label_defaults', 'trim|required|min_length[6]|max_length[35]');
		            $this->form_validation->set_rules('repassword_regis', 'lang:repassword_regis_label_defaults', 'trim|required|matches[password_regis]');
		            $this->form_validation->set_rules('email_regis', 'lang:email_regis_label_defaults', 'trim|required|valid_email|callback__exist_email');
		            $this->form_validation->set_rules('reemail_regis', 'lang:reemail_regis_label_defaults', 'trim|required|matches[email_regis]');
		            $this->form_validation->set_rules('fullname_regis', 'lang:fullname_regis_label_defaults', 'trim|required');
		            $this->form_validation->set_rules('address_regis', 'lang:address_regis_label_defaults', 'trim|required');
		            $this->form_validation->set_rules('province_regis', 'lang:province_regis_label_defaults', 'required|callback__exist_province');
		            $this->form_validation->set_rules('phone_regis', 'lang:phone_regis_label_defaults', 'trim|required|callback__is_phone');
		            $this->form_validation->set_rules('mobile_regis', 'lang:mobile_regis_label_defaults', 'trim|callback__is_phone');
		            $this->form_validation->set_rules('yahoo_regis', 'lang:yahoo_regis_label_defaults', 'trim|callback__valid_nick');
		            $this->form_validation->set_rules('skype_regis', 'lang:skype_regis_label_defaults', 'trim|callback__valid_nick');
		            $this->form_validation->set_rules('captcha_regis', 'lang:captcha_regis_label_defaults', 'callback__valid_captcha');
					#END Set rules
					#BEGIN: Set message
					$this->form_validation->set_message('required', $this->lang->line('required_message'));
					$this->form_validation->set_message('alpha_dash', $this->lang->line('alpha_dash_message'));
					$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
					$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
					$this->form_validation->set_message('matches', $this->lang->line('matches_message'));
					$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
					$this->form_validation->set_message('_exist_username', $this->lang->line('_exist_username_message_defaults'));
					$this->form_validation->set_message('_exist_email', $this->lang->line('_exist_email_message_defaults'));
					$this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message'));
					$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
                    $this->form_validation->set_message('_valid_nick', $this->lang->line('_valid_nick_message'));
					$this->form_validation->set_message('_valid_captcha', $this->lang->line('_valid_captcha_message_defaults'));
					$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
					#END Set message
					if($this->form_validation->run() != FALSE)
					{
		                $salt = $this->hash->key(8);
		                if((int)$this->input->post('vip_regis') == 1)
						{
	                        $group = 2;
	     					$active = 0;
	     					$enddate = $currentDate;
						}
						elseif((int)$this->input->post('shop_regis') == 1)
						{
	                        $group = 3;
	     					$active = 0;
	     					$enddate = $currentDate;
						}
						else
						{
	                        $group = 1;
	     					$active = 1;
	     					if((int)date('Y') < 2030)
	     					{
	                            $enddate = mktime(0, 0, 0, date('m'), date('d'), (int)date('Y')+10);
	     					}
	     					else
	     					{
	                            $enddate = mktime(0, 0, 0, date('m'), date('d'), (int)date('Y')+1);
	     					}
						}
						if((int)Setting::settingActiveAccount == 1)
						{
							$active = 0;
						}
						if((int)$this->input->post('sex_regis') == 1)
						{
							$sex_regis = 1;
						}
						else
						{
	                        $sex_regis = 0;
						}
						$key = $this->hash->create($this->input->post('username_regis'), $this->input->post('email_regis'), 'sha256md5');
						$dataRegister = array(
						                    'use_username'      =>      trim(strtolower($this->filter->injection_html($this->input->post('username_regis')))),
						                    'use_password'      =>      $this->hash->create($this->input->post('password_regis'), $salt, 'md5sha512'),
						                    'use_salt'          =>      $salt,
						                    'use_email'         =>      trim(strtolower($this->filter->injection_html($this->input->post('email_regis')))),
						                    'use_fullname'      =>      trim($this->filter->injection_html($this->input->post('fullname_regis'))),
			                                'use_birthday'      =>      mktime(0, 0, 0, (int)$this->input->post('month_regis'), (int)$this->input->post('day_regis'), (int)$this->input->post('year_regis')),
			                                'use_sex'           =>      $sex_regis,
			                                'use_address'       =>      trim($this->filter->injection_html($this->input->post('address_regis'))),
			                                'use_province'      =>      (int)$this->input->post('province_regis'),
			                                'use_phone'         =>      trim($this->filter->injection_html($this->input->post('phone_regis'))),
			                                'use_mobile'        =>      trim($this->filter->injection_html($this->input->post('mobile_regis'))),
			                                'use_yahoo'         =>      trim($this->filter->injection_html($this->input->post('yahoo_regis'))),
			                                'use_skype'         =>      trim($this->filter->injection_html($this->input->post('skype_regis'))),
			                                'use_group'         =>      $group,
			                                'use_status'        =>      $active,
			                                'use_regisdate'     =>      $currentDate,
			                                'use_enddate'       =>      $enddate,
			                                'use_key'           =>      $key,
			                                'use_lastest_login' =>      $currentDate
											);
						if($this->user_model->add($dataRegister))
						{
	                        if((int)Setting::settingActiveAccount == 1)
							{
								$this->load->library('email');
								#Create key activation
								$token = $this->hash->create(trim(strtolower($this->filter->injection_html($this->input->post('email_regis')))), $key, "sha512md5");
								$key = base_url().'activation/user/'.trim(strtolower($this->filter->injection_html($this->input->post('username_regis')))).'/key/'.$key.'/token/'.$token;
								#Mail
								$config['useragent'] = $this->lang->line('useragent_defaults');
								$config['mailtype'] = 'html';
								$this->email->initialize($config);
								$message = $this->lang->line('welcome_site_defaults').$this->lang->line('mail_activation_defaults').'<a href="'.$key.'">'.$key.'</a><br>';
								$this->email->from($this->lang->line('EMAIL_MEMBER_TT24H'));
								$this->email->to(trim($this->input->post('email_regis')));
								$this->email->subject($this->lang->line('subject_send_mail_defaults'));
								$this->email->message($message);
								if(@$this->email->send())
								{
	                                $this->session->set_flashdata('sessionSuccessSendActivation', 1);
								}
							}
		     				$this->session->set_flashdata('sessionSuccessRegister', 1);
						}
						$this->session->set_userdata('sessionTimePosted', time());
						redirect(base_url().trim(uri_string(), '/'), 'location');
					}
					else
			        {
						$data['username_regis'] = $this->input->post('username_regis');
						$data['email_regis'] = $this->input->post('email_regis');
						$data['reemail_regis'] = $this->input->post('reemail_regis');
						$data['fullname_regis'] = $this->input->post('fullname_regis');
						$data['day_regis'] = $this->input->post('day_regis');
						$data['month_regis'] = $this->input->post('month_regis');
						$data['year_regis'] = $this->input->post('year_regis');
						$data['sex_regis'] = $this->input->post('sex_regis');
						$data['address_regis'] = $this->input->post('address_regis');
						$data['province_regis'] = $this->input->post('province_regis');
						$data['phone_regis'] = $this->input->post('phone_regis');
						$data['mobile_regis'] = $this->input->post('mobile_regis');
						$data['yahoo_regis'] = $this->input->post('yahoo_regis');
						$data['skype_regis'] = $this->input->post('skype_regis');
						$data['vip_regis'] = $this->input->post('vip_regis');
						$data['shop_regis'] = $this->input->post('shop_regis');
			        }
		        }
                #BEGIN: Create captcha register
				$this->load->library('captcha');
	            $codeCaptcha = $this->captcha->code(6);
				$this->session->set_flashdata('sessionCaptchaRegister', $codeCaptcha);
				$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.rand(500, 50000).'reg.jpg';
				$this->session->set_flashdata('sessionPathCaptchaRegister', $imageCaptcha);
				$this->captcha->create($codeCaptcha, $imageCaptcha);
				if(file_exists($imageCaptcha))
				{
					$data['imageCaptchaRegister'] = $imageCaptcha;
				}
				#END Create captcha register
	        }
        }
		#Load view
		$this->load->view('home/register/defaults', $data);
	}
	
	function activation($username, $key, $token)
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Advertise
		$data['advertisePage'] = 'register';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		$user = $this->user_model->get("use_id, use_group, use_email, use_key", "use_username = '".$this->filter->injection_html($username)."'");
		if(count($user) == 1 && trim($username) != '' && trim($key) != '' && trim($token) != '')
		{
			if((int)$user->use_group == 2 || (int)$user->use_group == 3)
			{
				$data['vipOrSalerActivation'] = true;
			}
			else
			{
				if($key === $user->use_key && $token === $this->hash->create($user->use_email, $key, "sha512md5"))
				{
					if($this->user_model->update(array('use_status'=>1), "use_id = ".$user->use_id))
					{
                        $this->user_model->update(array('use_key'=>$this->hash->create($user->use_key, microtime(), 'md5sha256')), "use_id = ".$user->use_id);
                        $data['successActivation'] = true;
					}
					else
					{
                        $data['successActivation'] = false;
					}
				}
				else
				{
                    $data['successActivation'] = false;
				}
			}
		}
		else
		{
            $data['successActivation'] = false;
		}
		#Load view
		$this->load->view('home/register/activation', $data);
	}
	
	function _exist_province($str)
	{
		$this->load->model('province_model');
		if(count($this->province_model->get("pre_id", "pre_id != 1 AND pre_status = 1 AND pre_id = ".(int)$str)) == 1)
		{
			return true;
		}
		return false;
	}
	
	function _exist_username()
	{
		if(count($this->user_model->get("use_id", "use_username = '".trim(strtolower($this->filter->injection_html($this->input->post('username_regis'))))."'")) > 0)
		{
			return false;
		}
		return true;
	}

	function _exist_email()
	{
        if(count($this->user_model->get("use_id", "use_email = '".trim(strtolower($this->filter->injection_html($this->input->post('email_regis'))))."'")) > 0)
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
    
    function _valid_nick($str)
    {
        if(preg_match('/[^0-9a-z._-]/i', $str))
		{
			return false;
		}
		return true;
    }
	
	function _valid_captcha($str)
	{
		if($this->session->flashdata('sessionCaptchaRegister') && $this->session->flashdata('sessionCaptchaRegister') === $str)
		{
			return true;
		}
		return false;
	}
}