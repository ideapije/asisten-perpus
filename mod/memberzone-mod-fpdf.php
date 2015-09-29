<?php
/**
* 
*/
//include MEMBERZONE_HELP.'pdf/fpdf.php';
class PDF extends FPDF{

	
	
	function umum_quo($data){
		$getmemberops=get_option('memberzone_marketer');
		$header_img=getdata_bykoland_id('gambar','file','id','g1');
		$this->AddPage();
		
		(cekosong($header_img))?  $urlheader=MEMBERZONE_HELP.'pdf/img/header-pdf.png' : $urlheader=$header_img;
		$this->Image($urlheader,8,8,195,27);
		$this->SetXY(13, 35);
		$this->SetFont('Arial','B',15);
		$this->Cell(97,10,'Surat Penawaran',0,0,'L');//
		$this->SetXY(110, 35);
		$this->Cell(87,10,$data['kdquo'],0,0,'L'); 
		
		// identitas
		
		$this->SetXY(13, 46); 
		$this->SetFont('Arial','B',8);
		$this->Cell(30,7.5,'Tanggal',1,1,'L');
		$this->SetXY(13, 53.5); 
		$this->Cell(30,7.5,'No. Surat',1,1,'L');
		$this->SetXY(13,61); 
		$this->Cell(30,7.5,'Kepada',1,1,'L');
		$this->SetXY(13,68.5); 
		$this->Cell(30,15,'',1,1,'L');
		$this->SetXY(13,67.5); 
		$this->MultiCell(13,8,'Alamat',0,'L',false);
		
		//isi identitas
		$this->SetFont('Arial','',8);
		$this->SetXY(43, 46); 
		$this->Cell(65,7.5,$data['tgl'],1,1,'L'); 
		
		$this->SetXY(43, 53.5); 
		$this->MultiCell(65,3.5,$data['noquo'],0,'L',false); 
		$this->SetXY(43, 53.5); 
		$this->Cell(65,7.5,'',1,1,'L');
		$this->SetXY(43,61); 
		$this->MultiCell(65,3.5,$data['penerima'],0,'L',false); 
		$this->SetXY(43,61); 
		$this->Cell(65,7.5,'',1,1,'L');
		$this->SetXY(43,68.5); 
		$this->Cell(65,15,'',1,1,'L');
		$this->SetXY(43,67.5); 
		$this->MultiCell(65,5,$data['acus'],0,'L',false); 
		
		
		// identitas 2
		
		$this->SetXY(110, 46); 
		$this->SetFont('Arial','B',8);
		$this->Cell(30,7.5,'Attendance',1,1,'L');
		$this->SetXY(110, 53.5); 
		$this->Cell(30,7.5,'Cc',1,1,'L');
		$this->SetXY(110,61); 
		$this->Cell(30,7.5,'Telp./HP',1,1,'L');
		$this->SetXY(110,68.5); 
		$this->Cell(30,7.5,'Email',1,1,'L');
		$this->SetXY(110,76); 
		$this->Cell(30,7.5,'Ref',1,1,'L');
		
		//isi identitas 2
		$this->SetFont('Arial','',8);
		$this->SetXY(140, 46); 
		$this->Cell(57,7.5,$data['attn'],1,1,'L');
		$this->SetXY(140, 53.5); 
		$this->Cell(57,7.5,$data['cc'],1,1,'L'); 
		$this->SetXY(140,61); 
		$this->Cell(57,7.5,$data['telp'],1,1,'L'); 
		$this->SetXY(140,68.5); 
		$this->Cell(57,7.5,$data['email'],1,1,'L');
		$this->SetXY(140,76); 
		$this->Cell(57,7.5,'Ref',1,1,'L');
		
		$this->SetXY(12,83);
		$this->SetFont('Arial','',11);
		$this->Cell(100,8,'Berikut ini penawaran yang kami ajukan',0,0,'L');
		
		//produk
		$this->SetFont('Arial','B',10);
		//header tabel produk
			$this->SetXY(13, 90); 
			$this->MultiCell(87,8,'Product',1,'L',false);
			$this->SetXY(100, 90); 
			$this->Cell(12,8,'Qty',1,1,'C');
			$this->SetXY(112, 90); 
			$this->Cell(40,8,'price',1,1,'C');
			$this->SetXY(152, 90); 
			$this->Cell(45,8,'Amount',1,1,'C');
		//isi barang
		$this->SetXY(13, 98); 
		$this->SetFont('Arial','',10);
		$this->MultiCell(85,6,$data['produk'],0,'L',false);
		$this->SetXY(13, 98); 
		$this->Cell(87,20,'',1,1,'C');
		$this->SetXY(100, 98); 
		$this->Cell(12,20,$data['qty'],1,1,'C');
		$this->SetXY(112, 98); 
		$this->Cell(40,20,$data['price'],1,1,'C');
		$this->SetXY(152, 98); 
		$this->Cell(45,20,$data['subtotal'],1,1,'C');
		$this->SetXY(13, 118); 
		$this->Cell(139,8,'Grand Total',1,1,'L');
		$this->SetXY(152, 118); 
		$this->Cell(45,8,'Rp '.$data['subtotal'],1,1,'C'); 
		$this->Ln(20);
		$this->SetXY(13, 130); 
		$this->SetFont('Arial','B',12);
		$this->MultiCell(100,6,'Discont : '.$data['disc'],0,'L',false);

		//keterangan
		$this->SetXY(13, 145); 
		$this->SetFont('Arial','B',12);
		$this->Cell(100,6,'Keterangan opsional',0,L);
		
		
		$this->SetXY(13, 155); 
		$this->SetFont('Arial','',10);
		$this->Cell(90,50,'',0,L);
		$this->SetXY(13, 155); 
		$this->MultiCell(90,6,$data['opsional'],0,'L',false); 
		
		//Catatan
		$this->SetXY(106, 145); 
		$this->SetFont('Arial','B',12);
		$this->Cell(100,6,'Catatan Produk',0,L);
				
		$this->SetXY(106, 155); 
		$this->SetFont('Arial','',10);
		$this->Cell(90,50,'',0,L);
		$this->SetXY(108, 155); 
		$this->MultiCell(100,6,$data['notebrg'],0,'L',false);

		//salam
		$this->SetXY(145, 210); 
		$this->SetFont('Arial','B',12);
		$this->Cell(50,8,'Terima kasih',0,C);
		// nama Perusahaan
		$this->SetXY(106, 218); 
		$this->SetFont('Arial','',12);
		(cekosong($getmemberops['toko_nama']))? $namatoko='Cv Java Multi Mandiri' : $namatoko=$getmemberops['toko_nama'];
		$this->MultiCell(90,8,$namatoko,0,'R',false);
		$this->SetXY(106, 226);
		$ttd_img=getdata_bykoland_id('gambar','file','id','g4');
		(cekosong($cap_img))? $toko_ttd=MEMBERZONE_HELP.'pdf/img/ttd.jpg' : $toko_ttd=$cap_img; 
		$this->Image($toko_ttd,155,230,23,15);
		// logo
		$cap_img=getdata_bykoland_id('gambar','file','id','g2');
		(cekosong($cap_img))? $toko_cap=MEMBERZONE_HELP.'pdf/img/jadi.jpg' : $toko_cap=$cap_img;
		$this->Image($toko_cap,120,226,35,35);
		//$cetak=MEMBERZONE_ATTC_PDF.'quo/Quotation-'.$data['noquo'].'.pdf';
		$newdir=$_SERVER["DOCUMENT_ROOT"].'/pdf/quo/';
		if (file_exists($newdir)){
			$cetak=$newdir.'Quotation-'.$data['noquo'].'.pdf';
			if (file_exists($cetak)) {
				$this->Output();
			}else{
				$this->Output($cetak,'F');	
				ob_start();
            	include MEMBERZONE_UI . 'email/memberzone-ui-penawaran-email-quo.php';
            	$msg = ob_get_clean();
            	send_mail_attc(                            
                	$data['email'], 
                	$min_email, 
                	$mimin->user_login, 
                	'Penawaran-'.$data['produk'].'-No.'.$data['noquo'], 
                	$msg, 
                	$cetak
            	);
            	wp_redirect(admin_url());
            	exit;
			}
		}else{
			mkdir($newdir,0700,true);
		}
	}
	function umum_inv($data){
		$getmemberops=get_option('memberzone_marketer');
		$get_stspay=getpay($data['id'].'-'.$data['noquo'],'status');
		$quodata=get_list_quoby_id($data['id'],true);
		
		if ($quodata['subtotal']==$data['subtotal']){
			$disc=$data['disc'];
			$notebrg =$data['notebrg'];
		}else{
			$darisaldo=intval($quodata['subtotal']-$data['subtotal']);
			$notebrg ='Total Tagihan sebelumnya : '."\r\n";
			$notebrg .='Rp '.$data['price'].' X '.$data['qty'].' = Rp '.$quodata['subtotal'].",-\r\n";
			$notebrg .='Setelah di potong dengan saldo menjadi : '."\r\n Rp ".$quodata['subtotal'].' - Rp '.$darisaldo.' = Rp '.$data['subtotal'].',-';
			$disc='pengambilan saldo Rp'.$darisaldo; 
		}
		
		($get_stspay==6 || $get_stspay==8)? $paystat='PAID' : $paystat='UNPAID';
		$this->AddPage();
		$logo_img=getdata_bykoland_id('gambar','file','id','g3');
		(cekosong($logo_img))? $toko_logo=MEMBERZONE_HELP.'pdf/img/ajav.jpg' : $toko_logo=$logo_img;
		$this->Image($toko_logo,13,10,20,20);
		$this->SetXY(175,18);
		$this->SetFont('Arial','B',24);
		$this->Cell(25,10,'INVOICE',0,0,'R');
		$this->Line(13,32,200,32);
		$this->SetXY(13,34); 
		$this->SetFont('Arial','B',10);
		(cekosong($getmemberops['toko_nama']))? $namatoko='Cv Java Multi Mandiri' : $namatoko=$getmemberops['toko_nama'];
		$this->MultiCell(65,5,$namatoko,0,'L',false);// nama toko
		$this->SetXY(13,44); 
		$this->SetFont('Arial','',10);
		(cekosong($getmemberops['toko_alamat']))? $address="jl. Raya Baturaden Timur KM 7 No. 17\r\nPurwokerto-Jawa Tengah-Indonesia, 53100" : $address=$getmemberops['toko_alamat'];
		$this->MultiCell(75,5,$address,0,'L',false); //alamat
		$this->SetXY(13,60); 
		
		$this->SetXY(13,60);
		$this->Cell(50,3,'PHONE',0,0,'L');
		$this->SetX(30);
		$this->Cell(45,3,' : ',0,0,'L');
		$this->SetX(32);
		(cekosong($getmemberops['toko_notelp']))? $notelp=' 62-281-5755222' : $notelp=$getmemberops['toko_notelp'];
		$this->Cell(50,3,$notelp,0,0,'L');
		$this->SetXY(13,65);
		$this->Cell(50,3,'FAKS',0,0,'L');
		$this->SetX(30);	
		$this->Cell(45,3,' : ',0,0,'L');
		$this->SetX(32);
		(cekosong($getmemberops['toko_fax']))? $tokofax='62-281-6572606' : $tokofax=$getmemberops['toko_fax'];
		$this->Cell(50,3,$tokofax,0,0,'L');
		$this->SetXY(13,70);
		$this->Cell(50,3,'HP',0,0,'L');
		$this->SetX(30);	
		$this->Cell(45,3,' : ',0,0,'L');
		$this->SetX(32);
		(cekosong($getmemberops['person_hp']))? $person_hp='085291771888' : $person_hp=$getmemberops['person_hp'];
		$this->Cell(50,3,$person_hp,0,0,'L');
		$this->SetXY(13,75);
		$this->Cell(50,3,'EMAIL',0,0,'L');
		$this->SetX(30);	
		$this->Cell(45,3,' : ',0,0,'L');
		$this->SetX(32);
		(cekosong($getmemberops['toko_email']))? $tokoemail='info@jvm.co.id' : $tokoemail=$getmemberops['toko_email'];
		$this->Cell(50,3,$tokoemail,0,0,'L');
		$this->SetXY(110,32); 
		$this->SetFont('Arial','B',10);
		$this->Cell(12,8,'STATUS',0,1,'L');
		$this->SetXY(145,32); 
		$this->Cell(12,8,':',0,1,'L');
		$this->SetXY(150,32); 
		$this->SetFont('Arial','',10);
		$this->Cell(12,8,$paystat,0,1,'L');
		//
		$this->SetXY(110,36); 
		$this->SetFont('Arial','B',10);
		$this->Cell(12,8,'DATE',0,1,'L');
		$this->SetXY(145,36); 
		$this->Cell(12,8,':',0,1,'L');
		$this->SetXY(150,36); 
		$this->SetFont('Arial','',10);
		$this->Cell(12,8,$data['tgl'],0,1,'L');		
		
		$this->SetXY(110,40); 
		$this->SetFont('Arial','B',10);
		$this->Cell(12,8,'PAYMENT METHOD',0,1,'L');
		$this->SetXY(145,40); 
		$this->Cell(12,8,':',0,1,'L');
		$this->SetXY(150,40); 
		$this->SetFont('Arial','',10);
		$this->Cell(12,8,'Bank PAYMENT',0,1,'L');		
		
		$this->SetXY(110,44); 
		$this->SetFont('Arial','B',10);
		$this->Cell(12,8,'SHIPING METHOD',0,1,'L');
		$this->SetXY(145,44); 
		$this->Cell(12,8,':',0,1,'L');
		$this->SetXY(150,44); 
		$this->SetFont('Arial','',10);
		$this->Cell(12,8,'JNE',0,1,'L');		
		
		$this->SetXY(110,58); 
		$this->SetFont('Arial','B',10);
		$this->Cell(12,8,'PAYMENT STATUS',0,1,'L');
		$this->SetXY(145,58); 
		$this->Cell(12,8,':',0,1,'L');
		$this->SetXY(150,58); 
		$this->SetFont('Arial','',10);
		
		$this->Cell(12,8,$paystat,0,1,'L');		
		
		$this->SetXY(110,63); 
		$this->SetFont('Arial','B',10);
		$this->Cell(12,8,'NOTE PAYMENT',0,1,'L');
		$this->SetXY(145,63); 
		$this->Cell(12,8,':',0,1,'L');
		$this->SetXY(150,63); 
		$this->SetFont('Arial','',10);
		$this->Cell(12,8,$paystat,0,1,'L');		
		
		//data alamat
		$this->SetXY(13,80); 
		$this->SetFont('Arial','B',10);
		$this->Cell(12,8,'Alamat Pribadi',0,1,'L');
		$this->SetXY(13,85); 
		$this->SetFont('Arial','',10);
		$this->Cell(12,8,$data['ancus'],0,1,'L');
		$this->SetXY(13,90); 
		$this->MultiCell(60,5,$data['acus'],0,'L',false); //alamat
		$this->SetXY(13,115); 
		$this->Cell(12,8,$data['telpacus'],0,1,'L');
		
		$this->SetXY(73,80); 
		$this->SetFont('Arial','B',10);
		$this->Cell(12,8,'Alamat Penagihan',0,1,'L');
		$this->SetXY(73,85); 
		$this->SetFont('Arial','',10);
		$this->Cell(12,8,$data['anbil'],0,1,'L');
		$this->SetXY(73,90); 
		$this->MultiCell(60,5,$data['alamat_bill'],0,'L',false); //alamat
		$this->SetXY(73,115); 
		$this->Cell(12,8,$data['telpabil'],0,1,'L');
		
		$this->SetXY(133,80); 
		$this->SetFont('Arial','B',10);
		$this->Cell(12,8,'Alamat Pengiriman',0,1,'L');
		$this->SetXY(133,85); 
		$this->SetFont('Arial','',10);
		$this->Cell(12,8,$data['anship'],0,1,'L');
		$this->SetXY(133,90); 
		$this->MultiCell(60,5,$data['alamat_ship'],0,'L',false); //alamat
		$this->SetXY(133,115); 
		$this->Cell(12,8,$data['telpaship'],0,1,'L');
		
		//produk
			$this->SetXY(13, 130); 
			$this->SetFont('Arial','B',10); //header tabel produk
			$this->SetXY(13,130); 
			$this->MultiCell(87,8,'Product',1,'L',false);
			$this->SetXY(100, 130); 
			$this->Cell(12,8,'Qty',1,1,'C');
			$this->SetXY(112,130); 
			$this->Cell(40,8,'price',1,1,'C');
			$this->SetXY(152,130); 
			$this->Cell(45,8,'Amount',1,1,'C');
		//isi barang
		$this->SetXY(13, 138); 
		$this->SetFont('Arial','',10);
		$text=$data['produk'];
		$this->MultiCell(85,6,$text,0,'L',false);
		$this->SetXY(13, 138); 
		$this->Cell(87,20,'',1,1,'C');
		$this->SetXY(100, 138); 
		$this->Cell(12,20,$data['qty'],1,1,'C');
		$this->SetXY(112, 138); 
		$this->Cell(40,20,$data['price'],1,1,'C');
		$this->SetXY(152,138); 
		$this->Cell(45,20,$data['subtotal'],1,1,'C');
		$this->SetXY(13, 158); 
		$this->Cell(139,8,'Grand Total',1,1,'L');
		
		//total
		$this->SetXY(152,158); 
		$this->Cell(45,8,'Rp '.$data['subtotal'],1,1,'C');
		$this->Ln(20);
		$this->SetXY(13, 170); 
		$this->SetFont('Arial','B',12);
		
		
		$this->MultiCell(100,6,'Discont : '.$disc,0,'L',false);

		//bank information
		$this->SetXY(13, 178); 
		$this->SetFont('Arial','B',12);
		$this->Cell(139,8,'Informasi Rekening Bank',0,1,'L');
		$this->SetXY(13, 186); 
		$this->Cell(60,5,'Bank',0,1,'L');
		$this->SetXY(73, 186); 
		$this->Cell(60,5,'No.Rekening',0,1,'L');
		$this->SetXY(133, 186); 
		$this->Cell(60,5,'Atas Nama',0,1,'L');
		$this->SetFont('Arial','',12);
		
		//bank larik
		$kolbank=get_list_fields('bank_toko');
		$bank=get_data_table('bank_toko',$kolbank,false,false);
		$yy=193;
		if ($bank && count($bank) > 0) {
			foreach($bank as $key => $value) {
				$this->SetXY(13, $yy); 
				$this->Cell(60,5,$value['bank_nama'],0,1,'L');
				$this->SetXY(73, $yy); 
				$this->Cell(60,5,$value['bank_norek'],0,1,'L');
				$this->SetXY(133, $yy); 
				$this->Cell(60,5,$value['bank_an'],0,1,'L');
				$yy=$yy+6;
			}
		}else{
			$this->SetXY(13, $yy); 
			$this->Cell(60,5,'Akun bank pemilik toko belum tersedia',0,1,'L');
		}
		
		//catatan
		$this->SetXY(13, 230); 
		$this->SetFont('Arial','B',12);
		$this->Cell(50,8,'Catatan Produk:',0,C);
		$this->SetXY(13, 240); 
		$this->SetFont('Arial','',10);
		
			
		$this->MultiCell(100,6,$notebrg,0,'L',false);
		
		//salam
		$this->SetXY(145, 230); 
		$this->SetFont('Arial','B',12);
		$this->Cell(50,8,'Terima kasih',0,C);
		// nama Perusahaan
		$this->SetXY(106, 238); 
		$this->SetFont('Arial','',12);
		$this->MultiCell(90,8,$namatoko,0,'R',false);
		$this->SetXY(106, 245); 
		
		// logo
		$cap_img=getdata_bykoland_id('gambar','file','id','g2');
		(cekosong($cap_img))? $toko_cap=MEMBERZONE_HELP.'pdf/img/jadi.jpg' : $toko_cap=$cap_img;
		$this->Image($toko_cap,120,245,35,35);
		//
		$newdir=$_SERVER["DOCUMENT_ROOT"].'/pdf/inv/';
		if (file_exists($newdir)){
			$cetak=$newdir.'Invoice-'.$data['noquo'].'.pdf';
			if (file_exists($cetak)) {
				$this->Output();
			}else{
				$this->Output($cetak,'F');	
				ob_start();
            	include MEMBERZONE_UI . 'email/memberzone-ui-penawaran-email-quo.php';
            	$msg = ob_get_clean();
            	send_mail_attc(                            
                	$data['email'], 
                	$min_email, 
                	$mimin->user_login, 
                	'Penawaran-'.$data['produk'].'-No.'.$data['noquo'], 
                	$msg, 
                	$cetak
            	);
            	wp_redirect(admin_url());
            	exit;
			}
		}else{
			mkdir($newdir,0700,true);
		}
	}

}
