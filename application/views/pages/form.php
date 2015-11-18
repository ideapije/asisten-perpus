<link href="<?php echo base_url().'assets/css/jquery-ui.css';?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.min.js';?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-ui.min.js';?>"></script>
<script type="text/javascript">
    // <![CDATA[
    $(document).ready(function () {
        $(function () {
                    	<?php switch ($mng) {
                    		case '38':?>
						$( "#napeng" ).autocomplete({
                			source: function(request, response) {
                    			$.ajax({ 
                    				url: "<?php echo site_url('member/getauto/20/nama_peng'); ?>",
                    				data: { kirim: $("#napeng").val()},
                        			dataType: "json",
                        			type: "POST",
                        			success: function(data){
                            			response(data);
                        			}    
                    			});
                		},
            			});
							$( "#namapen" ).autocomplete({
                			source: function(request, response) {
                    			$.ajax({ 
                    				url: "<?php echo site_url('member/getauto/19/nama_pen'); ?>",
                    				data: { kirim: $("#namapen").val()},
                        			dataType: "json",
                        			type: "POST",
                        			success: function(data){
                            			response(data);
                        			}    
                    			});
                		},
            			});
						$( "#katbuk" ).autocomplete({
                		source: function(request, response) {
                    		$.ajax({ 
                    			url: "<?php echo site_url('member/getauto/27/desc_kat'); ?>",
                    			data: { kirim: $("#katbuk").val()},
                    		<?php 	break;
                    		case '29': ?>
				$( "#kdbuk" ).autocomplete({
                source: function(request, response) {
                    $.ajax({ 
                    			url: "<?php echo site_url('member/getauto/18/judul_buku'); ?>",
                    			data: { kirim: $("#kdbuk").val()},
                    			<?php break;
                    		default: ?>
				$( "#autocomplete" ).autocomplete({
                source: function(request, response) {
                    $.ajax({ 
                    			url: "<?php echo site_url('member/getauto/23/uname'); ?>",
                    			data: { uname: $("#autocomplete").val()},
                    			<?php break;
                    	};?>
                        dataType: "json",
                        type: "POST",
                        success: function(data){
                            response(data);
                        }    
                    });
                },
            });
        });
    });
    // ]]>
    </script>
<?php 
if (isset($_GET['m'])) {
	switch ($_GET['m']) {
		case '4':
			echo 'gagal upload';
			break;
		case '2':
			echo 'berhasil upload';
			break;
		default:
			echo '';
			break;
	}
	
}
echo form_open_multipart('member/insert/'.$mng);
if ((isset($likol)) && (count($likol) > 0 )) {
	foreach ($likol as $kol) {
		if (strlen($kol['id'])>0) {
			$attr=array('name'=>$kol['name'],'','type'=>$kol['type'],'id'=>$kol['id']);
		}elseif (strlen($kol['class'])>0) {
			$attr=array('name'=>$kol['name'],'','type'=>$kol['type'],'class'=>$kol['class']);
		}else{
			$attr=array('name'=>$kol['name'],'','type'=>$kol['type']);
		}
		echo form_label($kol['label'],$kol['name']);
		switch ($kol['type']) {
					case 'date':
						echo form_input($attr,date('Y-m-d')).'<br>';
						break;
					case 'textarea':
						echo form_textarea(array('name'=>$kol['name'],'cols'=>'40','rows'=>'5'),'').'<br>';
						break;
					case 'checkbox':
						echo form_input($attr,'10').'<br>';
						break;
					case 'select': ?>
						<select name="<?php echo $kol['name'];?>">
						<?php 
						
						switch ($kol['name']) {
							case 'id_status':
								$qopt=$this->m_perpus->listselect($kol['size'],$mng);
								$skol='desc_status';
								break;
							case 'id_penerbit':
								$qopt=$this->m_perpus->listselect($kol['size']);
								$skol='nama_pen';
								break;
							case 'id_kat':
								$qopt=$this->m_perpus->listselect($kol['size']);
								$skol='desc_kat';
								break;
							case 'idjbtn':
								$qopt=$this->m_perpus->listselect($kol['size']);
								$skol='desc_jabatan';
								break;
							case 'id_gender':
								$qopt=$this->m_perpus->listselect($kol['size']);
								$skol='desc_gender';
								break;
							default:
								$qopt=$this->m_perpus->listselect($kol['size']);
								$skol='';
								break;
						}
						if ($qopt) { 
							foreach ($qopt as $opt) { ?>
								<option value="<?php echo $opt[$idkol];?>">
								<?php
								$disst= spesifickolbyid($opt[$idkol],$kol['size'],$skol);
								echo ($disst)? $disst : $opt[$idkol];
								 ?></option>
							<?php } 
						}else{ ?>
							<option>none</option>
						<?php }?>
					</select><?php echo anchor_popup('member/slug/2/'.$kol['size'].'?m=1', 'Tambahkan', $atts);?><br>
						<?php break;
					case 'file':
						(cekimg($mng,$idval))? $idimg=cekimg($mng,$idval) : $idimg=$idimge;
						echo form_input($attr,$idimg).'<br>';

						break;
					case 'hidden':
						switch ($kol['name']) {
							case 'idimg':
								echo form_input(array('type'=>'file','name'=>'userfile','id'=>'img'));
								echo form_input($attr,'1').'<br>';
								break;
							case $idkol:
								echo form_input($attr,$idval).'<br>';
								break;
							default:
								echo form_input($attr,'1').'<br>';
								break;
						}
						break;
					default:
						echo form_input($attr).'<br>';
						break;
		}
		
	}?>
	<?php if ((isset($mng)) && ($mng==='18')): ?>
	<label>daftar nama pengarang</label><br>
		<?php
		$idpeng=spesifickolbyid($idval,21,'id_peng');
		if ($idpeng) {?>
			<ul>
				<?php 
				$np=count($idpeng);
				for ($i=0; $i < $np; $i++){?>
					<li><?php 
					echo spesifickolbyid($idpeng[$i],20,'nama_peng');
					?></li>
				<?php }?>
			</ul>
		<?php }else{ ?>
		<strong>belum ada nama pengarang</strong>
		<?php } ?>
	<fieldset><legend>Pengarang Buku</legend>
	<?php include APPPATH.'views/inc/gpengbuku.php';?>
	</fieldset>
	<?php endif;?>
	<?php echo form_submit('','save');
}else{
	echo 'tidak ada daftar bidang yang  tersedia';
}
echo form_close();
?>