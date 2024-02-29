<div class="table-responsive-sm">
	<table class="table">
		<tbody>
			<?php 
				$akses=true;
				if(!empty($posts)) {
					$no=1;
					foreach($posts AS $row){
						$bayar = bayar($row['id_invoice']);
						$id_invoice = encrypt_url($row['id_invoice']);
						$url_pdf = base_url().'operator/print_spk/'.$id_invoice;
						$pdf = '<a class="dropdown-item" href="'.$url_pdf.'" target="_blank"><i class="fa fa-file-pdf-o"></i> CETAK PDF</a>';
						$print = '<a class="dropdown-item" href=javascript:open_popup("'.$id_invoice.'") > <i class="fa fa-print"></i> Print </a>';
						$detail = detail_order($row['id_invoice'],$status_order);
						
						if(!empty($detail)) {
						?>
						<thead class="thead-dark">
							<tr>
								<th>No.Order</th>
								<th colspan="2">Tgl.Order</th>
								<th colspan="2">Tgl.Selesai</th>
								<th class="text-left">Pelanggan</th>
								<th class="text-left">Kasir</th>
								<th class="text-right"></th>
								<th class="text-right">Aksi</th>
							</tr>
						</thead>
						<tr>
							<td><button class="btn btn-info btn-sm flat"><?php echo $row["id_transaksi"]; ?></button></td>
							<td colspan="2" ><?=dtimes($row['tgl_trx'],false,false);?></td>
							<td colspan="2"><?=dtimes($row['tgl_ambil'],true,false);?></td>
							<td class="text-left"><?=$row['nama'];?></td>
							<td class="text-left"><span class="badge badge-success flat"><?=$row['kasir'];?></span></td>
							<td colspan="2" class="text-right"><div class="btn-group">
								<button type="button" class="btn btn-danger btn-sm buat_spk" data-id="<?=$id_invoice;?>">
									<i class="fa fa-pencil"></i> Buat SPK
								</button>
								 
							</div></td>
						</tr> 
						<thead class="thead-light">
							<tr> 
								<th>NO.SPK</th>
								<th>QTY</th>
								<th class="text-left">Produk</th>
								<th class="text-left">Bahan</th>
								<th class="text-left">Ukuran</th>
								<th class="text-left">Keterangan</th>
								<th class="text-right">Finishing</th>
								<th class="text-right">Operator</th>
								<th class="text-right">Status</th>
							</tr>
						</thead>
						<?php 
							$finishing ='';
							$num = 1;
							foreach($detail AS $val)
							{
								$kategori = jkategori($val->id_produk);
								if($kategori!=9){
									if($val->status==1){
										$status = prosess_status($id_invoice,$val->status,'Proses Desain','primary','object-group');
										}elseif($val->status==2){
										$status = prosess_status($id_invoice,$val->status,'Proses Cetak','info','spinner fa-spin');
										}elseif($val->status==3){
										$status = prosess_status($id_invoice,$val->status,'Selesai','success','list');
										}elseif($val->status==4){
										$status = prosess_status($id_invoice,$val->status,'Diambil','warning','hand-paper-o');
										}elseif($val->status==5){
										$status = prosess_status($id_invoice,$val->status,'Dikirim','warning','truck');
										}else{
										$status = prosess_status($id_invoice,$val->status,'Baru','secondary','file-o');
									}
									$operator = '-';
									if($val->id_operator!=0){
										$operator = juser($val->id_operator);
									}
									
									$bahan =  getDetailBahan($val->id_bahan)->title;
									if(!empty($val->detail)){
										$finishing = json_decode($val->detail);
									}
							?>
							<tr>
								<td><?=$val->no_spk;?></td>
								<td><?=$val->jumlah;?></td>
								<td class="text-left"><?=nama_produk($val->id_produk);?></td>
								<td class="text-left"><?=$bahan;?></td>
								<td class="text-left"><?=$val->ukuran;?></td>
								<td class="text-left"><?=$val->keterangan;?></td>
								<td class="text-right">
									<?php
										if(!empty($finishing)){
											foreach($finishing->data  AS $key=>$vals){
												echo ' | '.$vals->title.':'.$vals->isi.' | '; 
											}
										}
									?>
								</td>
								<td class="text-right"><?=$operator;?></td>
								<td class="text-right"><?=$status;?></td>
							</tr>
							<?php 
								$status_pekerjaan = $val->status;
							} 
						} 
						
						if($status_pekerjaan==1 OR $status_pekerjaan==2){
							$status_update = update_status($id_invoice,$status_pekerjaan,'Update Status','info','refresh');
							$surat = '';
							}elseif($status_pekerjaan==3){
							$status_update = update_status($id_invoice,$status_pekerjaan,'Update Status','info','refresh');
							$surat = '';
							}elseif($status_pekerjaan==4){
							$status_update = update_status($id_invoice,$status_pekerjaan,'Sudah diambil','warning','hand-paper-o');
							$surat = '';
							}elseif($status_pekerjaan==5){
							$status_update = update_status($id_invoice,$status_pekerjaan,'Dikirim','warning','truck');
							$surat = '<button class="btn btn-secondary btn-icon-split btn-sm flat buat_surat" data-id="'.$id_invoice.'">
							<span class="icon text-white-50">
							<i class="fa fa-file-text"></i>
							</span>
							<span class="text">Surat Jalan</span>
							</button>';
							}else{
							$status_update = update_status($id_invoice,$status_pekerjaan,'Update Status','info','refresh');
							$surat = '';
						}
						
						$share = '<button class="btn btn-success btn-icon-split btn-sm flat kirim_wa" data-id="'.$id_invoice.'" data-nomor="'.$row["no_hp"].'" data-trx="'.$row["id_transaksi"].'"  data-tgl="'.$row["tgl_trx"].'">
						<span class="icon text-white-50">
						<i class="fa fa-whatsapp"></i>
						</span>
						<span class="text">Kirim</span>
						</button>';
						?>
						
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td colspan="2" class="text-right"><?= $status_update.$surat.$share;?></td>
						</tr>
						<?php
							}else{
							$akses = false;
						}
						}
						}else{ 
						echo '<tr>
						<td colspan="8">Data belum ada</td>
						</tr>'; 
					} ?>
			</tbody>
		</table>
		<nav aria-label="Page navigation" class="mt-2">
			<?php if($akses==true){echo $this->ajax_pagination->create_links();} ?>
		</nav>
	</div>	
	<script>
		$(document).on('click','.buat_surat',function(e){
			e.preventDefault();
			var dataID = $(this).attr('data-id');
			var user = $("#user").val();
			// alert(info);
			$.ajax({
				'url': base_url + 'laporan/load_modal',
				'method': 'POST',
				data :{id:dataID,user:user},
				success: function(data) {
					if(data=='error'){
						sweet('Peringatan!!!','Maaf Data telah direkap & tidak bisa di edit','warning','warning');
						}else{
						$("#surat_jalan").modal('show');
						$(".load-modal").html(data);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					sweet('Peringatan!!!',thrownError,'warning','warning');
				}
			})
		});
		
		$(".kirim_wa").click(function(e) {
			e.preventDefault();
			var id = $(this).attr('data-id');
			var nomor = $(this).attr('data-nomor');
			var trx = $(this).attr('data-trx');
			var tgl = $(this).attr('data-tgl');
			// console.log(id);
			$('#WaLabel').html('Kirim '+trx);  
			$('#OpenModalWa').modal({backdrop: 'static', keyboard: false})  
			$.ajax({
				url: base_url + 'whatsapp/get_form_wa',
				data: {id:id,nomor:nomor,tgl:tgl},
				method: 'POST',
				dataType:'html',
				beforeSend: function(){
					$('body').loading();
				},
				success: function(data) {
					$(".load-data-wa").html(data);
					$('body').loading('stop');
				},
				error: function(xhr, status, error) {
					var err = xhr.responseText ;
					sweet('Server!!!',err,'error','danger');
					$('body').loading('stop');
				}
			});
		});
		
	</script>	