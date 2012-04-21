<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Contact extends Controller
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
		$this->lang->load('home/contact');
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
		$data['advertisePage'] = 'contact';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
        #BEGIN: Unlink captcha
		$this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionPathCaptchaContact'));
		#END Unlink captcha
		if($this->session->flashdata('sessionSuccessContact'))
		{
			$data['successContact'] = true;
		}
		else
		{
			$this->load->library('form_validation');
			$data['successContact'] = false;
			if($this->input->post('captcha_contact') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
			{
				#BEGIN: Set rules
				$this->form_validation->set_rules('name_contact', 'lang:name_contact_label_defaults', 'trim|required');
				$this->form_validation->set_rules('email_contact', 'lang:email_contact_label_defaults', 'trim|required|valid_email');
				$this->form_validation->set_rules('address_contact', 'lang:address_contact_label_defaults', 'trim|required');
				$this->form_validation->set_rules('phone_contact', 'lang:phone_contact_label_defaults', 'trim|required');
				$this->form_validation->set_rules('title_contact', 'lang:title_contact_label_defaults', 'trim|required');
				$this->form_validation->set_rules('content_contact', 'lang:content_contact_label_defaults', 'trim|required|min_length[10]|max_length[1000]');
				$this->form_validation->set_rules('captcha_contact', 'lang:captcha_contact_label_defaults', 'required|callback__valid_captcha');
				#END Set rules
				#BEGIN: Set message
				$this->form_validation->set_message('required', $this->lang->line('required_message'));
				$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
				$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
				$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
				$this->form_validation->set_message('_valid_captcha', $this->lang->line('_valid_captcha_message_defaults'));
				$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
				#END Set message
				if($this->form_validation->run() != FALSE)
				{
					$this->load->library('email');
					$config['useragent'] = $this->lang->line('useragen_defaults');
					$config['mailtype'] = 'html';
					$this->email->initialize($config);
					$messageContact = $this->lang->line('title_contact_mail_defaults').$this->lang->line('fullname_contact_mail_defaults').$this->input->post('name_contact').'<br>'.$this->lang->line('email_contact_mail_defaults').$this->input->post('email_contact').'<br>'.$this->lang->line('address_contact_mail_defaults').$this->input->post('address_contact').'<br>'.$this->lang->line('phone_contact_mail_defaults').$this->input->post('phone_contact').'<br>'.$this->lang->line('position_contact_mail_defaults').$this->input->post('position_contact').'<br>'.$this->lang->line('date_contact_mail_defaults').date('h\h:i, d-m-Y').'<br>'.$this->lang->line('content_contact_mail_defaults').nl2br($this->filter->html($this->input->post('content_contact')));
					$this->email->from($this->input->post('email_contact'));
					$this->email->to($this->lang->line('EMAIL_CONTACT_TT24H'));
					$this->email->subject($this->input->post('title_contact'));
					$this->email->message($messageContact);
					if($this->email->send())
					{
						$this->session->set_flashdata('sessionSuccessContact', 1);
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
					$data['position_contact'] = $this->input->post('position_contact');
					$data['content_contact'] = $this->input->post('content_contact');
				}
			}
            #BEGIN: Create captcha
            $this->load->library('captcha');
			$codeCaptcha = $this->captcha->code(6);
			$this->session->set_flashdata('sessionCaptchaContact', $codeCaptcha);
			$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.rand(10, 10000).'coni.jpg';
			$this->session->set_flashdata('sessionPathCaptchaContact', $imageCaptcha);
			$this->captcha->create($codeCaptcha, $imageCaptcha);
			if(file_exists($imageCaptcha))
			{
				$data['imageCaptchaContact'] = $imageCaptcha;
			}
			#END Create captcha
		}
		#Load view
		$this->load->view('home/contact/defaults', $data);
	}
	
	function _valid_captcha($str)
	{
        if($this->session->flashdata('sessionCaptchaContact') && $this->session->flashdata('sessionCaptchaContact') === $str)
		{
			return true;
		}
		return false;
	}
}