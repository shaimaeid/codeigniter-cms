    <!-- Secondary nav -->
    <div class="secNav">
        <div class="secWrapper">
            <div class="secTop">
                <div class="balance">
                <div class="balInfo">Users / Admins:<span><?php echo $total_users .' Users / Admins' ; ?></span>
				
				</div>
                
                </div>
                
            </div>
            
            <!-- Tabs container -->
            <div id="tab-container" class="tab-container">
                <ul class="iconsLine ic3 etabs">
                    <li><a rel="tipsy" class="tipN" title="Home" href="#general" ><span class="icos-home"></span></a></li>
                    <li><a rel="tipsy" class="tipN" title="function list" href="#stuff" ><span class="icos-list"></span></a></li>
                    <li><a el="tipsy" class="tipN" title="help tips" href="#allusers" ><span class="icos-help"></span></a></li>
                </ul>
                
                <div class="divider"><span></span></div>
                
                <div id="general">
					<div class="sidePad">
					 <a href="<?php echo site_url("users")?>#general" title="" class="sideB bRed mt10">View All </a>
					</div>
					<div class="divider"><span></span></div>
                </div>
                   
                <div id="stuff">
                    <div class="sidePad">
						<a href="<?php echo site_url("users/role/admin")?>#stuff" title="" class="sideB  bGreen mt10">Admins</a>
                        <a href="<?php echo site_url("users/role/user")?>#stuff" title="" class="sideB bBlue mt10">Users</a>

                    </div>
                    
                    <div class="divider"><span></span></div>
				</div>
				<div id="allusers">
                    <div class="sidePad">
					<h1>Managing Users </h1>
						
						<p><span class="icos-link"></span> <b>User Role</b> - to change user role to admin , select user then click change role .</p>
						<p><i>only admins can access cpanel.</i></p><br />
						<p><span class="icos-block"></span><b>User Status</b> - to block a user , select user record then click change status .</p>
						<p>- to <b>unblock </b>a user , select user record then click change status .</p>
						<p><i>blocked users can not add new advertisments.</i></p><br />
						<p><span class="icos-email"></span> <b>Send Message</b> - to email a user , select user record then click  send message .</p><br />
                    </div>
                    
                    <div class="divider"><span></span></div>
				</div>
              
           </div>

            
          
        
       </div> 
       <div class="clear"></div>
   </div>
</div>
<!-- Sidebar ends -->
    

<!-- Main content wrapper begins -->
<div id="content">