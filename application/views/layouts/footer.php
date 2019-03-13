<div class="footer-outer">
		<div class="footer-inner">
			<div class="footer_map">
	<div class="footer_map_heading">			
		<div id="faq_List_menu">
			<ul>
				<li>
					<?php echo anchor('faq/index','Faq\'s',array('class'=>"$sFaqClass",'rel'=>"faqList1",'style'=>'color: #fff;','id'=>''));?>
				</li>
			</ul>
		</div>		
		<a href="<?= base_url();?>welcome/contact_us" style="color:#fff;">Contact Us</a>	
		  	
	</div>
	<div class="footer_map_img">
		<a href="https://maps.google.co.in/maps?q=Crystal+Properties+Inc.+6683+Schuster+St+Las+Vegas,+Nevada,+United+states&amp;hl=en&amp;ll=36.068458,-115.192391&amp;spn=0.004379,0.010568&amp;sll=18.815427,76.775144&amp;sspn=10.48978,21.643066&amp;t=m&amp;z=17" style="color:#FFFFFF;text-align:left" target="_blank">
			<img src="<?php echo $this->config->item('ASSESTS_PATH');?>images/contactus.png" border="0" width="216" height="135" />
		</a>
	</div>
	<div class="footer_map_text">Crystal Properties Inc.<br>
		6683 Schuster St<Br>
		Las Vegas, Nevada 89113	<br>
		Phone:   (702) 260  7113<br />
		Email: <a href="mailto:info@Securedshowing.com">info@Securedshowing.com</a></span>
	</div>
	</div>
			<div class="footer_social">
			<div class="footer_map_heading">SOCIAL</div>
			<a href="#" class="footer_social_link">
			<div class="footer_social_linkleft"><img src="<?php echo $this->config->item('ASSESTS_PATH');?>images/face-icon.jpg" border="0"/></div>
			<div class="footer_social_linktext">Like us on Facebook</div>
			</a>
			<a href="#" class="footer_social_link">
			<div class="footer_social_linkleft"><img src="<?php echo $this->config->item('ASSESTS_PATH');?>images/twitter-icon.jpg" border="0"/></div>
			<div class="footer_social_linktext">Follow us on Twitter</div>
			</a>
			<a href="#" class="footer_social_link">
			<div class="footer_social_linkleft"><img src="<?php echo $this->config->item('ASSESTS_PATH');?>images/linked-icon.jpg" border="0"/></div>
			<div class="footer_social_linktext">Follow us on Linked</div>
			</a>
			</div>
			<div class="footer_newsletter">
			<div class="footer_map_heading">How secured showing works </div>
				<div class="footer_newsletter_text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div>
				<div class="footer_newsletter_button"><a href="<?=base_url()?>welcome/how_securedshowing_works">MOre</a></div>
				<div>
				</div>
			</div>
		</div>
	</div>
<div class="footerbottom_box">

<div class="footercopyrights">&copy; Copyright-2014 Securedshowing Inc. All rights reserved.</div>
</div>
</div>
<ul id="faqList1" class="ddsubmenustyle">
			<?php 
				$aFaqItems = $this->faq_model->get_list(null,1);			
				foreach($aFaqItems as $aFaqItem)
				{
					echo "<li>". anchor('faq/view/'.$this->cripter->encript($aFaqItem['faq_id']), $aFaqItem['faq_title'],array()).'</li>';	
				}			
			?>
		</ul>
<script type="text/javascript">
		//	ddlevelsmenu.setup("faq_List_menu", "topbar") 
	//		ddlevelsmenu.setup("mainmenuid", "topbar|sidebar")
			</script>			
</body>
</html>