jQuery(document).ready(function(){
	jQuery("#txtboxToFilter", "#nombayar").keydown(function(e) {
				if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					(e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
					(e.keyCode >= 35 && e.keyCode <= 40)) {
					return;
				}
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
	});
	jQuery(document).on('click','.btn-confrim-pay',function(){
		var dashid=$(this).attr('id');
		var imgurl=jQuery('#imgurl').text();
		m_id=jQuery('#noid-'+dashid).val();
		jQuery('#container-'+dashid).html('<img src="'+imgurl +'" />');
		jQuery.ajax({
				url: "admin-post.php?p=1",
				data:{'id':'9','key':m_id },
				type: "POST",
				success:function(data){$('#container-'+dashid).html(data);}
		});
	});
	jQuery(document).on('click','.btn-terima',function(){
		var dashid=$(this).attr('id');		
		var imgurl=jQuery('#imgurl').text();
		jQuery('.thickbox-info').html('<img src="'+imgurl +'" />');
		jQuery.ajax({
			url: "admin-post.php",
			data:{'id':dashid,'memberzone-penawaran-kirim':'diterima','action':'memberzone_penawaran'},
			type:"POST",
			success:function(data){$('.thickbox-info').html(data);}
		});
		//window.location.href="/wp-admin/options-general.php?page=memberzone";
	});
});
jQuery('.link-edit').click(function(){
		var id = jQuery(this).attr('id');
		jQuery('.val-'+id).hide();
		jQuery('#txt-'+id).show();
});
jQuery('.bank-edit').click(function(){
	var id = jQuery(this).attr('id');
	var nb=jQuery('#nb-'+id).text();
	var anb=jQuery('#anb-'+id).text();
	var nor=jQuery('#norek-'+id).text();
	jQuery(".idbank").val(id);jQuery(".nb").val(nb);
	jQuery(".anb").val(anb);jQuery(".norek").val(nor);
	jQuery('#nb-'+id).hide();jQuery('#anb-'+id).hide();jQuery('#norek-'+id).hide();
});
jQuery('.bank-del').click(function(){
	var id = jQuery(this).attr('id');
	var result = confirm("yakin untuk menghapus item ini?");
	if (result) {
		jQuery.ajax({
			url: "admin-post.php",
			data:{'id':id,'tabel':'bank_toko','kolpri':'id','memberzone-penawaran-kirim':'deldata','action':'memberzone_penawaran'},
			type:"POST",
			success:function(data){$('#trow-'+id).html(data);}
		});	
	}
});

jQuery('.reset-img').click(function(){
	var id = jQuery(this).attr('id');
	jQuery.ajax({
			url: "admin-post.php",
			data:{'id_img':id,'del':'y','memberzone-penawaran-kirim':'upload_img','action':'memberzone_penawaran'},
			type:"POST",
			success: function(data) {
				 window.location.href = data;
			}
	});
	//location.reload();
});
jQuery('.input').keypress(function (e) {
	var fsubmit=jQuery('#fsubmit').text();
	if (e.which == 13 ) {
		jQuery('form#'+fsubmit).submit();
		return false;    
	}
});
jQuery(".norek").attr('maxlength','18');
jQuery(".norek").maxlength();