<!--<div id="content">
<div class="row">
<h1><?php// echo lang('search_result');?>.</h1>



	<?php //if ( strlen($search_results)>0){?>
		<p><?php// echo $search_results ;?></p>
<h2> categories</h2>
	<?php //echo $sidebar_cat ;?>
	<h2> Locations </h2>
	<?php //echo $locations_sidbar ;?>		
	<?php //} else echo '<p> No search reasults </p>';?>
	
	
</div>
</div>
-->
<script type="text/javascript">
<!--
function getValue(){
	var retVal = prompt("Enter your Email: ", "your Email here");
	var retVal2 = prompt("Re-Type your Email: ", "Re-Type Email");
   alert("Done" );
}
//-->
</script>
<div id="content">
	<div class="clearfix"></div>

	<ul class="breadcrumb">
	<li><a href="<?php echo site_url('home') ; ?>"><?php echo lang('tarbeet');?></a> <span class="divider">/</span></li>
	</ul>

	<div class="row">
	<div id="inner_wrapper">

	<div id="ads">
	<table>
	<thead>
	<tr class="green">
	<th colspan="2"><?php echo lang('browse_ads');?></th>
	
	<th><?php echo lang('price');?></th>
	<th><?php echo lang('posted');?></th>
	</tr>
	</thead>
	<?php echo $search_results ?>
	</table>
	

	<img src="images/icons/post_a_classified_ad.gif" id="post_img"/> 
	<a href="#"><?php echo lang('post_your_ad');?>.</a> <?php echo lang('fast');?>.
	
    </div>
	</div>
	<div id="filters">
	<div class="current_matches">
	<?php echo lang('current_matches');?>(
	<?php// echo $all_ads_count ; ?> 
	)
	</div>
	<span id="categoryLabel" class="filterTitle"><?php echo lang('category');?>:</span>
	<div style="padding-left:10px;">
	<a href="#"><?php echo lang('all_categories');?></a>
	</div>
	<div class="title"> <?php// echo $main_cat_title ; ?> </div>
	<div class="links">
	<?php echo $sidebar_cat ; ?>
	</div>
	
	<div class="title"><?php echo lang('locations');?></div>
	<div class="links">
	<?php echo $locations_sidbar ; ?>
	</div>
	
	</div>   
	</div>
	<div class="clear" style="height:40px;"></div>

</div>