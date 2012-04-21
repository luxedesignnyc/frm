<?php if(count($top24hJob) > 0){ ?>
<tr>
    <td class="tieude_trai"><?php echo $this->lang->line('title_top_24h_job_right'); ?></td>
</tr>
<tr>
    <td align="left" style="padding:5px 5px 0px 5px;">
        <table border="0" width="90%" cellpadding="0" cellspacing="0">
            <?php $isDivJob = 1; ?>
            <?php foreach($top24hJob as $top24hJobArray){ ?>
            <tr id="DivTop24hJob_<?php echo $isDivJob; ?>">
                <td valign="top" style="padding-top:4px;"><img src="<?php echo base_url(); ?>templates/home/images/list_dot.gif" border="0" /></td>
                <td class="list_1" valign="top">
                    <a class="menu_1" href="<?php echo base_url(); ?>job/field/<?php echo $top24hJobArray->job_field; ?>/detail/<?php echo $top24hJobArray->job_id; ?>" onmouseover="ddrivetip('<?php echo $this->lang->line('position_tip'); ?>&nbsp;<?php echo $top24hJobArray->job_position; ?><br><?php echo $this->lang->line('time_surrend_tip'); ?>&nbsp;<?php echo date('d-m-Y', $top24hJobArray->job_time_surrend); ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();"><?php echo $top24hJobArray->job_title; ?></a>
                </td>
            </tr>
            <?php $isDivJob++; ?>
            <?php } ?>
            <tr>
        		<td valign="top" class="view_all" colspan="2"><a class="menu_2" onclick="OpenTabTopJob(<?php echo Setting::settingJob24Gio_J_Top; ?>, 1, 'job')" href="#24h">1</a>&nbsp;&nbsp;<a class="menu_2" onclick="OpenTabTopJob(<?php echo Setting::settingJob24Gio_J_Top; ?>, 2, 'job')" href="#48h">2</a>&nbsp;&nbsp;<a class="menu_2" onclick="OpenTabTopJob(<?php echo Setting::settingJob24Gio_J_Top; ?>, 3, 'job')" href="#72h">3&nbsp;...</a></td>
        	</tr>
        	<script>OpenTabTopJob(<?php echo Setting::settingJob24Gio_J_Top; ?>, 1, 'job');</script>
        </table>
    </td>
</tr>
<?php } ?>