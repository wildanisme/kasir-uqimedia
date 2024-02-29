<!DOCTYPE html>
<html>
	<head>
		<title>Invoice Order #<?=$cetak->id_transaksi;?></title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- Tell the browser to be responsive to screen width -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Percetakan & Digital Printing" />
		<meta name="keywords" content="cetak spanduk, cetak buku tulis murah, buku tulis, percetakan serang, percetakan pandeglang, percetakan labuan, percetakan rangkasbitung, undangan blangko murah,percetakan terbaik di serang, digital printing di banten, percetakan di banten, spanduk banner serang" />
		<meta name="author" content="Munajat Ibnu">
		<!-- Favicon icon -->
		<link rel="icon" type="image/png" sizes="16x16" href="<?=$favicon;?>">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<style>
			
			body{
			background-color:#EFF8FF; 
			font-size: <?=$font_size;?>pt;
			-webkit-print-color-adjust:exact !important;
			print-color-adjust:exact !important;
			color-adjust: exact;
			}
			h1, p{
			margin:0px;  
			}
			.main-section{
			background-color: #FFF;
			border: 2px dotted #ffffff;
			}
			.header{
			background-color: #ff;
			padding:10px 15px 10px 15px ;  
			color:#000000;
			border-bottom:2px dotted #000
			}
			.content{
			padding:10px 15px 10px 15px;
			}
			th{
			background-color: #ffffff;
			color: #000000;  
			text-align: right;
			}
			.table td:nth-child(1),
			.table th:nth-child(1){
			text-align:left; 
			}
			.lastSection{
			padding: 20px 15px 30px 15px;
			}
			.thumbnail {
			position: absolute;
			border: 0!important;
			z-index:1;
			right: 30%;
			opacity:0.7;
			}
			.border-top-0{border: 0px!important}
			.border-bottom-0{border: 0px!important}
			.text-center{text-align:center!important}
			.text-left{text-align:left!important}
			blockquote {
			padding: 10px 10px;
			margin: 0 0 10px;
			font-size: 17.5px;
			border-left: 5px solid #eee;
			}
			address {
			margin-bottom: 0;
			font-style: normal;
			line-height: 1.42857143;
			}
			.table {
			margin-bottom: 5px;
			}
			.table > thead > tr > th {
			vertical-align: bottom;
			border-bottom: 2px dotted #000;
			}
			.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
			border-top: 1.5px dotted #000;
			}
			.col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
			position: relative;
			min-height: 1px;
			padding-right: 10px;
			padding-left: 10px;
			}
			.p-1{padding-right: 5px;padding-left: 5px;}
			.p-2{padding-right: 10px;padding-left: 10px;}
			@media print {
			body {
			-webkit-filter: grayscale(100%);
			-moz-filter: grayscale(100%);
			-ms-filter: grayscale(100%);
			filter: grayscale(100%);
			}
			img {
			-webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
			filter: grayscale(100%);
			}
			}
			img {
			-webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
			filter: grayscale(100%);
			}
			.qrcode{position:absolute;right:30px;top:-20px}
		</style>
		
	</head>
	<body>
		<?php 
			$coun = count($detail); 
			$top = 0;
			if($coun==2){
				$top = '8cm';
				}elseif($coun==3){
				$top = '7cm';
				}elseif($coun==4){
				$top = '8cm';
				}elseif($coun==5){
				$top = '9cm';
				}elseif($coun==6){
				$top = '10cm';
				}elseif($coun==7){
				$top = '11cm';
				}elseif($coun==8){
				$top = '12cm';
				}elseif($coun==9){
				$top = '9cm';
				}elseif($coun==10){
				$top = '10cm';
				}elseif($coun==11){
				$top = '11cm';
				}elseif($coun==12){
				$top = '12cm';
				}else{
				$top = '6cm';
			}
			
			if($konsumen['no_hp']=='-'){
				$no_hp = '-';
				}else{
				$no_hp = hp_1(hp_2($konsumen['no_hp']));
			}
			if($tdetail == $total->total AND $pajak==0){
				
				$stamp  = $lunas;
				$alt    = '';
				$logo   = $logo_lunas;
				$color  = $info['warna_lunas'];
				$_waicon = $waicon['color'];
				$_mail   = $mail['color'];
				$_fbicon = $fbicon['color'];
				$_igicon = $igicon['color'];
				
				}elseif($tdetail == $total->total AND $pajak>0){
				$stamp = $lunas;
				$alt = '';
				$logo = $logo_lunas;
				$color = $info['warna_lunas'];
				$_waicon = $waicon['color'];
				$_mail   = $mail['color'];
				$_fbicon = $fbicon['color'];
				$_igicon = $igicon['color'];
				}elseif($tdetail != $total->total AND $pajak==0){
				$stamp = $blunas;
				$alt = '';
				$logo = $logo_blunas;
				$color = $info['warna_blunas'];
				$_waicon = $waicon['bw'];
				$_mail   = $mail['bw'];
				$_fbicon = $fbicon['bw'];
				$_igicon = $igicon['bw'];
				}elseif($tdetail != $total->total AND $pajak>0){
				$stamp = $blunas;
				$alt = '';
				$logo = $logo_blunas;
				$color = $info['warna_blunas'];
				$_waicon = $waicon['bw'];
				$_mail   = $mail['bw'];
				$_fbicon = $fbicon['bw'];
				$_igicon = $igicon['bw'];
				}else{
				$stamp = $blunas;
				$alt = '';
				$logo = $logo_blunas;
				$color = $info['warna_blunas'];
				$_waicon = $waicon['bw'];
				$_mail   = $mail['bw'];
				$_fbicon = $fbicon['bw'];
				$_igicon = $igicon['bw'];
			}
			if($cetak->status=='batal'){
				$stamp = '';
				$alt = 'BATAL';
				$color = "#333";
				$_waicon = $waicon['bw'];
				$_mail   = $mail['bw'];
				$_fbicon = $fbicon['bw'];
				$_igicon = $igicon['bw'];
			}
 			$deskripsi = base64_decode($info['deskripsi']);
			$deskripsi = cleanString($deskripsi);
			$wa = $email = $_fb = $fb ='';
			if($info['phone']!='-'){
				$_wa = '<img src="'.$_waicon.'" alt="" height="10" />';
				$wa = $info['phone'];
			}
			if($info['email']!='-'){
				$_email = '<img src="'.$_mail.'" alt="" height="10" />';
				$email = $info['email'];
			}
			
			if($info['fb']!='-'){
				$_fb = '<img src="'.$_fbicon.'" alt="" height="10" />';
				$fb = $info['fb'];
			}
			
			$_ig ='';$ig ='';
			if($info['ig']!='-'){
				$_ig = '<img src="'.$_igicon.'" alt="" height="10" />';
				$ig = $info['ig'];
			}
			if($konsumen['tampil']==1){
				$nama = $konsumen['perusahaan'];
				$perusahaan = cek_jenis_lembaga($konsumen['jenis']);
				$telp = $konsumen['no_telp'];
				$alamat = $konsumen['alamat_lembaga'];
				}else{
				$nama = $konsumen['nama'];
				$perusahaan = cek_jenis_lembaga($konsumen['jenis']);
				$telp = $konsumen['no_hp'];
				$alamat = $konsumen['alamat'];
			}
		?>
		<div class="container">
			<div class="row">
				<div class="col-md-5 col-sm-5 col-md-offset-3">
					<div class="row main-section">
						<div class="col-md-12 col-sm-12 header text-center">
							<h1><img src="<?=$logo;?>" width="75%" alt="" /></h1>
						</div>
						
						<div class="col-md-12 col-sm-12 content text-center">
							
							<p><?=$info['title'];?></p>
							<p><?=$deskripsi;?></p>
							<p><span class="sosmed"><?=$wa;?></span></p>
							
						</div>
						 
						<div class="col-md-6 col-sm-6 col-xs-6 text-left">
							<p>Invoice #<?=$cetak->id_transaksi;?></p>
							<span>Tgl. Order : <?=date('d/m/Y',strtotime($cetak->tgl_trx));?></span>
							<span>Tgl. Ambil : <?=date('d/m/Y',strtotime($cetak->tgl_ambil));?></span>
							<p>Kepada : <?=$nama;?></p>
							<p>Tlp. : <?=$telp;?></p>
						</div>
						
						<div class="col-md-6 col-sm-6">
							<div class="qrcode" style="width:80px; height:80px;">
								<img src="<?=base_url();?>uploads/qrcode/qris.png" alt="" style="width:100px; height:100px;" />
							</div>
						</div>
						
						<div class="col-md-12 col-sm-12 text-right">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th class="text-left">Produk</th>
											<th class="text-right">Qty</th>
											<th class="text-right">Harga</th>
											<th class="text-right">Total</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no=1; 
											$totalb=0; 
											$subtotal=0; 
											$sisa=0; 
											$diskon=0; 
											$grandtotal=0; 
											$finishing ='';
											foreach($detail  AS $val){
												$diskon = $val['jumlah'] * $val['harga'] * $val['diskon']/100;
												$totalb = $val['jumlah'] * $val['harga'] - $diskon;
												$subtotal += $totalb;
												if(!empty($val['detail'])){
													$finishing = json_decode($val['detail']);
												}
												$produk = $val['title'];
												if(!empty($val['short_title'])){
													$produk = $val['short_title'];
												}
											?>
											
											<tr>
												<td class="text-left"><?=$produk;?></td>
												<td class="text-right"><?=$val['jumlah'];?></td>
												<td class="text-right"><?=rp($val['harga']);?></td>
												<td class="text-right"><?=rp($totalb);?></td>
											</tr>
											<tr>
												<td colspan="5">
													Uk.: <?=$val['ukuran'];?> | Bhn.: <?=$val['nbahan'];?>
												</td>
											</tr>
											<?php $no++; 
												$grandtotal += $totalb;
											} 
											$pajak = ($subtotal * $cetak->pajak) /100;
											$sisa = $pajak + $subtotal - $total->total;
											$cek_bayar = $pajak + $subtotal;
										?>
									</tbody>
								</table>
							</div>
						</div>
						<?php
							$ketbyr = "";
							if($alt=='BATAL'){
								$ketbyr = "ORDER BATAL";
								}else{
								
								if($total->total!=0){ 
									if(isset($cara)){ 
										$ketbyr = 'CARA BAYAR :' .strtoupper($cara->nama_bayar);
									}
									}else{
									$ketbyr = "Piutang";
								}
							} 
							
							$jml_bayar  =0;
							$numItems = count($bdetail);
							
							foreach($bdetail AS $val){
								if($sisa==0 AND $cdetail==1 AND $val['jml_bayar']==$cek_bayar){
									$jml_bayar = $total->total;
									}elseif($sisa >0 AND $cdetail >=1 AND $val['jml_bayar']!=$cek_bayar){
									$jml_bayar = $val['jml_bayar'];
									}else{
									$jml_bayar = $val['jml_bayar'];
								}
								
							}
						?>
						
						<div class="col-md-12 col-print-12 p-0">
							<table class="table ">
								<tbody>
									
									<tr>
										<td class="font-weight-bold border-top-0">Total Order</td>
										<td class="font-weight-bold border-top-0">Rp.</td>
										<td class="text-right font-weight-bold border-top-0"><?=rp($grandtotal);?></td>
									</tr>                
									<tr>
										<td style="width:40px;font-weight:bold">Bayar</td>
										<td>Rp.</td>
										<td class="text-right"><b><?=rp($jml_bayar);?></b></td>
									</tr>
									<tr>
										<td>Sisa </td>
										<td>Rp.</td>
										<td class="text-right"><?=rp($sisa);?></td>
									</tr>
									
									<tr>
										<td class="border-bottom-0">
											<div class="thumbnail ">
												<?php if($sisa > 0){ ?>
													<img src="<?=$blunas;?>"  style="width:100px;" alt="Belum Lunas" class="img-responsive">
													<?php }elseif($sisa == 0 ){ ?>
													<img src="<?=$lunas;?>"  style="width:100px;" alt="Lunas" class="img-responsive">
													<?php }else{ ?>
												<?php } ?>
											</div>
											<tr>
												<td class="text-left border-top-0" style="width:40%">Pelanggan,</td>
												<td class="border-top-0" style="width:1px"></td>
												<td class="text-right border-top-0" style="width:40%">Kasir</td>
											</tr>
											<tr>
												<td class="border-top-0"></td>
												<td class="border-top-0"></td>
												<td class="border-top-0"></td>
											</tr>
											<tr>
												<td class="border-top-0"></td>
												<td class="border-top-0"></td>
												<td class="border-top-0"></td>
											</tr>
											<tr>
												<td class="text-left">
												<?=$konsumen['nama'];?></td>
												<td class="border-top-0"></td>
												<td class="text-right"><?=$marketing['nama_lengkap'];?></td>
											</tr>
											
										</td>
									</tr>
									<tr>
										<td class="pr-0 border-top-0">
											<tr>
												<td colspan="1" class="border-top-0">
													<span>No.Rekening</span>
												</td>
												<td colspan="2" class="border-top-0 text-right">
													<span><?=$ketbyr;?></span>
												</td>
												
											</tr>  
											
											<?php 
												foreach($bank AS $val){
												?>
												<tr>
													<td colspan="3" class="">
														<address class="">
															<span class="perhatian"><?=$val->inisial.' a.n '.$val->pemilik.' <b>'.$val->nomor_rekening;?></span>
														</address>
													</td>
												</tr>  
											<?php } ?>
											
										</td>
									</tr>
									<tr>
										<td colspan="3" class="pt-0">
											<address class="">
												<?=base64_decode($info['footer_invoice']);?>
											</address>
										</td>
									</tr>  
									
								</tbody>
							</table>
						</table>
						
					</div><!-- /.col -->
					
				</div>
			</div>
		</div>
	</div>
</body>
</html>