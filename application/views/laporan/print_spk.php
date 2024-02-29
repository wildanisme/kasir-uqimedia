<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?=$title;?></title>
		<link href="<?= $favicon;?>" rel="icon">
		<style>
			@page {
			margin: 0 0;
            }
			body {
			margin-top: 0cm;
			margin-left: 0.5cm;
			margin-right: 1cm;
			margin-bottom: 0cm;
			font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            }
			
			.invoice-box {
			width:100%;
			margin: 0 auto;
			padding: 10px;
			font-size: 12px;
			line-height: 18px;
			font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			color: #555;
			}
			
            /** Define the footer rules **/
            footer {
			position: fixed; 
			bottom: 0cm; 
			left: 0cm; 
			right: 0cm;
			height: 0.5cm;
			padding:5px;
			
			/** Extra personal styles **/
			background-color: <?=$color;?>;
			color: white;
			text-align: center;
            }
			.invoice-box table {
			width: 100%;
			line-height: inherit;
			text-align: left;
			}
			
			.invoice-box table td {
			padding: 0 5px 0 5px;
			vertical-align: top;
			}
			
			.invoice-box table tr td:nth-child(2) {
			
			}
			
			.invoice-box table tr.top table td {
			padding-bottom: 0;
			}
			
			.invoice-box table tr.top table td.title {
			font-size: 45px;
			line-height: 45px;
			color: #333;
			}
			
			.invoice-box table tr.information table td {
			
			}
			
			.invoice-box table tr.heading td {
			background: <?=$color;?>;
			color: #fff;
			font-weight: normal;
			padding: 5px;
			text-transform: uppercase;
			}
			
			.invoice-box table tr.details td {
			padding-bottom: 20px;
			}
			
			.invoice-box table tr.item td{
			border-bottom: 1px solid <?=$color;?>;
			}
			.invoice-box table tr.item td{
			border-bottom: 1px solid <?=$color;?>;
			}
			.invoice-box table tr.item1:first-child td {
			border-bottom:1px dotted <?=$color;?>;  
			}
			.invoice-box table tr.item2:first-child td {
			border-bottom:1px solid <?=$color;?>;  
			}
			
			.invoice-box table tr.item2:last-child td {
			border-top:1px dotted <?=$color;?>;  
			border-bottom:1px solid <?=$color;?>;  
			}
			
			.invoice-box table tr.kepada td{
			font-weight:bold;
			color: #fff;
			border-bottom:1px dotted #000
			}
			
			.invoice-box table tr.detail td{
			border-bottom:1px dotted #000
			}
			
			.invoice-box table td.tdetail {
			border-bottom:1px dotted #fff !important;
			width:250px!important
			}
			
			.invoice-box table td.detail_tgl {
			border-bottom:1px dotted #fff !important;
			}
			
			.invoice-box table td.sub-detail {
			border-bottom:1px dotted #fff !important;
			}
			
			.invoice-box table tr.item.last td {
			
			}
			.invoice-box table tr.total{
			font-weight: bold;
			text-align:right;
			}
			.invoice-box table tr.hormat{
			font-weight: bold;
			text-align:left;
			}
			.invoice-box table tr.pelanggan{
			font-weight: bold;
			text-align:center;
			}
			.invoice-box table td.total {
			text-align:right;
			}
			.invoice-box table td.tgl {
			font-weight:bold;
			border-bottom:1px dotted #000;
			}
			.invoice-box table td.tkepada {
			background:<?=$color;?>;
			opacity:0.7;
			width:12%!important
			}
			.invoice-box table tr.alamat{
			color:#000;
			width:50%!important;
			vertical-align: top!important;
			}
			.invoice-box table tr.kepada td.bawah {
			color:#000;
			font-weight:normal;
			width:30%!important
			}
			
			.invoice-box table tr.alamat td.nomor {
			font-weight:bold;
			vertical-align: text-bottom!important;
			}
			.invoice-box table td.total1 {
			border-left:1px solid <?=$color;?>;
			border-top:1px solid <?=$color;?>;
			border-bottom:1px dotted <?=$color;?>;
			}
			.invoice-box table td.total2 {
			border-top:1px solid <?=$color;?>;
			border-right:1px solid <?=$color;?>;
			border-bottom:1px dotted <?=$color;?>;
			text-align:right;
			font-weight:bold;
			}
			
			.invoice-box table td.lunas1 {
			border-left:1px solid <?=$color;?>;
			border-bottom:1px solid <?=$color;?>;
			background:<?=$color;?>;
			color:#fff;
			}
			.invoice-box table td.lunas2 {
			border-right:1px solid <?=$color;?>;
			border-bottom:1px solid <?=$color;?>;
			text-align:right;
			font-weight:bold;
			background:<?=$color;?>;
			color:#fff;
			}
			
			.invoice-box table td.umuka1 {
			border-left:1px solid <?=$color;?>;
			border-bottom:1px dotted <?=$color;?>;
			}
			.invoice-box table td.umuka2 {
			border-right:1px solid <?=$color;?>;
			border-bottom:1px dotted <?=$color;?>;
			text-align:right;
			font-weight:bold;
			}
			
			.invoice-box table td.sisa1 {
			border-left:1px solid <?=$color;?>;
			border-bottom:1px solid <?=$color;?>;
			}
			.invoice-box table td.sisa2 {
			border-right:1px solid <?=$color;?>;
			border-bottom:1px solid <?=$color;?>;
			text-align:right;
			font-weight:bold;
			}
			.invoice-box table td.ttd {
			border-bottom:1px dotted <?=$color;?>;
			text-align:center;
			font-weight:bold;
			}
			.invoice-box table td.border {
			border-right:1px dotted <?=$color;?>;
			}
			
			
			.invoice-box .table img{
			position: fixed;
			z-index:-1000;
			width:200px;
			}
			
			.alamat{font-size:11pt;}
			.sosmed{font-size:8pt;}
			
		</style>
		<?php if($html=="Y"){ ?>
			<style>
				@media print {
				.invoice-box {
				width:100%;
				margin: auto;
				padding: 10px;
				font-size: 12px;
				line-height: 18px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
				}
				
				.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
				}
				
				.invoice-box table td {
				padding: 0 5px 0 5px;
				vertical-align: top;
				}
				
				.invoice-box table tr td:nth-child(2) {
				
				}
				
				.invoice-box table tr.top table td {
				padding-bottom: 0;
				}
				
				.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
				}
				
				.invoice-box table tr.information table td {
				
				}
				
				.invoice-box table tr.heading td {
				background: #<?=$color;?>;
				color: #fff;
				font-weight: normal;
				padding: 5px;
				text-transform: uppercase;
				}
				
				.invoice-box table tr.details td {
				padding-bottom: 20px;
				}
				
				.invoice-box table tr.item td{
				border-bottom: 1px solid #000;
				
				}
				.invoice-box table tr.kepada td{
				font-weight:bold;
				color: #fff;
				border-bottom:1px dotted #000
				}
				
				.invoice-box table tr.item.last td {
				
				}
				.invoice-box table tr.total{
				font-weight: bold;
				text-align:right;
				}
				.invoice-box table tr.hormat{
				font-weight: bold;
				text-align:left;
				}
				.invoice-box table tr.pelanggan{
				font-weight: bold;
				text-align:center;
				}
				.invoice-box table td.total {
				text-align:right;
				}
				.invoice-box table td.tgl {
				font-weight:bold;
				border-bottom:1px dotted #000;
				}
				.invoice-box table td.tkepada {
				background:#<?=$color;?>;
				opacity:0.7;
				width:12%!important
				}
				.invoice-box table tr.kepada td.bawah {
				color:#000;
				width:30%!important
				}
				.invoice-box table td.nomor {
				font-weight:bold;
				}
				.invoice-box table td.total1 {
				border-left:1px solid <?=$color;?>;
				border-top:1px solid <?=$color;?>;
				border-bottom:1px dotted <?=$color;?>;
				}
				.invoice-box table td.total2 {
				border-top:1px solid <?=$color;?>;
				border-right:1px solid <?=$color;?>;
				border-bottom:1px dotted <?=$color;?>;
				text-align:right;
				font-weight:bold;
				}
				.invoice-box table td.lunas1 {
				border-left:1px solid <?=$color;?>;
				border-bottom:1px solid <?=$color;?>;
				}
				.invoice-box table td.lunas2 {
				border-right:1px solid <?=$color;?>;
				border-bottom:1px solid <?=$color;?>;
				text-align:right;
				font-weight:bold;
				}
				.invoice-box table td.umuka1 {
				border-left:1px solid <?=$color;?>;
				border-bottom:1px dotted <?=$color;?>;
				}.invoice-box table td.umuka2 {
				border-right:1px solid <?=$color;?>;
				border-bottom:1px dotted <?=$color;?>;
				text-align:right;
				font-weight:bold;
				}
				.invoice-box table td.sisa1 {
				border-left:1px solid <?=$color;?>;
				border-bottom:1px solid <?=$color;?>;
				}
				.invoice-box table td.sisa2 {
				border-right:1px solid <?=$color;?>;
				border-bottom:1px solid <?=$color;?>;
				text-align:right;
				font-weight:bold;
				}
				.invoice-box table td.ttd {
				border-bottom:1px dotted #000;
				text-align:center;
				font-weight:bold;
				}
				.invoice-box table td.border {
				border-right:1px dotted #000;
				}
				
				
				.invoice-box .table img{
				position: fixed;
				z-index:-1000;
				}
				.watermark{
				top:<?=$top;?>;
				right:4cm;
				width:    4.5cm;
				height:   auto;
				opacity:0.2;
				z-index:-1
				
				/** Your watermark should be behind every content**/
				}
				.sosmed{font-size:8pt;}
				}
			</style>
			<script type="text/javascript">
				<!--
				window.print();
				window.onfocus=function(){ window.close();}
				//-->
			</script>
			<?php }
			
		?>
		<style>
			img.logo{max-width:300px;max-height:100px}
		</style>
	</head>
	<?php 
		if($konsumen['tampil']==1){
			$nama = $konsumen['perusahaan'];
			$perusahaan = cek_jenis_lembaga($konsumen['jenis']);
			$telp = phone_number($konsumen['no_telp']);
			$alamat = $konsumen['alamat_lembaga'];
			}else{
			$nama = $konsumen['nama'];
			$perusahaan = cek_jenis_lembaga($konsumen['jenis']);
			$telp = phone_number($konsumen['no_hp']);
			$alamat = $konsumen['alamat'];
		}
		foreach($detail  AS $val){
			if($val['status_hitung'] ==1)
			{
				$qty = $val['jumlah'];
				}else{
				$qty = $val['jumlah'].' '.get_satuan($val['satuan']);
			}
		?>
		<body>
			
			<div class="invoice-box">
				
				
				<table style="width:100%;margin-top:10px" cellpadding="0" cellspacing="0">
					<tr>
						<td colspan="5" align="center"style="font-weight:bold;font-size:18pt">SURAT PERINTAH KERJA</td>
					</tr>
				</table>
				<table cellpadding="0" cellspacing="0" style="margin-top:5px; width:100%">
					<tbody>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td style="width:30px"><input type="checkbox" name="checkbox" id="checkbox"></td>
							<td style="width:165px">PLAT BARU</td>
							<td>&nbsp;</td>
							<td style="width:30px"><input type="checkbox" name="checkbox" id="checkbox"></td>
							<td>PLAT LAMA</td>
						</tr>
						<tr class="detail">
							<td class="tdetail">NO. SPK</td>
							<td class="sub-detail" style="width:2px">:</td>
							<td colspan="2" class="bawah"><?=$val['no_spk'];?></td>
							<td colspan="3">NO. ORDER : <?=$cetak->id_transaksi;?></td>
						</tr>
						<tr class="detail">
							<td class="tdetail">NAMA PEMESAN</td>
							<td class="sub-detail">:</td>
							<td colspan="5" class="bawah"><?=$nama;?></td>
						</tr>
						<tr class="detail">
							<td class="tdetail">NAMA BARANG</td>
							<td class="sub-detail">:</td>
							<td colspan="5" rowspan="1" class="bawah"><?=$val['title'];?></td>
						</tr>
						<tr class="detail">
							<td class="tdetail">JENIS BAHAN</td>
							<td class="sub-detail">:</td>
							<td colspan="2"><?=$val['nbahan'];?></td>
							<td colspan="2">UKURAN</td>
							<td>: <?=$val['ukuran'];?></td>
						</tr>
						<tr class="detail">
							<td class="tdetail">JUMLAH BAHAN</td>
							<td class="sub-detail">:</td>
							<td colspan="5" rowspan="1">&nbsp;</td>
						</tr>
						<tr class="detail">
							<td class="tdetail">MESIN CETAK</td>
							<td class="sub-detail">:</td>
							<td colspan="5" rowspan="1">&nbsp;</td>
						</tr>
						<tr class="detail">
							<td class="tdetail">JUMLAH PLAT</td>
							<td class="sub-detail">:</td>
							<td colspan="5" rowspan="1">&nbsp;</td>
						</tr>
						<tr class="detail">
							<td class="tdetail">JUMLAH KERTAS MASUK MESIN CETAK</td>
							<td class="sub-detail">:</td>
							<td colspan="4" rowspan="1">&nbsp;</td>
							<td style="text-align:right; width:134px">LEMBAR</td>
						</tr>
						<tr class="detail">
							<td class="tdetail">UKURAN KERTAS MASUK MESIN CETAK</td>
							<td class="sub-detail">:</td>
							<td colspan="5" rowspan="1">&nbsp;</td>
						</tr>
						<tr class="detail">
							<td class="tdetail">WARNA CETAKAN</td>
							<td class="sub-detail">:</td>
							<td colspan="5" rowspan="1">&nbsp;</td>
						</tr>
						<tr class="detail">
							<td class="tdetail">FINISHING</td>
							<td class="sub-detail">:</td>
							<td colspan="5" rowspan="1">&nbsp;</td>
						</tr>
						<tr class="detail">
							<td colspan="1" rowspan="10" align="center" class="detail_tgl" style="font-size:12pt"><br>CARA POTONG KERTAS<br>
								<table width="90%" border="1">
									<tr>
										<td align="center">
											<br>
											<br>
											<br>
											<br>
											<br>
											<br>
											<br>
											<br>
											<br>
											<?php
												$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
												echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($cetak->id_transaksi, $generator::TYPE_CODE_128)) . '">';
											?>
											
										</td>
									</tr>
								</table>
							</td>
							<td class="detail_tgl">&nbsp;</td>
							<td class="detail_tgl" colspan="2" style="width:214px">TANGGAL PRODUKSI</td>
							<td class="detail_tgl"style="width:1px">:</td>
							<td colspan="2" rowspan="1" style="width:189px">&nbsp;</td>
						</tr>
						<tr class="detail">
							<td class="detail_tgl">&nbsp;</td>
							<td class="detail_tgl" colspan="2" style="width:214px">HASIL AKHIR</td>
							<td class="detail_tgl"style="width:1px">:</td>
							<td colspan="2" rowspan="1" style="text-align:right; width:183px">LEMBAR</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="5" rowspan="1">* CETAK YANG STABIL + REGISTER</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="width:214px">&nbsp;</td>
							<td colspan="2" style="width:48px">&nbsp;</td>
							<td style="width:134px">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="width:214px">&nbsp;</td>
							<td colspan="2" style="width:48px">&nbsp;</td>
							<td style="width:134px">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="text-align:center; width:214px">MENGETAHUI</td>
							<td colspan="2" style="width:48px">&nbsp;</td>
							<td style="text-align:center; width:134px">OPERATOR</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="text-align:center; width:214px">&nbsp;</td>
							<td colspan="2" style="width:48px">&nbsp;</td>
							<td style="text-align:center; width:134px">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="text-align:center; width:214px">&nbsp;</td>
							<td colspan="2" style="width:48px">&nbsp;</td>
							<td style="text-align:center; width:134px">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="text-align:center; width:214px">&nbsp;</td>
							<td colspan="2" style="width:48px">&nbsp;</td>
							<td style="text-align:center; width:134px">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="text-align:center; width:214px">(...........................................)</td>
							<td colspan="2" style="width:48px">&nbsp;</td>
							<td style="text-align:center; width:134px">(...........................................)</td>
						</tr>
					</tbody>
				</table>		
				
			</div>
		</body>
	<?php } ?>
</html>
