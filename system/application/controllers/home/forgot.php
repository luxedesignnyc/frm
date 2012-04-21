<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Forgot extends Controller
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
		$this->lang->load('home/forgot');
		#Load model
		$this->load->model('forgot_model');
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
		$data['advertisePage'] = 'forgot';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
        #BEGIN: Unlink captcha
        $this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionPathCaptchaForgot'));
		#END Unlink captcha
		if($this->session->flashdata('sessionSuccessForgot'))
		{
			$data['successForgot'] = true;
		}
		else
		{
			$this->load->library('form_validation');
			$data['successForgot'] = false;
			if($this->input->post('captcha_forgot') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
			{
				#BEGIN: Set rules
				$this->form_validation->set_rules('username_forgot', 'lang:username_forgot_label_defaults', 'trim|required|min_length[6]|max_length[35]');
				$this->form_validation->set_rules('email_forgot', 'lang:email_forgot_label_defaults', 'trim|required|valid_email|callback__valid_forgot');
				$this->form_validation->set_rules('captcha_forgot', 'lang:captcha_forgot_label_defaults', 'required|callback__valid_captcha');
				#END Set rules
				#BEGIN: Set message
				$this->form_validation->set_message('required', $this->lang->line('required_message'));
				$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
				$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
				$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
				$this->form_validation->set_message('_valid_forgot', $this->lang->line('_valid_forgot_message_defaults'));
				$this->form_validation->set_message('_valid_captcha', $this->lang->line('_valid_captcha_message_defaults'));
				$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
				#END Set message
				if($this->form_validation->run() != FALSE)
				{
                    $salt = $this->hash->key(8);
                    $newPassword = $this->hash->key(10);
                    $key = $this->hash->create(trim(strtolower($this->filter->injection_html($this->input->post('email_forgot')))), microtime(), 'sha256md5');
					$dataForgot = array(
					                    'for_password'      =>      $this->hash->create($newPassword, $salt, 'md5sha512'),
					                    'for_salt'          =>      $salt,
					                    'for_email'         =>      trim(strtolower($this->filter->injection_html($this->input->post('email_forgot')))),
					                    'for_key'           =>      $key
										);
                    $this->forgot_model->delete(trim(strtolower($this->filter->injection_html($this->input->post('email_forgot')))), "for_email");
					if($this->forgot_model->add($dataForgot))
					{
						$this->load->library('email');
						$config['useragent'] = $this->lang->line('useragen_defaults');
						$config['mailtype'] = 'html';
						$this->email->initialize($config);
						$keySend = base_url().'forgot/reset/key/'.$key.'/token/'.$this->hash->create(trim(strtolower($this->filter->injection_html($this->input->post('email_forgot')))), $key, "sha512md5");
						$messageContact = $this->lang->line('new_password_mail_defaults').$newPassword.'<br><br>'.$this->lang->line('content_mail_defaults').$keySend.'">'.$keySend.'</a>';
						$this->email->from($this->lang->line('EMAIL_MEMBER_TT24H'));
						$this->email->to(trim($this->input->post('email_forgot')));
						$this->email->subject($this->lang->line('title_mail_defaults'));
						$this->email->message($messageContact);
						if($this->email->send())
						{
							$this->session->set_flashdata('sessionSuccessForgot', 1);
						}
						else
						{
                            $this->forgot_model->delete(trim(strtolower($this->filter->injection_html($this->input->post('email_forgot')))), "for_email");
						}
					}
     				$this->session->set_userdata('sessionTimePosted', time());
					redirect(base_url().trim(uri_string(), '/'), 'location');
				}
				else
				{
					$data['username_forgot'] = $this->input->post('username_forgot');
					$data['email_forgot'] = $this->input->post('email_forgot');
				}
			}
            #BEGIN: Create captcha
            $this->load->library('captcha');
			$codeCaptcha = $this->captcha->code(6);
			$this->session->set_flashdata('sessionCaptchaForgot', $codeCaptcha);
			$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.rand(10, 10000).'fori.jpg';
			$this->session->set_flashdata('sessionPathCaptchaForgot', $imageCaptcha);
			$this->captcha->create($codeCaptcha, $imageCaptcha);
			if(file_exists($imageCaptcha))
			{
				$data['imageCaptchaForgot'] = $imageCaptcha;
			}
			#END Create captcha
		}
		#Load view
		$this->load->view('home/forgot/defaults', $data);
	}
	
	function reset($key, $token)
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Advertise
		$data['advertisePage'] = 'forgot';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		$user = $this->forgot_model->get("*", "for_key = '".$this->filter->injection($key)."'");
		if(count($user) == 1 && $token === $this->hash->create($user->for_email, $key, "sha512md5") && trim($key) != '' && trim($token) != '')
		{
			$dataReset = array(
			                    'use_password'      =>      $user->for_password,
			                    'use_salt'          =>      $user->for_salt
								);
			if($this->user_model->update($dataReset, "use_email = '".$user->for_email."'"))
			{
                $this->forgot_model->delete($user->for_email, "for_email");
                $data['successResetPassword'] = true;
			}
			else
			{
                $data['successResetPassword'] = false;
			}
		}
		else
		{
            $data['successResetPassword'] = false;
		}
		#Load view
		$this->load->view('home/forgot/reset', $data);
	}

	function _valid_forgot()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        if(count($this->user_model->get("use_id", "use_status = 1 AND use_enddate >= $currentDate AND use_group < 4 AND use_email = '".trim(strtolower($this->filter->injection_html($this->input->post('email_forgot'))))."' AND use_username = '".trim(strtolower($this->filter->injection_html($this->input->post('username_forgot'))))."'")) == 1)
		{
			return true;
		}
		return false;
	}
	
	function _valid_captcha($str)
	{
        if($this->session->flashdata('sessionCaptchaForgot') && $this->session->flashdata('sessionCaptchaForgot') === $str)
		{
			return true;
		}
		return false;
	}
}