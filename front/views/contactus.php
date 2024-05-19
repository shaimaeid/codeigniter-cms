<section id="headline2">
<div class="container">
<h3><?php echo lang('contact_us');?>
<small><?php echo lang('use_contect_form');?></small></h3>
</div>
</section>
<section class="container page-content" >

<div class="vertical-space3"></div>
<div class="seven columns contact-inf">
<h4><?php echo lang('contact_info');?></h4>
<br />
<p><img src="images/social_address.png" alt="">&nbsp;<strong><?php echo lang('address');?></strong></p>
<p>
<?php echo template_parts_model::read_key("address"); ?></p>
<br />
<p><img src="images/social_phone.png" alt="">&nbsp;&nbsp;<strong><?php echo lang('phone');?>:</strong></p>
<p>
<?php echo template_parts_model::read_key("phone"); ?><br />
</p>
<br />
<p><img src="images/social_mail.png" alt="">&nbsp;<strong><?php echo lang('email');?>:</strong></p>
<p>
<?php echo template_parts_model::read_key("mail_st"); ?><br />
</p>


<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="100" marginwidth="400" 
src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=%D8%B4%D8%A7%D8%B1%D8%B9+%D8%B4%D8%B1%D9%8A%D9%81+%D8%A8%D8%A7%D8%B4%D8%A7+,%D8%A7%D9%84%D9%82%D8%A7%D9%87%D8%B1%D8%A9&amp;aq=&amp;sll=30.047218,31.242845&amp;sspn=0.001326,0.002642&amp;ie=UTF8&amp;hq=&amp;hnear=Sherif+Basha,+Egypt&amp;ll=30.052402,31.242461&amp;spn=0.005303,0.010568&amp;t=m&amp;z=14&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=%D8%B4%D8%A7%D8%B1%D8%B9+%D8%B4%D8%B1%D9%8A%D9%81+%D8%A8%D8%A7%D8%B4%D8%A7+,%D8%A7%D9%84%D9%82%D8%A7%D9%87%D8%B1%D8%A9&amp;aq=&amp;sll=30.047218,31.242845&amp;sspn=0.001326,0.002642&amp;ie=UTF8&amp;hq=&amp;hnear=Sherif+Basha,+Egypt&amp;ll=30.052402,31.242461&amp;spn=0.005303,0.010568&amp;t=m&amp;z=14" 
style="color:#0000FF;text-align:left">View Larger Map</a></small>
<hr>
<p><?php echo template_parts_model::read_key("contact_txt"); ?></p>

</div>

<div class="eight columns offset-by-one">
<div class="contact-form">
<div class="clr"></div><br />
<form action="" method="post" id="frmContact">
<h5><?php echo lang('what_ur_name');?></h5>
<input name="txtName" type="text" class="txbx" value="Name" /><br />
<h5><?php echo lang('what_ur_email');?></h5>
<input name="txtEmail" type="text" class="txbx" value="Email" /><br />
<h5><?php echo lang('email_subjects');?></h5>
<input name="txtSubject" type="text" class="txbx" value="Subject" /><br />
<div class="erabox">
<h5><?php echo lang('msgs_to_us');?></h5>
<textarea name="txtText"cols="" rows="" class="txbx era" ></textarea><br />
<input name="" type="button" class="sendbtn" value="Send Message" id="btnSend"/>

<div id="spanMessage">
</div>
</div>
</form>
</div><!-- end-contact-form  -->

</div>
<div class="white-space"></div>
</section><!-- container -->
