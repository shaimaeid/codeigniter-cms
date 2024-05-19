<h1>قائمة الدورات التدريبية ل<?php echo $title ;?></h1>
<Table width="100%" dir="rtl">
<tr><td>
<?php foreach ($content as $row):?>
<Table width="100%"  dir="rtl" class="table table-condensed">
<tr class="title"><td colspan="2"><?php echo $row['course_name']; ?></td></tr>

<tr><td width="100">المدينة</td><td><?php echo $row['city']; ?></td></tr>
<tr><td>التاريخ</td><td><?php echo date('Y-m-d', strtotime($row['course_date'])); ?></td></tr>
<tr><td>المدة</td><td><?php echo $row['duration']; ?></td></tr>
<tr><td colspan="2"><a href="<?php echo site_url('courses/details/'.$row['course_id']); ?>"><img  style="float:left;margin-bottom:10px;"  src="<?php echo ROOT ;?>/images/learn.png" alt="learn more" /></a></td></tr>
</table>
<?php endforeach;?>
</td></tr>
</table>