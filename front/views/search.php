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

<h1>Advanced Search</h1>
<div id="advanced_srch"  >
		<h1>Browse By Fields </h1>
		<?php echo header_model::get_fields_combo("EN"); ?>
		<h1>Browse By City </h1>
		<?php echo header_model::get_city_combo("EN"); ?>
		<h1>Browse By Month </h1>
		<select name="month" id="month">
		    <option value="all">Select Month</option>
			<option value="January">January</option>
			<option value="February">February</option>
			<option value="March">March</option>
			<option value="April">April</option>
			<option value="May">May</option>
			<option value="June">June</option>
			<option value="July">July</option>
			<option value="August">August</option>
			<option value="September">September</option>
			<option value="October">October</option>
			<option value="November">November</option>
			<option value="December">December</option>
		</select>
		<img id="lstsrch" src="<?php echo ROOT_DIR ;?>images/submit_srch.png" />

</div>

