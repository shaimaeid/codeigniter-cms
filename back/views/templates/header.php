<?php
if (isset($_SESSION['user_id']) == false){
	//header("Location:".ROOT_DIR."signin/");
}
//$_SESSION['user_id']=1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

	
	<title><?php echo $title ; ?></title>

	<link href="<?php echo ROOT_DIR;?>css/styles.css" rel="stylesheet" type="text/css" />
	<!--[if IE]> <link href="css/ie.css" rel="stylesheet" type="text/css"> <![endif]-->

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>

	<script type="text/javascript" src="<?php echo ROOT_DIR;?>js/plugins/forms/ui.spinner.js"></script>
	<script type="text/javascript" src="<?php echo ROOT_DIR;?>js/plugins/forms/jquery.mousewheel.js"></script>
	 
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	

	<link rel="stylesheet" type="text/css" href="<?php echo EXT_DIR;?>resources/css/ext-all.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo EXT_DIR;?>resources/css/ext-all-gray.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR;?>css/style_ico.css" />

	<script type="text/javascript" src="<?php echo EXT_DIR;?>ext-all-debug.js"></script>


	<script type="text/javascript" src="<?php echo ROOT_DIR;?>js/plugins/ui/jquery.collapsible.min.js"></script>
	<script type="text/javascript" src="<?php echo ROOT_DIR;?>js/plugins/ui/jquery.breadcrumbs.js"></script>
	<script type="text/javascript" src="<?php echo ROOT_DIR;?>js/plugins/ui/jquery.tipsy.js"></script>
	<script type="text/javascript" src="<?php echo ROOT_DIR;?>js/plugins/ui/jquery.fancybox.js"></script>
	<script type="text/javascript" src="<?php echo ROOT_DIR;?>js/plugins/others/jquery.elfinder.js"></script>

	<script type="text/javascript" src="<?php echo ROOT_DIR;?>js/plugins/ui/jquery.easytabs.min.js"></script>
	<script type="text/javascript" src="<?php echo ROOT_DIR;?>js/files/bootstrap.js"></script>
	<script type="text/javascript" src="<?php echo ROOT_DIR;?>js/files/functions.js"></script>
	
    </head>
    
    <body>
	

<!-- Top line begins -->
<div id="top">
	<div class="wrapper">
    	<a href="index.html" title="" class="logo">EBC ADMIN PANEL</a>
        
        <!-- Right top nav -->
        <div class="topNav">
            <ul class="userNav">
                <li><a rel="tipsy" class="search tipN" title="Search" ></a></li>
                <li><a rel="tipsy" class="settings tipN" title="Settings" href="#" ></a></li>
                <li><a rel="tipsy" class="logout tipN" title="Logout"  href="<?php echo site_url("signout"); ?>"></a></li>
            </ul>
        </div>

        <div class="clear"></div>
    </div>
</div>
<!-- Top line ends -->
<div id="sidebar">

	<!-- Main nav -->
    <div class="mainNav">
        <div class="user">
            <!--<a href="<?php //echo site_url("users/profile").'/'.$_SESSION['user_id']; ?>" title="" class="leftUserDrop"><img src="<?php //echo ROOT_DIR;?>images/user.png" alt="" /></a><span><?php //echo $_SESSION['username'] ; ?></span>-->
        </div>
        
        <!-- Responsive nav -->

        
        <!-- Main nav -->
        <ul class="nav">
            <li><a href="<?php echo site_url("home"); ?>" title=""><img src="<?php echo ROOT_DIR;?>images/icons/mainnav/dashboard.png" alt="" /><span>Cpanel Home</span></a></li>
           
            <li><a href="<?php echo site_url("articles"); ?>" title=""><img src="<?php echo ROOT_DIR;?>images/icons/mainnav/forms.png" alt="" /><span>Articles</span></a></li>
			<li><a href="<?php echo site_url("vacancies"); ?>" title=""><img src="<?php echo ROOT_DIR;?>images/icons/mainnav/ui.png" alt="" /><span>Vacancies</span></a></li>
			<li><a href="<?php echo site_url("jobs"); ?>" title=""><img src="<?php echo ROOT_DIR;?>images/icons/mainnav/forms.png" alt="" /><span>Job Applications</span></a></li>
            <li><a href="<?php echo site_url("users"); ?>" title=""><img src="<?php echo ROOT_DIR;?>images/icons/mainnav/ui.png" alt="" /><span>Users</span></a></li>
			<li><a href="<?php echo site_url("clients"); ?>" title=""><img src="<?php echo ROOT_DIR;?>images/icons/mainnav/ui.png" alt="" /><span>Clients</span></a></li>
			<li><a href="<?php echo site_url("template_part"); ?>" title=""><img src="<?php echo ROOT_DIR;?>images/icons/mainnav/ui.png" alt="" /><span>Template Part</span></a></li>
			
			<li><a href="<?php echo site_url("settings"); ?>" title=""><img src="<?php echo ROOT_DIR;?>images/icons/mainnav/other.png" alt="" /><span>Settings</span></a></li>
        </ul>
   </div>
    

	