<div class="table-responsive-sm">
	<table class="table">
		<tbody>
			<?php 
				if(!empty($posts)) {
					$no=1;
					foreach($posts AS $row){ 
						$id_invoice = encrypt_url($row['id']);
						$url_pdf = base_url().'laporan/cetak_surat/'.$id_invoice;
						$pdf = '<a href="'.$url_pdf.'" target="_blank" class="btn btn-primary btn-sm flat"><i class="fa fa-print"></i> SURAT</a>';
						$detail = detail_order($row['id_invoice']);
					?>
					<thead class="thead-dark">
						<tr>
							<th>No.Order</th>
							<th>Tgl.Order</th>
							<th>Tgl.Kirim</th>
							<th class="text-right">Customer</th>
							<th class="text-right">Pengirim</th>
							<th class="text-right">Aksi</th>
						</tr>
					</thead>
					<tr>
						<td><button class="btn btn-info btn-sm flat"><?php echo $row["id_transaksi"]; ?></button></td>
						<td><?=dtimes($row['tgl_trx'],false,false);?></td>
						<td><?=dtimes($row['tanggal'],false,false);?></td>
						<td class="text-right"><?=$row['nama'];?></td>
						<td class="text-right"><span class="badge badge-success flat"><?=$row['nama_lengkap'];?></span></td>
						<td class="text-right"><?=$pdf;?></td>
					</tr> 
					<thead class="thead-light">
						<tr> 
							<th>QTY</th>
							<th class="text-right">Produk</th>
							<th class="text-right">Jenis</th>
							<th class="text-right">Keterangan</th>
							<th class="text-right">Operator</th>
							<th class="text-right">Status</th>
						</tr>
					</thead>
					<?php 
						
						$num = 1;
						foreach($detail AS $val)
						{ 
							
							$operator = '-';
							if($val->id_operator!=0){
								$operator = juser($val->id_operator);
							}
						?>
						<tr>
							<td><?=$val->jumlah;?></td>
							<td class="text-right"><?=nama_produk($val->id_produk);?></td>
							<td class="text-right"><?=jenis_cetakan($val->jenis_cetakan);?></td>
							<td class="text-right"><?=$val->keterangan;?></td>
							<td class="text-right"><?=$operator;?></td>
							<td class="text-right">-</td>
						</tr>
						<?php 
						} 
						
					
					}}else{ ?>
					<tr>
						<td colspan="11">Data belum ada</td>
					</tr> 
			<?php }?>
		</tbody>
	</table>
	<nav aria-label="Page navigation" class="mt-2">
		<?php echo $this->ajax_pagination->create_links(); ?>
	</nav>
</div>	