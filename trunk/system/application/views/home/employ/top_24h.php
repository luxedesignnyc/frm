<?php if(count($top24hEmploy) > 0){ ?>
<tr>
    <td class="tieude_trai"><?php echo $this->lang->line('title_top_24h_employ_right'); ?></td>
</tr>
<tr>
    <td align="left" style="padding:5px 5px 0px 5px;">
        <table border="0" width="100%" cellpadding="0" cellspacing="0">
            <?php $isDivEmploy = 1; ?>
            <?php foreach($top24hEmploy as $top24hEmployArray){ ?>
            <tr id="DivTop24hEmploy_<?php echo $isDivEmploy; ?>">
                <td valign="top" style="padding-top:4px;"><img src="<?php echo base_url(); ?>templates/home/images/list_dot.gif" border="0" /></td>
                <td class="list_1" valign="top">
                    <a class="menu_1" href="<?php echo base_url(); ?>employ/field/<?php echo $top24hEmployArray->emp_field; ?>/detail/<?php echo $top24hEmployArray->emp_id; ?>" onmouseover="ddrivetip('<?php echo $this->lang->line('level_tip'); ?>&nbsp;<?php echo $top24hEmployArray->emp_level; ?><br><?php echo $this->lang->line('position_like_tip'); ?>&nbsp;<?php echo $top24hEmployArray->emp_position; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();"><?php echo $top24hEmployArray->emp_title; ?></a>
                </td>
            </tr>
            <?php $isDivEmploy++; ?>
            <?php } ?>
            <tr>
        		<td valign="top" class="view_all" colspan="2"><a class="menu_2" onclick="OpenTabTopJob(<?php echo Setting::settingJob24Gio_E_Top; ?>, 1, 'employ')" href="#24h">1</a>&nbsp;&nbsp;<a class="menu_2" onclick="OpenTabTopJob(<?php echo Setting::settingJob24Gio_E_Top; ?>, 2, 'employ')" href="#48h">2</a>&nbsp;&nbsp;<a class="menu_2" onclick="OpenTabTopJob(<?php echo Setting::settingJob24Gio_E_Top; ?>, 3, 'employ')" href="#72h">3&nbsp;...</a></td>
        	</tr>
        	<script>OpenTabTopJob(<?php echo Setting::settingJob24Gio_E_Top; ?>, 1, 'employ');</script>
        </table>
    </td>
</tr>
<?php } ?>