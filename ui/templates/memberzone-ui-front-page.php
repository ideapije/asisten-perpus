<span id="imgurl" style="display:none;"><?php echo MEMBERZONE_AST.'images/ajax-loader.gif';?></span>
<div id="container-<?php echo $value['id'];?>">
<table>
			<tr>
				<td width="200" rowspan="5">						
						<a href="<?php echo ($permalink)? $permalink : '#';?>">
							<img src="<?php echo (isset($url_img))? $url_img : MEMBERZONE_AST.'images/default_book_thumbnail.png';?>" alt="<?php echo 'featured image-'.$value['id_uid_book'];?>" style="width:85%;" />
						</a>
					</td>
					<td colspan="2"><h4><?php echo (isset($list_title) && strlen($list_title)>0 )? $list_title : 'Belum ada riwayat booking';?></h4></td>
				</tr>
				
				<tr>
					<td><?php echo (isset($list_time) && strlen($list_time)>0 )? $list_time : 'Hari ini : '.date('Y-m-d h:i:s');?> </td>
					<td colspan="2"><?php echo (isset($list_status) && strlen($list_status)>0 )? $list_status : 'none';?> </td>
				</tr>
				<tr>
					<td colspan="2">
						<p style="color:#000;background:yellow;">
						<?php 

						echo (isset($list_content) && strlen($list_content)>0 )? $list_content : '';?>
						</p>
					</td>
				</tr>
				
				<tr>
					<td colspan="3"><?php echo (isset($list_action) && strlen($list_action)>0 )? $list_action : '';?> </td>
				</tr>
</table>

<div>
