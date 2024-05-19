<h1><?php echo $title ; ?></h1>
<script>
Ext.require([
'Ext.form.*',
'Ext.tip.QuickTipManager'
]);
Ext.onReady(function(){  

//vars
var required = '<span style="color:red;font-weight:bold;" data-qtip="Required">*</span>';
var valid_user=null;
var valid_email=null;
  
Ext.QuickTips.init(); 
var itemsPerPage = 20;
// Action toolbar
// ---- actions tool bar definition ---- //
 var tbar1=new Ext.Toolbar({ height:30 , items: [
         { text: 'Add record',
            iconCls:'icos-add',
			tooltip:'Add new record',
            handler: function() {
             showform();      
            }
         },
		 { text: 'Delete',
            iconCls:'icos-cross',
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
				else{
					Ext.MessageBox.alert('Info', 'You Must Select One Record!!');
				} 
            }
        },
		{
			text: 'Change role',
			iconCls: 'icos-link',
			tooltip:'Change role',
			handler: function(){
				var keys = grid.getSelectionModel().getSelection( ) ;
				if (keys.length == 1) { 
					id='';
					Ext.each(grid.getSelectionModel().getSelection(), function(record){
						id+=','+record.get('user_id');
					});
					change_role(id.substring(1));
				}
				else{
					Ext.MessageBox.alert('Info', 'You Must Select One Record!!');
				} 
			}
		},
		{
			text: 'Change status',
			iconCls: 'icos-block',
			tooltip:'Change selected user',
			handler: function(){
				var keys = grid.getSelectionModel().getSelection( ) ;
				if (keys.length == 1) { 
					id='';
					block = '';
					Ext.each(grid.getSelectionModel().getSelection(), function(record){
						id+=','+record.get('user_id');
						block+=','+record.get('block');
					});
					block_user(id.substring(1),block.substring(1));
				}
				else{
					Ext.MessageBox.alert('Info', 'You Must Select One Record!!');
				} 
			}
		},
		{
			text: 'Change verification',
			iconCls: 'icos-link',
			tooltip:'Change selected user',
			handler: function(){
				var keys = grid.getSelectionModel().getSelection( ) ;
				if (keys.length == 1) { 
					id='';
					active = '';
					Ext.each(grid.getSelectionModel().getSelection(), function(record){
						id+=','+record.get('user_id');
						active+=','+record.get('active');
					});
					active_user(id.substring(1),active.substring(1));
				}
				else{
					Ext.MessageBox.alert('Info', 'You Must Select One Record!!');
				} 
			}
		},
		{
			text: 'Reset password',
			iconCls:'icos-refresh',
			tooltip:'Reset password for selected record',
			handler: function(){
				var keys = grid.getSelectionModel().getSelection( ) ;
				if (keys.length == 1) { 
					id='';
					Ext.each(grid.getSelectionModel().getSelection(), function(record){
						id+=','+record.get('user_id');
					});
					reset_password(id.substring(1));
				}
				else{
					Ext.MessageBox.alert('Info', 'You Must Select One Record!!');
				}
			}
		},
		{ text: 'Print',
            iconCls:'icos-printer',
			tooltip:'Print users',
            handler: function() {
            	Ext.ux.grid.Printer.sitepath = '<?php echo ROOT_DIR ; ?>';
				Ext.ux.grid.Printer.mainTitle='Tarbeet Web Site: <?php echo $title; ?>';
			    Ext.ux.grid.Printer.title = 'Tarbeet Web Site: <?php echo $title; ?>';
				Ext.ux.grid.Printer.stylesheetPath = '<?php echo ROOT_DIR;?>css/Print.css';
              	Ext.ux.grid.Printer.printAutomatically = false;
				Ext.ux.grid.Printer.print(grid);       
            }
		},
		{
			text: 'Send mail',
            iconCls:'icos-email',
			tooltip:'Send mail to selected record',
            handler: function() {}
		}
      ]});
	 
// Search Items 
	var id_srch=new Ext.form.TextField({
	name: 'user_id',
	width: 50,
	emptyText:'ID',
	hideLabel: true
	});
	var username_srch=new Ext.form.TextField({
	name: 'username',
	width: 100,
	emptyText:'User Name',
	hideLabel: true
	});	
	var email_srch=new Ext.form.TextField({
	name: 'email',
	width: 100,
	emptyText:'Email',
	hideLabel: true
	});	
	var phone_number_srch=new Ext.form.TextField({
	name: 'phone_number',
	width: 100,
	emptyText:'Phone',
	hideLabel: true
	});	
	var address_srch=new Ext.form.TextField({
	name: 'address',
	width: 100,
	emptyText:'Address',
	hideLabel: true
	});	
	
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
			action: 'get'
		},
		actionMethods: 'POST',
			reader: {
				type: 'json',
				root: 'results',
				idProperty: 'user_id',
				totalProperty: 'total'
			}
		},listeners: {
					'beforeload': function(store, options) {

						store.proxy.extraParams = { action: 'get',
								id:id_srch.getValue(),
								username:username_srch.getValue(),
								phone_number:phone_number_srch.getValue(),
								email:email_srch.getValue(),
								address:address_srch.getValue(),
								user_role : '<?php echo $role ; ?>'
												};
					}
				},
		fields: ['user_id', 'username'  , 'email','contact_person','phone_number','address' , 'role','block','active' ]
	});

	function VerifyVal(val) {
        if (val > 0) {
            return '<span style="color:green;">✓</span>';
        } else if (val <= 0) {
            return '<span style="color:red;">✕</span>';
        }
        return val;
	}
	
	function BlockkVal(val) {
        if (val <= 0) {
            return '<span class="icos-walking"></span>';
        } else if (val > 0) {
            return '<span class="icos-block"></span>';
        }
        return val;
	}
	
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
						xtype: 'textfield',
						allowBlank : false
					}
			},
			
			{ 
				text : 'Email',
				width : 200,
				sortable : true,
				dataIndex: 'email',
				editor: {
						xtype: 'textfield',
						vtype: 'email',
						allowBlank: false
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
						xtype: 'textfield'
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
				text : 'Status',
				width : 80,
				sortable : true,
				dataIndex: 'block',
				renderer : BlockkVal
			},
			{ 
				text : 'Verified',
				width : 80,
				sortable : true,
				dataIndex: 'active',
				renderer : VerifyVal
			}
		]
