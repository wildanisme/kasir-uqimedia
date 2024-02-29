<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=rincian_penjualan.xls");
?>
<style>
	/* Center tables for demo */
	table {
	font-family: Arial;
	font-size: 12pt;
	font-weight:bold
	}
	
	/* Default Table Style */
	table {
	color: #333;
	background: white;
	border: 1px solid grey;
	font-size: 12pt;
	border-collapse: collapse;
	}
	table thead th,
	table tfoot th {
	color: #777;
	background: rgba(0,0,0,.1);
	}
	table caption {
	padding:1em;
	font-weight:bold
	}
	table th,
	table td {
	padding: .5em;
	border: 1px solid lightgrey;
	}
	/* Zebra Table Style */
	[data-table-theme*=zebra] tbody tr:nth-of-type(odd) {
	background: rgba(0,0,0,.05);
	}
	[data-table-theme*=zebra][data-table-theme*=dark] tbody tr:nth-of-type(odd) {
	background: rgba(255,255,255,.05);
	}
	/* Dark Style */
	[data-table-theme*=dark] {
	color: #ddd;
	background: #333;
	font-size: 12pt;
	border-collapse: collapse;
	}
	[data-table-theme*=dark] thead th,
	[data-table-theme*=dark] tfoot th {
	color: #aaa;
	background: rgba(0255,255,255,.15);
	}
	[data-table-theme*=dark] caption {
	padding:.5em;
	}
	[data-table-theme*=dark] th,
	[data-table-theme*=dark] td {
	padding: .5em;
	border: 1px solid grey;
	}
