<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Job extends Controller
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
		$this->lang->load('home/job');
		#Load model
		$this->load->model('job_model');
		$this->load->model('employ_model');
		$this->load->model('field_model');
		#BEGIN: Update counter
		if(!$this->session->userdata('sessionUpdateCounter'))
		{
			$this->counter_model->update();
			$this->session->set_userdata('sessionUpdateCounter', 1);
		}
		#END Update counter
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
        $data['menuFieldJob'] = false;
        $data['menuFieldEmploy'] = false;
		$data['menuSelected'] = 'job';
		$data['menuType'] = 'job';
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'job_index';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Module
        $data['module'] = 'top_24h_job,top_24h_employ';
        #BEGIN: Top job 24h right
		$select = "job_id, job_field, job_title, job_time_surrend, job_position";
		$start = 0;
  		$limit = (int)Setting::settingJob24Gio_J_Top*3;
		$data['top24hJob'] = $this->job_model->fetch($select, "job_status = 1 AND job_enddate >= $currentDate", "job_id", "DESC", $start, $limit);
		#END Top job 24h right
		#BEGIN: Top employ 24h right
		$select = "emp_id, emp_field, emp_title, emp_level, emp_position";
		$start = 0;
  		$limit = (int)Setting::settingJob24Gio_E_Top*3;
		$data['top24hEmploy'] = $this->employ_model->fetch($select, "emp_status = 1 AND emp_enddate >= $currentDate", "emp_id", "DESC", $start, $limit);
		#END Top employ 24h right
		#BEGIN: Field
		$data['field'] = $this->field_model->fetch("fie_id, fie_name, fie_descr, fie_image", "fie_status = 1", "fie_order", "ASC");
		#END Field
		#Define url for $getVar
		$action = array('sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(2, $action);
		#BEGIN: Sort
		$where = "job_status = 1 AND job_enddate >= $currentDate";
		$sort = 'job_id';
		$by = 'DESC';
		$pageSort = '';
		$pageUrl = '';
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'title':
				    $pageUrl .= '/sort/title';
				    $sort = "job_title";
				    break;
                case 'date':
				    $pageUrl .= '/sort/date';
				    $sort = "job_begindate";
				    break;
                case 'place':
				    $pageUrl .= '/sort/place';
				    $sort = "pre_name";
				    break;
                case 'view':
				    $pageUrl .= '/sort/view';
				    $sort = "job_view";
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
		#END Sort
		#BEGIN: Create link Sort
		$data['sortUrl'] = base_url().'job/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link Sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->job_model->fetch_join("job_id", "LEFT", "tbtt_province", "tbtt_job.job_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, "", ""));
        $config['base_url'] = base_url().'job'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingJobNew;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$select = "job_id, job_title, job_field, job_view, job_time_surrend, job_position, job_begindate, pre_name";
		$limit = Setting::settingJobNew;
		$data['job'] = $this->job_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_job.job_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('home/job/defaults', $data);
	}
	
	function field($fieldID)
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Check exist field by $fieldID
		$field = $this->field_model->get("fie_id", "fie_id = ".(int)$fieldID." AND fie_status = 1");
		if(count($field) != 1 || !$this->check->is_id($fieldID))
		{
			redirect(base_url(), 'location');
			die();
		}
		#END Check exist field by $fieldID
		$fieldIDQuery = (int)$fieldID;
        #BEGIN: Menu
        $data['menuFieldJob'] = true;
        $data['menuFieldEmploy'] = false;
		$data['menuSelected'] = 'job';
		$data['menuType'] = 'job';
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'job_sub';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Module
        $data['module'] = 'top_24h_job,top_24h_employ';
        #BEGIN: Top job 24h right
		$select = "job_id, job_field, job_title, job_time_surrend, job_position";
		$start = 0;
  		$limit = (int)Setting::settingJob24Gio_J_Top*3;
		$data['top24hJob'] = $this->job_model->fetch($select, "job_status = 1 AND job_enddate >= $currentDate", "job_id", "DESC", $start, $limit);
		#END Top job 24h right
		#BEGIN: Top employ 24h right
		$select = "emp_id, emp_field, emp_title, emp_level, emp_position";
		$start = 0;
  		$limit = (int)Setting::settingJob24Gio_E_Top*3;
		$data['top24hEmploy'] = $this->employ_model->fetch($select, "emp_status = 1 AND emp_enddate >= $currentDate", "emp_id", "DESC", $start, $limit);
		#END Top employ 24h right
		#BEGIN: Field
		$data['field'] = $this->field_model->fetch("fie_id, fie_name, fie_descr, fie_image", "fie_status = 1", "fie_order", "ASC");
		#END Field
		#BEGIN: Interest job
		$select = "job_id, job_title, job_field, job_view, job_time_surrend, job_position, job_begindate, pre_name";
		$start = 0;
  		$limit = (int)Setting::settingJobInterest;
		$data['interestJob'] = $this->job_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_job.job_province = tbtt_province.pre_id", "", "", "", "", "", "", "job_field = $fieldIDQuery AND job_status = 1 AND job_enddate >= $currentDate", "job_view", "DESC", $start, $limit);
		#END Interest job
		#Define url for $getVar
		$action = array('sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Sort
		$where = "job_field = $fieldIDQuery AND job_status = 1 AND job_enddate >= $currentDate";
		$sort = 'job_id';
		$by = 'DESC';
		$pageSort = '';
		$pageUrl = '';
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'title':
				    $pageUrl .= '/sort/title';
				    $sort = "job_title";
				    break;
                case 'date':
				    $pageUrl .= '/sort/date';
				    $sort = "job_begindate";
				    break;
                case 'place':
				    $pageUrl .= '/sort/place';
				    $sort = "pre_name";
				    break;
                case 'view':
				    $pageUrl .= '/sort/view';
				    $sort = "job_view";
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
		#END Sort
		#BEGIN: Create link Sort
		$data['sortUrl'] = base_url().'job/field/'.$fieldID.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link Sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->job_model->fetch_join("job_id", "LEFT", "tbtt_province", "tbtt_job.job_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, "", ""));
        $config['base_url'] = base_url().'job/field/'.$fieldID.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingJobNew;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$select = "job_id, job_title, job_field, job_view, job_time_surrend, job_position, job_begindate, pre_name";
		$limit = Setting::settingJobNew;
		$data['job'] = $this->job_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_job.job_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('home/job/field', $data);
	}
	
	function detail($fieldID, $jobID)
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Check exist field by $fieldID
		$field = $this->field_model->get("fie_id, fie_name, fie_descr", "fie_id = ".(int)$fieldID." AND fie_status = 1");
		if(count($field) != 1 || !$this->check->is_id($fieldID))
		{
			redirect(base_url(), 'location');
			die();
		}
		#END Check exist field by $fieldID
		$fieldIDQuery = (int)$fieldID;
		#BEGIN: Check exist job by $jobID
		$job = $this->job_model->get("*", "job_id = ".(int)$jobID." AND job_field = $fieldIDQuery AND job_status = 1 AND job_enddate >= $currentDate");
		if(count($job) != 1 || !$this->check->is_id($jobID))
		{
			redirect(base_url(), 'location');
			die();
		}
		#END Check exist job by $jobID
		$jobIDQuery = (int)$jobID;
		#BEGIN: Update view
		if(!$this->session->userdata('sessionViewJob_'.$jobIDQuery))
		{
            $this->job_model->update(array('job_view' => (int)$job->job_view + 1), "job_id = ".$jobIDQuery);
            $this->session->set_userdata('sessionViewJob_'.$jobIDQuery, 1);
		}
		#END Update view
		$this->load->library('bbcode');
		$this->load->library('captcha');
		$this->load->library('form_validation');
		#BEGIN: Send friend & send fail
		$data['successSendFriendJob'] = false;
        $data['successSendFailJob'] = false;
		if($this->session->flashdata('sessionSuccessSendFriendJob'))
 		{
  			$data['successSendFriendJob'] = true;
 		}
 		elseif($this->session->flashdata('sessionSuccessSendFailJob'))
 		{
  			$data['successSendFailJob'] = true;
 		}
 		#BEGIN: Create captcha send friend
		if($this->session->flashdata('sessionPathCaptchaSendFriendJob') && file_exists($this->session->flashdata('sessionPathCaptchaSendFriendJob')))
		{
			@unlink($this->session->flashdata('sessionPathCaptchaSendFriendJob'));
		}
		$codeCaptcha = $this->captcha->code(6);
		$this->session->set_flashdata('sessionCaptchaSendFriendJob', $codeCaptcha);
		$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.rand(1, 10000).'fj.jpg';
		$this->session->set_flashdata('sessionPathCaptchaSendFriendJob', $imageCaptcha);
		$this->captcha->create($codeCaptcha, $imageCaptcha);
		if(file_exists($imageCaptcha))
		{
			$data['imageCaptchaSendFriendJob'] = $imageCaptcha;
		}
		#END Create captcha send friend
		#BEGIN: Create captcha send fail
		if($this->session->flashdata('sessionPathCaptchaSendFailJob') && file_exists($this->session->flashdata('sessionPathCaptchaSendFailJob')))
		{
			@unlink($this->session->flashdata('sessionPathCaptchaSendFailJob'));
		}
		$data['isSendedOneFail'] = false;
		if($this->session->userdata('sessionSendFailedJob_'.$jobIDQuery))
		{
			$data['isSendedOneFail'] = true;
		}
		else
		{
			$codeCaptcha = $this->captcha->code(6);
			$this->session->set_flashdata('sessionCaptchaSendFailJob', $codeCaptcha);
			$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.rand(10000, 100000).'bj.jpg';
			$this->session->set_flashdata('sessionPathCaptchaSendFailJob', $imageCaptcha);
			$this->captcha->create($codeCaptcha, $imageCaptcha);
			if(file_exists($imageCaptcha))
			{
				$data['imageCaptchaSendFailJob'] = $imageCaptcha;
			}
		}
		#END Create captcha send fail
		#BEGIN: Send link for friend
		if($this->input->post('captcha_sendlink') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
		{
			#BEGIN: Set rules
			$this->form_validation->set_rules('sender_sendlink', 'lang:sender_sendlink_label_detail', 'trim|required|valid_email');
			$this->form_validation->set_rules('receiver_sendlink', 'lang:receiver_sendlink_label_detail', 'trim|required|valid_email');
			$this->form_validation->set_rules('title_sendlink', 'lang:title_sendlink_label_detail', 'trim|required');
			$this->form_validation->set_rules('content_sendlink', 'lang:content_sendlink_label_detail', 'trim|required|min_length[10]|max_length[400]');
			$this->form_validation->set_rules('captcha_sendlink', 'lang:captcha_sendlink_label_detail', 'required|callback__valid_captcha_send_friend');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
			$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
			$this->form_validation->set_message('_valid_captcha_send_friend', $this->lang->line('_valid_captcha_send_friend_message_detail'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				$this->load->library('email');
				$config['useragent'] = $this->lang->line('useragen_mail_detail');
				$config['mailtype'] = 'html';
				$this->email->initialize($config);
				$this->email->from($this->input->post('sender_sendlink'));
				$this->email->to($this->input->post('receiver_sendlink'));
				$this->email->subject($this->input->post('title_sendlink'));
				$this->email->message($this->lang->line('content_default_send_friend_detail').base_url().trim(uri_string(), '/').'">'.base_url().trim(uri_string(), '/').'</a> '.$this->lang->line('next_content_default_send_friend_detail').$this->filter->html($this->input->post('content_sendlink')));
				if($this->email->send())
				{
					$this->session->set_flashdata('sessionSuccessSendFriendJob', 1);
				}
				$this->session->set_userdata('sessionTimePosted', time());
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			else
			{
				$data['sender_sendlink'] = $this->input->post('sender_sendlink');
				$data['receiver_sendlink'] = $this->input->post('receiver_sendlink');
				$data['title_sendlink'] = $this->input->post('title_sendlink');
				$data['content_sendlink'] = $this->input->post('content_sendlink');
				$data['isSendFriend'] = true;
			}
		}
		#END Send link for friend
		#BEGIN: Send link fail ads
		elseif($this->input->post('captcha_sendfail') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost && !$this->session->userdata('sessionSendFailedJob_'.$jobIDQuery))
		{
			#BEGIN: Set rules
			$this->form_validation->set_rules('sender_sendfail', 'lang:sender_sendfail_label_detail', 'trim|required|valid_email');
			$this->form_validation->set_rules('title_sendfail', 'lang:title_sendfail_label_detail', 'trim|required');
			$this->form_validation->set_rules('content_sendfail', 'lang:content_sendfail_label_detail', 'trim|required|min_length[10]|max_length[400]');
			$this->form_validation->set_rules('captcha_sendfail', 'lang:captcha_sendfail_label_detail', 'required|callback__valid_captcha_send_fail');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
			$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
			$this->form_validation->set_message('_valid_captcha_send_fail', $this->lang->line('_valid_captcha_send_fail_message_detail'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				$this->load->model('job_bad_model');
				$dataFailAdd = array(
										'jba_title'     =>      trim($this->filter->injection_html($this->input->post('title_sendfail'))),
										'jba_detail'    =>      trim($this->filter->injection_html($this->input->post('content_sendfail'))),
										'jba_email'     =>      trim($this->filter->injection_html($this->input->post('sender_sendfail'))),
										'jba_job'   	=>      (int)$job->job_id,
										'jba_date'      =>      $currentDate
										);
				if($this->job_bad_model->add($dataFailAdd))
				{
					$this->session->set_flashdata('sessionSuccessSendFailJob', 1);
					$this->session->set_userdata('sessionSendFailedJob_'.$jobIDQuery, 1);
				}
				$this->session->set_userdata('sessionTimePosted', time());
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			else
			{
				$data['sender_sendfail'] = $this->input->post('sender_sendfail');
				$data['title_sendfail'] = $this->input->post('title_sendfail');
				$data['content_sendfail'] = $this->input->post('content_sendfail');
				$data['isSendFail'] = true;
			}
		}
		#END Send link fail ads
		#END Send friend & send fail
		#BEGIN: Add favorite and submit forms
        $data['successFavoriteJob'] = false;
        $data['isLogined'] = false;
		if($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
		{
            $data['isLogined'] = true;
            if($this->session->flashdata('sessionSuccessFavoriteJob'))
        	{
				$data['successFavoriteJob'] = true;
        	}
            #BEGIN: Favorite
        	if($this->input->post('checkone') && $this->check->is_id($this->input->post('checkone')) && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
        	{
				$this->load->model('job_favorite_model');
    			$jobOne = $this->job_model->get("job_user", "job_id = ".(int)$this->input->post('checkone'));
    			$jobFavorite = $this->job_favorite_model->get("jof_id", "jof_job = ".(int)$this->input->post('checkone')." AND jof_user = ".(int)$this->session->userdata('sessionUser'));
				if(count($jobOne) == 1 && count($jobFavorite) == 0 && $jobOne->job_user != $this->session->userdata('sessionUser'))
				{
				    $dataAdd = array(
									    'jof_job'       =>      (int)$this->input->post('checkone'),
									    'jof_user'      =>      (int)$this->session->userdata('sessionUser'),
									    'jof_date'      =>      $currentDate
										);
					if($this->job_favorite_model->add($dataAdd))
					{
	    				$this->session->set_flashdata('sessionSuccessFavoriteJob', 1);
					}
				}
				unset($jobOne);
				unset($jobFavorite);
				$this->session->set_userdata('sessionTimePosted', time());
				redirect(base_url().trim(uri_string(), '/'), 'location');
        	}
        	#END Favorite
		}
        #END Add favorite and submit forms
		#Assign title and description for site
		$data['titleSiteGlobal'] = $job->job_title;
		$data['descrSiteGlobal'] = $job->job_title;
		#BEGIN: List field
		$data['listField'] = $this->field_model->fetch("fie_id, fie_name, fie_descr, fie_image", "fie_status = 1", "fie_order", "ASC");
		#END List field
		#BEGIN: Get job by $jobID and relate info
		$data['field'] = $field;
		$data['job'] = $job;
		$this->load->model('user_model');
		$data['user'] = $this->user_model->get("use_fullname", "use_id = ".(int)$job->job_user);
		$this->load->model('province_model');
		$data['province'] = $this->province_model->get("pre_name", "pre_id = ".(int)$job->job_province);
		#END Get job by $jobID and relate info
		#BEGIN: Menu
        $data['menuFieldJob'] = true;
        $data['menuFieldEmploy'] = false;
		$data['menuSelected'] = 'job';
		$data['menuType'] = 'job';
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'job_detail';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Module
        $data['module'] = 'top_24h_job,top_24h_employ';
        #BEGIN: Top job 24h right
		$select = "job_id, job_field, job_title, job_time_surrend, job_position";
		$start = 0;
  		$limit = (int)Setting::settingJob24Gio_J_Top*3;
		$data['top24hJob'] = $this->job_model->fetch($select, "job_status = 1 AND job_enddate >= $currentDate", "job_id", "DESC", $start, $limit);
		#END Top job 24h right
		#BEGIN: Top employ 24h right
		$select = "emp_id, emp_field, emp_title, emp_level, emp_position";
		$start = 0;
  		$limit = (int)Setting::settingJob24Gio_E_Top*3;
		$data['top24hEmploy'] = $this->employ_model->fetch($select, "emp_status = 1 AND emp_enddate >= $currentDate", "emp_id", "DESC", $start, $limit);
		#END Top employ 24h right
		#Define url for $getVar
		$action = array('sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(6, $action);
		#BEGIN: Relate user
		#BEGIN: Sort
		$where = "job_user = ".(int)$job->job_user." AND job_id != $jobIDQuery AND job_status = 1 AND job_enddate >= $currentDate";
		$sort = 'job_id';
		$by = 'DESC';
		$pageSort = '';
		$pageUrl = '';
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'title':
				    $pageUrl .= '/sort/title';
				    $sort = "job_title";
				    break;
                case 'date':
				    $pageUrl .= '/sort/date';
				    $sort = "job_begindate";
				    break;
                case 'place':
				    $pageUrl .= '/sort/place';
				    $sort = "pre_name";
				    break;
                case 'view':
				    $pageUrl .= '/sort/view';
				    $sort = "job_view";
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
		#END Sort
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'job/field/'.$fieldID.'/detail/'.$jobID.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->job_model->fetch_join("job_id", "LEFT", "tbtt_province", "tbtt_job.job_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, "", ""));
        $config['base_url'] = base_url().'job/field/'.$fieldID.'/detail/'.$jobID.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingJobUser;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$select = "job_id, job_title, job_field, job_view, job_time_surrend, job_position, job_begindate, pre_name";
		$limit = Setting::settingJobUser;
		$data['userJob'] = $this->job_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_job.job_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, $sort, $by, $start, $limit);
		#END Relate user
		#BEGIN: Relate field
		$select = "job_id, job_title, job_field, job_view, job_time_surrend, job_position, job_begindate, pre_name";
		$start = 0;
  		$limit = (int)Setting::settingJobField;
		$data['fieldJob'] = $this->job_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_job.job_province = tbtt_province.pre_id", "", "", "", "", "", "", "job_field = ".(int)$job->job_field." AND job_id != $jobIDQuery AND job_status = 1 AND job_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Relate field
		#Load view
		$this->load->view('home/job/detail', $data);
	}
	
	function post()
	{
        #BEGIN: CHECK LOGIN
		if(!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
		{
			redirect(base_url().'login', 'location');
			die();
		}
		#END CHECK LOGIN
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Advertise
		$data['advertisePage'] = 'post';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
        #BEGIN: Unlink captcha
        $this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionPathCaptchaPostJob'));
		#END Unlink captcha
		if($this->session->flashdata('sessionSuccessPostJob'))
		{
            $data['successPostJob'] = true;
		}
		else
		{
			$this->load->library('form_validation');
            $data['successPostJob'] = false;
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
            #BEGIN: Province
            $this->load->model('province_model');
            $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
            #END Province
            #BEGIN: Field
            $data['field'] = $this->field_model->fetch("fie_id, fie_name", "fie_status = 1", "fie_order", "ASC");
            #END Field
            #BEGIN: User
            $this->load->model('user_model');
			$user = $this->user_model->get("use_fullname, use_address, use_email, use_phone, use_mobile, use_yahoo, use_skype", "use_id = ".(int)$this->session->userdata('sessionUser'));
			$data['namecontact_job'] = $user->use_fullname;
			$data['addresscontact_job'] = $user->use_address;
			$data['phonecontact_job'] = $user->use_phone;
			$data['mobilecontact_job'] = $user->use_mobile;
			$data['emailcontact_job'] = $user->use_email;
			$data['yahoo_job'] = $user->use_yahoo;
			$data['skype_job'] = $user->use_skype;
            #END User
			if($this->input->post('captcha_job') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
			{
				#BEGIN: Set rules
				$this->form_validation->set_rules('title_job', 'lang:title_job_label_post', 'trim|required');
				$this->form_validation->set_rules('field_job', 'lang:field_job_label_post', 'required|callback__exist_field');
				$this->form_validation->set_rules('position_job', 'lang:position_job_label_post', 'trim|required');
				$this->form_validation->set_rules('level_job', 'lang:level_job_label_post', 'trim|required');
				$this->form_validation->set_rules('age1_job', 'lang:age_job_label_post', 'required|callback__valid_age');
				$this->form_validation->set_rules('require_job', 'lang:require_job_label_post', 'trim|required');
				$this->form_validation->set_rules('province_job', 'lang:province_job_label_post', 'required|callback__exist_province');
				$this->form_validation->set_rules('salary_job', 'lang:salary_job_label_post', 'trim|required|is_natural_no_zero');
				$this->form_validation->set_rules('try_job', 'lang:try_job_label_post', 'trim|required|is_natural');
				$this->form_validation->set_rules('interest_job', 'lang:interest_job_label_post', 'trim|required|max_length[500]');
				$this->form_validation->set_rules('quantity_job', 'lang:quantity_job_label_post', 'trim|required|is_natural_no_zero');
				$this->form_validation->set_rules('record_job', 'lang:record_job_label_post', 'trim|required|max_length[500]');
				$this->form_validation->set_rules('day_job', 'lang:day_job_label_post', 'required|callback__valid_date');
				$this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_post', 'trim|required|min_length[10]|max_length[10000]');
				$this->form_validation->set_rules('name_job', 'lang:name_job_label_post', 'trim|required');
				$this->form_validation->set_rules('address_job', 'lang:address_job_label_post', 'trim|required');
				$this->form_validation->set_rules('phone_job', 'lang:phone_job_label_post', 'trim|required|callback__is_phone');
				$this->form_validation->set_rules('mobile_job', 'lang:mobile_job_label_post', 'trim|callback__is_phone');
				$this->form_validation->set_rules('email_job', 'lang:email_job_label_post', 'trim|required|valid_email');
				$this->form_validation->set_rules('website_job', 'lang:website_job_label_post', 'trim|callback__valid_website');
				$this->form_validation->set_rules('namecontact_job', 'lang:namecontact_job_label_post', 'trim|required');
				$this->form_validation->set_rules('addresscontact_job', 'lang:addresscontact_job_label_post', 'trim|required');
				$this->form_validation->set_rules('phonecontact_job', 'lang:phonecontact_job_label_post', 'trim|required|callback__is_phone');
				$this->form_validation->set_rules('mobilecontact_job', 'lang:mobilecontact_job_label_post', 'trim|callback__is_phone');
				$this->form_validation->set_rules('emailcontact_job', 'lang:emailcontact_job_label_post', 'trim|required|valid_email');
				$this->form_validation->set_rules('yahoo_job', 'lang:yahoo_job_label_post', 'trim|callback__valid_nick');
				$this->form_validation->set_rules('skype_job', 'lang:skype_job_label_post', 'trim|callback__valid_nick');
				$this->form_validation->set_rules('endday_job', 'lang:endday_job_label_post', 'required|callback__valid_enddate');
				$this->form_validation->set_rules('captcha_job', 'lang:captcha_job_label_post', 'required|callback__valid_captcha_post');
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
				$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
				$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
				$this->form_validation->set_message('_valid_website', $this->lang->line('_valid_website_message'));
				$this->form_validation->set_message('_valid_date', $this->lang->line('_valid_date_message_post'));
				$this->form_validation->set_message('_valid_age', $this->lang->line('_valid_age_message_post'));
				$this->form_validation->set_message('_valid_captcha_post', $this->lang->line('_valid_captcha_post_message_post'));
				$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
				#END Set message
				if($this->form_validation->run() != FALSE)
				{
					if($this->input->post('time_job') == '1')
					{
						$time_job = $this->lang->line('time_job_1_post');
					}
					elseif($this->input->post('time_job') == '2')
					{
                        $time_job = $this->lang->line('time_job_2_post');
					}
					elseif($this->input->post('time_job') == '3')
					{
                        $time_job = $this->lang->line('time_job_3_post');
					}
					elseif($this->input->post('time_job') == '4')
					{
                        $time_job = $this->lang->line('time_job_4_post');
					}
					else
					{
                        $time_job = $this->lang->line('time_job_5_post');
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
						$datesalary_job = $this->lang->line('year_post');
					}
					elseif($this->input->post('datesalary_job') == '1')
					{
                        $datesalary_job = $this->lang->line('day_post');
					}
					else
					{
                        $datesalary_job = $this->lang->line('month_post');
					}
					if($this->input->post('datetry_job') == '3')
					{
						$try_job = $this->lang->line('year_post');
					}
					elseif($this->input->post('datetry_job') == '1')
					{
                        $try_job = $this->lang->line('day_post');
					}
					else
					{
                        $try_job = $this->lang->line('month_post');
					}
					$try_job = (int)$this->input->post('try_job').' '.$try_job;
					if($this->input->post('bestcontact_job') == '1')
					{
						$bestcontact_job = $this->lang->line('best_contact_1_contact_post');
					}
					elseif($this->input->post('bestcontact_job') == '2')
					{
                        $bestcontact_job = $this->lang->line('best_contact_2_contact_post');
					}
					elseif($this->input->post('bestcontact_job') == '3')
					{
                        $bestcontact_job = $this->lang->line('best_contact_3_contact_post');
					}
					elseif($this->input->post('bestcontact_job') == '4')
					{
                        $bestcontact_job = $this->lang->line('best_contact_4_contact_post');
					}
					else
					{
                        $bestcontact_job = $this->lang->line('best_contact_5_contact_post');
					}
					$dataPost = array(
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
                                        'job_begindate'       	=>      $currentDate,
                                        'job_enddate'   		=>      mktime(0, 0, 0, (int)$this->input->post('endmonth_job'), (int)$this->input->post('endday_job'), (int)$this->input->post('endyear_job')),
                                        'job_user'      		=>      (int)$this->session->userdata('sessionUser'),
                                        'job_status'      		=>      1,
                                        'job_reliable'       	=>      0,
                                        'job_view'   			=>      0
										);
					if($this->job_model->add($dataPost))
					{
						$this->session->set_flashdata('sessionSuccessPostJob', 1);
					}
					$this->session->set_userdata('sessionTimePosted', time());
					redirect(base_url().trim(uri_string(), '/'), 'location');
				}
				else
				{
					$data['title_job'] = $this->input->post('title_job');
					$data['field_job'] = $this->input->post('field_job');
					$data['position_job'] = $this->input->post('position_job');
					$data['level_job'] = $this->input->post('level_job');
					$data['foreign_language_job'] = $this->input->post('foreign_language_job');
					$data['computer_job'] = $this->input->post('computer_job');
					$data['age1_job'] = $this->input->post('age1_job');
					$data['age2_job'] = $this->input->post('age2_job');
     				$data['sex_job'] = $this->input->post('sex_job');
					$data['require_job'] = $this->input->post('require_job');
     				$data['experience_job'] = $this->input->post('experience_job');
     				$data['province_job'] = $this->input->post('province_job');
                    $data['time_job'] = $this->input->post('time_job');
                    $data['salary_job'] = $this->input->post('salary_job');
                    $data['currency_job'] = $this->input->post('currency_job');
                    $data['datesalary_job'] = $this->input->post('datesalary_job');
					$data['try_job'] = $this->input->post('try_job');
					$data['datetry_job'] = $this->input->post('datetry_job');
					$data['interest_job'] = $this->input->post('interest_job');
					$data['quantity_job'] = $this->input->post('quantity_job');
					$data['record_job'] = $this->input->post('record_job');
					$data['day_job'] = $this->input->post('day_job');
					$data['month_job'] = $this->input->post('month_job');
     				$data['year_job'] = $this->input->post('year_job');
					$data['txtContent'] = $this->input->post('txtContent');
     				$data['name_job'] = $this->input->post('name_job');
     				$data['address_job'] = $this->input->post('address_job');
                    $data['phone_job'] = $this->input->post('phone_job');
                    $data['mobile_job'] = $this->input->post('mobile_job');
                    $data['email_job'] = $this->input->post('email_job');
                    $data['website_job'] = $this->input->post('website_job');
					$data['namecontact_job'] = $this->input->post('namecontact_job');
					$data['addresscontact_job'] = $this->input->post('addresscontact_job');
					$data['phonecontact_job'] = $this->input->post('phonecontact_job');
					$data['mobilecontact_job'] = $this->input->post('mobilecontact_job');
					$data['emailcontact_job'] = $this->input->post('emailcontact_job');
					$data['yahoo_job'] = $this->input->post('yahoo_job');
					$data['skype_job'] = $this->input->post('skype_job');
     				$data['bestcontact_job'] = $this->input->post('bestcontact_job');
					$data['endday_job'] = $this->input->post('endday_job');
     				$data['endmonth_job'] = $this->input->post('endmonth_job');
     				$data['endyear_job'] = $this->input->post('endyear_job');
				}
			}
            #BEGIN: Create captcha post job
            $this->load->library('captcha');
            $codeCaptcha = $this->captcha->code(6);
			$this->session->set_flashdata('sessionCaptchaPostJob', $codeCaptcha);
			$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.(int)$this->session->userdata('sessionUser').'posj.jpg';
			$this->session->set_flashdata('sessionPathCaptchaPostJob', $imageCaptcha);
			$this->captcha->create($codeCaptcha, $imageCaptcha);
			if(file_exists($imageCaptcha))
			{
				$data['imageCaptchaPostJob'] = $imageCaptcha;
			}
			#END Create captcha post job
		}
		#Load view
		$this->load->view('home/job/post', $data);
	}
	
	function _valid_captcha_send_friend($str)
	{
		if($this->session->flashdata('sessionCaptchaSendFriendJob') && $this->session->flashdata('sessionCaptchaSendFriendJob') === $str)
		{
			return true;
		}
		return false;
	}

	function _valid_captcha_send_fail($str)
	{
		if($this->session->flashdata('sessionCaptchaSendFailJob') && $this->session->flashdata('sessionCaptchaSendFailJob') === $str)
		{
			return true;
		}
		return false;
	}
	
	function _valid_website($str)
	{
        if(preg_match('/[^0-9a-z_.-]/i', $str))
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
	
	function _valid_age()
	{
        $fromAge = (int)$this->input->post('age1_job');
		$toAge = (int)$this->input->post('age2_job');
		if($this->check->is_more($fromAge, $toAge, false))
		{
		    return false;
		}
		return true;
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

	function _exist_field($str)
	{
		if(count($this->field_model->get("fie_id", "fie_status = 1 AND fie_id = ".(int)$str)) == 1)
		{
			return true;
		}
		return false;
	}
	
	function _valid_date()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$date = mktime(0, 0, 0, (int)$this->input->post('month_job'), (int)$this->input->post('day_job'), (int)$this->input->post('year_job'));
		if($this->check->is_more($currentDate, $date))
		{
		    return false;
		}
		return true;
	}

	function _valid_enddate()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$endDate = mktime(0, 0, 0, (int)$this->input->post('endmonth_job'), (int)$this->input->post('endday_job'), (int)$this->input->post('endyear_job'));
		if($this->check->is_more($currentDate, $endDate))
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

	function _valid_captcha_post($str)
	{
		if($this->session->flashdata('sessionCaptchaPostJob') && $this->session->flashdata('sessionCaptchaPostJob') === $str)
		{
			return true;
		}
		return false;
	}
}