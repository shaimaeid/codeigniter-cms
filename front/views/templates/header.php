<?php $this->load->model('template_parts_model'); ?> 
<!DOCTYPE html>
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title><?php echo template_parts_model::read_key("site_title_en"); ?></title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
  ================================================== -->
	<link rel="stylesheet" href="<?php echo ROOT_DIR ;?>templates/css/style.css" type="text/css"  media="all">
	<link href='http://fonts.googleapis.com/css?family=Raleway:300,400,700,900' rel='stylesheet' type='text/css'>

	<!-- JS
  ================================================== -->
   <script type="text/javascript" src="<?php echo ROOT_DIR ;?>templates/js/jquery.min.js" ></script>
	<!--[if lt IE 9]>
	<script src="<?php echo ROOT_DIR ;?>templates/js/modernizr.custom.11889.js" type="text/javascript"></script>
	<![endif]-->
		<!-- HTML5 Shiv events (end)-->
    <script type="text/javascript" src="<?php echo ROOT_DIR ;?>templates/js/nav-resp.js"></script>
	
	<!-- Favicons
  ================================================== -->
	<link rel="shortcut icon" href="<?php echo ROOT_DIR ;?>templates/images/favicon.ico">

    </head>
<body>

	<!-- Primary Page Layout
	================================================== -->
	
