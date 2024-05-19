<?php
    include('../templates/orange/header_user_auth.php');
?>
<div id="content">
			
	<?php
	include('../templates/orange/sidebar.php');
	?>
	<div id="inner-content">
	
			<h2 class="det-header">أضف إعلان</h2>		
			<div style="height:40px;"></div>
<script>
Ext.override(Ext.form.Field, {
  setFieldLabel : function(text) {
    if (this.rendered) {
      this.el.up('.x-form-item', 10, true).child('.x-form-item-label').update(text);
    }
    this.fieldLabel = text;
  }
});
Ext.onReady(function(){

Ext.QuickTips.init();

 var store = new Ext.data.SimpleStore({
        fields: [ 'package','title'],
        data: [[ 0,'مجانى'], [ 1,'فضى'], [ 2,'ذهبى']],
        autoLoad: false
    }); 


	var main=0;
var dscat = new Ext.data.Store({
       url: '../json.php',
		 baseParams: {
         module: 'adv', 
         action: 'getCat',
		 main_id:this.main
		},
      reader: new Ext.data.JsonReader({
        root: 'rows',
        fields: ['cat_id', 'cat_name']
      }),
      autoLoad: false                                                                                    
    });
	
 var dsmcat = new Ext.data.Store({
       url: '../json.php',
		 baseParams: {
         module: 'adv', 
         action: 'getmCat',
		
		},
      reader: new Ext.data.JsonReader({
        root: 'rows',
        fields: ['mcat_id', 'mcat_name']
      }),
      autoLoad: true                                                                                    
    });

var pstore = new Ext.data.SimpleStore({
        fields: ['title', 'code'],
        data: [['بيع', 0], ['شراء', 1], ['استبدال', 2], ['تأجير', 3], ['طلب تعديل', 4]],
        autoLoad: false
    }); 

var sstore = new Ext.data.SimpleStore({
        fields: ['title', 'code'],
        data: [['جديد', 0], ['مستعمل', 1],['لا ينطبق', 2]],
        autoLoad: false
    }); 
var price=new Ext.form.TextField({
            xtype: 'textfield',
            fieldLabel: 'السعر',
			width:'190',
			allowBlank: false,
            name: 'price'
        });

var lists = new Ext.Container({
    autoEl: {},
    layout: 'column',
    defaults: {
        xtype: 'container',
        autoEl: {},
        layout: 'form',
        columnWidth: 0.5,
        bodyStyle: 'padding:20px'
    },
    items: [
	{columnWidth: 0.55,items:[
	{ 
	xtype:'combo',
    store: dsmcat,
    displayField: 'mcat_name',
    valueField: 'mcat_id',
	hiddenName:'mcat_id',
	width:198,
    editable: false,
    mode: 'local',
    forceSelection: true,
    triggerAction: 'all',
	allowBlank: false,
    fieldLabel: 'التصنيف الاساسى ',
    emptyText: 'اختر تصنيف الإعلان',
    selectOnFocus: true,
	listeners: {
        'select': function(cmb, rec, idx) {
		var id=this.getValue();
          dscat.baseParams['main_id'] =this.getValue();
		  dscat.reload();
           if(id==10){
		   
/*price.setFieldLabel('المرتب:'); */
add_form.getForm().findField('price').setFieldLabel('المرتب:'); 
disableFields();
}else{
price.setFieldLabel('السعر:'); 
enableFields();
}	
	   
        }}},
		
	{ 
	xtype:'combo',
    store: dscat,
    displayField: 'cat_name',
    valueField: 'cat_id',
	hiddenName:'cat_id',
	width:198,
    editable: false,
    mode: 'local',
    forceSelection: true,
    triggerAction: 'all',
	allowBlank: false,
    fieldLabel: 'التصنيف الفرعى',
    emptyText: 'اختر تصنيف الإعلان',
    selectOnFocus: true},

	{
            xtype: 'textfield',
            fieldLabel: ' رابط Youtube',
			width:'190',
            name: 'type'
        },price,{
            xtype: 'textfield',
            fieldLabel: 'تليفون 1',
			width:'190',
			allowBlank: false,
            name: 'phone_1'
        },{
            xtype: 'textfield',
            fieldLabel: 'تليفون 2',
			width:'190',
            name: 'phone_2'
        }]
    }
	,{columnWidth: 0.45,items:[{
            xtype: 'textfield',
            fieldLabel: 'الموديل',
			width:'190',
            name: 'model'
          },{
            xtype: 'textfield',
            fieldLabel: 'الماركة',
            name: 'brand',
			width:'190'
          },
	{
	xtype:'combo',
    store: pstore,
    displayField: 'title',
    valueField: 'code',
	name: 'purpose',
	hiddenName: 'purpose',
	width:198,
    editable: false,
    mode: 'local',
    forceSelection: true,
    triggerAction: 'all',
    fieldLabel: 'الغرض',
	allowBlank: false,
    emptyText: 'اختر الغرض',
    selectOnFocus: true
	},
	{
    xtype:'combo',
    store: sstore,
	width:198,
    displayField: 'title',
    valueField: 'title',
	name: 'status',
	hiddenName: 'status',
    editable: false,
    mode: 'local',
    forceSelection: true,
    triggerAction: 'all',
    fieldLabel: 'الحالة',
    emptyText: 'اختر الحالة',
    selectOnFocus: true,
	allowBlank: false
}, 
	{
		items: [
     { xtype: 'box',
       autoEl: { tag: 'div',
       html: ''
     }
     }
   ]
          },{
   
   items: [
     { xtype: 'box',
       autoEl: { tag: 'div',
       html: '<a style="display:block;width:100px;float:right;"  href="javascript:showform()">اضف صورة :</a><img id="pic1"  src="../images/user_adv/no_image.png"   class="img-contact" width="32" /><input type="hidden" name="img" value="" id="img" />'
     }
     }
   ]
}]
    }]
});
      var add_form = new Ext.FormPanel({ 
         url: '../json.php',
		 baseParams: {
         module: 'adv', 
         action: 'addAdv'
		},
         renderTo: 'ext_form',
         frame: true,
         cls : "right",
         width:740,
		 title:'ادخل بيانات اعلانك ادناه',
		layout:'form',
         items: [{
            xtype: 'textfield',
            fieldLabel: 'عنوان الاعلان',
            name: 'title',
			allowBlank: false,
			width:'592'
            
          },
		  {
            xtype: 'textarea',
            fieldLabel: 'الوصف',
            name: 'description',
            width:600,
			height:150,
			allowBlank: false
          }
		  
		  ,lists
		  
		  ],
		  buttons:
        [{
            text: 'اضافة الإعلان',
            handler: function()
            {
         if (add_form.getForm().isValid())                
                add_form.getForm().submit
                ({
                    success: function(form, action) {
					var x=Ext.decode(action.response.responseText).msg;
					
                       Ext.Msg.alert('تم', x+' تمت اضافة اعلانك بنجاح');
					    window.top.location.href = 'manage_advs.php';
					   
                    },

                    failure: function(form, action) {
                       Ext.Msg.alert('Failure', action.result.error);
					   Ext.Msg.alert('خطأ', 'عذرا - لقد حدث خطأ من فضلك اعد المحاولة');
                    }
                });
            }
        },{
            text: 'الملف الشخصى',
            handler: function(){window.location.href = 'profile.php';}
        },{
            text: 'ادارة الاعلانات',
            handler: function(){window.location.href = 'profile.php';}
        }]
		  
      });
	  add_form.getForm().findField('model').setValue('لا ينطبق');
	  add_form.getForm().findField('brand').setValue('لا ينطبق');
	  add_form.getForm().findField('price').setValue('0.00');
	  add_form.getForm().findField('status').setValue('لا ينطبق');
	  add_form.getForm().findField('purpose').setValue('بيع');
	  function disableFields(){
add_form.getForm().findField('status').setDisabled(true);
add_form.getForm().findField('purpose').setDisabled(true);
add_form.getForm().findField('brand').setDisabled(true);
add_form.getForm().findField('model').setDisabled(true);
};
function enableFields(){
add_form.getForm().findField('status').setDisabled(false);
add_form.getForm().findField('purpose').setDisabled(false);
add_form.getForm().findField('brand').setDisabled(false);
add_form.getForm().findField('model').setDisabled(false);
}
 });

