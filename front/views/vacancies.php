<?php 
/*

*/
$page= $this->uri->segment(3, 1);
$page_pre= $this->uri->segment(3, 1)-1;
$page_nxt= $this->uri->segment(3, 1)+1;
if($page==1)
$prv='class="disabled"';
else
$prv="";

if($page>=$tot)
$nxt='class="disabled"';
else
$nxt="";

if($this->uri->segment(4)=="ASC")
$sort="<a href='".site_url("vacancies").'/'.$this->uri->segment(2).'/'.$page."/DESC' ><img src='".ROOT_DIR."images/icons/desc.png'/> </a>";
else
$sort="<a href='".site_url("vacancies").'/'.$this->uri->segment(2).'/'.$page."/ASC' ><img src='".ROOT_DIR."images/icons/asc.png'/> </a>";
?>


<!-- begin header row -->
<h1> <?php echo lang('vacancies');?></h1>

<div id="view_pages" >
<?php echo lang('view_page');?> <b class="orange_num"><?php echo $page ; ?> </b>- <?php echo lang('of');?> <b class="orange_num"> <?php echo $tot ; ?> </b><?php echo lang('pages');?>.
</div>

<div id="sort">
<?php echo $sort;?>
</div>

<div class="clearfix"></div>
<!-- end header row -->



<!-- begin Items -->
<?php foreach ($content as $row):?>

<div id="ltoright">
<Table width="100%"  class="table table-condensed">
<tr class="title"><td colspan="2"><?php echo $row['title']; ?></td></tr>
<tr><td width="100"><?php echo lang('description');?></td><td><?php echo $row['description']; ?>.&nbsp; &nbsp;<a href="<?php echo site_url("vacancies")?>"> <b id="italic"><?php echo lang("more");?></b></a><br /></td></tr>
<tr><td colspan="2"><br />
<a href="<?php echo site_url("vacancies/apply")."/".$row['vacancy_id']?>"><img  style="float:right;"  src="<?php echo ROOT ;?>/images/icons/<?php echo lang("applyimg");?>" alt="Apply Now" /></a></td></tr>
</table>
</div>

<?php endforeach;?>
<!-- End Items -->


<div class="pagination">

<ul>
<li <?php echo $prv ; ?>><a href="<?php echo site_url("vacancies").'/'.$this->uri->segment(2, 1).'/'.$page_pre.'/'.$this->uri->segment(4,"ASC") ; ?>"><?php echo lang('prev') ;?></a></li>
<li class="active"><a href="<?php echo site_url("vacancies").'/'.$this->uri->segment(2, 1).'/'.$page.'/'.$this->uri->segment(4,"ASC") ; ?>"><?php echo $page ; ?></a></li>
<?php 

for ($i = 1; $i <= 9; $i++) {
	$li="";
    if (++$page<=$tot) {
       $li='<li><a href="'.site_url("vacancies").'/'.$this->uri->segment(2, 1).'/'.$page.'/'.$this->uri->segment(4,"ASC").'">'.$page.'</a></li>';
    }
    echo $li;
}
?>
<li <?php echo $nxt ; ?>><a href="<?php echo site_url("vacancies").'/'.$this->uri->segment(2, 1).'/'.$page_nxt.'/'.$this->uri->segment(4,"ASC") ; ?>"><?php echo lang('next') ;?></a></li>
</ul>
</div>	