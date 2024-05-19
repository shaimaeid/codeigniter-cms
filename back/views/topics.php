<h1><?php echo $title ; ?></h1>
<script>
Ext.onReady(function(){  

//vars
Ext.QuickTips.init(); 
var itemsPerPage = 20;
// Action toolbar
// ---- actions tool bar definition ---- //
 var tbar1=new Ext.Toolbar({ items: [
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
						id+=','+record.get('topic_id');
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
		 { text: 'Print',
            iconCls:'icos-printer',
			tooltip:'Print topics',
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
	name: 'topic_id',
	width: 50,
	emptyText:'ID',
	hideLabel: true
	});
	var name_en_srch=new Ext.form.TextField({
	name: 'name_en',
	width: 100,
	emptyText:'English Name',
	hideLabel: true
	});	
	var name_ar_srch=new Ext.form.TextField({
	name: 'name_ar',
	width: 100,
	emptyText:'Arabic Name',
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
			url: 'topics',
			extraParams: {
			action: 'get'
		},
		actionMethods: 'POST',
			reader: {
				type: 'json',
				root: 'results',
				idProperty: 'topic_id',
				totalProperty: 'total'
			}
		},listeners: {
					'beforeload': function(store, options) {

						store.proxy.extraParams = { action: 'get',
											id:id_srch.getValue(),
											name_en:name_en_srch.getValue(),
											name_ar:name_ar_srch.getValue()
													};
					}
				},
				
		fields: ['topic_id' ,'name_en', 'name_ar' ]
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
				text : 'Topic ID',
				width : 50,
				sortable : true,
				dataIndex: 'topic_id'
			},
			{ 
				text : 'English Name',
				width : 150,
				sortable : true,
				dataIndex: 'name_en',
				editor: {
						xtype: 'textfield',
						allowBlank:false
					}
			},
			{ 
				text : 'Arabic Name',
				width : 200,
				sortable : true,
				dataIndex: 'name_ar',
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
						name_en_srch,
						name_ar_srch,
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
										name_en:name_en_srch.getValue(),
										name_ar:name_ar_srch.getValue()
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
							name_en_srch.setValue(null);
							name_ar_srch.setValue(null);
							store.load({
								params:{
									start:0,
									limit: itemsPerPage
								}
							});  						
						  }
						}
					]
			}
			
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
		url: 'topics',
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
					fieldLabel: 'English Name ',
					width:'190',
					name: 'name_en',
					allowBlank: false
				},
				{
					xtype: 'textfield',
					fieldLabel: 'Arabic Name ',
					width:'190',
					name: 'name_ar',
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
			url: 'topics',
			params: {
				action: 'update',
				id:e.record.get("topic_id"),
				
				name_en:e.record.get("name_en"),
				name_ar:e.record.get("name_ar")
				
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
			url: 'topics',
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