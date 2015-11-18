 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html">Blog Name</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
<?php if ($menu) { 
    foreach ($menu as $value) { ?>
    <li><a href="<?php echo site_url('member/slug/'.$value['idmenu']);?>"><?php $menue=getmenu($value['idmenu']);echo $menue['title'];?></a></li><?php } ?>
    <?php }else{ ?><li><a href="#">Menu belum tersedia</a></li><?php }?>
    <?php if ($this->session->userdata('logged_in')): ?>
        <li><a href="<?php echo site_url('member/logout');?>">Logout</a></li>
    <?php endif;?>
            <!--<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> Dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Dropdown Item</a></li>
                <li><a href="#">Another Item</a></li>
                <li><a href="#">Third Item</a></li>
                <li><a href="#">Last Item</a></li>
              </ul>
            </li> -->

          </ul>
        </div>
      </nav>
<div id="page-wrapper">
