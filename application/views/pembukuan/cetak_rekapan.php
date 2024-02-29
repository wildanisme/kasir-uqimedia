<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Cetak Pengeluaran</title>
		<link href="<?= FCPATH; ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<style>
			@page { width:21cm;height:14.8cm;margin: 0.6cm 0.5cm 0.1cm 0.5cm; }
			.invoice-box {
			width:100%;
			margin: auto;
			padding: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, .15);
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
			
			.invoice-box table tr.details td {
			padding-bottom: 20px;
			}
			
			.invoice-box table tr.item td{
			border-bottom: 1px solid #000;
			
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
			.invoice-box table td.tgl {
			border-bottom:1px dotted #000;
			font-weight:bold;
			}
			.invoice-box table td.tkepada {
			background:<?=$info['warna_lunas'];?>;
			width:12%!important
			}
			.invoice-box table tr.kepada td.bawah {
			color:#000;
			width:30%!important
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
			
			
			.invoice-box .table img{
			position: fixed;
			z-index:-1000;
			}
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
			// print_r($detail);
		?>
		<div class="invoice-box">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="4" rowspan="5"><img src="<?=$logo;?>" style="width:100%; max-width:350px;"></td>
					<td colspan="2" class="tgl">REKAPAN</td>
				</tr>
				<tr class="">
					<td colspan="2">Serang, <?=tgl_indo(date('Y-m-d'));?></td>
				</tr>
				<tr class="">
					<td colspan="2"></td>
				</tr>
				<tr class="kepada">
					<td class="tkepada">Pencatat</td>
					<td class="bawah"><?=$user['nama_lengkap'];?></td>
				</tr>
				<tr class="">
					<td colspan="2"></td>
				</tr>
				<tr>
					<td colspan="4"><i style="margin-top:2px" class="fa fa-whatsapp"></i>&nbsp;<span class="sosmed"><?=$info['phone'];?></span> <i style="margin-top:2px" class="fa fa-envelope-square"></i>&nbsp;<span class="sosmed"><?=$info['email'];?></span> <i style="margin-top:2px" class="fa fa-facebook-square"></i>&nbsp;<span class="sosmed"><?=$info['fb'];?></span>&nbsp;<i style="margin-top:2px" class="fa fa-instagram"></i>&nbsp;<span class="sosmed"><?=$info['ig'];?></span></td>
					<td colspan="2"></td>
				</tr>
			</table>
			<table style="width:100%;margin-top:5px" cellpadding="0" cellspacing="0">
				<tr class="heading">
					<td style="width:3%!important" class="text-right">No.</td>
					<td class="total">Debet</td>
					<td class="total">Kredit</td>
					<td class="total" style="width:16%!important">Saldo</td>
				</tr>
				<?php 
					$no=1; 
					$debet=0;$kredit=0;$saldo=0;$tdebet=0;$tkredit=0;$tsaldo=0;
					foreach($detail  AS $row){
						$debet = $row['debet'];
						$kredit = $row['kredit'];
						$tdebet += $debet;
						$tkredit +=  $kredit;
						$tsaldo +=  $debet - $kredit;
						if($debet>0){
							$saldo = $saldo + $row['debet'];			
							}else{
							$saldo = $saldo - $row['kredit'];
						}
					?>
					<tr class="item">
						<td class="text-right"><?=$no;?></td>
						<td class='total'><?=rp($debet);?></td>
						<td class='total'><?=rp($kredit);?></td>
						<td class='total'><?=rp($saldo);?></td>
					</tr>
					<?php $no++; } 
					
				?>
				
			</table>
			<table class="table" style="width:100%;margin-top:10px" cellpadding="0" cellspacing="0">
				<tr>
					
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td class="total1" style="width:12%">Total</td>
					<td class="total2" style="width:19%"><?=rp($tsaldo);?></td>
				</tr>
			</table>
		</div>
	</body>
</html>
