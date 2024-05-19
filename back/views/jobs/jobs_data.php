<h1><?php echo $title ; ?></h1>
<script>
Ext.require([
'Ext.form.*',
'Ext.tip.QuickTipManager'
]);
Ext.onReady(function(){  
Ext.QuickTips.init(); 
var itemsPerPage = 20;
// Action toolbar
// ---- actions tool bar definition ---- //
 var tbar1=new Ext.Toolbar({ height:30 , items: [
		 { text: 'Delete',
            iconCls:'icos-cross',
			tooltip:'Delete selected recoreds',
            handler: function() {
				var keys = grid.getSelectionModel().getSelection( ) ;
				if (keys.length > 0)
				{ 
					id='';
					Ext.each(grid.getSelectionModel().getSelection(), function(record){
						id+=','+record.get('job_application_id');
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
			url: 'jobs',
			extraParams: {
				action: 'get'
			},
			actionMethods: 'POST',
			reader: {
				type: 'json',
				root: 'results',
				idProperty: 'job_application_id',
				totalProperty: 'total'
			}
		},
		listeners: {
			'beforeload': function(store, options) {
				store.proxy.extraParams = { action: 'get',
											app_type : '<?php echo $app_type ; ?>'
											};
			}
		},
		fields: ['job_application_id' ,'vacancy_id' ,'job_position_id' ,'applicant_name' ,'gender' ,'age' ,'email' ,'mobile' ,'experience_years' ,'cv_url' ,'datetime' ,'vacancy_title' ,'job_position_title']
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
		anchor: '90%',
		columns: [
			{ 
				text : 'Application ID',
				width : 100,
				sortable : true,
				dataIndex: 'job_application_id'
			},
			{ 
				text : 'Applicant name',
				width : 150,
				sortable : true,
				dataIndex: 'applicant_name'
			},
			{ 
				text : 'Vacancy title',
				width : 150,
				sortable : true,
				dataIndex: 'vacancy_title'
			},
			{ 
				text : 'Job Position title',
				width : 150,
				sortable : true,
				dataIndex: 'job_position_title'
			},
			{ 
				text : 'Email',
				width : 150,
				sortable : true,
				dataIndex: 'email'
			},
			{ 
				text : 'Gender',
				width : 100,
				sortable : true,
				dataIndex: 'gender'
			},
			{ 
				text : 'Age',
				flex:1,
				sortable : true,
				dataIndex: 'age'
			},
			{ 
				text : 'Mobile',
				width : 100,
				sortable : true,
				dataIndex: 'mobile'
			},
			{ 
				text : 'Experience years',
				width : 100,
				sortable : true,
				dataIndex: 'experience_years'
			},
			{ 
				text : 'CV URL',
				width : 80,
				sortable : true,
				dataIndex: 'cv_url'
			},
			{ 
				text : 'Date time',
				width : 80,
				sortable : true,
				dataIndex: 'datetime'
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
			tbar1]
	});
	store.load({
		params:{
			start:0,
			limit: itemsPerPage
		}
	});
	
	// delete selected record
	function del_record(id){
		Ext.Ajax.request({
			url: 'jobs',
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