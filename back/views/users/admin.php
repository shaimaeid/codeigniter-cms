<h1><?php echo $title ; ?></h1>
<script>
Ext.onReady(function(){  

//vars
Ext.QuickTips.init(); 
var itemsPerPage = 20;
// Action toolbar
var tbar1=new Ext.Toolbar({ items: [
         { text: 'Add record',
            iconCls:'icon-add',
			tooltip:'Add new record',
            handler: function() {
             showform();      
            }
         },
		 { text: 'Delete',
            iconCls:'icon-delete',
			tooltip:'Delete selected recoreds',
            handler: function() {
				var keys = grid.getSelectionModel().getSelection( ) ;
				if (keys.length > 0)
				{ 
					id='';
					Ext.each(grid.getSelectionModel().getSelection(), function(record){
						id+=','+record.get('user_id');
					});
					Ext.MessageBox.confirm('Confirm','Are you sure you wanna detele this record!',function (btn){
							if(btn=='yes'){ 
								del_record(id.substring(1));
							}
						},
						this);
				}
            }
         },
		 {
			text: 'Upgrade',
			iconCls: 'icon-filter',
			tooltip:'Upgrade to admin',
			handler: function(){
				var keys = grid.getSelectionModel().getSelection( ) ;
				if (keys.length == 1) { 
					id='';
					Ext.each(grid.getSelectionModel().getSelection(), function(record){
						id+=','+record.get('user_id');
					});
					downgrade_user(id.substring(1));
				}
				else{
					Ext.MessageBox.alert('Info', 'You Must Select One Record!!');
				} 
			}
		},
		{ text: 'Print',
            iconCls:'icon-print',
			tooltip:'Print users',
            handler: function() {
            	Ext.ux.grid.Printer.sitepath = '<?php echo ROOT_DIR ; ?>';
				Ext.ux.grid.Printer.mainTitle='Tarbeet Web Site: <?php echo $title; ?>';
			    Ext.ux.grid.Printer.title = 'Tarbeet Web Site: <?php echo $title; ?>';
				Ext.ux.grid.Printer.stylesheetPath = '<?php echo ROOT_DIR;?>css/Print.css';
              	Ext.ux.grid.Printer.printAutomatically = false;
				Ext.ux.grid.Printer.print(grid);       
            }
		}
      ]});
	

	// ---- main store for the grid ---- //
	var store = new Ext.data.JsonStore({
		// store configs
		storeId: 'myStore',
		autoLoad: false,
		usersize: itemsPerPage,
		proxy: {
			type: 'ajax',
			url: 'users',
			extraParams: {
			action: 'get_admin'
		},
		actionMethods: 'POST',
			reader: {
				type: 'json',
				root: 'results',
				idProperty: 'user_id',
				totalProperty: 'total'
			}
		},
				
		fields: ['user_id', 'username'  , 'email','contact_person','phone_number','address' , 'role','block','active' ]
	});

	// grid
	var wdth=Ext.getDom('grid_details').clientWidth-20;
    var grid = new Ext.grid.Panel({
        height: 580,
		width:wdth,
        renderTo: 'grid_details',
        store: store,
        id: 'grid',
		selType: 'checkboxmodel',
		selModel: {
			mode: 'MULTI',   // or SINGLE, SIMPLE ... review API for Ext.selection.CheckboxModel
			checkOnly: true    // or false to allow checkbox selection on click anywhere in row
		},
		plugins: [
				Ext.create('Ext.grid.plugin.RowEditing', {
					clicksToEdit: 2
				})
			],
			features: [],
		anchor: '90%',
		
			columns: [
			{ 
				text : 'User ID',
				width : 50,
				sortable : true,
				dataIndex: 'user_id'
			},
			{ 
				text : 'User Name',
				width : 150,
				sortable : true,
				dataIndex: 'username',
				editor: {
						xtype: 'textfield'
						
					}
			},
			
			{ 
				text : 'Email',
				width : 200,
				sortable : true,
				dataIndex: 'email',
				editor: {
						xtype: 'textfield'
						
					}
			},
			{ 
				text : 'Contact Person',
				width : 150,
				sortable : true,
				dataIndex: 'contact_person',
				editor: {
						xtype: 'textfield'
						
					}
			},
			{ 
				text : 'Phone Number',
				flex:1,
				sortable : true,
				dataIndex: 'phone_number',
				editor: {
						xtype: 'textfield',
						
					}
			},
			{ 
				text : 'Address',
				width : 150,
				sortable : true,
				dataIndex: 'address',
				editor: {
						xtype: 'textfield'
						
					}
			},
			{ 
				text : 'Role',
				width : 80,
				sortable : true,
				dataIndex: 'role'
			},
			{ 
				text : 'Block',
				width : 80,
				sortable : true,
				dataIndex: 'block'
			},
			{ 
				text : 'Verified',
				width : 80,
				sortable : true,
				dataIndex: 'active',
				editor: {	  
							xtype: 'combo',
							name: 'active',
							autoSelect: false,
							allowBlank: false,
							editable: false,
							triggerAction: 'all',
							typeAhead: true,
							width:120,
							listWidth: 120,
							enableKeyEvents: true,
							mode: 'local',
							store: [
								['1', 'Yes'],
								['0', 'No'],
								
							]	
					}
			}
			]
,
        viewConfig: {
            forceFit: true
        }
	});
	store.load({
		params:{
			start:0,
			limit: itemsPerPage
		}
	});
	// --------------------- Functions 
	//add new record window code
	function showform(){
	
	var myForm = new Ext.FormPanel({
		url: 'users',
		baseParams: {
			action: 'insert'
		},
		frame: true,
		bodyStyle: '',
		width: 320,
		layout: 'form',
		method: 'POST',
	    items: [
			{
				xtype: 'textfield',
				fieldLabel: 'User Name *',
				width:'190',
				name: 'username',
				allowBlank: false
			},
			
			{
				xtype: 'textfield',
				fieldLabel: 'Email *',
				width:'190',
				name: 'email',
				 vtype: 'email', // applies email validation rules to this field
				allowBlank: false
			},
			{
				xtype: 'textfield',
				fieldLabel: 'Role ',
				width:'190',
				name: 'role',
				allowBlank: false
			},
			{
				xtype: 'textfield',
				fieldLabel: 'Block ',
				width:'190',
				name: 'block',
				allowBlank: false
			}
			,
			{
				xtype: 'textfield',
				fieldLabel: 'Active ',
				width:'190',
				name: 'active',
				allowBlank: false
			},
			{
				xtype: 'textfield',
				fieldLabel: 'Address ',
				width:'190',
				name: 'address',
				allowBlank: false
			},
			{
				xtype: 'textfield',
				fieldLabel: 'Contact Person ',
				width:'190',
				name: 'contact_person',
				allowBlank: false
			}
		]
	});
	var win = new Ext.Window({
		title: 'Add new record',
		id: 'formanchor-win', 
		width: 400, 
		plain: true, 
		layout: 'fit', 
		border: false, 
		closable: false, 
		items:myForm,
		buttons: [{
					text: 'Add record',
					handler: function(){
						if(myForm.getForm().isValid()){
							myForm.getForm().submit
							({
								success: function(form, action) {
									var text =  action.result.msg;
									Ext.Msg.alert('Done',text);
									store.reload();
								}, 
								failure: function(form, action) {
                                 var text =  action.result.err
								 Ext.Msg.alert('Error',text);
                    
								}
							});
						}
						else {
							Ext.Msg.alert('Error','Please, Insert all the obligatory fields.');
							myForm.getForm().show();
						}
						win.close();
					}
				},
				{
					text: 'Reset',
					handler: function(){
						myForm.getForm().reset();
					}
				},
				{
					text: 'Close',
					handler: function(){
						win.close();
					}
				}
			]
	});
	win.show();
	};

	// Edit selected record
	grid.on('beforeedit', function(editor, e) {	});
	grid.on('edit', function(editor, e) {
		Ext.Ajax.request({
			url: 'users',
			params: {
				action: 'update',
				id:e.record.get("user_id"),
				username:e.record.get("username"),
				email:e.record.get("email"),
				role:e.record.get("role"),
				block:e.record.get("block"),
				active:e.record.get("active"),
				contact_person:e.record.get("contact_person"),
				phone_number:e.record.get("phone_number"),
				address:e.record.get("address")
			},
			success: function(response){
				var text = Ext.decode(response.responseText).msg;
				Ext.Msg.alert('Update',text);
				store.reload();
				}
		});
	});

	// delete selected record
	function del_record(id){
		Ext.Ajax.request({
			url: 'users',
			params: {
				action: 'delete',
				id:id
			},
			success: function(response){
				var text = Ext.decode(response.responseText).msg;
				Ext.Msg.alert('Delete',text);
				store.reload();
			}
		});
	}
	
	// delete selected record
	function downgrade_user(id){
		Ext.Ajax.request({
			url: 'users',
			params: {
				action: 'downgrade',
				id:id
			},
			success: function(response){
				var text = Ext.decode(response.responseText).msg;
				Ext.Msg.alert('dDowngrade',text);
				store.reload();
			}
		});
	}
});
</script>
<div id="grid_details">

</div>