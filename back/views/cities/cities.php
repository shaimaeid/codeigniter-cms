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
				showform(0);      
            }
         },
		 { text: 'Edit record',
            iconCls:'icos-create',
			tooltip:'Edit selected record',
            handler: function() {
				var keys = grid.getSelectionModel().getSelection( ) ;
				if (keys.length == 1)
				{ 
					id='';
					Ext.each(grid.getSelectionModel().getSelection(), function(record){
						id+=','+record.get('city_id');
					});
					Ext.MessageBox.confirm('Confirm','Are you sure you wanna edit this record!',function (btn){
							if(btn=='yes'){
								showform(id.substring(1));
							}
						},
						this);
				}
				else 
					Ext.MessageBox.alert('Info','One record should be selected!');
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
						id+=','+record.get('city_id');
					});
					Ext.MessageBox.confirm('Confirm','Are you sure you wanna delete this record!',function (btn){
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
	var en_name_srch=new Ext.form.TextField({
	name: 'name',
	width: 100,
	emptyText:'City English Name',
	hideLabel: true
	});	
	var ar_name_srch=new Ext.form.TextField({
	name: 'name_ar',
	width: 100,
	emptyText:'City Arabic Name',
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
			url: 'cities',
			extraParams: {
			action: 'get'
		},
		actionMethods: 'POST',
			reader: {
				type: 'json',
				root: 'results',
				idProperty: 'city_id',
				totalProperty: 'total'
			}
		},listeners: {
					'beforeload': function(store, options) {

						store.proxy.extraParams = { action: 'get',
													id:id_srch.getValue(),
													name:en_name_srch.getValue(),
													name_ar:ar_name_srch.getValue()
													};
					}
				},
		fields: ['city_id' , 'name' , 'name_ar','logo_en','logo_ar']
	});

	// grid
	var wdth=Ext.getDom('grid_details').clientWidth;
    var grid = new Ext.grid.Panel({
        height: 500,
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
					width : 100,
					sortable : true,
					dataIndex: 'city_id'
				},
				{ 
					text : 'City English Name',
					width : 200,
					sortable : true,
					dataIndex: 'name',
					editor: {xtype: 'textfield'}
				},
				{ 
					text : 'City Arabic Name',
					width : 200,
					sortable : true,
					dataIndex: 'name_ar',
					editor: {xtype: 'textfield'}
				},
				{ 
					text : 'City English Logo',
					width : 100,
					sortable : true,
					dataIndex: 'logo_en',
					renderer:function(value, p, record, rowIndex, colIndex, ds) {
						var image=record.get('logo_en');
						var noimage='<img src="<?php echo site_url('upload'); ?>/no-image.jpg" width="90" height="70"/>';
						if (image != null){
							var img='<a href="<?php echo FRONT; ?>images/cities_images'+'/'+image+'" target="_BLANK"><img src="<?php echo FRONT; ?>images/cities_images'+'/'+image+'" width="50" height="50"/></a>';
							if(image.length>0){
											return img;
										}
							else{
									return  noimage;
								}
						}
						else 
							return noimage ;
				   }
				},
				{ 
					text : 'City Arabic Logo',
					width : 100,
					sortable : true,
					dataIndex: 'logo_ar',
					renderer:function(value, p, record, rowIndex, colIndex, ds) {
						var image=record.get('logo_ar');
						var noimage='<img src="<?php echo site_url('upload'); ?>/no-image.jpg" width="90" height="70"/>';
						if (image != null){
							var img='<a href="<?php echo FRONT; ?>images/cities_images_ar'+'/'+image+'" target="_BLANK"><img src="<?php echo FRONT; ?>images/cities_images_ar'+'/'+image+'" width="50" height="50"/></a>';
							if(image.length>0){
											return img;
										}
							else{
									return  noimage;
								}
						}
						else 
							return noimage ;
				   }
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
						en_name_srch,
						ar_name_srch,
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
										name:en_name_srch.getValue(),
										name_ar:ar_name_srch.getValue()
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
							en_name_srch.setValue(null);
							ar_name_srch.setValue(null);
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
	function showform(city_id){
	var myForm = new Ext.FormPanel({
		url: 'cities',
		baseParams: {
			action: 'insert',
			city_id: city_id
		},
		frame: true,
		bodyStyle: '',
		width: 300,
		layout: 'form',
		method: 'POST',
	    items: [
			{
				xtype: 'textfield',
				fieldLabel: 'City English Name',
				width:'100',
				name: 'name',
				allowBlank: false
			},
			{
				xtype: 'textfield',
				fieldLabel: 'City Arabic Name',
				width:'100',
				name: 'name_ar',
				allowBlank: false
			},
			{
				xtype: 'label',
				html:'<img id="pic1" src="<?php echo ROOT_DIR ; ?>upload/no-image.jpg" width="100" height="70" > '
			},
			{
				xtype: 'filefield',
				name: 'logo_en',
				fieldLabel: 'English Logo',
				labelWidth: 100,
				msgTarget: 'side',
				anchor: '100%',
				buttonText: 'Select file...'
			},
			{
				xtype: 'label',
				html:'<img id="pic2" src="<?php echo ROOT_DIR ; ?>upload/no-image.jpg" width="100" height="70" > '
			},
			{
				xtype: 'filefield',
				name: 'logo_ar',
				fieldLabel: 'Arabic Logo',
				labelWidth: 100,
				msgTarget: 'side',
				anchor: '100%',
				buttonText: 'Select file...'
			}
		]
	});
	if (city_id>0){
		myForm.getForm().load({
			url: 'cities',
			params: {
				action: 'load_form',
				city_id: city_id
			},
			success: function(form, action) {
				logo_en=Ext.getDom('pic1');
				if (action.result.data.logo_en != null)
					logo_en.src = '<?php echo FRONT; ?>images/cities_images/'+action.result.data.logo_en;
				
				logo_ar=Ext.getDom('pic2');
				if (action.result.data.logo_ar != null)
					logo_ar.src = '<?php echo FRONT; ?>images/cities_images_ar/'+action.result.data.logo_ar;
			},
			failure: function(form, action) {
				Ext.Msg.alert("Load failed", action.result.errorMessage);
			}
		});
	}
	var win = new Ext.Window({
		title: 'Add/Edit record',
		id: 'formanchor-win', 
		width: 500, 
		height: 400, 
		plain: true, 
		layout: 'fit', 
		border: false, 
		closable: false, 
		items:myForm,
		buttons: [{
					text: 'Add/Edit record',
					handler: function(){
						if(myForm.getForm().isValid()){
							myForm.getForm().submit
							({
								success: function(form, action) {
									var text =  action.result.msg;
									Ext.Msg.alert('Done',text);
									store.reload();
									win.close();
								}, 
								failure: function(form, action) {
									var text =  action.result.err;
									Ext.Msg.alert('Error',text);
								}
							});
						}
						else {
							Ext.Msg.alert('Error','Please, Insert all the obligatory fields.');
							//myForm.getForm().show();
						}
						
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
				city_id:e.record.get("city_id"),
				name:e.record.get("name"),
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