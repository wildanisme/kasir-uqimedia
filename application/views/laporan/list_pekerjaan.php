<?php
	$html = '';
	foreach($posts AS $row)
	{
		$bayar = bayar($row['id_invoice']);
		// if($bayar > 0){
		$detail = detail_pekerjaan($row['id_invoice']);
		foreach($detail AS $val)
		{
			if($val->status==0){
				$status = '<button class="btn btn-secondary btn-sm flat edit_baru" data-id="'.$val->id_rincianinvoice.'">Baru</button>';
				}elseif($val->status==1){
				$status = '<button class="btn btn-primary btn-sm flat edit_proses" data-id="'.$val->id_rincianinvoice.'">Proses Desain</button>';
				}elseif($val->status==2){
				$status = '<button class="btn btn-info btn-sm flat">Proses Cetak</button>';
				}elseif($val->status==3){
				$status = '<button class="btn btn-success btn-sm flat">Selesai</button>';
				}else{
				$status = '<button class="btn btn-warning btn-sm flat">Diambil</button>';
			}
			$operator = '-';
			if($val->id_operator!=0){
				$operator = juser($val->id_operator);
			}
		?>
		<tr>
			<td><?=$row['id_transaksi'];?></td>
			<td><?=$val->jumlah;?></td>
			<td class="text-left"><?=nama_produk($val->id_produk);?></td>
			<td class="text-left"><?=jenis_cetakan($val->jenis_cetakan);?></td>
			<td class="text-left"><?=$val->keterangan;?></td>
			<td class="text-left"><?=$operator;?></td>
			<td class="text-right"><?=$status;?></td>
		</tr>
	<?php }  }				