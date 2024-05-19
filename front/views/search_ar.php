<script type="text/javascript">
		Ext.onReady(function(){ 

		Ext.get('lstsrch').on('click', search, this, {
				//preventDefault: true
			});

			function search(e){
				var city=Ext.get('citycmb').dom["value"];
				var cat=Ext.get('catcmb').dom["value"];
				var m=Ext.get('month').dom["value"];
				window.location.href="<?php echo site_url("courses/list_courses");?>/"+city+'/'+cat+'/'+m+'/1/ASC';
				
			}
		});

	</script>

<h1>بحث متقدم</h1>
<div id="advanced_srch"  >
		<h1>استعرض بالمجال </h1>
		<?php echo header_model::get_fields_combo("AR"); ?>
		<h1>استعرض بالمدينة </h1>
		<?php echo header_model::get_city_combo("AR"); ?>
		<h1>استعرض بالشهر </h1>
		<select name="month" id="month">
		    <option value="">اختر الشهر</option>
			<option value="January">يناير</option>
			<option value="February">فبراير</option>
			<option value="March">مارس</option>
			<option value="April">أبريل</option>
			<option value="May">مايو</option>
			<option value="June">يونيو</option>
			<option value="July">يوليو</option>
			<option value="August">أغسطس</option>
			<option value="September">سبتمبر</option>
			<option value="October">أكتوبر</option>
			<option value="November">نوفمبر</option>
			<option value="December">ديسمبر</option>
		</select>
		<img id="lstsrch" src="<?php echo ROOT_DIR ;?>images/submit_srch.png" />

</div>

