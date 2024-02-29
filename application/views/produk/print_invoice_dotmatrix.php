
<!DOCTYPE html>
<html class="no-js" lang="en">
	
	<head>
		<!-- Meta Tags -->
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="ThemeMarch">
		<!-- Site Title -->
		<title>Print Invoice</title>
		<?=link_tag('assets/css/style-invoice.css'); ?>
		<style>
			.cs-width_0 {
			width: 2%;
			}
			.cs-width_rp {
			width: 1%;
			}
		</style>
	</head>
	
	<body>
		<?php
			$deskripsi = base64_decode($info['deskripsi']);
			$deskripsi = cleanString($deskripsi);
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
		<div class="cs-container">
			<div class="cs-invoice cs-style1">
				<div class="cs-invoice_in" id="download_section">
					<div class="cs-invoice_head cs-type1 cs-mb10">
						<div class="cs-invoice_left">
							<p class="cs-invoice_number cs-primary_color cs-mb5 cs-f20"><b class="cs-primary_color"><?=$info['perusahaan'];?></b></p>
							<p class="cs-invoice_date cs-primary_color cs-m0"><?=$deskripsi;?></p>
							<p class="cs-invoice_date cs-primary_color cs-m0">Telp. <?=$info['phone'];?>, Email : <?=$info['email'];?></p>
						</div>
						<div class="cs-invoice_right cs-text_right">
							<p class="cs-invoice_number cs-primary_color cs-mb5 cs-f20"><b class="cs-primary_color">NOTA PENJUALAN
							</b></p>
							<p class="cs-invoice_date cs-primary_color cs-m0"><b class="cs-primary_color">No. Nota : </b><?=$cetak->id_transaksi;?></p>
							<p class="cs-invoice_date cs-primary_color cs-m0"><b class="cs-primary_color">Tanggal : </b><?=date_time($cetak->tgl_trx,false);?></p>
						</div>
					</div>
					<div class="cs-invoice_head cs-mb10">
						<div class="cs-invoice_left">
							<b class="cs-primary_color">Kepada Yth: <?=$nama;?></b>
						</div>
						<div class="cs-invoice_right cs-text_right">
							<b class="cs-primary_color">Kasir: <?=$marketing['nama_lengkap'];?></b>
						</div>
					</div>
					<div class="cs-table cs-style1">
						<div class="cs-border_none">
							<div class="cs-table_responsive cs-border_bottom">
								<table>
									<thead>
										<tr>
											<th class="cs-width_2x cs-semi_bold cs-primary_color cs-border_bottom border-top cs-pl0">Item</th>
											<th class="cs-width_5 cs-semi_bold border-top cs-border_bottom cs-primary_color">Nama Barang</th>
											<th class="cs-width_0 cs-semi_bold border-top cs-border_bottom cs-primary_color">Qty</th>
											<th class="cs-width_0 cs-semi_bold border-top cs-border_bottom cs-primary_color cs-text_right">Harga</th>
											<th class="cs-width_1 cs-semi_bold border-top cs-border_bottom cs-primary_color cs-text_right cs-pr0">Jumlah</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no=1; 
											$totalb=0; 
											$subtotal=0; 
											$sisa=0; 
											$diskon=0; 
											$finishing ='';
											foreach($detail  AS $val){
												$diskon = $val['jumlah'] * $val['harga'] * $val['diskon']/100;
												$totalb = $val['jumlah'] * $val['harga'] - $diskon;
												$subtotal += $totalb;
												if(!empty($val['detail'])){
													$finishing = json_decode($val['detail']);
												}
												if(!empty($finishing)){
													$item1 = 'item1';
													$item2 = 'item2';
													}else{
													$item1 = 'item';
													$item2 = 'item';
												}
												$baris = $max_item - $no;
												
											?>
											<tr>
												<td class="cs-width_2x cs-pl0"><?=$val['title'];?></td>
												<td class="cs-width_5 "><?=$val['keterangan'];?> <?=$val['ukuran'];?></td>
												<td class="cs-width_0 "><?=$val['jumlah'];?></td>
												<td class="cs-width_0 cs-text_right"><?=rp($val['harga']);?></td>
												<td class="cs-width_1  cs-text_right cs-pr0"><?=rp($totalb);?></td>
											</tr>
											<?php
												$no++;
											} 
											
											for ($x = 1; $x <= $baris; $x++) { ?>
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
											<?php 
											} 
											$pajak = ($subtotal * $cetak->pajak) /100;
											$sisa = $pajak + $subtotal - $total->total - $potongan_harga;
											$cek_bayar = $pajak + $subtotal;
											
										?>
									</tbody>
								</table>
							</div>
							<?php 
								$urutan  =0;
								$numItems = count($bdetail);
								$i = 0;
								$total_bayar = 0;
								$ni = 1;
								foreach($bdetail AS $val){
									if($sisa==0 AND $cdetail==1 AND $val['jml_bayar']==$cek_bayar){
										if($jumlah_bayar > $total->total){
											$total_bayar = $jumlah_bayar;
											}else{
											$total_bayar = $total->total;
										}
										
										}else{
										$total_bayar += $val['jml_bayar'];
										
									}
									$ni++;
								} 
								if($sisa >0){
									$sum_sisa = rp($sisa);
									$title_sisa = 'UANG MUKA';
									}else{ 
									$sum_sisa = 0;
									$title_sisa = 'BAYAR';
								}  
								$potonganharga = 0;
								if($potongan_harga >0)
								{
									$potonganharga = rp($potongan_harga);
								}
							?>
							<div class="cs-invoice_footer cs-mt15">
								<div class="cs-left_footer cs-mobile_hide cs-pt0 cs-pl0">
									<p class="cs-mb10"><b class="cs-primary_color">Terbilang: <?=ucwords(terbilang($subtotal));?></b></p>
									<p class="cs-m0 cs-f12">PEMBAYARAN via TRANSFER : <br>
										<?php foreach($bank AS $val){
											echo $val->inisial.' a.n '.$val->pemilik.' <b>'.$val->nomor_rekening.'</b><br>';
										} ?>
									</p>
								</div>
								<div class="cs-center_footer cs-mobile_hide cs-text_center  cs-pt0 cs-border_bottom">
									<p class="cs-mb0"><b class="cs-primary_color">Hormat Kami,</b></p>
								</div>
								<div class="cs-right_footer ">
									<table>
										<tbody>
											<tr class="cs-border_none">
												<td class="cs-width_4 cs-semi_bold cs-primary_color ">JUMLAH TOTAL</td>
												<td class="cs-width_rp cs-semi_bold cs-primary_color cs-p0" >Rp.</td>
												<td class="cs-width_3 cs-semi_bold cs-primary_color cs-text_right cs-pr0"><?=rp($subtotal);?></td>
											</tr>
											<tr class="cs-border_none">
												<td class="cs-width_3 cs-semi_bold cs-primary_color">DISKON (%)</td>
												<td class="cs-width_rp cs-semi_bold cs-primary_color cs-p0">Rp.</td>
												<td class="cs-width_3 cs-semi_bold cs-primary_color cs-text_right cs-pr0"><?=$potonganharga;?></td>
											</tr>
											<tr class="cs-border_none">
												<td class="cs-width_3 cs-semi_bold cs-primary_color "><?=$title_sisa;?></td>
												<td class="cs-width_rp cs-semi_bold cs-primary_color cs-p0">Rp.</td>
												<td class="cs-width_3 cs-semi_bold cs-primary_color cs-text_right cs-pr0"><?=rp($total_bayar);?></td>
											</tr>
											<?php if($kembalian > 0){ ?>
												<tr class="cs-border_none">
													<td class="cs-width_3 cs-semi_bold cs-primary_color ">SISA</td>
													<td class="cs-width_rp cs-semi_bold cs-primary_color cs-p0">Rp.</td>
													<td class="cs-width_3 cs-semi_bold  cs-primary_color cs-text_right cs-pr0"><?=rp($kembalian);?></td>
												</tr>
												<?php }else{ ?>
												<tr class="cs-border_none">
													<td class="cs-width_3 cs-semi_bold cs-primary_color ">SISA</td>
													<td class="cs-width_rp cs-semi_bold cs-primary_color cs-p0">Rp.</td>
													<td class="cs-width_3 cs-semi_bold  cs-primary_color cs-text_right cs-pr0"><?=$sum_sisa;?></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						
					</div>
					
				</div>
				
			</div>
		</div>
		
	</body>
</html>																	