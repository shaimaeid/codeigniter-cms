    <!-- Secondary nav -->
    <div class="secNav">
        <div class="secWrapper">
            <div class="secTop">
                <div class="balance">
                <div class="balInfo">Job Applications:<span><?php echo $total_applications .' Job Application' ; ?></span>
				
				</div>
                
                </div>
                
            </div>
            
            <!-- Tabs container -->
            <div id="tab-container" class="tab-container">
                <ul class="iconsLine ic3 etabs">
                    <li><a rel="tipsy" class="tipN" title="Home" href="#general" ><span class="icos-home"></span></a></li>
                    <li><a rel="tipsy" class="tipN" title="function list" href="#stuff" ><span class="icos-list"></span></a></li>
                    <li><a rel="tipsy" class="tipN" title="help tips" href="#allapps" ><span class="icos-help"></span></a></li>
                </ul>
                
                <div class="divider"><span></span></div>
                
                <div id="general">
					<div class="sidePad">
					 <a href="<?php echo site_url("jobs")?>#general" title="" class="sideB bRed mt10">View All </a>
					</div>
					<div class="divider"><span></span></div>
                </div>
                   
                <div id="stuff">
                    <div class="sidePad">
						<a href="<?php echo site_url("jobs/type/join")?>#stuff" title="" class="sideB  bGreen mt10">Join Us Applications</a>
                        <a href="<?php echo site_url("jobs/type/vacancy")?>#stuff" title="" class="sideB bBlue mt10">Vacancies Applications</a>

                    </div>
                    
                    <div class="divider"><span></span></div>
				</div>
				<div id="allapps">
                    <div class="sidePad">
						<h1>Managing Job Applications </h1>	
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