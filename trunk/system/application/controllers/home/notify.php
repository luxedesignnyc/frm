<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Notify extends Controller
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
		$this->lang->load('home/notify');
		#Load model
		$this->load->model('notify_model');
		#BEGIN: Update counter
		if(!$this->session->userdata('sessionUpdateCounter'))
		{
			$this->counter_model->update();
			$this->session->set_userdata('sessionUpdateCounter', 1);
		}
		#END Update counter
		#BEGIN: Ads & Notify Taskbar
		$this->load->model('ads_model');
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
        $id = (int)$this->uri->segment(2);
        $data['id'] = $id;
        $this->load->library('bbcode');
        #BEGIN: Detail
        $notify = $this->notify_model->get("*", "not_id = $id AND not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate");
        if(count($notify) != 1 || !$this->check->is_id($id))
        {
			redirect(base_url(), 'location');
			die();
        }
        $data['notify'] = $notify;
        #END Detail
        #BEGIN: Advertise
		$data['advertisePage'] = 'notify';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#BEGIN: List notify
		$where = "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate";
		$sort = "not_id";
		$by = "DESC";
		#Define url for $getVar
		$action = array('page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#If have page
		if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
		{
			$start = (int)$getVar['page'];
		}
		else
		{
			$start = 0;
		}
		$data['page'] = $start;
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->notify_model->fetch("not_id", $where));
        $config['base_url'] = base_url().'notify/'.$id.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingOtherAccount;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Check is have notify
		if(count($totalRecord) < 1)
		{
            redirect(base_url(), 'location');
			die();
		}
		#Fetch record
		$select = "not_id, not_title, not_degree, not_detail, not_begindate";
		$limit = Setting::settingOtherAccount;
		$data['listNotify'] = $this->notify_model->fetch($select, $where, $sort, $by, $start, $limit);
		#END List notify
		#Load view
		$this->load->view('home/notify/defaults', $data);
	}
}