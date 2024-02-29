<!DOCTYPE html>
<html>
	<head>
		<title>Print slip gaji</title>
		<link href="<?=base_url();?>uploads/<?=$logo;?>" rel="icon">
		<?=link_tag('assets/vendor/fontawesome/css/font-awesome.css'); ?>
		<?=link_tag('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>
		<style>
			body{
			margin-top:20px;
			background:#eee;
			}
			@media print
			{    
			.no-print, .no-print *
			{
			display: none !important;
			}
			}
			.container {
			width: 21cm;
			height: 100%
			}
			.invoice {
			background: #fff;
			padding: 20px
			}
			
			.invoice-company {
			font-size: 20px
			}
			
			.invoice-header {
			margin: 0 -20px;
			background: #f0f3f4;
			padding: 10px 20px 0 20px
			}
			
			.invoice-header-footer {
			margin: 0 -20px;
			padding: 10px 20px 0 20px
			}
			
			.invoice-date,
			.invoice-from,
			.invoice-to {
			display: table-cell;
			width: 1%
			}
			
			.invoice-from,
			.invoice-to {
			padding-right: 20px
			}
			
			.invoice-date .date,
			.invoice-from strong,
			.invoice-to strong {
			font-size: 16px;
			font-weight: 600
			}
			
			.invoice-date {
			text-align: right;
			padding-left: 20px
			}
			
			.invoice-price {
			background: #f0f3f4;
			display: table;
			width: 100%
			}
			
			.invoice-price .invoice-price-left,
			.invoice-price .invoice-price-right {
			display: table-cell;
			padding: 20px;
			font-size: 20px;
			font-weight: 600;
			width: 70%;
			position: relative;
			vertical-align: middle
			}
			
			.invoice-price .invoice-price-left .sub-price {
			display: table-cell;
			vertical-align: middle;
			padding: 0 20px
			}
			
			.invoice-price small {
			font-size: 12px;
			font-weight: 400;
			display: block
			}
			
			.invoice-price .invoice-price-row {
			display: table;
			float: left
			}
			
			.invoice-price .invoice-price-right {
			width: 30%;
			background: #2d353c;
			color: #fff;
			font-size: 28px;
			text-align: right;
			vertical-align: bottom;
			font-weight: 300
			}
			
			.invoice-price .invoice-price-right small {
			display: block;
			opacity: .6;
			position: absolute;
			top: 10px;
			left: 10px;
			font-size: 12px
			}
			
			.invoice-footer {
			border-top: 1px solid #ddd;
			padding-top: 5px;
			font-size: 14px
			}
			
			.invoice-note {
			color: #999;
			margin-top: 80px;
			font-size: 85%
			}
			
			.invoice>div:not(.invoice-footer) {
			margin-bottom:10px
			}
			
			.btn.btn-white, .btn.btn-white.disabled, .btn.btn-white.disabled:focus, .btn.btn-white.disabled:hover, .btn.btn-white[disabled], .btn.btn-white[disabled]:focus, .btn.btn-white[disabled]:hover {
			color: #2d353c;
			background: #fff;
			border-color: #d9dfe3;
			}
			
			.table td, .table th {
			padding: 2px 6px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<?php
				if(!empty($row)){ 
					
					$tgl = $row['tgl_rekap'];
					$gaji_pokok = $row['gaji_pokok'];
					$tun_jab = $row['tun_jab'];
					$transport = $row['transport'];
					$makan = $row['makan'];
					$asuransi = $row['asuransi'];
					$jam_kerja = $row['jam_kerja'];
					$istirahat = $row['istirahat'];
					$jml_cuti = $row['jml_cuti'];
					$jml_kerja = $row['jml_kerja'];
					$jml_libur = $row['jml_libur'];
					$gaji_kotor = ($row['gaji_kotor']);
					$lembur = $row['lembur'];
					$tot_makan = ($row['tot_makan']);
					$tot_trasport = ($row['tot_transport']);
					$tot_tun_cuti = ($row['tot_tun_cuti']);
					$tot_tun_libur = ($row['tot_tun_libur']);
					$tot_tun_jab = ($row['tot_tun_jab']);
					$tot_bonus = $row['tot_bonus'];
					$pot_absen = ($row['pot_absen']);
					$pot_asuransi = $row['pot_asuransi'];
					$pot_kasbon = $row['pot_kasbon'];
					$uang_makan = $row['uang_makan_diambil'];
					$uang_transport = $row['uang_trans_diambil'];
					}else{
					$tgl = "";
					$gaji_pokok = 0;
					$tun_jab = 0;
					$transport = 0;
					$makan = 0;
					$asuransi =0;
					$jam_kerja = 0;
					$istirahat = 0;
					$jml_kerja = 0;
					$jml_cuti = 0; 
					$jml_libur = 0; 
					$gaji_kotor =0;
					$lembur = 0; 
					$tot_makan = 0; 
					$tot_trasport = 0;
					$tot_tun_cuti = 0; 
					$tot_tun_libur = 0; 
					$tot_tun_jab = 0;
					$tot_bonus = 0;
					$pot_absen = 0; 
					$pot_asuransi = 0;
					$pot_kasbon = 0;
					$uang_makan = 0;
					$uang_transport = 0;
				}
				$total_potongan = $pot_kasbon + $uang_makan + $uang_transport;
				$gaji_bersih = $gaji_kotor + $lembur + $tot_makan +  $tot_trasport + $tot_tun_cuti + $tot_tun_libur + $tot_tun_jab + $tot_bonus - $pot_asuransi;
				$gajiditerima = $gaji_bersih - $total_potongan;
				
			?>
			<div class="col-md-12">
				<div class="invoice">
					<!-- begin invoice-company -->
					<div class="invoice-company text-inverse f-w-600">
						<span class="pull-right no-print"><a class="btn btn-sm btn-white m-b-10 p-l-5" href="javascript:;" onclick="window.print()"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a></span><img src="<?=base_url();?>uploads/<?=$logo;?>" alt="logo" height="30" /><?=$perusahaan;?>
					</div><!-- end invoice-company -->
					<!-- begin invoice-header -->
					<div class="invoice-header">
						<div class="invoice-from">
							<small>Kepada Yth:</small>
							<address class="m-t-5 m-b-5">
								<strong class="text-inverse"><?=$user->nama_lengkap;?>.</strong><br>
								<?=$user->level;?>
							</address>
						</div>
						
						<div class="invoice-date">
							<small>Slip Gaji / periode <?=$bln;?></small>
							<div class="date text-inverse m-t-5">
								Tanggal
							</div>
							<div class="invoice-detail">
								<?=dtime(today());?><br>
							</div>
						</div>
					</div><!-- end invoice-header -->
					<!-- begin invoice-content -->
					<div class="invoice-content">
						<!-- begin table-responsive -->
						<div class="table-responsive">
							<table class="table table-invoice">
								<thead>
									<tr>
										<th>RINCIAN GAJI</th>
										<th class="text-right" width="10%">JUMLAH</th>
										<th>PERHITUNGAN</th>
										<th class="text-right" width="10%">JUMLAH</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Gaji Pokok</td>
										<td class="text-right"><?=rp($gaji_pokok);?></td>
										<td class="text-left">Gaji Kotor</td>
										<td class="text-right"><?=rp($gaji_kotor);?></td>
									</tr>
									<tr>
										<td>Uang Makan</td>
										<td class="text-right"><?=rp($makan);?></td>
										<td class="text-left">Total Uang Makan</td>
										<td class="text-right"><?=rp($tot_makan);?></td>
										
									</tr>
									<tr>
										<td>Uang Transport</td>
										<td class="text-right"><?=rp($transport);?></td>
										<td class="text-left">Total Uang Transport</td>
										<td class="text-right"><?=rp($tot_trasport);?></td>
									</tr>
									<tr>
										<td>Jam Kerja</td>
										<td class="text-right"><?=$jam_kerja;?> Jam</td>
										<td class="text-left">Total Lembur</td>
										<td class="text-right"><?=rp($lembur);?></td>
									</tr>
									<tr>
										<td>Jam Istirahat</td>
										<td class="text-right"><?=$istirahat;?> Jam</td>
										<td class="text-left">Bonus</td>
										<td class="text-right"><?=rp($tot_bonus);?></td>
									</tr>
									<tr>
										<td>Jumlah Hari Kerja</td>
										<td class="text-right"><?=$jml_kerja;?> Hari</td>
										<td class="text-left">Tunjangan Jabatan</td>
										<td class="text-right"><?=rp($tot_tun_jab);?></td>
									</tr>
									<tr>
										<td>Jumlah Hari Sakit </td>
										<td class="text-right"><?=$jml_cuti;?> Hari</td>
										<td class="text-left">Tunjangan Sakit</td>
										<td class="text-right"><?=rp($tot_tun_cuti);?></td>
									</tr>
									<tr>
										<td>Jumlah Hari Libur</td>
										<td class="text-right"><?=$jml_libur;?> Hari</td>
										
										<td class="text-left">Tunjangan Hari Libur</td>
										<td class="text-right"><?=rp($tot_tun_libur);?></td>
									</tr>
									<thead>
									<tr>
										<th>POTONGAN</th>
										<th class="text-right" width="10%">JUMLAH</th>
										<th>POTONGAN</th>
										<th class="text-right" width="10%">JUMLAH</th>
									</tr>
									<tr>
										<td>Potongan Absen</td>
										<td class="text-right"><?=rp($pot_absen);?></td>
										<td>Uang Makan diambil</td>
										<td class="text-right"><?=rp($uang_makan);?></td>
									</tr>
									<tr>
										<td class="text-left">Potongan Kasbon</td>
										<td class="text-right"><?=rp($pot_kasbon);?></td>
										<td class="text-left">Uang Transport diambil</td>
										<td class="text-right"><?=rp($uang_transport);?></td>
									</tr>
								</thead>
								</tbody>
							</table>
						</div><!-- end table-responsive -->
						<!-- begin invoice-price -->
						<div class="invoice-price">
							<div class="invoice-price-left">
								<div class="invoice-price-row">
									<div class="sub-price">
										<small>GAJI BERSIH</small> <span class="text-inverse"><?=rprp($gaji_bersih);?></span>
									</div>
									<?php if($total_potongan >0){ ?>
									<div class="sub-price">
										<i class="fa fa-minus text-muted"></i>
									</div>
									<div class="sub-price">
										<small>TOTAL POTONGAN</small> <span class="text-danger"><?=rprp($total_potongan);?></span>
									</div>
									<?php } ?>
								</div>
							</div>
							<div class="invoice-price-right">
								<small>TOTAL GAJI</small> <span class="f-w-600"><?=rprp($gajiditerima);?></span>
							</div>
						</div><!-- end invoice-price -->
					</div><!-- end invoice-content -->
					<!-- begin invoice-note -->
					<div class="invoice-header-footer">
						<div class="invoice-from text-center">
							<small>Penerima</small>
							<div class="date text-inverse m-t-5">
								<?=$user->nama_lengkap;?> 
							</div>
							<div class="invoice-detail">
								<br><br>______________________
							</div>
						</div>
						
						<!--div class="invoice-to text-center">
							<small>Bagian Keuangan</small>
							<div class="date text-inverse m-t-5">
								Nama 
							</div>
							<div class="invoice-detail">
								<br><br>______________________
							</div>
						</div-->
						<div class="invoice-date text-center">
							<small>Direktur</small>
							<div class="date text-inverse m-t-5">
								<?=ttd_user('owner');?> 
							</div>
							<div class="invoice-detail">
								<br><br>______________________
							</div>
						</div>
					</div><!-- end invoice-header -->
					<!-- begin invoice-footer -->
					<div class="invoice-footer">
						<p class="text-center f-w-900"><?=cleanTag(base64_decode($alamat));?>, M: <?=$phone;?> E: <?=$email;?></p>
					</div><!-- end invoice-footer -->
				</div>
			</div>
		</div>
	</body>
</html>