<div id="wrap" class="colorskin-1">
  <div class="top-bar">
    <div class="container">
      <div class="top-links"> <?php echo template_parts_model::get_top_menu(); ?></div>
      <div class="socailfollow"><a href="<?php echo template_parts_model::read_key("facebook"); ?>" class="facebook"><img src="images/social_facebook2.png" alt="" ></a> <a href="<?php echo template_parts_model::read_key("twitter"); ?>" class="twitter"><img src="images/social_twitter2.png" alt="" ></a>  <a href="<?php echo template_parts_model::read_key("pinterest"); ?>" class="pinterest"><img src="images/social_pinterest.png" alt=""></a>  <a href="<?php echo template_parts_model::read_key("youtube"); ?>" class="youtube"><img src="images/social_youtube.png" alt=""></a> </div>
    </div>
  </div>
  <header id="header">
    <div  class="container">
      <div class="four columns logo"><a href="index.html"><img src="images/<?php echo template_parts_model::read_key("header_logo"); ?>" id="img-logo" alt="logo"></a></div>
      <div class="twelve columns alignright">
        <input name="" type="text" placeholder="Search..." class="header-saerch" >
      </div>
    </div>
    <nav id="nav-wrap" class="nav-wrap2">
      <div class="container">
        <ul id="nav" class="sixteen columns">
          <li class="current"><a data-description="All Start here" class="drp-aro" href="index.html">Home </a> </li>
          <li><a data-description="template features" class="drp-aro" href="#">Products <span class="row-mn"></span></a>
            <ul>
   
            <li><a href="#">Software</a>
                <ul>
				  <li><a href="#">Hansa ERP</a></li>
                  <li><a href="#">Archiving and contents management system</a></li>
                  <li><a href="#">CBS</a></li>
                  <li><a href="#">Queue system software</a></li>
                </ul>
            </li>
			<li><a href="#">Hardware</a>
                <ul>
                  <li><a href="#">Queue System</a></li>
                  <li><a href="#">Receipt Printer</a></li>
                  <li><a href="#">Barcode printers</a></li>
                  <li><a href="#">Handheld scanners</a></li>
                  <li><a href="#">Labels</a></li>
                </ul>
            </li>
            </ul>
          </li>
		  <li><a data-description="Time to meet Quentin" class="drp-aro" href="about.html">Professional Services <span class="row-mn"></span></a>
            <ul>
              <li><a href="about.html"> BI (Business Intelligence)</a></li>
              <li><a href="about-me.html">Data center designing , setup and configuration</a></li>
              <li><a href="about-simple.html">Networking security</a></li>
              <li><a href="ourteam.html">Data Mining</a></li>
              <li><a href="testimonials.html">Information system security</a></li>
              <li><a href="testimonials.html">Financial Consultancy</a></li>
            </ul>
          </li>
          <li><a data-description="things we have done" class="drp-aro" href="portfolio3col.html">IT Consultancy <span class="row-mn"></span></a>
			<ul>
              <li><a href="about.html"> Security</a></li>
              <li><a href="about-me.html">Networks</a></li>
            </ul>
          </li>
		   <li><a data-description="things we have done" class="drp-aro" href="portfolio3col.html">Soft Skills Training <span class="row-mn"></span></a>
			<ul>
              <li><a href="about.html"> Speed Reading</a></li>
              <li><a href="about-me.html">Software training</a></li>
              <li><a href="about-me.html">Hardware training</a></li>
              <li><a href="about-me.html">Self Developing</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
    <!-- /nav-wrap -->
  </header>
  <!-- end-header -->
  <section id="hero" class="tbg1">
    <div id="layerslider-container-fw">
      <div id="layerslider" style="width: 100%; height: 436px; margin: 0px auto; ">
	  
        <div class="ls-layer" style="slidedirection: top; slidedelay: 6000; durationin: 1500; durationout: 1500; delayout: 500;">
		
		 <img src="images/slide-bg1.jpg" class="ls-bg" alt="">
		 
		 <img src="images/slide1-p1.png" class="ls-s6" alt="" style="top: 48px; left: 68%;  slidedirection : fade; slideoutdirection : bottom; durationin : 1500; durationout : 750; easingin : easeInOutQuint; easingout : easeInOutQuint; delayin : 1500;">
		 
          <h2 class="ls-s3" style="position: absolute; top:94px; left: 30px; slidedirection : top; slideoutdirection : top; durationin : 3000; durationout : 750; easingin : easeInOutQuint; easingout : easeInBack; delayin : 1000;">Premium Multi-purpose,<br>
            Responsive Template</h2>
			
          <h4 class="ls-s3 l1-s1" style="position: absolute; top:194px; left: 30px; slidedirection : left; slideoutdirection : left; durationin : 3000; durationout : 750; easingin : easeInOutQuint; easingout : easeInBack; delayin : 1000;">Modern & Clean Design Business Template</h4>
		  
          <p class="ls-s8" style="position: absolute; top:240px; left: 30px; width:460px; slidedirection : left; slideoutdirection : left; durationin : 3000; durationout : 750; easingin : easeInOutQuint; easingout : easeInBack; delayin : 1400;">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse</p>
		  
          <a class="button ls-s8" href="#" style="position: absolute; top:314px; left: 30px; slidedirection : bottom; slideoutdirection : bottom; durationin : 3000; durationout : 750; easingin : easeInOutQuint; easingout : easeInOutQuint; delayin : 1300;">Purchase Now</a>
		  
		   </div>
		   
        <div class="ls-layer" style="slidedirection: right; slidedelay: 5000; durationin: 1500; durationout: 1500;">
		
		 <img src="images/slide-bg3-3.jpg" class="ls-bg" alt=""> 
		 
		 <img src="images/slide1-p2.png" class="ls-s6" alt="" style="top: 30px; left: 68%;  slidedirection : bottom; slideoutdirection : bottom; durationin : 1500; durationout : 750; easingin : easeInOutQuint; easingout : easeInOutQuint; delayin : 800;">
		 
          <h2 class="ls-s3" style="position: absolute; top:94px; left: 30px; slidedirection : right; slideoutdirection : left; durationin : 3000; durationout : 750; easingin : easeInOutQuint; easingout : easeInBack; delayin : 400;">10 Predefined,<br>
            Beautiful Color Skins</h2>
			
          <h3 class="ls-s3 l1-s1" style="position: absolute; top:192px; left: 30px; slidedirection : bottom; slideoutdirection : left; durationin : 3000; durationout : 750; easingin : easeInOutQuint; easingout : easeInBack; delayin : 600;">Easily Start & Customize Your Website</h3>
		  
          <p class="ls-s8" style="position: absolute; top:240px; left: 30px; width:460px; slidedirection : right; slideoutdirection : left; durationin : 3000; durationout : 750; easingin : easeInOutQuint; easingout : easeInBack; delayin : 600;">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse</p>
		  
          <a class="button ls-s8" href="#" style="position: absolute; top:314px; left: 30px; slidedirection : bottom; slideoutdirection : bottom; durationin : 3000; durationout : 750; easingin : easeInOutQuint; easingout : easeInOutQuint; delayin : 750;">Purchase Now</a>
		  
		   </div>
		   
        <div class="ls-layer" style="slidedirection: right; slideoutdirection : top; slidedelay: 5000; durationin: 1500; durationout: 1500; delayout: 500;"> 
		
		<img src="images/slide-bg2.jpg" class="ls-bg" alt=""> 
		
		<img src="images/cloud-slide1.png" class="ls-s6" alt="" style="top: 48px; left: 59%; slidedirection : right; slideoutdirection : top; durationin : 2000; durationout : 1700; easingin : easeOutExpo; delayin : 350;">
		 <img src="images/cloud-slide2.png" class="ls-s6"  alt="" style="top: 148px; left: 49%; slidedirection : right; slideoutdirection : top;  durationin : 2000; durationout : 1700; easingin : easeOutExpo; delayin : 1300;">
		  <img src="images/slide1-p3.png" class="ls-s6" alt="" style="top: 48px; left: 69%;  slidedirection : right; slideoutdirection : top; durationin : 2000; durationout : 1700; easingin : easeInOutQuint; easingout : easeInOutQuint; delayin : 750;">
		   <img src="images/cloud-slide3.png" class="ls-s6"  alt="" style="top: 241px; left: 72%; slidedirection : right; slideoutdirection : top; durationin : 2000; durationout : 1700; easingin : easeOutExpo; delayin : 1700;">
		    <img src="images/cloud-slide3.png" class="ls-s6"  alt="" style="top: 265px; left: 61%; slidedirection : right; slideoutdirection : top; durationin : 2000; durationout : 1700; easingin : easeOutExpo; delayin : 1600;">
			
          <h2 class="ls-s3" style="position: absolute; top:94px; left: 30px; color:#fff; text-shadow:0px 1px 1px rgba(0,0,0,0.4); slidedirection : right; slideoutdirection : left; durationin : 3000; durationout : 750; easingin : easeInOutQuint; easingout : easeInBack; delayin : 1000;">Enjoy the amazing features<br>
            from Layer Slider</h2>
			
          <h4 class="ls-s3 l1-s1" style="position: absolute; top:194px; left: 30px; slidedirection : left; slideoutdirection : left; durationin : 3000; durationout : 750; easingin : easeInOutQuint; easingout : easeInBack; delayin : 1000;">The Parallax Effect Slider</h4>
		  
          <p class="ls-s8" style="position: absolute; top:240px; left: 30px; width:290px; slidedirection : right; slideoutdirection : left; durationin : 3000; durationout : 750; easingin : easeInOutQuint; easingout : easeInBack; delayin : 1000;">Raw denim you probably haven't heard of them jean shorts Austin stumptown aliqua.</p>
		  
          <a class="button ls-s8" href="#" style="position: absolute; top:314px; left: 30px; slidedirection : bottom; slideoutdirection : bottom; durationin : 3000; durationout : 750; easingin : easeInOutQuint; easingout : easeInOutQuint; delayin : 1300;">Purchase Now</a>
		  
		   </div>
		   
      </div>
    </div>
  </section>
  <!-- end-hero-->
  <!-- start-home-content-->
  <section class="container home-content" >
  <!-- Quentin-Iconbox-start -->
    <div class="vertical-space1"></div>
    <ul id="main-ibox" class="sixteen columns omega">
      <?php echo template_parts_model::get_Features(); ?>
    </ul>
    <script type="text/javascript">
		$('ul#main-ibox li:nth-child(2)').addClass('active9');
		$('ul#main-ibox li').mouseover(function() {
		$('li.active9').removeClass('active9'), $('li:hover').addClass('active9');
		}).mouseout(function() {
		$('li.active9').removeClass('active9'), $('ul#main-ibox li:nth-child(2)').addClass('active9')
		});
		</script>
    <div class="vertical-space1"></div>
	<!-- Quentin-Iconbox-end -->