<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Login extends Controller
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
		#Load library
		$this->load->library('hash');
		#Load language
		$this->lang->load('home/common');
		$this->lang->load('home/login');
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
		$data['advertisePage'] = 'login';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		if(!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
		{
            $data['successLogin'] = false;
            $data['errorLogin'] = false;
            if($this->session->userdata('sessionTimeValidLogin') && time() - (int)$this->session->userdata('sessionTimeValidLogin') > (int)Setting::settingTimeSession*60)
            {
				$this->session->unset_userdata('sessionValidLogin');
				$this->session->unset_userdata('sessionTimeValidLogin');
            }
            if($this->session->flashdata('sessionErrorLogin'))
            {
                $this->session->set_userdata('sessionValidLogin', (int)$this->session->userdata('sessionValidLogin')+1);
                $data['errorLogin'] = true;
            }
            if((int)$this->session->userdata('sessionValidLogin') < 5)
            {
				if($this->input->post('UsernameLogin') && trim($this->input->post('UsernameLogin')) != '' && $this->input->post('PasswordLogin') && trim($this->input->post('PasswordLogin')) != '')
				{
					$user = $this->user_model->get("use_id, use_password, use_salt, use_group, use_status, use_enddate", "use_username = '".$this->filter->injection_html($this->input->post('UsernameLogin'))."'");
					if(count($user) == 1)
					{
	                    $password = $this->hash->create($this->input->post('PasswordLogin'), $user->use_salt, 'md5sha512');
	                    if($user->use_password === $password && (int)$user->use_status == 1 && (int)$user->use_enddate >= (int)$currentDate && (int)$user->use_group < 4)
	                    {
							$sessionLogin = array(
							                        'sessionUser'      	=>      (int)$user->use_id,
							                        'sessionGroup'     	=>      (int)$user->use_group
													);
							$this->session->set_userdata($sessionLogin);
							$this->session->set_flashdata('sessionSuccessLogin', 1);
							$this->session->unset_userdata('sessionValidLogin');
							$this->session->unset_userdata('sessionTimeValidLogin');
							$this->user_model->update(array('use_lastest_login'=>time()), "use_id = ".$user->use_id);
	                    }
	                    else
	                    {
	                        $this->session->set_flashdata('sessionErrorLogin', 1);
	                    }
					}
					else
					{
						$this->session->set_flashdata('sessionErrorLogin', 1);
					}
					redirect(base_url().trim(uri_string(), '/'), 'location');
				}
			}
			else
			{
				$data['validLogin'] = true;
				if(!$this->session->userdata('sessionTimeValidLogin'))
				{
					$this->session->set_userdata('sessionTimeValidLogin', time());
				}
			}
		}
		else
		{
            if($this->session->flashdata('sessionSuccessLogin'))
            {
				$data['successLogin'] = true;
            }
            else
            {
                redirect(base_url(), 'location');
            }
		}
		#Load view
		$this->load->view('home/login/defaults', $data);
	}
	
	function logout()
	{
        if($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
		{
            $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
	        #BEGIN: Advertise
			$data['advertisePage'] = 'login';
			$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
			#END Advertise
			#BEGIN: Counter
			$data['counter'] = $this->counter_model->get();
			#END Counter
        	$this->session->sess_destroy();
        	#Load view
			$this->load->view('home/login/logout', $data);
        }
        else
        {
			redirect(base_url(), 'location');
		}
	}
}