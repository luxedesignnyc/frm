<!--BEGIN: LEFT-->
<td bgcolor="#f3f3f3" width="201" valign="top">
    <table width="201" border="0" cellpadding="0" cellspacing="0">
        <?php $this->load->view('home/common/menu'); ?>
         <?php if(isset($advertisePage) && $advertisePage != 'account'){ ?>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <td class="tieude_trai"><?php echo $this->lang->line('title_advertise_left'); ?></td>
        </tr>
        <tr>
            <td height="5"></td>
        </tr>
        <?php $this->load->view('home/advertise/left'); ?>
        <?php } ?>
    </table>
</td>
<!--END LEFT-->