<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>CETAK LAPORAN TRANSAKSI</title>
		<link href="<?= FCPATH; ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
			/** Define the footer rules **/
            footer {
			position: fixed; 
			bottom: 0cm; 
			left: 0cm; 
			right: 0cm;
			height: 0.5cm;
			padding:5px;
			
			/** Extra personal styles **/
			background-color: <?=$info['warna_lunas'];?>;
			color: white;
			text-align: center;
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
			background: <?=$info['warna_lunas'];?>;
			color: #fff;
			font-weight: bold;
			padding: 5px;
			}
			
			.invoice-box table tr.heading2 td {
			background: #333;
			color: #fff;
			font-weight: bold;
			padding: 5px;
			}
			
			.invoice-box table tr.details td {
			padding-bottom: 20px;
			}
			
			.invoice-box table tr.item td{
			border-bottom: 1px dotted #000;
			
			}
			.invoice-box table tr.kepada td{
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
			
			.invoice-box table td.ket {
			text-align:left;
			}
			.invoice-box table td.tgl {
			border-bottom:1px dotted #000;
			font-weight:bold;
			}
			.invoice-box table td.tkepada {
			background:<?=$info['warna_lunas'];?>;
			width:20%!important
			}
			.invoice-box table tr.kepada td.bawah {
			color:#000;
			width:15%!important
			}
			.invoice-box table td.total1 {
			border-left:1px solid #000;
			border-top:1px solid #000;
			border-bottom:1px dotted #000;
			}
			.invoice-box table td.total2 {
			border-top:1px solid #000;
			border-right:1px solid #000;
			border-bottom:1px dotted #000;
			text-align:right;
			font-weight:bold;
			}
			.invoice-box table td.umuka1 {
			border-left:1px solid #000;
			border-bottom:1px dotted #000;
			}.invoice-box table td.umuka2 {
			border-right:1px solid #000;
			border-bottom:1px dotted #000;
			text-align:right;
			font-weight:bold;
			}
			.invoice-box table td.sisa1 {
			border-left:1px solid #000;
			border-bottom:1px solid #000;
			}
			.invoice-box table td.sisa2 {
			border-right:1px solid #000;
			border-bottom:1px solid #000;
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
			.invoice-box table td.borderl {
			border-left:1px dotted #000;
			}
			.invoice-box table td.borderr {
			border-right:1px dotted #000;
			}
			
			.invoice-box .table img{
			position: fixed;
			z-index:-1000;
			}
			.font-weight-bold{font-weight:bold;}
			.watermark{
			right:4cm;
			width:    4.5cm;
			height:   auto;
			opacity:0.2;
			z-index:-1
			
			/** Your watermark should be behind every content**/
            }
			
		</style>
	</head>
	<body>
		<?php
			$alamat = base64_decode($info['deskripsi']);
			$alamat = cleanString($alamat);
		?>
		<footer>
			<?=$info['title'];?> © <?php echo date("Y");?> 
		</footer>
		<div class="invoice-box">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="4" rowspan="5" style="width:350px;"><img src="<?=$logo;?>" style="width:100%; max-width:350px;max-height:80px"></td>
					<td colspan="2" class="tgl">LAPORAN TRANSAKSI</td>
				</tr>
				<tr class="">
					<td colspan="2">TGL. CETAK : <?=tgl_indo(date('Y-m-d'));?></td>
				</tr>
				<tr class="">
					<td colspan="2"></td>
				</tr>
				<tr class="kepada">
					<td class="tkepada">PENGGUNA</td>
					<td class="bawah"><?=$user;?></td>
				</tr>
				<tr class="kepada">
					<td class="tkepada"><?=$periode_name;?></td>
					<td class="bawah"><?=($periode);?></td>
				</tr>
				<tr class="">
					<td colspan="2"></td>
				</tr>
				<tr>
					<td colspan="4">
						<span class="alamat"><?=($alamat);?></span><br>
						M:<span class="sosmed"><?=$info['phone'];?></span>&nbsp;E:<span class="sosmed"><?=$info['email'];?></span>&nbsp;FB:<span class="sosmed"><?=$info['fb'];?></span>&nbsp;IG:<span class="sosmed"><?=$info['ig'];?></span>
						<td colspan="2"></td>
					</tr>
				</table>
				<table style="width:100%;margin-top:5px" cellpadding="0" cellspacing="0">
					
					<?php 
						$heading = '<tr class="heading">
						<td style="width:1%;" class="text-center">NO.</td>
						<td style="width:4%"  class="text-left">NO_ORDER</td>
						<td style="width:5%"  class="text-left">TGL_BAYAR</td>
						<td style="width:10%"  class="text-left">KASIR</td>
						<td colspan="2" class="text-left">KETERANGAN</td>
						<td style="width:5%"  class="total">MASUK</td>
						<td style="width:5%"  class="total">KELUAR</td>
						</tr>';
						
						
						$total_masuk = $total_keluar = $total_beli = $total_pendapatan = 0;
						if(!empty($result['masuk']))
						{
							echo '<tr class="item">
							<td colspan="8" class="text-left font-weight-bold">PENJUALAN</td>
							</tr>
							<tr class="heading">
							<td style="width:1%;" class="text-center">NO.</td>
							<td style="width:5%"  class="text-left">NO_ORDER</td>
							<td style="width:4%"  class="text-left">PEMESAN</td>
							<td style="width:5%"  class="text-left">TGL_BAYAR</td>
							<td style="width:5%"  class="text-left">KASIR</td>
							<td style="width:8%"  class="text-left">KETERANGAN</td>
							<td style="width:5%"  class="total">MASUK</td>
							<td style="width:5%"  class="total">KELUAR</td>
							</tr>';
							$no=1;
							foreach($result['masuk'] as $key=>$val)
							{
								$total_masuk  += $val['jml_bayar'];
								$bayar = $this->model_app->cara_bayar(array('`jenis_bayar`.`publish`' => 'Y', '`bayar_invoice_detail`.`id_invoice`' => $val['noid']));
								$nama_bayar = $bayar->nama_bayar;
								$id_bayar = $bayar->id_bayar;
								if($id_bayar==1){
									$getAkun = getNameKas(411);
									}else{
									$getAkun = bank($val['id_sub_bayar']);
								}
								$nama = cekKonsumen($val["id_konsumen"])['nama'];
							?>
							<tr class="item">
								<td class="borderl"><?=$no;?>.</td>
								<td class="borderl borderr">#<?=$val['id'];?></td>
								<td class="borderr"><?=$nama;?>.</td>
								<td class="borderr"><?=date_time($val['tgl_bayar'],false);?></td>
								<td class="borderr"><?=$val['fo'];?></td>
								<td class="borderr"><?=$nama_bayar;?> (<?=$getAkun;?>)</td>
								<td class="borderr total"><?=rp($val['jml_bayar']);?></td>
								<td class="borderr total"></td>
							</tr>
							<?php $no++; 
								$detail = detail_order($val['noid'],'semua');
								if(!empty($detail)) 
								{
								?>
								<tr class="heading2">
									<td style="width:1%;" class="text-center">#</td>
									<td style="width:5%"  class="text-left">QTY</td>
									<td style="width:4%"  class="text-left">HARGA</td>
									<td class="text-left">SUB_TOTAL</td>
									<td style="width:5%"  class="text-left">PRODUK</td>
									<td style="width:8%"  class="text-left">KATEGORI</td>
									<td style="width:5%"  class="text-left">BAHAN</td>
									<td style="width:5%"  class="text-left">UKURAN</td>
								</tr>
								<?php
									$subtotal = 0;
									$num = 0;
									foreach($detail AS $val)
									{ 
										$num++;
										$subtotal = $val->jumlah * $val->harga;
										if($val->diskon > 0){
											$diskon = ($subtotal * $val->diskon) /100;
											$subtotal = $subtotal - $diskon;
											}else{
											$diskon = 0;
											$subtotal = $subtotal;
										}
									?>
									<tr class="item">
										<td class="borderl"><?=$num;?></td>
										<td class="borderr borderl"><?=$val->jumlah;?></td>
										<td class="borderr"><?=rp($val->harga);?></td>
										<td class="borderr"><?=rp($subtotal);?></td>
										<td class="borderr"><?=nama_produk($val->id_produk);?></td>
										<td class="borderr"><?=jenis_cetakan($val->jenis_cetakan);?></td>
										<td class="borderr borderl"><?=getDetailBahan($val->id_bahan)->title;?></td>
										<td class="borderr borderl"><?=$val->ukuran;?></td>
									</tr>
									<?php 
									}
								}
							}
						}
						
						if(!empty($result['keluar'])){
							echo '<tr class="item">
							<td colspan="8" class="text-left font-weight-bold">PENGELUARAN</td>
							</tr>';
							echo $heading;
							$no = 0;
							foreach($result['keluar'] as $key=>$val){
								$no++;
								$total_keluar  += $val['jml_bayar'];
								$bayar = $this->model_app->cara_bayar_keluar(array('`jenis_bayar`.`publish`' => 'Y', '`bayar_pengeluaran`.`id_pengeluaran`' => $val['id']));
								$nama_bayar = $bayar->nama_bayar;
								$id_bayar = $bayar->id_bayar;
								if($id_bayar==1){
									$getAkun = getNameKas($val['id_sub_bayar']);
									}else{
									$getAkun = bank($val['id_sub_bayar']);
								}
							?>
							<tr class="item">
								<td class="borderl"><?=$no;?>.</td>
								<td class="borderl borderr">#<?=$val['id'];?></td>
								<td class="borderr"><?=date_time($val['tgl_bayar'],false);?></td>
								<td class="borderr"><?=$val['fo'];?></td>
								<td colspan="2" class="borderr"><?=$nama_bayar;?> (<?=$getAkun;?>)</td>
								<td class="borderr"></td>
								<td class="borderr total"><?=rp($val['jml_bayar']);?></td>
							</tr>
							<?php $no++; 
							}
						}
						
						if(!empty($result['beli'])){
							echo '<tr class="item">
							<td colspan="8" class="text-left font-weight-bold">PEMBELIAN</td>
							</tr>';
							echo $heading;
							$no = 0;
							foreach($result['beli'] as $key=>$val){
								$no++;
								$total_beli  += $val['jml_bayar'];
								$bayar = $this->model_app->cara_bayar_beli(array('`jenis_bayar`.`publish`' => 'Y', '`bayar_pembelian`.`id_pembelian`' => $val['id']));
								$nama_bayar = $bayar->nama_bayar;
								$id_bayar = $bayar->id_bayar;
								if($id_bayar==1){
									$getAkun = getNameKas($val['id_sub_bayar']);
									}else{
									$getAkun = bank($val['id_sub_bayar']);
								}
							?>
							<tr class="item">
								<td class="borderl"><?=$no;?>.</td>
								<td class="borderl borderr">#<?=$val['id'];?></td>
								<td class="borderr"><?=date_time($val['tgl_bayar'],false);?></td>
								<td class="borderr"><?=$val['fo'];?></td>
								<td colspan="2" class="borderr"><?=$nama_bayar;?> (<?=$getAkun;?>)</td>
								<td class="borderr"></td>
								<td class="borderr total"><?=rp($val['jml_bayar']);?></td>
							</tr>
							<?php $no++; 
							}
						}
						$total_pendapatan = $total_masuk - $total_keluar - $total_beli;
					?>
					<tfoot>
						<tr class="item">
							<td colspan="3" class="borderl">SUBTOTAL</td>
							<td class=" text-center"></td>
							<td class=" text-center"></td>
							<td class="borderr text-center"></td>
							<td class="borderr total"><?=rp($total_masuk);?></td>
							<td class="borderr total"><?=rp($total_keluar);?></td>
						</tr>
					</tfoot>
				</table>
				<table class="table" style="width:100%;margin-top:10px" cellpadding="0" cellspacing="0">
					<tr>
						<td colspan="4" class="total1" style="width:12%">TOTAL KESELURUHAN</td>
						<td class="total2" style="width:19%"><?=rp($total_pendapatan);?></td>
					</tr>
				</table>
			</div>
		</body>
	</html>																											