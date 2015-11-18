<div class="bs-docs-header" id="content">
      <div class="container">
      <?php include APPPATH.'views/fields/form-search.php';?>
        </div>
      </div>
<?php if (!$this->session->userdata('logged_in')) : ?>
    <div class="row" >
      <div class="col-xs-12" >
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="item active">
      <img src="<?php echo base_url();?>assets/gambar/slideshow/Untitled-1.png" alt="satu">
      <div class="carousel-caption">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. 
      </div>
    </div>
    <div class="item">
      <img src="<?php echo base_url();?>assets/gambar/slideshow/Untitled-2.png" alt="dua">
      <div class="carousel-caption">
      Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. 
      Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. 
      </div>
    </div>
    <div class="item">
      <img src="<?php echo base_url();?>assets/gambar/slideshow/Untitled-3.png" alt="tiga">
      <div class="carousel-caption">
      Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
      </div>
    </div>
  </div>
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>
      </div>
</div>
<?php endif;?>
<div id="hasils" style="background-color:#fff;padding:15px 0px 15px 0px;">


