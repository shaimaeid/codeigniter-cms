<h1><?php echo lang('courses_in') ;?> 
<?php 
if($this->uri->segment(3)!="all"){
echo str_replace ("%20"," ",$this->uri->segment(3)) ;
}else{
echo "All cities";
}
?></h1>
<?php 
//$tot=10;
$page= $this->uri->segment(6, 1);
$page_pre= $this->uri->segment(6, 1)-1;
$page_nxt= $this->uri->segment(6, 1)+1;
if($page==1)
$prv='class="disabled"';
else
$prv="";
if($this->uri->segment(7)=="ASC")
$sort="<a href='".site_url("courses/list_courses").'/'.$this->uri->segment(3, 1).'/'.$this->uri->segment(4, 1).'/'.$this->uri->segment(5, 1).'/'.$page."/DESC' ><i class='icon-chevron-up'></i> &nbsp;".lang('sort_desc') ."</a>";
else
$sort="<a href='".site_url("courses/list_courses").'/'.$this->uri->segment(3, 1).'/'.$this->uri->segment(4, 1).'/'.$this->uri->segment(5, 1).'/'.$page."/ASC' ><i class='icon-chevron-down'></i> &nbsp;".lang('sort_asc') ."</a>";
?>
<div id="view_pages" >
<?php echo lang('view_page') ;?> <b class="orange_num"><?php echo $page ; ?> </b>- <?php echo lang('of') ;?> <b class="orange_num"> <?php echo $tot ; ?> </b><?php echo lang('pages') ;?>.</div>
<div id="sort">
<?php echo $sort;?>
</div>
<Table width="100%">
<tr><td>
<?php foreach ($content as $row):?>
<div id="ltoright"> 
<Table width="100%"  class="table table-condensed" >
<tr class="title"><td colspan="2"><?php echo $row['course_id']."-".$row['course_name']; ?></td></tr>

<tr><td  width="100"><?php echo lang('category') ;?></td><td><?php echo $row['course_category']; ?></td></tr>
<tr><td><?php echo lang('date') ;?></td><td><?php echo date('d-m-Y', strtotime($row['course_date'])); ?></td></tr>
<tr><td width="100"><?php echo lang('city') ;?></td><td><?php echo $row['city']; ?></td></tr>
<tr><td><?php echo lang('duration') ;?></td><td><?php echo $row['duration']; ?></td></tr>
<tr><td colspan="2"><a href="<?php echo site_url('courses/details/'.$row['course_id']); ?>"><img  style="float:right;margin-bottom:10px;"  src="<?php echo ROOT ;?>/images/<?php echo lang('learn_img') ;?>" alt="learn more" /></a></td></tr>
</table>
</div>
<?php endforeach;?>
</td></tr>
</table>

<div class="pagination">

<ul>
<li <?php echo $prv ; ?>><a href="<?php echo site_url("courses/list_courses").'/'.$this->uri->segment(3, 1).'/'.$this->uri->segment(4, 1).'/'.$this->uri->segment(5, 1).'/'.$page_pre.'/'.$this->uri->segment(7,"ASC") ; ?>">Prev</a></li>
<li class="active"><a href="<?php echo site_url("courses/list_courses").'/'.$this->uri->segment(3, 1).'/'.$this->uri->segment(4, 1).'/'.$this->uri->segment(5, 1).'/'.$page.'/'.$this->uri->segment(7,"ASC") ; ?>"><?php echo $page ; ?></a></li>
<?php 

for ($i = 1; $i <= 9; $i++) {
	$li="";
    if (++$page<=$tot) {
       $li='<li><a href="'.site_url("courses/list_courses").'/'.$this->uri->segment(3, 1).'/'.$this->uri->segment(4, 1).'/'.$this->uri->segment(5, 1).'/'.$page.'/'.$this->uri->segment(7,"ASC").'">'.$page.'</a></li>';
    }
    echo $li;
}
?>
<li><a href="<?php echo site_url("courses/list_courses").'/'.$this->uri->segment(3, 1).'/'.$this->uri->segment(4, 1).'/'.$this->uri->segment(5, 1).'/'.$page_nxt.'/'.$this->uri->segment(7,"ASC") ; ?>">Next</a></li>
</ul>
</div>