jQuery(document).ready(function () {

	jQuery(document).on('keydown','input[type=number]',function(e){
        // Allow: backspace, delete, tab, escape, enter and .
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
	jQuery(document).on('click','.btn-act',function(){
		var m_id =jQuery(this).closest('td').find('.meta_id').text();
		var act=jQuery(this).attr('name');
		jQuery.ajax({
				url: "admin-post.php?p=1",
				data:{'id':act,'key':m_id},
				type: "POST",
				success:function(data){jQuery('#page-content').html(data);}
		});
	});
	
	/*   ---------------------------------------------------- awal buat opsional ------------------------------------------------*/

	jQuery(document).on('click','.btn-insert',function(){
		var data={ 
			'meta_label' : jQuery('.meta_label').val()
			,'meta_type' : jQuery('.meta_type').val()
			,'meta_max_val' : jQuery('.meta_max_val').val()
			,'meta_opsional' : jQuery('.meta_opsional').is(':checked')
			,'action' : 'memberzone_penawaran'
			,'memberzone-penawaran-kirim' : 'insertdata'
			,'tabel':'custom_meta_key'
			,'permalink' : jQuery('.permalink').attr('href')
		};
		jQuery.ajax({
				url: "admin-post.php",
				data: data,
				type: "POST",
				success:function(data){
					window.location.href=data;
				}
		});
	});
	
	jQuery(document).on('click','.addval',function(){
		var btnini=jQuery(this).attr('name');
		jQuery("#txt-"+btnini).show();
		jQuery("#btn-" + btnini).show();
    	jQuery("#ad-"+btnini).hide();
	});

	jQuery(document).on('click','.btn-save-opt',function(){
		var str = jQuery(this).attr("id");
		var txtval =str.substr(4);
		var data={
			'action' : 'memberzone_penawaran'
			,'memberzone-penawaran-kirim' : 'insertdata'
			,'tabel':'opsional_meta_key'
			,'permalink': jQuery('#kemburl').text()
			,'opsional': jQuery('#txt-'+txtval).val()
			,'meta_key': txtval 
			,'post_id' : jQuery('#post_id').text()
		};
		jQuery.ajax({
			url: "admin-post.php",
			data:data,
			type:"POST",
			success: function(data) {
				 window.location.href = data;
			}
		});
	});

	jQuery(document).on('click','.btn-del-opt',function(){
		var id=jQuery(this).attr('id');
		var result = confirm("yakin untuk menghapus item ini?");
		if(result){
			var data={
				'action' : 'memberzone_penawaran'
				,'memberzone-penawaran-kirim' : 'deletedata'
				,'tabel':'custom_meta_key'
				,'permalink': jQuery('#kemburl').text()
				,'kolid':'id'
				,'id':id
			};
			jQuery.ajax({
				url: "admin-post.php",
				data:data,
				type:"POST",
				success: function(data) {
					window.location.href = data;
				}
			});
		}
	});


	jQuery(document).on('click','.btn-edit-metabox',function(){
		var id = jQuery(this).attr('id');
		var mt=jQuery('.p-mt-'+id).text();
		var ml=jQuery('.p-ml-'+id).text();
		var mmx=jQuery('.p-mmx-'+id).text();
		jQuery('.ml-'+id).attr('style','display:block;');
		jQuery('.mt-'+id).attr('style','display:block;');
		jQuery('.mmx-'+id).attr('style','display:block;');
		jQuery('.btn-'+id).attr('style','display:block;');


		jQuery('.p-ml-'+id).attr('style','display:none;');
		jQuery('.p-mt-'+id).attr('style','display:none;');
		jQuery('.p-mmx-'+id).attr('style','display:none;');
		jQuery('.p-mo-'+id).attr('style','display:none;');

		jQuery('.ml-'+id).val(ml);
		jQuery('.mt-'+id).val(mt);
		jQuery('.mmx-'+id).val(mmx);
		jQuery('.mo-'+id).attr('style','display:block;');
		jQuery(this).attr('style','display:none;');


	});
	jQuery(document).on('click','.btn-upd-metabox',function(){
		var permalink=jQuery('.grouptxt').text();
		var id = jQuery(this).attr('id');
		var data={
			'action' : 'memberzone_penawaran'
			,'memberzone-penawaran-kirim' : 'perbaharui'
			,'tabel':'custom_meta_key'
			,'permalink': permalink
			,'kolid':'id'
			,'id':id
			,'meta_label': jQuery('.ml-'+id).val()
			,'meta_type': jQuery('.mt-'+id).val()
			,'meta_max_val' : jQuery('.mmx-'+id).val()
			,'meta_opsional' : jQuery('.mo-'+id).is(':checked')
		};
		jQuery.ajax({
			url: "admin-post.php",
			data:data,
			type:"POST",
			success: function(data) {
				window.location.href = data;
			}
		});
	});
	
/*   ---------------------------------------------------- akhir buat opsional ------------------------------------------------*/

	jQuery(document).on('click','.link-edit',function(){
		var id = jQuery(this).attr('id');
		jQuery('.val-'+id).hide();
		jQuery('#txt-'+id).show();
	});

	jQuery(document).on('keydown','.maxval',function(){
		jQuery(".norek").maxlength();
	});	
	
	
	jQuery(document).on('keypress','.input',function(e){
		var fsubmit=jQuery('#fsubmit').text();
		if (e.which == 13 ) {
			jQuery('form#'+fsubmit).submit();
			return false;    
		}
	});
	
	jQuery(document).on('click','.btn-acc-booking',function(){
		var id=jQuery(this).attr('id');
		var send_id=jQuery('#ak'+id+'si').text();
		var result = confirm("Anda yakin? menyetujui permintaan ini");
		var data={
			'action':'memberzone_penawaran'
			,'memberzone-penawaran-kirim':'perbaharui'
			,'tabel':'perpus_booking'
			,'kolid':'id'
			,'id':send_id
			,'booking_status':2
			,'permalink':'admin.php?page=list-booking-page'
		};
		if(result){
			jQuery.ajax({
				url: "admin-post.php",
				data:data,
				type:"POST",
				success: function(data) {	
					window.location.href = data;
				}
			});
		}
	});	


	jQuery(document).on('change','.slc-jenis-uid',function(){
		var id=jQuery(this).val();
		if (id!=='0') {
			var data={
				'action':'memberzone_penawaran'
				,'memberzone-penawaran-kirim':'get_idlinked_rfid'
				,'jenis':id
			};

			jQuery('.show-id-linked').find('option').remove().end();
			jQuery.ajax({
					url: "admin-post.php",
					data:data,
					type:"POST",
					dataType:'json',
					success: function(data){
        				$.each(data, function(key, value){
        					$('.show-id-linked').append($("<option></option>").attr("value",value.ID).text(value.isi));
        				});
					}		
			});	
		};
	});	
	jQuery(document).on('click','.btn-create-rfid',function(){
		var pilihjenis =jQuery('.slc-jenis-uid').val();
		if (pilihjenis=='0') {
			alert('silahkan pilih jenis rfid terlebih dahulu');
		}else{
			var data={
				'action':'memberzone_penawaran'
				,'memberzone-penawaran-kirim':'insertdata'
				,'tabel':'uid_book'
				,'uid':jQuery('.uid').val()
				,'type_uid':jQuery('.slc-jenis-uid').val()
				,'id_link_uid':jQuery('.show-id-linked').val()
				,'permalink':'admin.php?page=rfid-page'
			};
			jQuery.ajax({
					url: "admin-post.php",
					data:data,
					type:"POST",
					success: function(data){
        				window.location.href = data;		
					}		
			});					
		};
	});	
	jQuery(document).on('keyup','.keydown-book',function(){
			if (str.length == 0) { 
            	document.getElementById("txtHprod").innerHTML = "";
            	return;
            } else {
            	var xmlhttp = new XMLHttpRequest();
            	xmlhttp.onreadystatechange = function() {
            		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            			document.getElementById("txtHprod").innerHTML = xmlhttp.responseText;
            		}
            }
            xmlhttp.open("GET", window.location.origin+"/toko/gudang/getproduk?p="+str, true);
            xmlhttp.send();
        }
	});	

	jQuery(document).on('click','.btn-submit-recieved',function(){
		var id = jQuery(this).attr('id');
		var uid=jQuery('.txt'+id+'uid').val();
		var data={
				'action':'memberzone_penawaran'
				,'memberzone-penawaran-kirim':'cekpinjam'
				,'uid':uid
		};
		jQuery.ajax({
					url: "admin-post.php",
					data:data,
					type:"POST",
					success: function(data){
        				window.location.href = data;		
					}		
		});
	});	
	jQuery(document).on('click','.btn-confrim-return',function(){
		var id=jQuery(this).attr('id');
		var data={
				'action':'memberzone_penawaran'
				,'memberzone-penawaran-kirim':'cekembali'
				,'id_peminjaman':id
		};
		jQuery.ajax({
					url: "admin-post.php",
					data:data,
					type:"POST",
					success: function(data){
        				window.location.href = data;		
					}		
		});
	});
	jQuery(document).on('click','.btn-recieved-return-book',function(){
		var id=jQuery(this).attr('id');
		var data={
				'action':'memberzone_penawaran'
				,'memberzone-penawaran-kirim':'insertdata'
				,'tabel':'log_kembalian'
				,'id_peminjaman':id
				,'permalink':'admin.php?page=list-booking-page'
		};
		var result = confirm("yakin anda sudah menerima pengembalian buku ini?");
		if (result){
			jQuery.ajax({
					url: "admin-post.php",
					data:data,
					type:"POST",
					success: function(data){
        				window.location.href = data;		
					}		
			});
		};
	});

});	
