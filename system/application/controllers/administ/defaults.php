<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Defaults extends Controller
{
	function __construct()
	{
		parent::Controller();
		#Load language
		$this->lang->load('admin/common');
		$this->lang->load('admin/defaults');
		$this->lang->load('admin/login');
		#Load model
		$this->load->model('user_model');
		$this->load->model('shop_model');
		$this->load->model('product_model');
		$this->load->model('ads_model');
		$this->load->model('job_model');
		$this->load->model('employ_model');
		$this->load->model('contact_model');
		$this->load->model('product_bad_model');
		$this->load->model('ads_bad_model');
	}

	function index()
	{
		if(!$this->check->is_logined($this->session->userdata('sessionUserAdmin'), $this->session->userdata('sessionGroupAdmin')))
		{
            $data['errorLogin'] = false;
            if($this->session->flashdata('sessionErrorLoginAdmin'))
            {
                $data['errorLogin'] = true;
            }
			if($this->input->post('usernameLogin') && trim($this->input->post('usernameLogin')) != '' && $this->input->post('passwordLogin') && trim($this->input->post('passwordLogin')) != '')
			{
				$user = $this->user_model->get("use_id, use_password, use_salt, use_group, use_status", "use_username = '".$this->filter->injection_html($this->input->post('usernameLogin'))."'");
				if(count($user) == 1)
				{
                    $this->load->library('hash');
                    $password = $this->hash->create($this->input->post('passwordLogin'), $user->use_salt, 'md5sha512');
                    if($user->use_password === $password && $user->use_status == 1 && (int)$user->use_group >= 4)
                    {
						$this->load->model('group_model');
						$group = $this->group_model->get("gro_permission", "gro_id = ".$user->use_group);
						$sessionLogin = array(
						                        'sessionUserAdmin'      	=>      (int)$user->use_id,
						                        'sessionGroupAdmin'     	=>      (int)$user->use_group,
						                        'sessionPermissionAdmin' 	=>      $this->filter->injection($group->gro_permission)
												);
						$this->session->set_userdata($sessionLogin);
						$this->user_model->update(array('use_lastest_login'=>time()), "use_id = ".(int)$user->use_id);
                    }
                    else
                    {
                        $this->session->set_flashdata('sessionErrorLoginAdmin', 1);
                    }
				}
				else
				{
					$this->session->set_flashdata('sessionErrorLoginAdmin', 1);
				}
				redirect(base_url().'administ', 'location');
			}
			#Load view
			$this->load->view('admin/login/defaults', $data);
		}
		else
		{
	        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
			#User
			$data['userDefaults'] = count($this->user_model->fetch("use_id", "", "", ""));
			$data['activeUserDefaults'] = count($this->user_model->fetch("use_id", "use_status = 1", "", ""));
			#Vip
			$data['vipDefaults'] = count($this->user_model->fetch("use_id", "use_group = 2", "", ""));
			$data['endVipDefaults'] = count($this->user_model->fetch("use_id", "use_group = 2 AND use_regisdate < use_enddate AND use_enddate < $currentDate", "", ""));
			$data['activeVipDefaults'] = count($this->user_model->fetch("use_id", "use_group = 2 AND use_status = 1", "", ""));
			#Shop
			$data['shopDefaults'] = count($this->shop_model->fetch("sho_id", "", "", ""));
			$data['endShopDefaults'] = count($this->shop_model->fetch("sho_id", "sho_enddate < $currentDate", "", ""));
			$data['activeShopDefaults'] = count($this->shop_model->fetch("sho_id", "sho_status = 1", "", ""));
			#Product
			$data['productDefaults'] = count($this->product_model->fetch("pro_id", "", "", ""));
			$data['endProductDefaults'] = count($this->product_model->fetch("pro_id", "pro_enddate < $currentDate", "", ""));
			#Ads
			$data['adsDefaults'] = count($this->ads_model->fetch("ads_id", "", "", ""));
			$data['endAdsDefaults'] = count($this->ads_model->fetch("ads_id", "ads_enddate < $currentDate", "", ""));
			#Job
			$data['jobDefaults'] = count($this->job_model->fetch("job_id", "", "", ""));
			$data['endJobDefaults'] = count($this->job_model->fetch("job_id", "job_enddate < $currentDate", "", ""));
			#Employ
			$data['employDefaults'] = count($this->employ_model->fetch("emp_id", "", "", ""));
			$data['endEmployDefaults'] = count($this->employ_model->fetch("emp_id", "emp_enddate < $currentDate", "", ""));
			#Advertise
			$data['advertiseDefaults'] = count($this->advertise_model->fetch("adv_id", "", "", ""));
			$data['endAdvertiseDefaults'] = count($this->advertise_model->fetch("adv_id", "adv_enddate < $currentDate", "", ""));
			$data['activeAdvertiseDefaults'] = count($this->advertise_model->fetch("adv_id", "adv_status = 1", "", ""));
			#Contact
			$data['contactDefaults'] = count($this->contact_model->fetch("con_id", "", "", ""));
			$data['notViewContactDefaults'] = count($this->contact_model->fetch("con_id", "con_view = 0", "", ""));
			#Product bad
			$data['productBadDefaults'] = count($this->product_bad_model->fetch("prb_id", "", "", ""));
			#Ads bad
			$data['adsBadDefaults'] = count($this->ads_bad_model->fetch("adb_id", "", "", ""));
			#Load view
			$this->load->view('admin/defaults/defaults', $data);
		}
	}
}