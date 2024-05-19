<h1><?php echo $title ; ?></h1>
<script>
Ext.onReady(function(){  
Ext.tip.QuickTipManager.init();  // enable tooltips
//vars

var page_id=new Ext.form.TextField({
	name: 'id',
	width: 50,
	value:'<?php echo $pages_id;?>',
	hideLabel: true,
	hidden:true
	});
var wdth=Ext.getDom('form_details').clientWidth-20;


// combo boxes stores
var topicStore = new Ext.data.JsonStore({
		storeId: 'topicStore',
		autoLoad:true,
		proxy: {
			type: 'ajax',
			url: 'articles',
			extraParams: {
			action: 'get_topics'
		},
		actionMethods: 'POST',
			reader: {
				type: 'json',
				root: 'results',
				idProperty: 'topic_id'
			}
		},
		fields: ['topic_id','topic_name']
	});
		
//Edit Page Form
var topicCombo =Ext.create('Ext.form.ComboBox', {
		fieldLabel: 'Topic Name',
		name  : 'topic_id',
		width    : 125,
		store: topicStore,
		queryMode: 'remote',
		displayField: 'topic_name',
		valueField: 'topic_id',
		triggerAction: 'all',
		allowBlank:false,
		listeners: {
			'select': function(cmb, rec, idx) {
			  var x =this.getValue();
			   topic_form.getForm().findField('topic_id').setValue(x);
							   
			}
			}
	});
var topic_form = new Ext.FormPanel({
		url: '<?php echo site_url("articles");?>',
		baseParams: {
			action: 'update'
		},
		title:'Edit <?php echo ucfirst($page_name) ; ?> Page ',
		layout: 'form',
		frame: true,
		bodyStyle: '',
		width: wdth,
		
		renderTo:'form_details',
		method: 'POST',
	    items: [
			
			topicCombo,
			{
				xtype: 'textfield',
				fieldLabel: 'English Title',
				allowBlank:false,
				width:'190',
				name: 'title_en'
				
			},
			{
				xtype: 'textfield',
				fieldLabel: 'Arabic Title',
				allowBlank:false,
				width:'190',
				name: 'title_ar'
				
			}
			
			,
			{
			xtype: 'htmleditor',
			enableColors: true,
			enableAlignments: true,
            name: 'content_en',
            fieldLabel: 'English Content',
			allowBlank:false,
			height:250,
			labelStyle:'margin-bottom:230px;',
            minLength: 6,
			allowBlankText: 'required'
			},
			{
			xtype: 'htmleditor',
			enableColors: true,
			enableAlignments: true,
            name: 'content_ar',
            fieldLabel: 'Arabic Content',
			allowBlank:false,
			height:250,
			labelStyle:'margin-bottom:230px;',
            minLength: 6,
			allowBlankText: 'required'
			},
			page_id,
			,
			{
                xtype: 'checkboxfield',
				fieldLabel: 'Published',
				name: 'published'
           }
			
		],
		  buttons:
        [{
            text:'Save Changes',
            handler: function()
            {
         if (topic_form.getForm().isValid())                
                topic_form.getForm().submit
                ({
                    success: function(form, action) {
					Ext.Msg.alert('Saved', action.result.msg);
					
					
                    }, 

                    failure: function(form, action) {
                       Ext.Msg.alert('Failure', action.result.error);
                    }
                });
            }
        },{
            text: 'Reset',
            handler: function(){topic_form.getForm().reset()}
        }]
		  
	});

//to load the data in the form 	
topic_form.getForm().load({
    url: 'articles',
    params: {
	 action: 'load_form',
     page_id: '<?php echo $pages_id;?>' 
    },
	success: function(form, action) {
		topicCombo.setValue(action.result.data.topic_id);
    },
    failure: function(form, action) {
        Ext.Msg.alert("Load failed", action.result.errorMessage);
    }
});	
			

	
});
	

</script>
<div id="form_details">

</div>