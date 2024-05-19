<script>
Ext.require([
'Ext.form.*',
'Ext.tip.QuickTipManager'
]);

Ext.onReady(function(){
	var required = '<span style="color:red;font-weight:bold;" data-qtip="Required">*</span>';
	Ext.tip.QuickTipManager.init();
	  var apply_form = new Ext.FormPanel({ 
        url: 'courses',
		baseParams: {
			action: 'apply',
			course_id: <?php echo $course_id;?>
		},
		 layout:'form',
		 bodyStyle: 'padding:20px; background:transparent;',
         renderTo: 'apply_form',
		 border:false,
		 width:550,
		 height:400,
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
			{
				xtype: 'textfield',
				name: 'company',
				fieldLabel: '<?php echo lang('company');?>'
			},
			{
				xtype: 'textfield',
				name: 'job',
				fieldLabel: '<?php echo lang('job');?>'
			},
			{
				xtype: 'textfield',
				name: 'mobile',
				fieldLabel: '<?php echo lang('mobile');?>'
			},
			{
				xtype: 'textfield',
				name: 'phone',
				fieldLabel: '<?php echo lang('phone');?>'
			},
			{
				xtype: 'textfield',
				vtype:'email',
				name: 'email',
				fieldLabel: '<?php echo lang('email');?>'
			},
			{
				xtype: 'textarea',
				name: 'special_requirments',
				fieldLabel: '<?php echo lang('special_reauirments');?>'
			}
		],
		  buttons:
        [{
            text: '<?php echo lang('submit');?>',
            handler: function()
            {
				if (apply_form.getForm().isValid())                
					apply_form.getForm().submit
                ({
                    success: function(form, action) {
                       Ext.Msg.alert('Success', action.result.msg);
                    }, 

                    failure: function(form, action) {
                       Ext.Msg.alert('Failure', action.result.error);
                    }
                });
            }
        },
		{
            text: '<?php echo lang('reset');?>',
            handler: function(){apply_form.getForm().reset()}
        }]
		  
      });
});

</script>
<div id="apply_form">
</div>