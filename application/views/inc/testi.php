
<?php
if (isset($_GET['kb'])) { ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/rating.js"></script>
	<div id="testi">
            <div id="rating_<?php echo decrypt_url($_GET['kb']);?>" class="ratings">
            <?php 
			for($k=1;$k<6;$k++){
					if($rat+0.5>$k) $class="star_".$k."  ratings_stars ratings_vote";
					else $class="star_".$k." ratings_stars ratings_blank"; ?>
			<div class="<?php echo $class;?>">
			</div>
			<?php }
//echo' <div class="total_votes"><p class="voted"> Rating: <strong>'.@number_format($rat).'</strong>/5 ('.$v. '  vote(s) cast) ; ?>
</div>
</div>
<?php } ?>