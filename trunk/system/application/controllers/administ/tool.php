<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Tool extends Controller
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
		$this->lang->load('admin/tool');
	}
	
	function mail()
	{
		if($this->session->flashdata('sessionSuccessSend'))
		{
			$data['successSend'] = true;
		}
		else
		{
            $data['successSend'] = false;
			$this->load->model('user_model');
	        $data['email'] = $this->user_model->fetch("use_email", "", "use_email", "ASC");
	        $this->load->library('form_validation');
	        #BEGIN: Set rules
	        $this->form_validation->set_rules('to_mail', 'lang:to_mail_label_mail', 'trim|required|valid_emails');
	        $this->form_validation->set_rules('from_mail', 'lang:from_mail_label_mail', 'trim|required|valid_email');
	        $this->form_validation->set_rules('subject_mail', 'lang:subject_mail_label_mail', 'trim|required');
	        $this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_mail', 'trim|required');
	        #END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('valid_emails', $this->lang->line('valid_email_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				$this->load->library('bbcode');
				#BEGIN: Mail
                $this->load->library('email');
                $config['useragent'] = $this->lang->line('useragen_mail');
                $config['mailtype'] = 'html';
				$this->email->initialize($config);
				$this->email->from($this->input->post('from_mail'));
				$this->email->to(trim($this->input->post('to_mail'), ','));
				$this->email->subject($this->input->post('subject_mail'));
				$this->email->message($this->bbcode->light($this->input->post('txtContent')));
				#END Mail
				if($this->email->send())
				{
                    $this->session->set_flashdata('sessionSuccessSend', 1);
				}
				redirect(base_url().'administ/tool/mail', 'location');
			}
			else
			{
                $data['to_mail'] = $this->input->post('to_mail');
                if($this->input->post('from_mail'))
                {
                	$data['from_mail'] = $this->input->post('from_mail');
                }
                else
                {
                    $data['from_mail'] = Setting::settingEmail_1;
                }
                $data['subject_mail'] = $this->input->post('subject_mail');
                $data['txtContent'] = $this->input->post('txtContent');
			}
		}
		#Load view
		$this->load->view('admin/tool/mail', $data);
	}
	
	function cache()
	{
		$this->load->helper('file');
		if(is_dir('system/cache/'))
		{
			@delete_files('system/cache/', true);
   			@write_file('system/cache/index.html', '<p>Directory access is forbidden.</p>');
		}
		redirect(base_url().'administ');
	}
	
	function captcha()
	{
        $this->load->helper('file');
		if(is_dir('templates/captcha/'))
		{
			@delete_files('templates/captcha/', true);
   			@write_file('templates/captcha/index.html', '<p>Directory access is forbidden.</p>');
		}
		redirect(base_url().'administ');
	}
}