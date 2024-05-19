<h1><?php echo $title; ?></h1>
<script>
Ext.require([
'Ext.form.*',
'Ext.tip.QuickTipManager'
]);
Ext.apply(Ext.form.VTypes, {
    password : function(val, field) {
        if (field.initialPassField) {
            var pwd = Ext.getCmp(field.initialPassField);
            return (val == pwd.getValue());
        }
        return true;
    },
    passwordText : 'Passwords do not match'
});
Ext.onReady(function(){
	var valid_password =null;
	var required = '<span style="color:red;font-weight:bold;" data-qtip="Required">*</span>';
	Ext.tip.QuickTipManager.init();
	  var Profile_form = new Ext.FormPanel({ 
        url: 'users',
		baseParams: {
			action: 'edit_profile'
		},
		 layout:'form',
		 bodyStyle: 'padding:20px;',
         renderTo: 'inner-data',
		 frame: true,
		 border:false,
		 width:600,
		 height:500,
		 fieldDefaults: {
            labelWidth: 125,
            msgTarget: 'under',
            autoFitErrors: true
        },
         items: [{
            xtype: 'textfield',
            name: 'username',
            fieldLabel: 'User Name',
			labelStyle:'margin-bottom:30px;',
            emptyText : 'Enter a value'
        }, 
		{
            xtype: 'textfield',
            name: 'email',
            fieldLabel: 'Email',
			vtype:'email',
			vtypeText: 'Invalid email format.  Email must be of the form user@domain.com',
        },
		{
			xtype: 'textfield',
			name: 'old_password',
			fieldLabel: 'Old Password',
			inputType: 'password',
			minLength: 8,
			minLengthText: 'not lesser than 8 characters',
			allowBlankText: 'Required',
            listeners: {  
				change: function(field) {  
					var confirmField = field.up('form').down('[name=password2]');  
					confirmField.allowBlank = (field.value == '');  // <- the change is here
					confirmField.validate();  
				}  
			}
		},
		{
			xtype: 'textfield',
			name: 'new_password',
			fieldLabel: 'New Password',
			inputType: 'password',
			id: 'new_password',
			labelStyle:'margin-bottom:30px;',
            minLength: 8,
			minLengthText: 'not lesser than 8 characters',
			allowBlankText: 'Required',
            listeners: {  
				change: function(field) {  
					var confirmField = field.up('form').down('[name=re_new_password]');  
					confirmField.allowBlank = (field.value == '');  // <- the change is here
					confirmField.validate();  
				}  
			}
		},
		{
			xtype: 'textfield',
			name: 're_new_password',
			fieldLabel: 'Rewrite New Password',
			inputType: 'password',
			minLength: 8,
			minLengthText: 'at least 8 characters',
			allowBlankText: 'Required',
			vtype: 'password',
			vtypeText:'password dont match',
            initialPassField: 'new_password' // id of the initial password field
		},
		{
			xtype: 'textfield',
			name: 'contact_person',
			fieldLabel: 'Contact Person (optional)'
        },
		{
            xtype: 'textfield',
            name: 'address',
            fieldLabel: 'Address (optional)'
        },
		{
            xtype: 'textfield',
            name: 'phone_number',
            fieldLabel: 'Phone Number (optional)'
        },
		{
		xtype: 'label',
		html:'<b><h5><center>Verify your current password to save changes</center></h5></b>'
		},
		{
			xtype: 'textfield',
			name: 'verify_password',
			inputType: 'password',
			allowBlankText: 'Required',
			vtype: 'password',
			minLength: 8,
			minLengthText: 'not lesser than 8 characters',
			allowBlankText: 'Required'
		}
		],
		  buttons:
        [{
            text: 'Save changes',
            handler: function()
            {
         if (Profile_form.getForm().isValid())                
                Profile_form.getForm().submit
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
            text: 'Cancel',
            handler: function(){Profile_form.getForm().reset()}
        }]
		  
      });
	  
	Profile_form.getForm().load({
		url: 'users',
		params: {
			action: 'load_form'
		},
		success: function(form, action) {},
		failure: function(form, action) {
			Ext.Msg.alert("Load failed", action.result.errorMessage);
		}
	});
	function validate_password(verify_password){
		Ext.Ajax.request({
			url: 'users',
			params: {
				action: 'validate_password',
				password:verify_password
			},
			success: function(response){
				var success = Ext.decode(response.responseText).success;
				valid_password=success;
			}
		});
	}
	  });
	</script>
	<div id='inner-data'>
	
	</div>