function showform(){
var pictUploadForm = new Ext.FormPanel({
   frame: true,
   title: 'اضف صورة',
   bodyStyle: 'direction:ltr',
   width: 320,
   layout: 'column',
   url: '../include/file-upload.php',
   method: 'POST',
   fileUpload: true,
   items: [
{ 
xtype: 'textfield',
fieldLabel: 'New (JPG or PNG only)',
labelSeparator: '',
name: 'newPic',
id:'newPic',
inputType: 'file',
allowBlank: false
},
{
   columnWidth: '100 px',
   bodyStyle: 'padding:10px',
   items: [
     { xtype: 'box',
       autoEl: { tag: 'div',
       html: '<img id="pic" height="100" src="' + Ext.BLANK_IMAGE_URL + '"  class="img-contact" />'
        
          }
     }
   ]
}],
    buttons: [{
            text: 'اضف',
            handler: function(){
                if(pictUploadForm.getForm().isValid()){
	                pictUploadForm.getForm().submit({
	                    url: '../include/file-upload.php',
	                    waitMsg: 'Uploading your photo...',
	                    success: function(fp, o){
						Ext.getDom('pic').src = '../images/user_adv/'+o.result.file;
						Ext.getDom('pic1').src = '../images/user_adv/'+o.result.file;
						Ext.getDom('img').value =o.result.file;
						Ext.Msg.alert('Success', 'Processed file "'+o.result.file+'" on the server');
							
	                    }
	                });
                }
            }
        },{
            text: 'مسح',
            handler: function(){
                pictUploadForm.getForm().reset();
            }
        }]
});
function validateFileExtension(fileName) {
   var exp = /^.*\.(jpg|JPG|png|PNG)$/;
   return exp.test(fileName);
};
var win = new Ext.Window({
id: 'formanchor-win'
, width: 400
, height: 200
, plain: true
, layout: 'fit'
, border: false
, closable: false
, items:pictUploadForm,
buttons:[{
            text: 'اغلاق',
            handler: function(){
                win.close();
            }
        }]
});

win.show();

};

  

 
   
   </script>
   <div id="ext_form">


   </div>
	
</div>
<div class="clear"></div>
</div>
<?php
    include('../templates/orange/footer_user.php');

?>