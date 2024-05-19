
<footer id="footer">
    <div class="container footer-in">
      <div class="disclaimer four columns">
        <h4 class="subtitle">Disclaimer</h4>
        <br />
        <p> Important: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla at felis mi, at auctor mi. Donec vel nibh sem. Etiam ut lacus a dui accumsan accumsan. </p>
        <br />
        <p>© 2012. All Rights Reserved.<br>
          Powered by <a href="http://wordpress.org/">WordPress</a></p>
      </div>
      <!-- Disclaimer /end -->
      <div class="four columns">
        <h4 class="subtitle">stay connected</h4>
        <br />
        <p class="twitt-txt">@<a href="https://twitter.com/webnus">webnus</a> <span id="twitter"></span> </p>
        <div class="socailfollow"><a href="<?php echo template_parts_model::read_key("facebook"); ?>" class="facebook"><img src="images/social_facebook2.png" alt="" ></a> <a href="<?php echo template_parts_model::read_key("twitter"); ?>" class="twitter"><img src="images/social_twitter2.png" alt="" ></a><a href="<?php echo template_parts_model::read_key("pinterest"); ?>" class="pinterest"><img src="images/social_pinterest.png" alt=""></a> <a href="<?php echo template_parts_model::read_key("youtube"); ?>" class="youtube"><img src="images/social_youtube.png" alt=""></a>  </div>
      </div>
      <!-- end-stay connected /end -->
      <div class="four columns">
        <h4 class="subtitle">flickr photostream</h4>
        <br />
        <div class="flickr-feed">
          <script type="text/javascript" src="http://www.flickr.com/badge_code.gne?count=9&amp;display=random&amp;size=square&amp;nsid=36587311@N08&amp;raw=1"></script>
          <div class="clear"></div>
        </div>
      </div>
      <!-- flickr  /end -->
      <div class="four columns contact-inf">
        <h4 class="subtitle">Contact Information</h4>
        <br />
        <p><strong>Address: </strong> No.28 - 63739 street lorem ipsum City, Country</p>
        <p><strong>Phone: </strong> + 1 (234) 567 8901 </p>
        <p><strong>Fax: </strong> + 1 (234) 567 8901 </p>
        <p><strong>Email: </strong> support@yoursite.com </p>
      </div>
      <!-- end-contact-info /end -->
    </div>
    <!-- end-footer-in -->
    <div class="footbot container" >
      <div class="footer-navi"> <?php echo template_parts_model::get_footer_menu(); ?></div>
	  <!-- footer-navigation /end -->
      <img src="images/<?php echo template_parts_model::read_key("footer_logo"); ?>" alt=""> </div>
    <!-- end-footbot -->
  </footer>
  <!-- end-footer -->
  <span id="scroll-top"><a class="scrollup"></a></span>
  </div>
<!-- end-wrap -->

<!-- End Document
================================================== -->
<script type="text/javascript" src="<?php echo ROOT_DIR ;?>templates/js/jcarousel.js" ></script>
<script type="text/javascript">
jQuery(document).ready(function() {
jQuery('#latest-projects').jcarousel(), jQuery('#our-clients').jcarousel();
});
</script>  
<script type="text/javascript" src="<?php echo ROOT_DIR ;?>templates/js/quentin-custom.js" ></script>
<script src="<?php echo ROOT_DIR ;?>templates/layerslider/jQuery/jquery-easing-1.3.js" type="text/javascript"></script>
<script src="<?php echo ROOT_DIR ;?>templates/layerslider/js/layerslider.kreaturamedia.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$('#layerslider').layerSlider({
skinsPath : 'layerslider/skins/',
skin : 'fullwidth',
thumbnailNavigation : 'hover',
hoverPrevNext : true,
responsive : true,
responsiveUnder : 940,
thumbnailNavigation : false,
sublayerContainer : 1000
});
});		
</script>
<script src="<?php echo ROOT_DIR ;?>templates/js/bootstrap-alert.js"></script>
<script src="<?php echo ROOT_DIR ;?>templates/js/bootstrap-dropdown.js"></script>
<script src="<?php echo ROOT_DIR ;?>templates/js/bootstrap-tab.js"></script>
</body>
</html>