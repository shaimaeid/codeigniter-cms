<h1><?php echo $title ; ?></h1>
<script>
Ext.onReady(function(){  

//vars
Ext.QuickTips.init(); 
var itemsPerPage = 20;
// Action toolbar
// ---- actions tool bar definition ---- //
 var tbar1=new Ext.Toolbar({ items: [

		
		 { text: 'Print',
            iconCls:'icos-printer',
			tooltip:'Print Settings',
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

	  
// Search Items 
	var id_srch=new Ext.form.TextField({
	name: 'setting_id',
	width: 50,
	emptyText:'ID',
	hideLabel: true
	});
	var key_srch=new Ext.form.TextField({
	name_en: 'key',
	width: 100,
	emptyText:'Key',
	hideLabel: true
	});	
	var value_srch=new Ext.form.TextField({
	name: 'value',
	width: 100,
	emptyText:'Value',
	hideLabel: true
	});	
	
	// ---- main store for the grid ---- //
	var store = new Ext.data.JsonStore({
		// store configs
		storeId: 'myStore',
		autoLoad: false,
		topicsize: itemsPerPage,
		proxy: {
			type: 'ajax',
			url: 'settings',
			extraParams: {
			action: 'get'
		},
		actionMethods: 'POST',
			reader: {
				type: 'json',
				root: 'results',
				idProperty: 'setting_id',
				totalProperty: 'total'
			}
		},listeners: {
					'beforeload': function(store, options) {

						store.proxy.extraParams = { action: 'get',
											id:id_srch.getValue(),
											key:key_srch.getValue(),
											value:value_srch.getValue()
													};
					}
				},
				
		fields: ['setting_id' ,'key', 'value' ]
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
				text : 'Setting ID',
				width : 100,
				sortable : true,
				dataIndex: 'setting_id'
			},
			{ 
				text : 'Key',
				width : 150,
				sortable : true,
				dataIndex: 'key',
				
			},
			{ 
				text : 'Value',
				flex : 1,
				sortable : true,
				dataIndex: 'value',
				editor: {
						xtype: 'textfield',
						allowBlank:false
						}
						
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
						key_srch,
						value_srch,
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
										key:key_srch.getValue(),
										value:value_srch.getValue()
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
							key_srch.setValue(null);
							value_srch.setValue(null);
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
		url: 'settings',
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
					fieldLabel: 'Key',
					width:'190',
					name: 'key',
					allowBlank: false
				},
				{
					xtype: 'textfield',
					fieldLabel: 'Value',
					width:'190',
					name: 'value',
					allowBlank: false
				}
			
			
			
		]
	});
	var win = new Ext.Window({
		title: 'Add new record',
		id: 'formanchor-win', 
		width: 400, 
		height: 250, 
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
			url: 'settings',
			params: {
				action: 'update',
				id:e.record.get("setting_id"),
				
				key:e.record.get("key"),
				value:e.record.get("value")
				
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
			url: 'settings',
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
});
</script>
<div id="grid_details">

</div>