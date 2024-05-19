    <?php $row=$course[0];?>
	<h2 class="title"><?php echo $row['course_name'] ; ?></h2>
		<?php  if($row['logo']==NULL) echo ""; else {echo '<img src="'.ROOT_DIR.'images/'.$row['logo'].'" alt="logo" />';}?>
	<Table width="100%" id='tblarabicdetails' class="table table-condensed">
			
			<tr class="title"><td colspan="2">Course Details</td></tr>
			<tr ><td width="200"><?php echo lang('details');?></td><td><?php echo $row['details'];?></td></tr>
			<tr><td><?php echo lang('date');?></td><td><?php  echo date('Y-m-d', strtotime($row['course_date'])); ?></td></tr>
			<tr><td><?php echo lang('duration');?></td><td><?php echo $row['duration'];?></td></tr>
			<tr><td><?php echo lang('city');?></td><td><?php if($row['city_name']==NULL) echo ""; else{ echo $row['city_name'];}?></td></tr>
			<?php if (strlen( $row['outlines_file'])>0){ ?>
				<tr><td><?php echo lang('outlines_files');?></td><td><a href= "<?php echo ROOT_DIR; ?>files/courses_outlines/<?php  echo $row['outlines_file'];?>" target="_blank">Download Outline files</a> </td></tr>
			<?php } else { ?>
				<tr><td><?php echo lang('outlines_files');?></td><td>None</td>
			<?php } ?>
			<tr><td><?php echo lang('description');?></td><td><?php if($row['description']==NULL) echo ""; else{ echo $row['description'];}?></td></tr>
	</table>
	<div id="course_link">
	<a href="<?php echo site_url("courses/apply").'/'.$row['course_id']?>">Apply To Course</a>
	</div>