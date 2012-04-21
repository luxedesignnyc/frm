<?php if(isset($siteGlobal)){ ?>
<!--BEGIN: Left-->
<td width="201" valign="top" bgcolor="#DFF3FE">
    <table width="201" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td class="title"><?php echo $this->lang->line('title_advertise_left_detail_global'); ?></td>
        </tr>
        <tr>
            <td height="5"></td>
        </tr>
        <?php $this->load->view('home/advertise/left'); ?>
    </table>
</td>
<!--END Left-->
<?php } ?>