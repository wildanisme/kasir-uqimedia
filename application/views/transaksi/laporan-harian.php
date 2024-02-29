<div class="table-responsive-sm">
	<table class="table">
		
		<?php if(!empty($result)){ ?>
			<tbody>
				<?php
					// dump($result);
					
					$no=1;
					$sum_keluar=0;
					$sum_beli=0;
					$total_masuk = $total_keluar = $total_beli = $total_pendapatan = 0;
					if(!empty($result['masuk'])){
						echo '<thead class="thead-light"><tr>
						<td colspan="8" class="text-left font-weight-bold">Penjualan ---</td>
						</tr></thead>';
						echo '<thead class="thead-dark">
						<tr>
						<th style="width:1%;" class="text-left">NO</th>
						<th style="width:1%"  class="text-left">NO_ORDER</th>
						<th style="width:1%"  class="text-left">PEMESAN</th>
						<th style="width:2%"  class="text-left">TGL_BAYAR</th>
						<th style="width:8%"  class="text-left">KASIR</th>
						<th style="width:8%"  class="text-left">KETERANGAN</th>
						<th style="width:5%"  class="text-right">MASUK</th>
						<th style="width:5%"  class="text-right">KELUAR</th>
						</tr>
						</thead>';
						foreach($result['masuk'] as $key=>$val){
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
						<tr>
							<td class="text-left"><?=$no;?></td>
							<td class="text-left">#<?=$val['id'];?></td>
							<td class="text-left"><?=$nama;?></td>
							<td class="text-left"><?=date_time($val['tgl_bayar'],false);?></td>
							<td class="text-left"><?=$val['fo'];?></td>
							<td class="text-left"><?=$nama_bayar;?> (<?=$getAkun;?>)</td>
							<td class="text-right"><?=rp($val['jml_bayar']);?></td>
							<td class="text-right"></td>
						</tr>
						<?php $no++; 
							$detail = detail_order($val['noid'],'semua');
							if(!empty($detail)) {
							?>
							<thead class="thead-light">
								<tr> 
									<th>#</th>
									<th>QTY</th>
									<th class="text-left">HARGA</th>
									<th class="text-left">SUB_TOTAL</th>
									<th class="text-left">PRODUK</th>
									<th class="text-left">KATEGORI</th>
									<th class="text-left">BAHAN</th>
									<th class="text-left">UKURAN</th>
								</tr>
							</thead>
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
								<tr>
									<td class="text-left"><?=$num;?></td>
									<td class="text-left"><?=$val->jumlah;?></td>
									<td class="text-left"><?=rp($val->harga);?></td>
									<td class="text-left"><?=rp($subtotal);?></td>
									<td class="text-left"><?=nama_produk($val->id_produk);?></td>
									<td class="text-left"><?=jenis_cetakan($val->jenis_cetakan);?></td>
									<td class="text-left"><?=getDetailBahan($val->id_bahan)->title;?></td>
									<td class="text-left"><?=$val->ukuran;?></td>
								</tr>
								<?php 
								}
							}
						}
						echo '<tr>
						<th colspan="6" class="text-left">Total Penjualan</th>
						<th class="text-right">'.rp($total_masuk).'</th>
						<th class="text-center"></th>
						</tr>';
					}
					
					if(!empty($result['keluar'])){
						echo '<thead class="thead-dark"><tr>
						<td colspan="8" class="text-left font-weight-bold">Pengeluaran ---</td>
						</tr></thead>';
					echo '<thead class="thead-dark">
						<tr>
						<th style="width:1%;" class="text-left">NO</th>
						<th style="width:1%"  class="text-left">NO_ORDER</th>
						<th style="width:2%"  class="text-left">TGL_BAYAR</th>
						<th style="width:10%"  class="text-left">KASIR</th>
						<th colspan="2" style="width:8%"  class="text-left">KETERANGAN</th>
						<th style="width:5%"  class="text-right">MASUK</th>
						<th style="width:5%"  class="text-right">KELUAR</th>
						</tr>
						</thead>';
						$no=1;
						foreach($result['keluar'] as $key=>$val){
							$total_keluar  += $val['jml_bayar'];
							$sum_keluar  += $val['jml_bayar'];
							$bayar = $this->model_app->cara_bayar_keluar(array('`jenis_bayar`.`publish`' => 'Y', '`bayar_pengeluaran`.`id_pengeluaran`' => $val['id']));
							$nama_bayar = $bayar->nama_bayar;
							$id_bayar = $bayar->id_bayar;
							if($id_bayar==1){
								$getAkun = getNameKas($val['id_sub_bayar']);
								}else{
								$getAkun = bank($val['id_sub_bayar']);
							}
						?>
						<tr>
							<td class="text-left"><?php echo $no;?></td>
							<td class="text-left">#<?=$val['id'];?></td>
							<td class="text-left"><?=date_time($val['tgl_bayar'],false);?></td>
							<td class="text-left"><?=$val['fo'];?></td>
							<td colspan="3" class="text-left"><?=$nama_bayar;?> (<?=$getAkun;?>)</td>
							<td class="text-right"><?=rp($val['jml_bayar']);?></td>
						</tr>
						<?php $no++; 
						}
						echo '<tr>
						<th colspan="5" class="text-left">Total Pengeluaran</th>
						<th class="text-center"></th>
						<th class="text-right">'.rp($total_keluar).'</th>
						</tr>';
					}
					
					if(!empty($result['beli'])){
					echo '<thead class="thead-dark"><tr>
						<td colspan="8" class="text-left font-weight-bold">Pembelian ---</td>
						</tr></thead>';
					echo '<thead class="thead-dark">
						<tr>
						<th style="width:1%;" class="text-left">NO</th>
						<th style="width:1%"  class="text-left">NO_ORDER</th>
						<th style="width:2%"  class="text-left">TGL_BAYAR</th>
						<th style="width:8%"  class="text-left">KASIR</th>
						<th colspan="2" class="text-left">KETERANGAN</th>
						<th style="width:5%"  class="text-right">MASUK</th>
						<th style="width:5%"  class="text-right">KELUAR</th>
						</tr>
						</thead>';
						$no=1;
						foreach($result['beli'] as $key=>$val){
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
						<tr>
							<td class="text-left"><?php echo $no;?></td>
							<td class="text-left">#<?=$val['id'];?></td>
							<td class="text-left"><?=date_time($val['tgl_bayar'],false);?></td>
							<td class="text-left"><?=$val['fo'];?></td>
							<td colspan="3" class="text-left"><?=$nama_bayar;?> (<?=$getAkun;?>)</td>
							<td class="text-right"><?=rp($val['jml_bayar']);?></td>
						</tr>
						<?php $no++; 
						}
						echo '<tr>
						<th colspan="6" class="text-left">Total Pembelian</th>
						<th class="text-center"></th>
						<th class="text-right">'.rp($total_beli).'</th>
						</tr>';
					}
					$sum_keluar = $total_keluar + $total_beli;
					$total_pendapatan = $total_masuk - $total_keluar - $total_beli;
				?>
				
			</tbody>
			<tfoot>
				<thead class="thead-dark">
					<tr>
						<th class="text-center"></th>
						<th class="text-center"></th>
						<th class="text-center"></th>
						<th class="text-center"></th>
						<th class="text-center"></th>
						<th class="text-center"></th>
						<th class="text-right"><?=rp($total_masuk);?></th>
						<th class="text-right"><?=rp($sum_keluar);?></th>
					</tr>
				</thead>
				<thead class="thead">
					<tr>
						<th colspan="3" class="text-left">Total Keseluruhan</th>
						<th class="text-center"></th>
						<th class="text-center"></th>
						<th class="text-center"></th>
						<th class="text-center"></th>
						<th class="text-right"><?=rp($total_pendapatan);?></th>
					</tr>
				</thead>
			</tfoot>
			<?php }else{
				echo '<tr><td colspan="8" class="text-left">Belum ada data</td></tr>';
			} ?>
	</table>							
	<script>
		
	</script>																														