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
						id+=','+record.get('page_id');
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
		{ text: 'Publish/Un Publish',
			iconCls:'icos-books',
			tooltip:'Change page publish status',
			handler: function() {
				var keys = grid.getSelectionModel().getSelection( ) ;
				if (keys.length > 0)
				{ 
					id='';
					publish='';
					Ext.each(grid.getSelectionModel().getSelection(), function(record){
						id+=','+record.get('page_id');
						publish+=','+record.get('published');
					});
					change_publish(id.substring(1),publish.substring(1));
				}
				else{
					Ext.MessageBox.alert('Info', 'You Must Select One Record!!');
				}
			}
		},
		{ text: 'Print',
            iconCls:'icos-printer',
			tooltip:'Print articles',
            handler: function() {
            	Ext.ux.grid.Printer.sitepath = '<?php echo ROOT_DIR ; ?>';
				Ext.ux.grid.Printer.mainTitle='Tarbeet Web Site: <?php echo $title; ?>';
			    Ext.ux.grid.Printer.title = 'Tarbeet Web Site: <?php echo $title; ?>';
				Ext.ux.grid.Printer.stylesheetPath = '<?php echo ROOT_DIR;?>css/Print.css';
              	Ext.ux.grid.Printer.printAutomatically = false;
				Ext.ux.grid.Printer.print(grid);       
            }
		},
		{ text:'Publish All',
			iconCls:'icos-books',
			tooltip:'Publish all the articals',
			handler: function(){
				Ext.MessageBox.confirm('Confirm','Are you sure you wanna publish all pages!',function (btn){
						if(btn=='yes'){ 
							publish_all();
						}
					},
					this);
			}
		}	
      ]});
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
	
	  
// Search Items 
	var id_srch=new Ext.form.TextField({
	name: 'page_id',
	width: 50,
	emptyText:'ID',
	hideLabel: true
	});
	var ar_title_srch=new Ext.form.TextField({
	name: 'ar_title',
	width: 100,
	emptyText:'Arabic Title',
	hideLabel: true
	});	
	var en_title_srch=new Ext.form.TextField({
	name: 'en_title',
	width: 100,
	emptyText:'English Title',
	hideLabel: true
	});	
	// edit combo
	var topic_edit_Combo =Ext.create('Ext.form.ComboBox', {
		name  : 'topic_id',
		width    : 125,
		store: topicStore,
		queryMode: 'remote',
		displayField: 'topic_name',
		valueField: 'topic_id',
		triggerAction: 'all',
		allowBlank: false		
	});
	
	// ---- main store for the grid ---- //
	var store = new Ext.data.JsonStore({
		// store configs
		storeId: 'myStore',
		autoLoad: false,
		pageSize: itemsPerPage,
		proxy: {
			type: 'ajax',
			url: 'articles',
			extraParams: {
			action: 'get'
		},
		actionMethods: 'POST',
			reader: {
				type: 'json',
				root: 'results',
				idProperty: 'page_id',
				totalProperty: 'total'
			}
		},listeners: {
					'beforeload': function(store, options) {

						store.proxy.extraParams = { action: 'get',
													id:id_srch.getValue(),
													ar_title:ar_title_srch.getValue(),
													en_title:en_title_srch.getValue()
													};
					}
				},
				groupField: 'topic_name',
		fields: ['page_id' ,'page_name', 'topic_id' , 'title_en' , 'title_ar' ,  'published' ,'topic_name']
	});

	function PublishedVal(val) {
        if (val > 0) {
            return '<span style="color:green;">✓</span>';
        } else if (val <= 0) {
            return '<span style="color:red;">✕</span>';
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
			features: [{ftype:'grouping'}],
		anchor: '90%',
			columns: [
			{ 
				text : 'Page ID',
				width : 50,
				sortable : true,
				dataIndex: 'page_id'
			},
			{ 
				text : 'Page url name',
				width : 150,
				sortable : true,
				dataIndex: 'page_name',
				editor: {
						xtype: 'textfield',
						allowBlank:false
					}
			},
			{ 
				text : 'Topic Name',
				width : 200,
				sortable : true,
				dataIndex: 'topic_id',
				renderer:function(value, p, record, rowIndex, colIndex, ds) {
                        return record.get('topic_name');
                    },
				editor: topic_edit_Combo
			},
			{ 
				text : 'English Title',
				width : 150,
				sortable : true,
				dataIndex: 'title_en',
				editor: {
						xtype: 'textfield',
						allowBlank : false
					}
			},
			{ 
				text : 'Arabic Title',
				width : 150,
				sortable : true,
				dataIndex: 'title_ar',
				editor: {
						xtype: 'textfield',
						allowBlank:false
					}
			},
			{ 
				text : 'Content',
				width:150,
				sortable : true,
				dataIndex: 'page_name',
				renderer:function(value, p, record, rowIndex, colIndex, ds) {
					var page=record.get('page_name');
					var anchore='<a href="<?php echo site_url("articles/edit"); ?>/'+page+'">Edit Page</a>';
                        return anchore;
               }	
			},
			{ 
				text : 'Published',
				width : 100,
				sortable : true,
				dataIndex: 'published',
				renderer : PublishedVal,
				editor: {xtype: 'checkboxfield'}
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
						ar_title_srch,
						en_title_srch,
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
										ar_title:ar_title_srch.getValue(),
										en_title:en_title_srch.getValue()
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
							ar_title_srch.setValue(null);
							en_title_srch.setValue(null);
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
	var topicCombo =Ext.create('Ext.form.ComboBox', {
		fieldLabel: 'Topic Name *',
		name  : 'topic_id',
		width    : 125,
		store: topicStore,
		queryMode: 'remote',
		displayField: 'topic_name',
		valueField: 'topic_id',
		triggerAction: 'all',
		allowBlank: false,
		listeners: {
			'select': function(cmb, rec, idx) {
			  var x =this.getValue();
			   myForm.getForm().findField('topic_id').setValue(x);
							   
			}
			}
	});
	var myForm = new Ext.FormPanel({
		url: 'articles',
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
				fieldLabel: 'Page name in URL ',
				width:'190',
				name: 'page_name',
				allowBlank: false
			},
			topicCombo,
			{
				xtype: 'textfield',
				fieldLabel: 'English Title ',
				width:'190',
				name: 'title_en',
				allowBlank: false
			},
			{
				xtype: 'textfield',
				fieldLabel: 'Arabic Title ',
				width:'190',
				name: 'title_ar',
				allowBlank: false
			},
			{
                xtype: 'checkboxfield',
				fieldLabel: 'Published',
				name: 'published'  
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
			url: 'articles',
			params: {
				action: 'update',
				id:e.record.get("page_id"),
				topic_id:e.record.get("topic_id"),
				title_en:e.record.get("title_en"),
				title_ar:e.record.get("title_ar"),
				published:e.record.get("published")
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
			url: 'articles',
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
	// publish all the pages
	function publish_all(){
		Ext.Ajax.request({
			url: 'articles',
			params: {
				action: 'publish_all'
			},
			success: function(response){
				var text = Ext.decode(response.responseText).msg;
				Ext.Msg.alert('Publish All',text);
				store.reload();
			}
		});
	}
	function change_publish(id,publish){
		Ext.Ajax.request({
			url: 'articles',
			params: {
				action: 'change_publish',
				id:id,
				publish:publish
			},
			success: function(response){
				var text = Ext.decode(response.responseText).msg;
				Ext.Msg.alert('Publish/Unpublish',text);
				store.reload();
			}
		});
	}
});
</script>
<div id="grid_details">

</div>