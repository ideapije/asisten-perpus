    <!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="jumbotron ">
        <div class="container">
            <div class="sticky"><div id="anchor"></div>
                <div class="input-group input-group-lg">
                    <input type="text" class="form-control col-lg-12">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
            </span>
                </div>
            </div>
          </div>
      </div>
</div>
<div class="row">
    <div class="listcatalog">
     <?php if ($katalog && count($katalog)>0) {
    foreach ($katalog as $key => $value) {
        (strlen(COVER_SRC.$value['lib_book_cover'])>0 && file_exists(COVER_SRC.$value['lib_book_cover']))? $img_src=COVER_SRC.$value['lib_book_cover'] : $img_src=COVER_SRC.'cover-default.jpg';?>
        <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                <div class="thumbnail">
                    <div class="caption">
                        <h4><?php echo $value['lib_book_title'];?></h4>
                        <p> 
                            <strong><?php echo $value['lib_book_author'];?></strong> <!--Deskripsi singkat belum tersedia-->
                            <a href="#" class="btn btn-sm btn-primary" rel="tooltip" title="Zoom">Details</a>
                            <a href="#" class="btn btn-sm btn-success" rel="tooltip" title="Download now">Booking Now</a>
                        </p>
                    </div>
                        <img class="img-responsive" src="<?php echo $img_src;?>" alt="<?php echo $value['lib_book_title'];?>">
                </div>
        </div>
<?php    }
}?>   
</div>
</div>
<div class="row">
    <div class="col-xs-12 katalog-pagination" >
    <?php echo $pagination; ?>
    </div>
</div>
<hr>