</style>
<table class="table  table-striped table-mailcard" id="table_content">
	<caption>RINCIAN PENJUALAN</caption>
	<thead class="thead-dark">
		<tr>
			<th>No.Order</th>
			<th>Tgl.Order</th>
			<th>Tgl.Selesai</th>
			<th class="text-right">Customer</th>
			<th class="text-right">Pajak</th>
			<th class="text-right">Total_Order</th>
			<th class="text-right">Bayar</th>
			<th class="text-right">Diskon</th>
			<th class="text-right">Piutang</th>
			<th class="text-right">Kasir</th>
		</tr>
	</thead>
	<tbody>
		
		<?php 
			$omset_ppajak=0;
			$piutang=0;
			$t_omset=0;
			$totalDiskon=0;
			$total_pajak=0;
			$total_order=0;
			$total_piutang=0;
			$total_bayar=0;
			$total_diskon=0;
			$sub_tpajak=0;
			$Totalbayar=0;
			$diskon=0;
			
			if(!empty($posts)) {
				$no=1;
				foreach($posts AS $row){ 
					if($no%2==0){
						$warna = "background:#ffe599;padding:5px";
						$warna1 = "background:#ffe599";
						$warna2 = "background:#ffe599";
						}else{
						$warna = "background:#ffe599;padding:10px";
						$warna1 = "background:#bfffcf;padding:10px";
						$warna2 = "background:#424251;color:#fff";
					}
					$rows = bayar($row['id_invoice']);
					if (isset($rows)) {
						$Totalbayar = $rows['Totalbayar'];
						}else{
						$Totalbayar = 0;
					}
					$t_omset = sumOrder($row['id_invoice']);
					$totalDiskon = totalDiskon($row['id_invoice']);
					$t_omset = $t_omset - $totalDiskon;
					$piutang = sumPiutang($row['id_invoice']);
					
					$diskon = $row['potongan_harga'];
					$cashback = $row['cashback'];
					$sisa = $t_omset - $piutang[0]['piutang'] - $diskon;
					if($row['pajak']>0){
						$sub_tpajak = ($t_omset * $row['pajak']) /100;
						$piutang =  $t_omset + $sub_tpajak - $Totalbayar;
						}else{
						$piutang = $t_omset - $piutang[0]['piutang'];
						$sub_tpajak = $row['pajak'];
					}
					if($row['status']=='batal'){
						$Totalbayar = 0;
						$t_omset = 0;
					}
					if($row["oto"]==0){
						$status = 'Buka';
						$view = 'edit';
						}elseif($row["oto"]==1){
						$status = 'Edit Order';
						$view = 'edit';
						}elseif($row["oto"]==2){
						$status = 'Hapus Pembayaran';
						$view = 'view';
						}elseif($row["oto"]==3){
						$status = 'Edit Order Lunas';
						$view = 'edit';
						}elseif($row["oto"]==4){
						$status = 'Pending';
						$view = 'view';
						}elseif($row["oto"]==5){
						$status = 'Batal';
						$view = 'view';
						}else{
						$status = 'Kunci';
						$view = 'view';
					}
				?>
				
				<tr style="<?=$warna;?>">
					<td class="pl-0"><?php echo $row["id_transaksi"]; ?></td>
					<td><?=($row['tgl_trx']);?></td>
					<td><?=($row['tgl_ambil']);?></td>
					<td class="text-right"><?=$row['nama'];?></td>
					<td class="text-right"><?=rp($sub_tpajak);?> </td>
					<td class="text-right"><?=rp($t_omset);?></td>
					<td class="text-right"><?=rp($Totalbayar);?></td>
					<td class="text-right"><?=rp($diskon);?></td>
					<td class="text-right"><?=rp($sisa);?></td>
					<td class="text-right"><span class="badge badge-success flat"><?=$row['kasir'];?></span></td>
				</tr> 
				<thead class="thead-light">
					<tr> 
						<th>QTY</th>
						<th class="text-right">Harga</th>
						<th class="text-right">Diskon</th>
						<th class="text-right">Sub_total</th>
						<th class="text-right">Produk</th>
						<th class="text-right">Jenis</th>
						<th colspan="4" class="text-right">Keterangan</th>
					</tr>
				</thead>
				<?php 
					$detail = detail_order($row['id_invoice'],'semua');
					// print_r($detail);
					$subtotal = 0;
					$num = 1;
					foreach($detail AS $val)
					{ 
						$subtotal = $val->jumlah * $val->harga;
						if($val->diskon > 0){
							$diskon = ($subtotal * $val->diskon) /100;
							$subtotal = $subtotal - $diskon;
							}else{
							$diskon = 0;
							$subtotal = $subtotal;
						}
					?>
					<tr style="<?=$warna2;?>">
						<td><?=$val->jumlah;?></td>
						<td class="text-right"><?=rp($val->harga);?></td>
						<td class="text-right"><?=rp($diskon);?></td>
						<td class="text-right"><?=rp($subtotal);?></td>
						<td class="text-right"><?=nama_produk($val->id_produk);?></td>
						<td class="text-right"><?=jenis_cetakan($val->jenis_cetakan);?></td>
						<td colspan="4" class="text-right"><?=$val->keterangan;?></td>
					</tr>
					<?php 
					}
					$total_order += $t_omset;
					$total_pajak += 0;
					$total_bayar += $Totalbayar;
					$total_diskon += $diskon;
					$total_piutang += $sisa;
				}}else{ ?>
				<tr>
					<td colspan="11">Data belum ada</td>
				</tr> 
		<?php }?>
	</tbody>
	<tfoot>
		<thead class="thead-dark">
			<tr style="border-bottom:1px solid #000!important">
				<th colspan="3">Total</th>
				<th class="text-right">&nbsp;</th>
				<th class="text-right">Pajak</th>
				<th class="text-right">Total_Order</th>
				<th class="text-right">Bayar</th>
				<th class="text-right">Diskon</th>
				<th class="text-right">Piutang</th>
				<th class="text-right">&nbsp;</th>
			</tr>
		</thead>
		<tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th class="text-right"><?=rp($total_pajak);?></th>
			<th class="text-right"><?=rp($total_order);?></th>
			<th class="text-right"><?=rp($total_bayar);?></th>
			<th class="text-right"><?=rp($total_diskon);?></th>
			<th class="text-right"><?=rp($total_piutang);?></th>
			<th>&nbsp;</th>
		</tr>
	</tfoot>
	
</table>