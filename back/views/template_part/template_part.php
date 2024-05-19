<h1><?php echo $title ; ?></h1>
<script>
Ext.require([
'Ext.form.*',
'Ext.tip.QuickTipManager'
]);
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
			tooltip:'Add new record',
            handler: function() {
				var keys = grid.getSelectionModel().getSelection( ) ;
				if (keys.length == 1)
				{ 
					id='';
					Ext.each(grid.getSelectionModel().getSelection(), function(record){
						id+=','+record.get('template_part_id');
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
						id+=','+record.get('template_part_id');
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
			tooltip:'Print',
            handler: function() {
            	Ext.ux.grid.Printer.sitepath = '<?php echo ROOT_DIR ; ?>';
				Ext.ux.grid.Printer.mainTitle='CMS Web Site: <?php echo $title; ?>';
			    Ext.ux.grid.Printer.title = 'CMS Web Site: <?php echo $title; ?>';
				Ext.ux.grid.Printer.stylesheetPath = '<?php echo ROOT_DIR;?>css/print.css';
              	Ext.ux.grid.Printer.printAutomatically = false;
				Ext.ux.grid.Printer.print(grid);       
            }

			}
      ]});
	// Search Items 
	var id_srch=new Ext.form.TextField({
	name: 'template_part_id',
	width: 50,
	emptyText:'Template ID',
	hideLabel: true
	});
	var name_srch=new Ext.form.TextField({
	name: 'title',
	width: 100,
	emptyText:'Title',
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
			url: 'template_part',
			extraParams: {
			action: 'get'
		},
		actionMethods: 'POST',
			reader: {
				type: 'json',
				root: 'results',
				idProperty: 'template_part_id',
				totalProperty: 'total'
			}
		},
		listeners: {
					'beforeload': function(store, options) {

						store.proxy.extraParams = { action: 'get',
													id:id_srch.getValue(),
													title:name_srch.getValue()
													};
					}
				},
		fields: ['template_part_id','title','content','update_time','image']
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
		anchor: '90%',
		columns: [
				{ 
					text : 'Template ID',
					width : 100,
					sortable : true,
					dataIndex: 'template_part_id'
				},
				{ 
					text : 'Title',
					width : 200,
					sortable : true,
					dataIndex: 'title'
				},
				{ 
					text : 'Content',
					width : 200,
					sortable : true,
					dataIndex: 'content'
				},
				{ 
					text : 'Template Logo',
					width : 100,
					sortable : true,
					dataIndex: 'image',
					renderer:function(value, p, record, rowIndex, colIndex, ds) {
						var image=record.get('image');
						var noimage='<img src="<?php echo FRONT; ?>upload/no-image.jpg" width="90" height="70"/>';
						if (image != null){
							var img='<a href="<?php echo FRONT; ?>images/template'+'/'+image+'" target="_BLANK"><img src="<?php echo FRONT; ?>images/template'+'/'+image+'" width="50" height="50"/></a>';
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
					text : 'Update Date',
					width : 200,
					sortable : true,
					dataIndex: 'update_time'
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
							iconCls:'icos-search',
							handler: function() {
								grid.child('pagingtoolbar').moveFirst();
								store.reload({
									params:{
										start:0,
										limit: itemsPerPage,
										id:id_srch.getValue(),
										title:name_srch.getValue()
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
	function showform(template_part_id){
	var myForm = new Ext.FormPanel({
		url: 'template_part',
		baseParams: {
			action: 'insert',
			template_part_id: template_part_id
		},
		frame: true,
		bodyStyle: '',
		width: 300,
		layout: 'form',
		method: 'POST',
	    items: [
			{
				xtype: 'textfield',
				fieldLabel: 'Template Title',
				width:'100',
				name: 'title',
				allowBlank: false
			},
			{
				xtype: 'textareafield',
				fieldLabel: 'Content',
				width:'100',
				name: 'content'
			},
			{
				xtype: 'label',
				html:'<img id="pic2" src="<?php echo ROOT_DIR ; ?>upload/no-image.jpg" width="100" height="70" > '
			},
			{
				xtype: 'filefield',
				name: 'image',
				fieldLabel: 'Logo',
				labelWidth: 100,
				msgTarget: 'side',
				anchor: '100%',
				buttonText: 'Select file...'
			},
			{
				xtype: 'datefield',
				fieldLabel: 'Update Time',
				width:'100',
				name: 'update_time'
				
			}
		]
	});
	
	if (template_part_id>0){
		myForm.getForm().load({
			url: 'template_part',
			params: {
				action: 'load_form',
				template_part_id: template_part_id
			},
			success: function(form, action) {
				logo=Ext.getDom('pic2');
				if (action.result.data.logo != null)
					logo.src = '<?php echo FRONT; ?>images/template/'+action.result.data.logo;
			},
			failure: function(form, action) {
				Ext.Msg.alert("Load failed", action.result.errorMessage);
			}
		});
	}
	var win = new Ext.Window({
		title: 'Add new record',
		id: 'formanchor-win', 
		width: 500, 
		height: 350, 
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
									win.close();
								}, 
								failure: function(form, action) {
									var text =  action.result.err
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
			url: 'template_part',
			params: {
				action: 'update',
				template_part_id:e.record.get("template_part_id"),
				title:e.record.get("title"),
				content:e.record.get("content"),
				update_time:e.record.get("update_time")
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
			url: 'template_part',
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