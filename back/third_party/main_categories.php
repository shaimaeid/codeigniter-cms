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
						id+=','+record.get('city_id');
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
            iconCls:'icon-print',
			tooltip:'Print cities',
            handler: function() {
            	Ext.ux.grid.Printer.sitepath = '<?php echo ROOT_DIR ; ?>';
				Ext.ux.grid.Printer.mainTitle='AYB Web Site: <?php echo $title; ?>';
			    Ext.ux.grid.Printer.title = 'AYB Web Site: <?php echo $title; ?>';
				Ext.ux.grid.Printer.stylesheetPath = '<?php echo ROOT_DIR;?>css/print.css';
              	Ext.ux.grid.Printer.printAutomatically = false;
				Ext.ux.grid.Printer.print(grid);       
            }

			}
      ]});
	// Search Items 
	var id_srch=new Ext.form.TextField({
	name: 'city_id',
	width: 50,
	emptyText:'ID',
	hideLabel: true
	});
	var name_srch=new Ext.form.TextField({
	name: 'name',
	width: 100,
	emptyText:'City',
	hideLabel: true
	});	
	// ---- main store for the grid ---- //
	var store = new Ext.data.JsonStore({
		// store configs
		storeId: 'myStore',
		autoLoad: false,
		pageSize: itemsPerPage,
		proxy: {
			type: 'ajax',
			url: 'areas',
			extraParams: {
			action: 'get_areas'
		},
		actionMethods: 'POST',
			reader: {
				type: 'json',
				root: 'results',
				idProperty: 'area_id',
				totalProperty: 'total'
			}
		},listeners: {
					'beforeload': function(store, options) {

						store.proxy.extraParams = { action: 'load',
													id:id_srch.getValue(),
													name:name_srch.getValue()
													};
					}
				},
		fields: ['area_id' , 'area_name_en' , 'area_name_ar' , 'map_id']
	});

	// grid
	var wdth=Ext.getDom('grid_details').clientWidth;
    var grid = new Ext.grid.Panel({
        height: 480,
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
		anchor: '90%',
		columns: [
					{ 
					text : 'ID',
					width : 50,
					sortable : true,
					dataIndex: 'area_id'
					},
					{ 
					text : 'Area Name EN',
					width : 50,
					sortable : true,
					dataIndex: 'area_name_en'
					},
					{ 
					text : 'Area Name AR',
					width : 50,
					sortable : true,
					dataIndex: 'area_name_ar'
					},
					{ 
					text : 'Map ID',
					width : 50,
					sortable : true,
					dataIndex: 'map_id'
					}
			],
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
						name_srch,
						{ 
							text: 'Search',
							iconCls:'icon-search',
							handler: function() {
								grid.child('pagingtoolbar').moveFirst();
								store.reload({
									params:{
										start:0,
										limit: itemsPerPage,
										id:id_srch.getValue(),
										name:name_srch.getValue()
									}
								});				
							}	
						},
						{
							text: 'Clear filters',
							iconCls:'icon-filter',
							handler: function() {
							grid.child('pagingtoolbar').moveFirst();
							id_srch.setValue(null);
							name_srch.setValue(null);
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
		url: 'cities',
		baseParams: {
			action: 'add'
		},
		frame: true,
		bodyStyle: '',
		width: 320,
		layout: 'form',
		method: 'POST',
	    items: [
			{
				xtype: 'textfield',
				fieldLabel: 'City *',
				width:'190',
				name: 'name',
				allowBlank: false
			}
		]
	});
	var win = new Ext.Window({
		title: 'Add new record',
		id: 'formanchor-win', 
		width: 400, 
		height: 200, 
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
			url: 'cities',
			params: {
				action: 'update',
				id:e.record.get("city_id"),
				name:e.record.get("name")
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
			url: 'cities',
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