,
        viewConfig: {
            forceFit: true
        },
		dockedItems: [{
				xtype: 'pagingtoolbar',
				store: store,   // same store GridPanel is using
				dock: 'bottom',
				displayInfo: true
			},
			tbar1,
			{
				xtype: 'toolbar',
				dock: 'top',
				items:
					[
						{
							xtype: 'label',
							forId: 'myFieldId',
							text: 'Filters:',
							margins: '0'
						},
						id_srch,
						username_srch,
						phone_number_srch,
						email_srch,
						address_srch,
						{ 
							text: 'Search',
							iconCls:'icos-search',
							handler: function() {
								grid.child('pagingtoolbar').moveFirst();
								store.reload({
									params:{
									start:0,
									limit: itemsPerPage,
									id:id_srch.getValue(),
									username:username_srch.getValue(),
									phone_number:phone_number_srch.getValue(),
									email:email_srch.getValue(),
									address:address_srch.getValue(),
									user_role : '<?php echo $role ; ?>'
									}
								});				
							}	
						},
						{
							text: 'Clear filters',
							iconCls:'icos-trash',
							handler: function() {
							grid.child('pagingtoolbar').moveFirst();
							id_srch.setValue(null);
							username_srch.setValue(null);
							phone_number_srch.setValue(null);
							email_srch.setValue(null);
							address_srch.setValue(null);
							store.load({
								params:{
									start:0,
									limit: itemsPerPage
								}
							});  						
						  }
						}
					]
			},
			
		]
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
				fieldLabel: 'User Name',
				afterLabelTextTpl: required,
				width:'190',
				name: 'username',
				allowBlank: false,
				validateOnChange:true,
				validator:function(value) { 
					if(value.length>=6){
						validate_name(value);
						if(valid_user){
							return true;
						}
						else if(valid_user==false){
							Ext.Msg.alert('Error','This name already exist!');
							//return 'This name already exist';
						}
					}
					else{
						return 'Not less than 6 characters'
					}
				}
			},
			
			{
				xtype: 'textfield',
				name: 'password',
				fieldLabel: 'Password',
				inputType: 'password',
				afterLabelTextTpl: required,
				id: 'pass',
				allowBlank: false,
				minLength: 8,
				minLengthText: 'At least 6 characters',
				allowBlankText: 'Required'  
			},
			{
				xtype: 'textfield',
				fieldLabel: 'Email',
				afterLabelTextTpl: required,
				width:'190',
				name: 'email',
				vtype: 'email', // applies email validation rules to this field
				allowBlank: false,
				validateOnChange:true,
				validator:function(value) { 
					
						validate_email(value);
						if(valid_email){
						return true;
						}
						else if(valid_email==false){
							 Ext.Msg.alert('Error','This email already exist');
							//return 'This email already exist';
						}
					
				}
			},
			{
				xtype: 'radiogroup',
				fieldLabel: 'Role',
				columns: 2,
				itemId: 'Roles',
				items: [
					{
						xtype: 'radiofield',
						boxLabel: 'Admin',
						name: 'user_role',
						inputValue: 'admin'
					},
					{
						xtype: 'radiofield',
						boxLabel: 'User',
						name: 'user_role',
						checked: true,
						inputValue: 'user'
					}
				]
			},
			{
				xtype: 'textfield',
				fieldLabel: 'Address',
				width:'190',
				name: 'address'
			},
			{
				xtype: 'textfield',
				fieldLabel: 'Contact Person',
				width:'190',
				name: 'contact_person'
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
	
	// Change role of selected record
	function change_role(id){
		Ext.Ajax.request({
			url: 'users',
			params: {
				action: 'change_role',
				id:id,
				role:'<?php echo $role ; ?>'
			},
			success: function(response){
				var text = Ext.decode(response.responseText).msg;
				Ext.Msg.alert('Role change',text);
				store.reload();
			}
		});
	}
	
	// block the selected record
	function block_user(id,block){
		Ext.Ajax.request({
			url: 'users',
			params: {
				action: 'block_user',
				id:id,
				block:block
			},
			success: function(response){
				var text = Ext.decode(response.responseText).msg;
				Ext.Msg.alert('Block',text);
				store.reload();
			}
		});
	}
	function active_user(id,active){
		Ext.Ajax.request({
			url: 'users',
			params: {
				action: 'active_user',
				id:id,
				active:active
			},
			success: function(response){
				var text = Ext.decode(response.responseText).msg;
				Ext.Msg.alert('Active',text);
				store.reload();
			}
		});
	}
	
	
	function reset_password(id){
		Ext.Ajax.request({
			url: 'users',
			params: {
				action: 'reset_password',
				id:id
			},
			success: function(response){
				var text = Ext.decode(response.responseText).msg;
				Ext.Msg.alert('Reset password',text);
				store.reload();
			}
		});
	}
	
	function validate_name(name){
		Ext.Ajax.request({
			url: 'users',
			params: {
				action: 'validate_username',
				name:name
			},
			success: function(response){
				var success = Ext.decode(response.responseText).success;
				valid_user=success;
			}
		});
	}
		
	function validate_email(email){
		Ext.Ajax.request({
			url: 'users',
			params: {
				action: 'validate_email',
				email:email
			},
			success: function(response){
				var success = Ext.decode(response.responseText).success;
				valid_email=success;
			}
		});
	}
});
</script>
<div id="grid_details">

</div>