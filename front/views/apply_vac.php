<script>
Ext.require([
'Ext.form.*',
'Ext.tip.QuickTipManager'
]);

Ext.onReady(function(){
	// The data store containing the list of states
	
	var gender = Ext.create('Ext.data.Store', {
		fields: ['value', 'name'],
		data : [
			{"value":"0", "name":"Male"},
			{"value":"1", "name":"Female"}
		]
	});

	// Create the combo box, attached to the states data store

	var gender_combo =Ext.create('Ext.form.ComboBox', {
		fieldLabel: 'Gender',
		store: gender,
		queryMode: 'local',
		displayField: 'name',
		valueField: 'value',
		name  : 'value'
	});
	
	var required = '<span style="color:red;font-weight:bold;" data-qtip="Required">*</span>';
	Ext.tip.QuickTipManager.init();
	  var join_form = new Ext.FormPanel({ 
        url: 'vacancies',
		baseParams: {
			action: 'apply_vac',
			vac_id : '<?php echo $vac_id; ?>'
		},
		 layout:'form',
		 bodyStyle: 'padding:20px; background:transparent;',
         renderTo: 'apply_form',
		 border:false,
		 width:600,
		 height:500,
		 fieldDefaults: {
            labelWidth: 125,
            msgTarget: 'under',
            autoFitErrors: true
        },
         items: [
			{
				xtype: 'textfield',
				name: 'name',
				fieldLabel: '<?php echo lang('name');?>',
				allowBlankText: '<span style="color:red;font-weight:bold;" data-qtip="Required">*</span>'
			}, 
			gender_combo,
			{
				xtype: 'numberfield',
				name: 'age',
				fieldLabel: '<?php echo lang('age');?>'
			},
			{
				xtype: 'textfield',
				vtype:'email',
				name: 'email',
				fieldLabel: '<?php echo lang('email');?>'
			},
			{
				xtype: 'textfield',
				name: 'phone_number',
				fieldLabel: '<?php echo lang('mobile');?>'
			},
			{
				xtype: 'numberfield',
				name: 'experince',
				fieldLabel: '<?php echo lang('experience_years');?>'
			},
			{
				xtype: 'filefield',
				name: 'cv',
				fieldLabel: '<?php echo lang('cv_url');?>'
			}
		],
		  buttons:
        [{
            text: 'Join',
            handler: function()
            {
				if (join_form.getForm().isValid()) {               
						join_form.getForm().submit
					({
						success: function(form, action) {
						   Ext.Msg.alert('Success','Done');
						}, 

						failure: function(form, action) {
						   Ext.Msg.alert('Failure','Sorry an error happened, try again later!');
						}
					});
				}
            }
        },
		{
            text: 'Cancel',
            handler: function(){join_form.getForm().reset()}
        }]
		  
      });
});
</script>
<div id="apply_form">
</div>