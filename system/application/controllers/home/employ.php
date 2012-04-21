<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Employ extends Controller
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
		$this->lang->load('home/employ');
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
		$data['menuSelected'] = 'employ';
		$data['menuType'] = 'job';
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'employ_index';
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
		$where = "emp_status = 1 AND emp_enddate >= $currentDate";
		$sort = 'emp_id';
		$by = 'DESC';
		$pageSort = '';
		$pageUrl = '';
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'title':
				    $pageUrl .= '/sort/title';
				    $sort = "emp_title";
				    break;
                case 'date':
				    $pageUrl .= '/sort/date';
				    $sort = "emp_begindate";
				    break;
                case 'place':
				    $pageUrl .= '/sort/place';
				    $sort = "pre_name";
				    break;
                case 'view':
				    $pageUrl .= '/sort/view';
				    $sort = "emp_view";
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
		#END Sort
		#BEGIN: Create link Sort
		$data['sortUrl'] = base_url().'employ/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link Sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->employ_model->fetch_join("emp_id", "LEFT", "tbtt_province", "tbtt_employ.emp_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, "", ""));
        $config['base_url'] = base_url().'employ'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingJobNew;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$select = "emp_id, emp_title, emp_field, emp_view, emp_level, emp_position, emp_begindate, pre_name";
		$limit = Setting::settingJobNew;
		$data['employ'] = $this->employ_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_employ.emp_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('home/employ/defaults', $data);
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
        $data['menuFieldJob'] = false;
        $data['menuFieldEmploy'] = true;
		$data['menuSelected'] = 'employ';
		$data['menuType'] = 'job';
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'employ_sub';
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
		#BEGIN: Interest employ
		$select = "emp_id, emp_title, emp_field, emp_view, emp_level, emp_position, emp_begindate, pre_name";
		$start = 0;
  		$limit = (int)Setting::settingJobInterest;
		$data['interestEmploy'] = $this->employ_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_employ.emp_province = tbtt_province.pre_id", "", "", "", "", "", "", "emp_field = $fieldIDQuery AND emp_status = 1 AND emp_enddate >= $currentDate", "emp_view", "DESC", $start, $limit);
		#END Interest employ
		#Define url for $getVar
		$action = array('sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Sort
		$where = "emp_field = $fieldIDQuery AND emp_status = 1 AND emp_enddate >= $currentDate";
		$sort = 'emp_id';
		$by = 'DESC';
		$pageSort = '';
		$pageUrl = '';
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'title':
				    $pageUrl .= '/sort/title';
				    $sort = "emp_title";
				    break;
                case 'date':
				    $pageUrl .= '/sort/date';
				    $sort = "emp_begindate";
				    break;
                case 'place':
				    $pageUrl .= '/sort/place';
				    $sort = "pre_name";
				    break;
                case 'view':
				    $pageUrl .= '/sort/view';
				    $sort = "emp_view";
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
		#END Sort
		#BEGIN: Create link Sort
		$data['sortUrl'] = base_url().'employ/field/'.$fieldID.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link Sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->employ_model->fetch_join("emp_id", "LEFT", "tbtt_province", "tbtt_employ.emp_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, "", ""));
        $config['base_url'] = base_url().'employ/field/'.$fieldID.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingJobNew;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$select = "emp_id, emp_title, emp_field, emp_view, emp_level, emp_position, emp_begindate, pre_name";
		$limit = Setting::settingJobNew;
		$data['employ'] = $this->employ_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_employ.emp_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('home/employ/field', $data);
	}
	
	function detail($fieldID, $employID)
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
		#BEGIN: Check exist employ by $employID
		$employ = $this->employ_model->get("*", "emp_id = ".(int)$employID." AND emp_field = $fieldIDQuery AND emp_status = 1 AND emp_enddate >= $currentDate");
		if(count($employ) != 1 || !$this->check->is_id($employID))
		{
			redirect(base_url(), 'location');
			die();
		}
		#END Check exist employ by $employID
		$employIDQuery = (int)$employID;
		#BEGIN: Update view
		if(!$this->session->userdata('sessionViewEmploy_'.$employIDQuery))
		{
            $this->employ_model->update(array('emp_view' => (int)$employ->emp_view + 1), "emp_id = ".$employIDQuery);
            $this->session->set_userdata('sessionViewEmploy_'.$employIDQuery, 1);
		}
		#END Update view
		$this->load->library('bbcode');
		$this->load->library('captcha');
		$this->load->library('form_validation');
		#BEGIN: Send friend & send fail
		$data['successSendFriendEmploy'] = false;
        $data['successSendFailEmploy'] = false;
		if($this->session->flashdata('sessionSuccessSendFriendEmploy'))
 		{
  			$data['successSendFriendEmploy'] = true;
 		}
 		elseif($this->session->flashdata('sessionSuccessSendFailEmploy'))
 		{
  			$data['successSendFailEmploy'] = true;
 		}
 		#BEGIN: Create captcha send friend
		if($this->session->flashdata('sessionPathCaptchaSendFriendEmploy') && file_exists($this->session->flashdata('sessionPathCaptchaSendFriendEmploy')))
		{
			@unlink($this->session->flashdata('sessionPathCaptchaSendFriendEmploy'));
		}
		$codeCaptcha = $this->captcha->code(6);
		$this->session->set_flashdata('sessionCaptchaSendFriendEmploy', $codeCaptcha);
		$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.rand(1, 10000).'fe.jpg';
		$this->session->set_flashdata('sessionPathCaptchaSendFriendEmploy', $imageCaptcha);
		$this->captcha->create($codeCaptcha, $imageCaptcha);
		if(file_exists($imageCaptcha))
		{
			$data['imageCaptchaSendFriendEmploy'] = $imageCaptcha;
		}
		#END Create captcha send friend
		#BEGIN: Create captcha send fail
		if($this->session->flashdata('sessionPathCaptchaSendFailEmploy') && file_exists($this->session->flashdata('sessionPathCaptchaSendFailEmploy')))
		{
			@unlink($this->session->flashdata('sessionPathCaptchaSendFailEmploy'));
		}
		$data['isSendedOneFail'] = false;
		if($this->session->userdata('sessionSendFailedEmploy_'.$employIDQuery))
		{
			$data['isSendedOneFail'] = true;
		}
		else
		{
			$codeCaptcha = $this->captcha->code(6);
			$this->session->set_flashdata('sessionCaptchaSendFailEmploy', $codeCaptcha);
			$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.rand(10000, 100000).'be.jpg';
			$this->session->set_flashdata('sessionPathCaptchaSendFailEmploy', $imageCaptcha);
			$this->captcha->create($codeCaptcha, $imageCaptcha);
			if(file_exists($imageCaptcha))
			{
				$data['imageCaptchaSendFailEmploy'] = $imageCaptcha;
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
					$this->session->set_flashdata('sessionSuccessSendFriendEmploy', 1);
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
		elseif($this->input->post('captcha_sendfail') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost && !$this->session->userdata('sessionSendFailedEmploy_'.$employIDQuery))
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
				$this->load->model('employ_bad_model');
				$dataFailAdd = array(
										'emb_title'     =>      trim($this->filter->injection_html($this->input->post('title_sendfail'))),
										'emb_detail'    =>      trim($this->filter->injection_html($this->input->post('content_sendfail'))),
										'emb_email'     =>      trim($this->filter->injection_html($this->input->post('sender_sendfail'))),
										'emb_employ'   	=>      (int)$employ->emp_id,
										'emb_date'      =>      $currentDate
										);
				if($this->employ_bad_model->add($dataFailAdd))
				{
					$this->session->set_flashdata('sessionSuccessSendFailEmploy', 1);
					$this->session->set_userdata('sessionSendFailedEmploy_'.$employIDQuery, 1);
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
        $data['successFavoriteEmploy'] = false;
        $data['isLogined'] = false;
		if($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
		{
            $data['isLogined'] = true;
            if($this->session->flashdata('sessionSuccessFavoriteEmploy'))
        	{
				$data['successFavoriteEmploy'] = true;
        	}
            #BEGIN: Favorite
        	if($this->input->post('checkone') && $this->check->is_id($this->input->post('checkone')) && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
        	{
				$this->load->model('employ_favorite_model');
    			$employOne = $this->employ_model->get("emp_user", "emp_id = ".(int)$this->input->post('checkone'));
    			$employFavorite = $this->employ_favorite_model->get("emf_id", "emf_employ = ".(int)$this->input->post('checkone')." AND emf_user = ".(int)$this->session->userdata('sessionUser'));
				if(count($employOne) == 1 && count($employFavorite) == 0 && $employOne->emp_user != $this->session->userdata('sessionUser'))
				{
				    $dataAdd = array(
									    'emf_employ'    =>      (int)$this->input->post('checkone'),
									    'emf_user'      =>      (int)$this->session->userdata('sessionUser'),
									    'emf_date'      =>      $currentDate
										);
					if($this->employ_favorite_model->add($dataAdd))
					{
	    				$this->session->set_flashdata('sessionSuccessFavoriteEmploy', 1);
					}
				}
				unset($employOne);
				unset($employFavorite);
				$this->session->set_userdata('sessionTimePosted', time());
				redirect(base_url().trim(uri_string(), '/'), 'location');
        	}
        	#END Favorite
		}
        #END Add favorite and submit forms
		#Assign title and description for site
		$data['titleSiteGlobal'] = $employ->emp_title;
		$data['descrSiteGlobal'] = $employ->emp_title;
		#BEGIN: List field
		$data['listField'] = $this->field_model->fetch("fie_id, fie_name, fie_descr, fie_image", "fie_status = 1", "fie_order", "ASC");
		#END List field
		#BEGIN: Get job by $jobID and relate info
		$data['field'] = $field;
		$data['employ'] = $employ;
		$this->load->model('user_model');
		$data['user'] = $this->user_model->get("use_fullname", "use_id = ".(int)$employ->emp_user);
		$this->load->model('province_model');
		$data['province'] = $this->province_model->get("pre_name", "pre_id = ".(int)$employ->emp_province);
		#END Get job by $jobID and relate info
		#BEGIN: Menu
        $data['menuFieldJob'] = false;
        $data['menuFieldEmploy'] = true;
		$data['menuSelected'] = 'employ';
		$data['menuType'] = 'job';
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'employ_detail';
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
		$where = "emp_user = ".(int)$employ->emp_user." AND emp_id != $employIDQuery AND emp_status = 1 AND emp_enddate >= $currentDate";
		$sort = 'emp_id';
		$by = 'DESC';
		$pageSort = '';
		$pageUrl = '';
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'title':
				    $pageUrl .= '/sort/title';
				    $sort = "emp_title";
				    break;
                case 'date':
				    $pageUrl .= '/sort/date';
				    $sort = "emp_begindate";
				    break;
                case 'place':
				    $pageUrl .= '/sort/place';
				    $sort = "pre_name";
				    break;
                case 'view':
				    $pageUrl .= '/sort/view';
				    $sort = "emp_view";
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
		#END Sort
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'employ/field/'.$fieldID.'/detail/'.$employID.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->employ_model->fetch_join("emp_id", "LEFT", "tbtt_province", "tbtt_employ.emp_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, "", ""));
        $config['base_url'] = base_url().'employ/field/'.$fieldID.'/detail/'.$employID.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingJobUser;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$select = "emp_id, emp_title, emp_field, emp_view, emp_level, emp_position, emp_begindate, pre_name";
		$limit = Setting::settingJobUser;
		$data['userEmploy'] = $this->employ_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_employ.emp_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, $sort, $by, $start, $limit);
		#END Relate user
		#BEGIN: Relate field
  		$select = "emp_id, emp_title, emp_field, emp_view, emp_level, emp_position, emp_begindate, pre_name";
		$start = 0;
  		$limit = (int)Setting::settingJobField;
		$data['fieldEmploy'] = $this->employ_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_employ.emp_province = tbtt_province.pre_id", "", "", "", "", "", "", "emp_field = ".(int)$employ->emp_field." AND emp_id != $employIDQuery AND emp_status = 1 AND emp_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Relate field
		#Load view
		$this->load->view('home/employ/detail', $data);
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
        unlink_captcha($this->session->flashdata('sessionPathCaptchaPostEmploy'));
		#END Unlink captcha
		if($this->session->flashdata('sessionSuccessPostEmploy'))
		{
            $data['successPostEmploy'] = true;
		}
		else
		{
			$this->load->library('form_validation');
            $data['successPostEmploy'] = false;
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
			$user = $this->user_model->get("use_fullname, use_sex, use_address, use_email, use_phone, use_mobile, use_yahoo, use_skype", "use_id = ".(int)$this->session->userdata('sessionUser'));
			$data['name_employ'] = $user->use_fullname;
			$data['sex_employ'] = $user->use_sex;
			$data['address_employ'] = $user->use_address;
			$data['phone_employ'] = $user->use_phone;
			$data['mobile_employ'] = $user->use_mobile;
			$data['email_employ'] = $user->use_email;
			$data['yahoo_employ'] = $user->use_yahoo;
			$data['skype_employ'] = $user->use_skype;
            #END User
			if($this->input->post('captcha_employ') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)Setting::settingTimePost)
			{
				#BEGIN: Set rules
				$this->form_validation->set_rules('title_employ', 'lang:title_employ_label_post', 'trim|required');
				$this->form_validation->set_rules('field_employ', 'lang:field_employ_label_post', 'required|callback__exist_field');
				$this->form_validation->set_rules('position_employ', 'lang:position_employ_label_post', 'trim|required');
				$this->form_validation->set_rules('province_employ', 'lang:province_employ_label_post', 'required|callback__exist_province');
				$this->form_validation->set_rules('salary_employ', 'lang:salary_employ_label_post', 'trim|required|is_natural_no_zero');
				$this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_post', 'trim|required|min_length[10]|max_length[10000]');
				$this->form_validation->set_rules('name_employ', 'lang:name_employ_label_post', 'trim|required');
				$this->form_validation->set_rules('level_employ', 'lang:level_employ_label_post', 'trim|required');
				$this->form_validation->set_rules('address_employ', 'lang:address_employ_label_post', 'trim|required');
				$this->form_validation->set_rules('phone_employ', 'lang:phone_employ_label_post', 'trim|required|callback__is_phone');
				$this->form_validation->set_rules('mobile_employ', 'lang:mobile_employ_label_post', 'trim|callback__is_phone');
				$this->form_validation->set_rules('email_employ', 'lang:email_employ_label_post', 'trim|required|valid_email');
				$this->form_validation->set_rules('yahoo_employ', 'lang:yahoo_employ_label_post', 'trim|callback__valid_nick');
				$this->form_validation->set_rules('skype_employ', 'lang:skype_employ_label_post', 'trim|callback__valid_nick');
				$this->form_validation->set_rules('endday_employ', 'lang:endday_employ_label_post', 'required|callback__valid_enddate');
				$this->form_validation->set_rules('captcha_employ', 'lang:captcha_employ_label_post', 'required|callback__valid_captcha_post');
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
				$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
				$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
				$this->form_validation->set_message('_valid_captcha_post', $this->lang->line('_valid_captcha_post_message_post'));
				$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
				#END Set message
				if($this->form_validation->run() != FALSE)
				{
					if($this->input->post('time_employ') == '1')
					{
						$time_employ = $this->lang->line('time_employ_1_post');
					}
					elseif($this->input->post('time_employ') == '2')
					{
                        $time_employ = $this->lang->line('time_employ_2_post');
					}
					elseif($this->input->post('time_employ') == '3')
					{
                        $time_employ = $this->lang->line('time_employ_3_post');
					}
					elseif($this->input->post('time_employ') == '4')
					{
                        $time_employ = $this->lang->line('time_employ_4_post');
					}
					else
					{
                        $time_employ = $this->lang->line('time_employ_5_post');
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
						$datesalary_employ = $this->lang->line('year_post');
					}
					elseif($this->input->post('datesalary_employ') == '1')
					{
                        $datesalary_employ = $this->lang->line('day_post');
					}
					else
					{
                        $datesalary_employ = $this->lang->line('month_post');
					}
					$dataPost = array(
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
					                    'emp_begindate'       	=>      $currentDate,
                                        'emp_enddate'   		=>      mktime(0, 0, 0, (int)$this->input->post('endmonth_employ'), (int)$this->input->post('endday_employ'), (int)$this->input->post('endyear_employ')),
                                        'emp_user'      		=>      (int)$this->session->userdata('sessionUser'),
                                        'emp_status'      		=>      1,
                                        'emp_reliable'       	=>      0,
                                        'emp_view'   			=>      0
										);
					if($this->employ_model->add($dataPost))
					{
						$this->session->set_flashdata('sessionSuccessPostEmploy', 1);
					}
					$this->session->set_userdata('sessionTimePosted', time());
					redirect(base_url().trim(uri_string(), '/'), 'location');
				}
				else
				{
					$data['title_employ'] = $this->input->post('title_employ');
					$data['field_employ'] = $this->input->post('field_employ');
					$data['position_employ'] = $this->input->post('position_employ');
     				$data['province_employ'] = $this->input->post('province_employ');
                    $data['time_employ'] = $this->input->post('time_employ');
                    $data['salary_employ'] = $this->input->post('salary_employ');
                    $data['currency_employ'] = $this->input->post('currency_employ');
                    $data['datesalary_employ'] = $this->input->post('datesalary_employ');
					$data['txtContent'] = $this->input->post('txtContent');
     				$data['name_employ'] = $this->input->post('name_employ');
     				$data['age_employ'] = $this->input->post('age_employ');
     				$data['sex_employ'] = $this->input->post('sex_employ');
     				$data['level_employ'] = $this->input->post('level_employ');
					$data['foreign_language_employ'] = $this->input->post('foreign_language_employ');
					$data['computer_employ'] = $this->input->post('computer_employ');
     				$data['experience_employ'] = $this->input->post('experience_employ');
     				$data['address_employ'] = $this->input->post('address_employ');
                    $data['phone_employ'] = $this->input->post('phone_employ');
                    $data['mobile_employ'] = $this->input->post('mobile_employ');
                    $data['email_employ'] = $this->input->post('email_employ');
					$data['yahoo_employ'] = $this->input->post('yahoo_employ');
					$data['skype_employ'] = $this->input->post('skype_employ');
					$data['endday_employ'] = $this->input->post('endday_employ');
     				$data['endmonth_employ'] = $this->input->post('endmonth_employ');
     				$data['endyear_employ'] = $this->input->post('endyear_employ');
				}
			}
            #BEGIN: Create captcha post employ
            $this->load->library('captcha');
            $codeCaptcha = $this->captcha->code(6);
			$this->session->set_flashdata('sessionCaptchaPostEmploy', $codeCaptcha);
			$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.(int)$this->session->userdata('sessionUser').'pose.jpg';
			$this->session->set_flashdata('sessionPathCaptchaPostEmploy', $imageCaptcha);
			$this->captcha->create($codeCaptcha, $imageCaptcha);
			if(file_exists($imageCaptcha))
			{
				$data['imageCaptchaPostEmploy'] = $imageCaptcha;
			}
			#END Create captcha post employ
		}
		#Load view
		$this->load->view('home/employ/post', $data);
	}
	
	function _valid_captcha_send_friend($str)
	{
		if($this->session->flashdata('sessionCaptchaSendFriendEmploy') && $this->session->flashdata('sessionCaptchaSendFriendEmploy') === $str)
		{
			return true;
		}
		return false;
	}

	function _valid_captcha_send_fail($str)
	{
		if($this->session->flashdata('sessionCaptchaSendFailEmploy') && $this->session->flashdata('sessionCaptchaSendFailEmploy') === $str)
		{
			return true;
		}
		return false;
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

	function _exist_field($str)
	{
		if(count($this->field_model->get("fie_id", "fie_status = 1 AND fie_id = ".(int)$str)) == 1)
		{
			return true;
		}
		return false;
	}

	function _valid_enddate()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$endDate = mktime(0, 0, 0, (int)$this->input->post('endmonth_employ'), (int)$this->input->post('endday_employ'), (int)$this->input->post('endyear_employ'));
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
		if($this->session->flashdata('sessionCaptchaPostEmploy') && $this->session->flashdata('sessionCaptchaPostEmploy') === $str)
		{
			return true;
		}
		return false;
	}
}