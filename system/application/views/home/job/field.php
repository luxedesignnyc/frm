<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: CENTER-->
<td width="602" valign="top">
    <table width="602" border="0" cellpadding="0" cellspacing="0">
        <?php $this->load->view('home/advertise/top'); ?>
        <tr id="DivField_1" style="display:none;">
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.jpg" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_field_field'); ?></div>
            </td>
        </tr>
        <tr id="DivField_2" style="display:none;">
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg" valign="top">
                <table align="center" width="580" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td height="6" colspan="4"></td>
                    </tr>
                    <tr>
                    <?php $counter = 1; ?>
                    <?php foreach($field as $fieldArray){ ?>
                        <td align="left" width="25" class="icon_field"><img src="<?php echo base_url(); ?>templates/home/images/field/<?php echo $fieldArray->fie_image; ?>" border="0" /></td>
                        <td align="left" class="list_field">
                            <a class="menu_1" href="<?php echo base_url(); ?>job/field/<?php echo $fieldArray->fie_id; ?>" title="<?php echo $fieldArray->fie_descr; ?>">
                            <?php echo $fieldArray->fie_name; ?>
                            </a>
                        </td>
                    <?php if($counter % 2 == 0 && $counter < count($field)){ ?>
					</tr><tr>
    				<?php } ?>
                    <?php $counter++; ?>
                    <?php } ?>
                    <?php if(count($field) % 2 != 0){ ?>
                    <td align="left" width="25" class="icon_field"></td>
                    <td align="left" class="list_field"></td>
                    <?php } ?>
					</tr>
                </table>
            </td>
        </tr>
        <tr id="DivField_3" style="display:none;">
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung.jpg" height="16" ></td>
        </tr>
        <tr id="DivField_4" style="display:none;">
            <td height="10"></td>
		</tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.jpg" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_interest_field'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_tinraovat.jpg" height="29">
                <table align="center" width="580" height="29" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="360" class="title_boxjob_1">
                            <?php echo $this->lang->line('title_list'); ?>
                        </td>
                        <td width="105" class="title_boxjob_2">
                            <?php echo $this->lang->line('date_post_list'); ?>
                        </td>
                        <td width="110" class="title_boxjob_1">
                            <?php echo $this->lang->line('place_job_list'); ?>
                        </td>
                    </tr>
                </table>
           </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg" valign="top">
                <table align="center" width="580" border="0" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($interestJob as $interestJobArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowInterestJob_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowInterestJob_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRowInterestJob_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="28" height="32" class="line_boxjob_1" ><img src="<?php echo base_url(); ?>templates/home/images/icon_tieudejob.gif" /></td>
                        <td width="322" height="32" class="line_boxjob_1"><a class="menu" href="<?php echo base_url(); ?>job/field/<?php echo $interestJobArray->job_field; ?>/detail/<?php echo $interestJobArray->job_id; ?>" onmouseover="ddrivetip('<?php echo $this->lang->line('position_tip'); ?>&nbsp;<?php echo $interestJobArray->job_position; ?><br><?php echo $this->lang->line('time_surrend_tip'); ?>&nbsp;<?php echo date('d-m-Y', $interestJobArray->job_time_surrend); ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();"><?php echo sub($interestJobArray->job_title, 60); ?></a>&nbsp;<span class="number_view">(<?php echo $interestJobArray->job_view; ?>)</span>&nbsp;</td>
                        <td width="100" height="32" class="line_boxjob_2"><?php echo date('d-m-Y', $interestJobArray->job_begindate); ?></td>
                        <td width="105" height="32" class="line_boxjob_3"><?php echo $interestJobArray->pre_name; ?></td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                </table>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung.jpg" height="16" ></td>
        </tr>
        <tr>
            <td height="5"></td>
		</tr>
        <?php $this->load->view('home/advertise/bottom'); ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.jpg" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_new_job_field'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_tinraovat.jpg" height="29">
                <table align="center" width="580" height="29" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="360" class="title_boxjob_1">
                            <?php echo $this->lang->line('title_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                        <td width="105" class="title_boxjob_2">
                            <?php echo $this->lang->line('date_post_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                        <td width="110" class="title_boxjob_1">
                            <?php echo $this->lang->line('place_job_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>place/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>place/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                    </tr>
                </table>
           </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg" >
                <table align="center" width="580" border="0" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($job as $jobArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowJob_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowJob_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRowJob_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="28" height="32" class="line_boxjob_1" ><img src="<?php echo base_url(); ?>templates/home/images/icon_tieudejob.gif" /></td>
                        <td width="322" height="32" class="line_boxjob_1"><a class="menu" href="<?php echo base_url(); ?>job/field/<?php echo $jobArray->job_field; ?>/detail/<?php echo $jobArray->job_id; ?>" onmouseover="ddrivetip('<?php echo $this->lang->line('position_tip'); ?>&nbsp;<?php echo $jobArray->job_position; ?><br><?php echo $this->lang->line('time_surrend_tip'); ?>&nbsp;<?php echo date('d-m-Y', $jobArray->job_time_surrend); ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();"><?php echo sub($jobArray->job_title, 60); ?></a>&nbsp;<span class="number_view">(<?php echo $jobArray->job_view; ?>)</span>&nbsp;</td>
                        <td width="100" height="32" class="line_boxjob_2"><?php echo date('d-m-Y', $jobArray->job_begindate); ?></td>
                        <td width="105" height="32" class="line_boxjob_3"><?php echo $jobArray->pre_name; ?></td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" id="post_boxjob"><img src="<?php echo base_url(); ?>templates/home/images/icon_postboxjob.gif" onclick="ActionLink('<?php echo base_url(); ?>job/post')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="sort_boxjob">
                            <select name="select_sort" id="select_sort" onchange="ActionSort(this.value)">
                                <option value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_asc_by_view_field'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_desc_by_view_field'); ?></option>
                            </select>
                        </td>
                        <td width="37%" id="show_page"><?php echo $linkPage; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung.jpg" height="16" ></td>
        </tr>
        <?php $this->load->view('home/advertise/footer'); ?>
    </table>
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>