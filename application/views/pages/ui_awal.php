           <nav id="navbar" class="uk-navbar uk-navbar-attached" data-uk-sticky>            
            <div class="uk-container uk-container-center uk-hidden-small">
                <a id="logo" class="uk-navbar-brand" href="#">
                    Digital Asistant Library
                </a><!-- logo berakhir disini -->
                
                <ul id="menu-utama" class="uk-navbar-nav">
                    <li><a href="">Profil</a></li>
                    </ul>
                    </div>
		</nav>
        <div class="uk-grid">
        <div class="uk-width-7-10">
        	<?php include APPPATH.'views/inc/katalog-01.php';?>
        </div>
        <div class="uk-width-3-10">
        	<!--<img class="uk-margin-bottom" width="140" height="120" src=""> -->
                    <div class="uk-panel uk-panel-box">
                        <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tab-content'}">
                            <li class="<?php echo ($this->uri->segment(2)=='reg')? 'uk-width-1-3' : 'uk-width-1-3 uk-active';?>" ><a href="">Sign</a></li>
                            <li class="<?php echo ($this->uri->segment(2)=='reg')? 'uk-width-1-3 uk-active' : 'uk-width-1-3';?>"><a href="">Sign Up</a></li>
                            
                        </ul>
                    
                        <ul id="tab-content" class="uk-switcher uk-margin">
                            <li><?php include APPPATH.'views/inc/login.php';?></li>
                            <li><?php include APPPATH.'views/inc/reg.php';?></li>
                        </ul>
                    </div>
        </div>
        </div>

         
            


