
<div id="innerdiv">

</div> 

<script>
Ext.onReady(function(){
  var required = '<span style="color:red;font-weight:bold;" data-qtip="Required">*</span>';
  Ext.tip.QuickTipManager.init();
  var login_form = new Ext.FormPanel({ 
        url: 'signin',
		baseParams: {
			action: 'authenticate'
		},
		//title:"User login",
		frame: true,
		bodyStyle: 'padding:10px;',
         renderTo: 'innerdiv',
		 border:false,
		 layout:'form',
		 fieldDefaults: {
            labelWidth: 125,
            msgTarget: 'under',
            autoFitErrors: true
        },
		 width:400,
		 height:200,
         items: [{
            xtype: 'textfield',
            name: 'username',
            fieldLabel: 'Username',
			labelStyle:'margin-bottom:30px;',
			afterLabelTextTpl: required,
            allowBlank: false,
            minLength: 6,
			minLengthText: 'at least 6 characters',
			allowBlankText: 'Required'
        }, {
		    
            xtype: 'textfield',
            name: 'password',
            fieldLabel: 'Password',
			labelStyle:'margin-bottom:30px;',
			afterLabelTextTpl: required,
            inputType: 'password',
            allowBlank: false,
            minLength: 8,
			minLengthText: 'not lesser than 8 characters',
			allowBlankText: 'Required'
        }
		  ],
		  buttons:
        [{
            text:'Sign in',
            handler: function()
            {
         if (login_form.getForm().isValid())                
                login_form.getForm().submit
                ({
                    success: function(form, action) {
					var text="<?php  if(isset($_SESSION['username'])){echo "".$_SESSION['username'];} ?>";
					   window.location = "<?php echo ROOT_DIR ;?>home/";
                    }, 

                    failure: function(form, action) {
                       Ext.Msg.alert('Failure', action.result.error);
                    }
                });
            }
        },{
            text: 'Reset',
            handler: function(){login_form.getForm().reset()}
        }]
		  
      });
});
	</script>
