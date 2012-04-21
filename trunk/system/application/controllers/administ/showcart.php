<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Showcart extends Controller
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
		$this->lang->load('admin/showcart');
		#Load model
		$this->load->model('showcart_model');
		#BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->showcart_model->delete($this->input->post('checkone'), "shc_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
	}
	
	function index()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Search & Filter
		$where = '';
		$sort = '';
		$by = '';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = '';
		#If search
		if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
		{
            $keyword = $getVar['keyword'];
			switch(strtolower($getVar['search']))
			{
				case 'name':
				    $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $where .= "pro_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'cost':
				    $sortUrl .= '/search/cost/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/cost/keyword/'.$getVar['keyword'];
				    $where .= "pro_cost LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'buyer':
				    $sortUrl .= '/search/buyer/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/buyer/keyword/'.$getVar['keyword'];
				    $where .= "use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
                case 'buydate':
				    $sortUrl .= '/filter/buydate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/buydate/key/'.$getVar['key'];
				    $where .= "shc_buydate = ".(float)$getVar['key'];
				    break;
                case 'process':
				    $sortUrl .= '/filter/process/key/'.$getVar['key'];
				    $pageUrl .= '/filter/process/key/'.$getVar['key'];
				    $where .= "shc_process = 1";
				    break;
                case 'notprocess':
				    $sortUrl .= '/filter/notprocess/key/'.$getVar['key'];
				    $pageUrl .= '/filter/notprocess/key/'.$getVar['key'];
				    $where .= "shc_process = 0";
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
				    $sort .= "pro_name";
				    break;
                case 'cost':
				    $pageUrl .= '/sort/cost';
				    $sort .= "pro_cost";
				    break;
                case 'buyer':
				    $pageUrl .= '/sort/buyer';
				    $sort .= "use_username";
				    break;
                case 'quantity':
				    $pageUrl .= '/sort/quantity';
				    $sort .= "shc_quantity";
				    break;
                case 'buydate':
				    $pageUrl .= '/sort/buydate';
				    $sort .= "shc_buydate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "shc_id";
			}
			if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
			{
                $pageUrl .= '/by/desc';
				$by .= "DESC";
			}
			else
			{
                $pageUrl .= '/by/asc';
				$by .= "ASC";
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
		$data['sortUrl'] = base_url().'administ/showcart'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->showcart_model->fetch_join("shc_id", "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", "LEFT", "tbtt_user", "tbtt_showcart.shc_buyer = tbtt_user.use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/showcart'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = Setting::settingOtherAdmin;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#sTT - So thu tu
		$data['sTT'] = $start + 1;
		#Fetch record
		$select = "shc_id, shc_buydate, shc_process, shc_quantity, pro_id, pro_name, pro_category, pro_cost, pro_currency, pro_view, use_id, use_username, use_email";
		$limit = Setting::settingOtherAdmin;
		$data['showcart'] = $this->showcart_model->fetch_join($select, "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", "LEFT", "tbtt_user", "tbtt_showcart.shc_buyer = tbtt_user.use_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/showcart/defaults', $data);
	}
}