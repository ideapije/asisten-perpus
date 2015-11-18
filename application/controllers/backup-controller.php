	$num_rows		=$this->db->count_all('buku');
			$burl			=site_url('asisten/home/');
			$per 			=16;
			$config 		=pagination_config($num_rows,$burl,$per);
   			$data['email']	=array('type'=>'email','name'=>'email','size'=>50,'placeholder'=>'masukkan email terdaftar','class'=>'form-control');
			$data['passc']	=array('name'=>'passc','size'=>'50','class'=>'form-control');
			$data['gender']	=$this->db->get('gender')->result_array();
			$data['jbtn']	=$this->db->not_like('idjbtn','1')->get('jabatan')->result_array();
			$data['uname']	=array('name' => 'uname', 'size'=>'50','placeholder'=>'masukkan username','class'=>'form-control');
			$data['pass']	=array('name'=>'pass','size'=>'50','placeholder'=>'masukkan password','class'=>'form-control');
			$data['offset']	=$offset;
			$data['atts']	=array('width'=> 800,'height'=> 600,'scrollbars'=>'yes','status'=>'yes','resizable'=> 'yes','screenx'=> 0,'screeny'=> 0,'window_name' => '_blank');
			$this->pagination->initialize($config);


view/inv/login
<?php echo validation_errors();echo form_open('asisten'); ?>
    <div class="form-group">
    <?php echo form_label('username', 'uname'); ?>
    <?php echo form_input($uname).'<br>'; ?>
    </div>
    <div class="form-group">
    <?php echo form_label('Password', 'pass'); ?>
    <?php echo form_password($pass).'<br>'; ?>
    </div>
    <?php $arr2=array('style'=>'margin-left:10px;','data-target'=>'#reset','data-toggle'=>'modal'); ?>
    <?php 
    if (!is_null($atts) && count($atts) > 0) {
        echo anchor('#','lupa Password?',array_merge($atts,$arr2));
    } ?>
    <div class="form-group">
    <?php echo form_submit(array('name'=>'login','value'=>'sign in','class'=>'btn btn-success btn-block')); ?>
    <a href="<?php echo current_url().'?r=5';?>" class="btn btn-default btn-block">Sign Up</a>
    </div>
    <?php
    if (isset($_GET['kb'])) { echo form_hidden('kb',$this->encrypt->encode(decrypt_url($_GET['kb'])));}?>
<?php echo form_close(); ?>