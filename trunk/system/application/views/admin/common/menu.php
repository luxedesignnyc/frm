<tr>
    <td height="27" valign="top">
        <table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td width="2" height="27" valign="top"></td>
                <td height="27" valign="top">
                    <div id="chromemenu">
                        <ul>
                            <li><a onclick="ActionLink('<?php echo base_url(); ?>administ')" style="cursor:pointer;"><?php echo $this->lang->line('home_menu'); ?></a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu1')" style="cursor:pointer;"><?php echo $this->lang->line('system_menu'); ?></a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu2')" style="cursor:pointer;"><?php echo $this->lang->line('category_menu'); ?></a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu3')" style="cursor:pointer;"><?php echo $this->lang->line('member_menu'); ?></a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu4')" style="cursor:pointer;"><?php echo $this->lang->line('shop_menu'); ?></a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu5')" style="cursor:pointer;"><?php echo $this->lang->line('product_menu'); ?></a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu6')" style="cursor:pointer;"><?php echo $this->lang->line('ads_menu'); ?></a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu7')" style="cursor:pointer;"><?php echo $this->lang->line('job_menu'); ?></a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu8')" style="cursor:pointer;"><?php echo $this->lang->line('info_menu'); ?></a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu9')" style="cursor:pointer;"><?php echo $this->lang->line('tool_menu'); ?></a></li>
                            <li><a onclick="ActionLink('<?php echo base_url(); ?>administ/logout')" style="cursor:pointer;"><?php echo $this->lang->line('logout_menu'); ?></a></li>
                        </ul>
                    </div>
                    <!--1st drop down menu -->
			        <div id="dropmenu1" class="dropmenudiv">
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/system/config')" style="cursor:pointer;"><?php echo $this->lang->line('config_system_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/system/info')" style="cursor:pointer;"><?php echo $this->lang->line('info_system_menu'); ?></a>
			        </div>
			        <!--2st drop down menu -->
			        <div id="dropmenu2" class="dropmenudiv">
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/category')" style="cursor:pointer;"><?php echo $this->lang->line('category_category_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/field')" style="cursor:pointer;"><?php echo $this->lang->line('field_category_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/province')" style="cursor:pointer;"><?php echo $this->lang->line('province_category_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/menu')" style="cursor:pointer;"><?php echo $this->lang->line('menu_category_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/advertise')" style="cursor:pointer;"><?php echo $this->lang->line('advertise_category_menu'); ?></a>
			        </div>
			        <!--3st drop down menu -->
			        <div id="dropmenu3" class="dropmenudiv">
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/user')" style="cursor:pointer;"><?php echo $this->lang->line('user_member_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/end')" style="cursor:pointer;"><?php echo $this->lang->line('end_user_member_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/inactive')" style="cursor:pointer;"><?php echo $this->lang->line('inactive_user_member_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/vip')" style="cursor:pointer;"><?php echo $this->lang->line('vip_member_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/vip/end')" style="cursor:pointer;"><?php echo $this->lang->line('end_vip_member_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/saler')" style="cursor:pointer;"><?php echo $this->lang->line('saler_member_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/saler/end')" style="cursor:pointer;"><?php echo $this->lang->line('end_saler_member_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/group')" style="cursor:pointer;"><?php echo $this->lang->line('group_member_menu'); ?></a>
			        </div>
			        <!--4st drop down menu -->
			        <div id="dropmenu4" class="dropmenudiv">
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/shop')" style="cursor:pointer;"><?php echo $this->lang->line('shop_shop_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/shop/end')" style="cursor:pointer;"><?php echo $this->lang->line('end_shop_shop_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart')" style="cursor:pointer;"><?php echo $this->lang->line('showcart_shop_menu'); ?></a>
			        </div>
			        <!--5st drop down menu -->
			        <div id="dropmenu5" class="dropmenudiv">
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/product')" style="cursor:pointer;"><?php echo $this->lang->line('product_product_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/product/end')" style="cursor:pointer;"><?php echo $this->lang->line('end_product_product_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/product/bad')" style="cursor:pointer;"><?php echo $this->lang->line('bad_product_product_menu'); ?></a>
			        </div>
			        <!--6st drop down menu -->
			        <div id="dropmenu6" class="dropmenudiv">
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/ads')" style="cursor:pointer;"><?php echo $this->lang->line('ads_ads_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/ads/end')" style="cursor:pointer;"><?php echo $this->lang->line('end_ads_ads_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/ads/bad')" style="cursor:pointer;"><?php echo $this->lang->line('bad_ads_ads_menu'); ?></a>
			        </div>
			        <!--7st drop down menu -->
			        <div id="dropmenu7" class="dropmenudiv">
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/job')" style="cursor:pointer;"><?php echo $this->lang->line('job_job_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/job/end')" style="cursor:pointer;"><?php echo $this->lang->line('end_job_job_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/job/bad')" style="cursor:pointer;"><?php echo $this->lang->line('bad_job_job_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/employ')" style="cursor:pointer;"><?php echo $this->lang->line('employ_job_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/employ/end')" style="cursor:pointer;"><?php echo $this->lang->line('end_employ_job_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/employ/bad')" style="cursor:pointer;"><?php echo $this->lang->line('bad_employ_job_menu'); ?></a>
			        </div>
			        <!--8st drop down menu -->
			        <div id="dropmenu8" class="dropmenudiv">
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/contact')" style="cursor:pointer;"><?php echo $this->lang->line('contact_info_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/notify')" style="cursor:pointer;"><?php echo $this->lang->line('notify_info_menu'); ?></a>
			        </div>
			        <!--9st drop down menu -->
			        <div id="dropmenu9" class="dropmenudiv">
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/tool/mail')" style="cursor:pointer;"><?php echo $this->lang->line('mail_tool_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/tool/cache')" style="cursor:pointer;"><?php echo $this->lang->line('clear_cache_tool_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/tool/captcha')" style="cursor:pointer;"><?php echo $this->lang->line('clear_captcha_tool_menu'); ?></a>
			        </div>
                </td>
                <td width="2" height="27" valign="top"></td>
            </tr>
        </table>
    </td>
</tr>